<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*Cache Model
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
	class Cache_model extends CI_Model{
		//默认查询参数
		var $DEFAULT_PARAMS;
		
		var $PROTO = array(1,6,17);
		
		var $FROM = 'acid_event AS e';
		
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Etc/GMT-8');
			$this->DEFAULT_PARAMS = '"{"time":{"start":' . strtotime("-1 day") . ',"end":' . time() . ',"axis":"hour"}}"';
		}
		
		/**
		*return data to form the statistical graph.
		*@param object $params null or a json object which holds start time, end time, signature, sensor and so on.
		*default time range is past_24h
		*/
		public function get_statistic_graph($params)
		{
			if($params == NULL)
				$params = $this->DEFAULT_PARAMS;
			
			$where = $this->form_where_clause($params);
			
			$params = json_decode($params);
			
			$time_start = isset($params->time->start) ? $params->time->start : strtotime("-1 day");
			$time_end = isset($params->time->end) ? $params->time->end : time();
			$start = min($time_start, $time_end);
			$end = max($time_start, $time_end);
			
			//结果集
			$data = array();
			$group_by = '';
			
			//取得x轴坐标，设置group_by子句
			$axis = isset($params->time->axis) ? $params->time->axis : "hour";
			$axis_array = $this->get_axis_array($start, $end , $axis);
			
			switch(strtolower($axis))
			{	
				case 'month':
					$group_by = 'LEFT( TIMESTAMP, 7 ) ';
					$axis_desp = 'Month of Year';
					break;
				case 'day':
					$group_by = 'LEFT( TIMESTAMP, 10 ) ';
					$axis_desp = 'Day of Month';
					break;
				case 'hour':
					$group_by = 'LEFT( TIMESTAMP, 13 ) ';
					$axis_desp = 'Hour of Day';
					break;
				case 'minute':
					$group_by = 'LEFT( TIMESTAMP, 16 ) ';
					$axis_desp = 'Minute of Hour';
					break;
				case 'year':
				default:
					$group_by = 'LEFT( TIMESTAMP, 4 ) ';
					$axis_desp = 'Year';
					break;
			}
				
			//severity
			$data['high'] = $this->get_severity_count('high', $axis_array, $group_by, $this->FROM, $where);
			$data['medium'] = $this->get_severity_count('medium', $axis_array, $group_by, $this->FROM, $where);
			$data['low'] = $this->get_severity_count('low', $axis_array, $group_by, $this->FROM, $where);
			$data['event_count'] = array_sum($data['high']) + array_sum($data['medium']) + array_sum($data['low']); 
			
			
			//sensor
			$data['sensor_metrics'] = $this->get_sensor_metrics($axis_array, $group_by, $this->FROM, $where);
			
			//protocol
			$protocol = isset($params->protocol) ? explode(",",trim($params->protocol, " ,")) : $this->PROTO;
			$data['proto'] = array();
			foreach($protocol as $value)
			{
				if(in_array($value, $this->PROTO))
				{
					$proto_name = $this->get_protocol_name($value);
					$data['proto'][$proto_name] = $this->get_protocol_count($value, $axis_array, $group_by, $this->FROM, $where);
				}
			}
			
			//src metrics
			$data['src_metrics'] = $this->get_src_metrics($this->FROM, $where);
			
			//dst metrics
			$data['dst_metrics'] = $this->get_dst_metrics($this->FROM, $where);
			
			//signature metrics
			$data['signature_metrics'] = $this->get_sig_metrics($this->FROM, $where);
			
			//threat ips
			$data['threat_ips'] = $this->get_threat_ip($this->FROM, $where);
			
			$data['axis'] = array();
			foreach($axis_array as $value)
				$data['axis'][] = str_replace(" ","~", "\"" . substr($value, -5) . "\""); 
				
			$data['axis_desp'] = $axis_desp;
			return $data;
		}
		
		
		/**
		 * 
		 * @param string $params json encoded 
		 * @param number $page, if ZERO, return all expected events
		 */
		public function get_event_list($params, $page = 0)
		{
			if($params == NULL)
				$params = $this->DEFAULT_PARAMS;

			$where = $this->form_where_clause($params);
			
			$params = json_decode($params);
			
			$limit = '';
			if($page > 0 )
				$limit = " LIMIT " . (($page - 1)*20) . ",20";
			
		
			$sql = "SELECT sig_priority AS sev, e.sid, INET_NTOA( ip_src ) AS src, INET_NTOA( ip_dst ) AS dst, left(sig_name, 30) as sig_name, timestamp
					FROM " . $this->FROM;
			
			if($where != "")
				$sql .= " WHERE " . $where;
			
			$sql .= $limit;
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		/**
		 * 
		 * @param string $params json encoded
		 * @return array, to export in excel
		 */
		public function get_export_event_list($params='')
		{
			$data = $this->get_event_list($params);
			foreach ($data as &$row)
			{
				switch ($row['sev'])
				{
					case 1:$row['sev'] = 'HIGH';break;
					case 2:$row['sev'] = 'MDDIUM';break;
					case 3:
					default:$row['sev'] = 'LOW';break;
				}
			}
			
			$result = array();
			$result['fields'] = array('severity', 'sid', 'src', 'dst', 'signature', 'timestamp');
			$result['list'] = $data;
			return $result;
		}
		
		
		public function get_threat_ip($from, $where = '', $limit = 30)
		{
			$sql = 'SELECT count(ip_src) as cnt, inet_ntoa(ip_src) as ipaddr FROM ' . $from;
			if($where != NULL)
				$sql .=  ' WHERE ' . $where;
			$sql .= ' GROUP BY ipaddr ORDER BY cnt DESC LIMIT ' . $limit; 
			
			$query = $this->db->query($sql);
			
			$this->load->library('demonGeoIP');
			$result = array();
			
			foreach($query->result_array() as $row)
			{
				$geo_ip = $this->demongeoip->get_ip_geo($row['ipaddr']);
				
				if($geo_ip != NULL && $geo_ip['latitude'] != '' && $geo_ip['longitude'] != '')
				{
					$result[] = $row + $geo_ip;
				}
			}
	
			return $result;
		}
		
		/**
		*@param array $params parameter
		*
		*/
		public function get_event_count($params)
		{
			if($params == NULL)
				$params = $this->DEFAULT_PARAMS;
				
			$where = $this->form_where_clause($params);
			$params = json_decode($params);
			
			$sql = "SELECT count(*) as cnt
					FROM " . $this->FROM;
			
			if($where != "")
				$sql .= " WHERE " . $where;
			
			$query = $this->db->query($sql);
			$result =  $query->row_array();
			return intval($result['cnt']);
		}
		
		
		
		
		/**
		*计算时间在range范围内的指定协议的事件数量
		*以数组返回，根据range确定时间间隔
		*/
		public function get_protocol_count($proto, $axis_array, $group_by, $from, $where="")
		{
			
			$sql = "SELECT " . $group_by . " as t, count(*) as cnt 
					FROM " . $from .
					" WHERE ip_proto = ?";
					
			if($where != "")
				$sql .= " AND " . $where;		
					
			$sql .= " GROUP BY t";
					
					
			$query = $this->db->query($sql, array($proto));
			
			//结果数组，为了把每个时间段的数据填到对应的位置上，先处理一下
			$result = $axis_array;
			$result = array_flip($result);
			foreach($result as $key=>$value)
			{
				$result[$key] = 0;
			}
			
			foreach($query->result_array() as $row)
			{
			
				if(array_key_exists($row['t'], $result))
					$result[$row['t']] = intval($row['cnt']);
			}
			
			return $result;
		}
		
		/**
		*计算低3，中2，高1不同严重性的数量，以数组返回
		*@param interger $severity 危险级，1为最高
		*@param string $where where子句
		*@param string $group_by group_by子句
		*/
		public function get_severity_count($severity, $axis_array, $group_by, $from, $where ="")
		{
			$priority = 1;
			switch(strtolower($severity))
			{
				case "high": $priority = 1;break;
				case "medium": $priority = 2;break;
				case "low":
				default: $priority = 3;break;
			}
			$sql = "SELECT " . $group_by . " as t, count(*) as cnt 
					FROM ". $from .
					" WHERE sig_priority = ? ";
			if($where != "")
				$sql .= " AND " . $where;
			$sql .= ' GROUP BY t';
			$query = $this->db->query($sql, array($priority));

			//结果数组，为了把每个时间段的数据填到对应的位置上，先处理一下
			$result = $axis_array;
			$result = array_flip($result);
			foreach($result as $key=>$value)
			{
				$result[$key] = 0;
			}
			
			foreach($query->result_array() as $row)
			{
				if(array_key_exists($row['t'], $result))
					$result[$row['t']] = intval($row['cnt']);
			}
			return $result;
		}
		
		
		/**
		*根据range计算，返回每个sensor在每个时间段的总数，以数组形式
		*@param array $axis x-axis
		*@param string $where where子句
		*@param string $group_by group by 子句
		*/
		public function get_sensor_metrics($axis_array, $group_by, $from, $where="")
		{
			$sql = "SELECT * FROM sensor";
			$query = $this->db->query($sql);
			$sensors = $query->result_array();
			
			$sensors_metrics = array();
			
			foreach($sensors as $sensor)
			{
				$sid = $sensor['sid'];
				
				$sql = "SELECT " . $group_by . " as t,count(*) as cnt
						FROM " . $from . "
						WHERE sid = ? ";
				if($where != "")
					$sql .= " AND " . $where;
				$sql .= " GROUP BY t";

				$query = $this->db->query($sql, array($sid));
				
				//结果数组，为了把每个时间段的数据填到对应的位置上，先处理一下
				$result = $axis_array;
				$result = array_flip($result);
				foreach($result as $key=>$value)
				{
					$result[$key] = 0;
				}
				
				foreach($query->result_array() as $row)
				{
					if(array_key_exists($row['t'], $result))
						$result[$row['t']] = intval($row['cnt']);
				}
				
				$sensors_metrics[$sid . ":" . $sensor['hostname'] . ":" . $sensor['interface']] = $result;
			}
			
			return $sensors_metrics;
		}
		
		/**
		*@todo 加了limit会导致比例不正确
		*/
		public function get_src_metrics($from, $where="")
		{
			$sql = "SELECT INET_NTOA( ip_src ) as ipaddr, COUNT( * ) AS cnt
					FROM " . $from;
					
			if($where != "")
				$sql .= " WHERE " . $where;
				
			$sql .= " GROUP BY ip_src LIMIT 10";
					
			$query = $this->db->query($sql);
			$result = array();
			foreach( $query->result_array() as $row )
			{
				$result[$row['ipaddr']] = intval($row['cnt']);
			}
			arsort($result);
			return $result;
		}
		
		/**
		*@todo 加了limit会导致比例不正确
		*/
		public function get_dst_metrics($from, $where = "")
		{
			$sql = "SELECT INET_NTOA( ip_dst ) as ipaddr, COUNT( * ) AS cnt
					FROM " . $from;
					
			if($where != "")
				$sql .= " WHERE " . $where;
				
			$sql .= " GROUP BY ip_dst LIMIT 10";
					
			$query = $this->db->query($sql);
			$result = array();
			foreach( $query->result_array() as $row )
			{
				$result[$row['ipaddr']] = intval($row['cnt']);
			}
			arsort($result);
			return $result;
		}
		
		/**
		*返回每个signature的事件总数，已排序
		*@todo 加了limit会导致比例不正确
		*/
		public function get_sig_metrics($from, $where="")
		{
			$sql = "SELECT signature, left(sig_name, 30) as sname, count(*) as cnt 
				FROM " . $from;
				
			if($where != "")
				$sql .= " WHERE " . $where;
				
			$sql .= " GROUP BY signature LIMIT 10";
				
			$query = $this->db->query($sql);
			$result = array();
			foreach( $query->result_array() as $row )
			{
				$result[$row['sname']] = intval($row['cnt']);
			}
			arsort($result);
			return $result;
		}
		
		/**
		*return axis array
		*@param timestamp $start seconds from 1970/1/1
		*@param timestamp $end
		*@param string $axis year month day hour or minute
		*/
		public function get_axis_array($start, $end, $axis)
		{
			$axis_array = array();
			
		
			switch(strtolower($axis))
			{
				case "month":
					$start = strtotime(date('Y-m', $start)); 
					for($i = $start; $i < $end; $i = strtotime('+1 month', $i))
						$axis_array[] = date("Y-m", $i);
					break;
				case "day":
					$start = strtotime(date('Y-m-d', $start)); 
					for($i = $start; $i < $end; $i = strtotime('+1 day', $i))
						$axis_array[] = date("Y-m-d", $i);
					break;
				case "hour":
					$start = strtotime(date('Y-m-d H:0:0', $start)); 
					for($i = $start; $i < $end; $i = strtotime('+1 hour', $i))
						$axis_array[] = date("Y-m-d H", $i);
					break;
				case "minute":
					$start = strtotime(date('Y-m-d H:i:0', $start)); 
					for($i = $start; $i < $end; $i = strtotime('+1 minute', $i))
						$axis_array[] = date("Y-m-d H:i", $i);
					break;
				case "year":
				default:
					$axis_array = range(date("Y", $start), date("Y", $end));
					break;
			}
			return $axis_array;
		}
		
		/**
		*helper function
		*form the where clause based on the json decoded params
		*@param string @params
		*@return string 
		*/
		public function form_where_clause($params)
		{
			if($params == NULL)
				return "";
				
			$params = json_decode($params);
			
			$time_start = isset($params->time->start) ? $params->time->start : strtotime("-1 day");
			$time_end = isset($params->time->end) ? $params->time->end : time();
			$start = min($time_start, $time_end);
			$end = max($time_start, $time_end);
			$where = 'unix_timestamp(timestamp) > ' . $start . ' AND unix_timestamp(timestamp) < ' . $end;
			
			//有协议限制
			if(isset($params->protocol))
			{
				if($where != '')
					$where .= ' AND ';
					
				$proto_list = trim($params->protocol, " ,");
				$where .= 'e.ip_proto IN (' . $proto_list . ')';
			}
			
			//有signature限制
			if(isset($params->signature))
			{
				$sig_list = trim($params->signature, ", ");
				if($where != '')
					$where .= ' AND ';
				$where .= 'e.signature in (' . $sig_list . ')';
			}
			
			//有sensor限制
			if(isset($params->sensor))
			{
				if($where != '')
					$where .= ' AND ';
				
				$sensor_list = trim($params->sensor, " ,");
				$where .= 'e.sid IN (' . $sensor_list . ')';
			}
			

			
			//有源ip限制
			if(isset($params->ip) && isset($params->ip->src))
			{
				$iplist = $this->iplist2long($params->ip->src);
				
				if($where != '')
					$where .= ' AND ';
				
				$where .= 'e.ip_src IN (' . $iplist . ')';				
			}
			
			//有目的ip限制
			if(isset($params->ip) && isset($params->ip->dst))
			{
				$iplist = $this->iplist2long($params->ip->src);
				
				if($where != '')
					$where .= ' AND ';
				
				$where .= 'e.ip_dst IN (' . $iplist . ')';	
			}
			
			return $where;
		}
		
		/**
		*helper function 
		*translate a list of dotted-decimal notation ip addresses to a list of integer
		*@param string $iplist 
		*/
		public function iplist2long($iplist)
		{
			$iplist = trim($iplist, " ,");
			$ip_arr = explode(",", $iplist);
			$long = '';
			foreach($ip_arr as $ip)
			{
				$long .= sprintf("%u", ip2long($ip)) . ',';
			}
			return trim($long, ", ");
			
		}
		
		/**
		*helper function
		*return the protocol name of a specific id
		*@param integer $id protocol id
		*/
		public function get_protocol_name($id)
		{
			$name = '';
			switch(intval($id))
			{
				case 1:
					$name = "ICMP";
					break;
				case 6:
					$name = "TCP";
					break;
				case 17:
					$name = "UDP";
					break;
				default:
					$name = "unknown";
					break;
			}
			
			return $name;
		}
		
		/**
		 * 
		 */
		public function refreshDemonEvent()
		{
			
		}
		
		/**
		 * helper function
		 * handle the input timestamp
		 * @param timestamp $time_start
		 * @param timestamp $time_end
		 * @return multitype:Ambigous <mixed, number>
		 */
		public function time_filter($time_start, $time_end)
		{
			$s = strtotime($time_start);
			$e = strtotime($time_end);
				
			$start = min($s, $e);
			$end = max($s, $e);
		
			if(!$start || !$end)
			{
				$start = strtotime('-1 year');
				$end = time();
			}
				
			return array('time_start'=>$start, 'time_end'=>$end);
		}
	}