<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*IDS model
	*@author:LiHaibo_ISLee
	*@time:2013/1/30
	*/
class Sensors_model extends CI_Model {
	
	/**
	*return all sensors' name
	*/
	public function get_sensors_hostname()
	{
		$sql = 'SELECT sid,`hostname` FROM `sensor`';
		$query = $this->db->query($sql);
		$sensors = array();
		
		foreach($query->result_array() as $result)
			$sensors[$result['sid']] = $result['hostname'];
			
		return $sensors;
	}
	
	/**
	*return all sensors' information
	*/
	public function get_all_sensors()
	{
		$sql = 'SELECT * FROM `sensor`';
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
}