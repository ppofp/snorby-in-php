<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistic_model extends CI_Model
{
	
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Etc/GMT-8');
		}
		/**
		 * 
		 * @param timestamp $time_start
		 * @param timestamp $time_end
		 */
		public function get_statistic_data($time_start, $time_end)
		{	
			$data = array();
			$data['sensors'] = $this->get_sensor($time_start, $time_end);
			$data['signatures'] = $this->get_signature($time_start, $time_end);
			$data['total'] = $this->get_total_account($time_start, $time_end);
			$data['ipsrc'] = $this->get_ipsrc($time_start, $time_end);
			$data['ipdst'] = $this->get_ipdst($time_start, $time_end);
			$data['time'] = $this->time_filter($time_start, $time_end);
			return $data;
		}
		
		public function get_sensor($time_start, $time_end)
		{

			$time = $this->time_filter($time_start, $time_end);
			
			
			$sql = "SELECT count(*) as cnt, sid FROM event
					WHERE unix_timestamp(timestamp) between " . $time['time_start'] . " AND " . $time['time_end'] .
					" GROUP BY sid " ;
			$query = $this->db->query($sql);
			
			$sensor_cnt = $query->result_array();
			
			$sql = 'SELECT * FROM `sensor`';
			$query = $this->db->query($sql);
			$result = $query->result_array();
			
			
			foreach( $result as &$row)
			{
				$row['cnt']  = 0; 
				foreach($sensor_cnt as $cnt_row)
				{
					if($row['sid'] == $cnt_row['sid'])
					{
						$row['cnt'] = $cnt_row['cnt'];
					}
				}
			}
			
			return $result;
			 
		}
		
		/**
		 * 
		 * @param timestamp $time_start
		 * @param timestamp $time_end
		 * @return array
		 */
		public function get_signature($time_start, $time_end)
		{
			$time = $this->time_filter($time_start, $time_end);
				
				
			$sql = "SELECT count(*) as cnt, left(sig_name,25) as sig_name FROM event as e, signature as s
					WHERE e.signature = s.sig_id AND unix_timestamp(timestamp) between " . $time['time_start'] . " AND " . $time['time_end'] .
					" GROUP BY signature ORDER BY cnt DESC LIMIT 5" ;
			$query = $this->db->query($sql);
				
			$signatures = $query->result_array() ; 

			return $signatures;
		}
		
		
		/**
		 * 
		 * @param timestamp $time_start
		 * @param timestamp $time_end
		 */
		public function get_ipsrc($time_start, $time_end)
		{
			$time = $this->time_filter($time_start, $time_end);
			$sql = "SELECT count(*) as cnt,inet_ntoa(ip_src) as ipaddr FROM event as e, iphdr as ip
					WHERE e.sid = ip.sid AND e.cid = ip.cid 
						AND unix_timestamp(timestamp) between " . $time['time_start'] . " AND " . $time['time_end'].
					" GROUP BY ip_src 
					ORDER BY cnt DESC LIMIT 5";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		/**
		 * 
		 * @param timestamp $time_start
		 * @param timestamp $time_end
		 */
		public function get_ipdst($time_start, $time_end)
		{
			$time = $this->time_filter($time_start, $time_end);
			$sql = "SELECT count(*) as cnt,inet_ntoa(ip_dst) as ipaddr FROM event as e, iphdr as ip
					WHERE e.sid = ip.sid AND e.cid = ip.cid 
						AND unix_timestamp(timestamp) between " . $time['time_start'] . " AND " . $time['time_end'].
					" GROUP BY ip_dst 
					ORDER BY cnt DESC LIMIT 5";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function get_total_account($time_start, $time_end)
		{
			$time = $this->time_filter($time_start, $time_end);
			$sql = "SELECT count(*) as cnt FROM event 
					WHERE unix_timestamp(timestamp) between " . $time['time_start'] . " AND " . $time['time_end'];
			$query = $this->db->query($sql);
			
			if($query->num_rows() == 0)
				return 0;
			else
				return $query->row()->cnt;
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