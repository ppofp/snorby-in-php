<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*Cache Model
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
	
	class Cache_model extends CI_Model{
		
		//时间起，调用 _set_time_horizon后才有效
		var $time_start;
		//时间止，调用 _set_time_horizon后才有效
		var $time_end;
		//，调用 _set_time_horizon后才有效
		var $group_by;
		
		
		public function __construct()
		{
			parent::__construct();
			$time_start = date('y-m-d H:i:s');
			$time_end = date('y-m-d H:i:s');
		}
		
		/**
		*计算时间在range范围内的指定协议的事件数量
		*以数组返回，根据range确定时间间隔
		*/
		public function get_protocol_count($proto, $range = "last_24")
		{
			$this->_set_time_horizon($range);
			$proto_table = null;
			//根据协议决定查询的表
			switch(strtoupper($proto))
			{
				case "TCP":	$proto_table = "tcphdr"; break;
				case "UDP":	$proto_table = "udphdr"; break;
				case "ICMP":
				default:	$proto_table = "icmphdr"; break;
			}
			
			$sql = "SELECT " . $this->group_by . " as t, count(*) as cnt 
					FROM `" . $proto_table . "` AS pt, event AS e 
					WHERE (pt.cid, pt.sid) = (e.cid, e.sid) AND `timestamp` between '" . $this->time_start . "' and '" . $this->time_end . "' 
					GROUP BY " . $this->group_by;
					
					
			$query = $this->db->query($sql);
			
			//结果数组，为了把每个时间段的数据填到对应的位置上，先处理一下
			$result = $this->get_axis($range);
			$result = array_flip($result);
			foreach($result as $key=>$value)
			{
				$result[$key] = 0;
			}
			
			foreach($query->result_array() as $row)
			{
				$result[$row['t']] = $row['cnt'];
			}
			
			return $result;
			
		}
		
		/**
		*计算低3，中2，高1不同严重性的数量，以数组返回
		*根据range确定时间间隔
		*/
		public function get_severity_count($severity, $range)
		{
			$priority = 1;
			switch(strtolower($severity))
			{
				case "high": $priority = 1;break;
				case "medium": $priority = 2;break;
				case "low":
				default: $priority = 3;break;
			}
			$this->_set_time_horizon($range);
			$sql = "SELECT " . $this->group_by . " as t, count(*) as cnt 
					FROM event as e, signature as s 
					WHERE e.signature = s.sig_id AND s.sig_priority = ? AND `timestamp` between '" . $this->time_start . "' and '" . $this->time_end . "'";
			$query = $this->db->query($sql, array($priority));

			//结果数组，为了把每个时间段的数据填到对应的位置上，先处理一下
			$result = $this->get_axis($range);
			$result = array_flip($result);
			foreach($result as $key=>$value)
			{
				$result[$key] = 0;
			}
			
			foreach($query->result_array() as $row)
			{
				$result[$row['t']] = $row['cnt'];
			}
			
			return $result;
		}
		
		
		/**
		*根据range计算，返回每个sensor在每个时间段的总数，以数组形式
		*/
		public function get_sensor_metrics($range)
		{
			$this->_set_time_horizon($range);
			$sql = "SELECT sid, `hostname` FROM sensor";
			$query = $this->db->query($sql);
			$sensors = $query->result_array();
			
			$sensors_metrics = array();
			
			foreach($sensors as $sensor)
			{
				$sid = $sensor['sid'];
				
				$sql = "SELECT " . $this->group_by . " as t,count(*) as cnt
						FROM event 
						WHERE sid = ? AND `timestamp` between '" . $this->time_start . "' and '" . $this->time_end . "'
						GROUP BY " . $this->group_by;

				$query = $this->db->query($sql, array($sid));
				
				//结果数组，为了把每个时间段的数据填到对应的位置上，先处理一下
				$result = $this->get_axis($range);
				$result = array_flip($result);
				foreach($result as $key=>$value)
				{
					$result[$key] = 0;
				}
				
				foreach($query->result_array() as $row)
				{
					$result[$row['t']] = $row['cnt'];
				}
				
				$sensors_metrics[$sid . ":" . $sensor['hostname']] = $result;
			}
			
			return $sensors_metrics;
		}
		
		/**
		*根据range计算总数，返回每个源ip在range时间范围内的总数
		*/
		public function get_src_metrics($range)
		{
			$this->_set_time_horizon($range);
			$sql = "SELECT INET_NTOA( ip_src ) as ipaddr, COUNT( * ) AS cnt
					FROM iphdr as i, event as e
					WHERE i.cid=e.cid AND e.sid=i.sid AND `timestamp` between '" . $this->time_start . "' and '" . $this->time_end . "'
					GROUP BY ip_src";
					
			$query = $this->db->query($sql);
			$result = array();
			foreach( $query->result_array() as $row )
			{
				$result[$row['ipaddr']] = $row['cnt'];
			}
			arsort($result);
			return $result;
		}
		
		/**
		*返回每个目的ip在range时间范围内的总数，已排序
		*/
		public function get_dst_metrics($range)
		{
			$this->_set_time_horizon($range);
			$sql = "SELECT INET_NTOA( ip_dst ) as ipaddr, COUNT( * ) AS cnt
					FROM iphdr as i, event as e
					WHERE i.cid=e.cid AND e.sid=i.sid AND `timestamp` between '" . $this->time_start . "' and '" . $this->time_end . "'
					GROUP BY ip_dst";
					
			$query = $this->db->query($sql);
			$result = array();
			foreach( $query->result_array() as $row )
			{
				$result[$row['ipaddr']] = $row['cnt'];
			}
			arsort($result);
			return $result;
		}
		
		/**
		*返回每个signature的事件总数，已排序
		*/
		public function get_sig_metrics($range)
		{
			$this->_set_time_horizon($range);
			$sql = "SELECT sig_id, left(sig_name, 30) as sname, count(*) as ct 
				FROM `signature` AS s, `event` AS e  
				WHERE s.sig_id = e.signature AND `timestamp` between '" . $this->time_start . "' and '" . $this->time_end . "' 
				GROUP BY sig_name";
				
			$query = $this->db->query($sql);
			$result = array();
			foreach( $query->result_array() as $row )
			{
				$result[$row['sname']] = $row['ct'];
			}
			arsort($result);
			return $result;
		}
		
		public function get_axis($range = 'last_24')
		{
			/**
			*获取x轴坐标
			*/
			
			$axis = array();
			
			$season = ceil((date("n"))/3);
			switch(strtolower($range))
			{
				case "year":
					$axis = range(1,12);
					break;
				case "quarter":
					$axis = range($season*3-3+1, $season*3 );
					break;
				case "month":
					$axis = range(1, date('t'));
					break;
				case "week":
					$axis = range(date('d', strtotime("-1 week Monday")), date('d', strtotime("-0 week Sunday")));
					break;
				case "yesterday":
				case "today":
					$axis = range(0, 23);
					break;
				case "last_24": 
				default:
					$axis = array_merge(range(date("H", strtotime('-1 day +1 hour')), 23),range(0, date("H")));
					break;
			}
			return $axis;
		}
		
		private function _set_time_horizon($range = 'last_24')
		{
			date_default_timezone_set('Etc/GMT-8');
	
			$season = ceil((date("n"))/3);//当月是第几季度
			switch(strtolower($range))
			{
				case "year":	$this->group_by = "EXTRACT( MONTH FROM timestamp )"; $this->time_start = date('Y') . '-01-01'; 					$this->time_end = date('Y') . '-12-31'; break;
				case "quarter":	$this->group_by = "EXTRACT( MONTH FROM timestamp )"; $this->time_start = date('Y-' . ($season*3-3+1) . '-1'); 		$this->time_end = date('Y-' . ($season*3) . '-' . date('t',mktime(0, 0 , 0,$season*3,1,date('Y')))); break;
				case "month":	$this->group_by = "EXTRACT( DAY FROM timestamp )"; $this->time_start = date('Y-m-1'); 							$this->time_end = date('Y-m-' . date('t')); break;
				case "week":	$this->group_by = "EXTRACT( DAY FROM timestamp )"; $this->time_start = date('Y-m-d', strtotime("-1 week Monday")); $this->time_end = date('Y-m-d', strtotime("-0 week Sunday")); break;
				case "yesterday":	$this->group_by = "EXTRACT( HOUR FROM timestamp )"; $this->time_start = date('Y-m-d', strtotime("-1 day")); 	$this->time_end = date('Y-m-d', strtotime("-1 day")); break;
				case "today":	$this->group_by = "EXTRACT( HOUR FROM timestamp )"; $this->time_start =  date('Y-m-d'); 							$this->time_end =  date('Y-m-d'); break;
				case "last_24": 
				//默认时间范围是过去二十四个小时
				default: $this->group_by = "EXTRACT( HOUR FROM timestamp )"; $this->time_start = date("Y-m-d H:0:0", strtotime('-1 day +1 hour')); $this->time_end = date("Y-m-d H:i:s"); break;
			}
		}
	}