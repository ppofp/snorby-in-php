<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*signature model
	*@author:LiHaibo_ISLee
	*@time:2013/1/30
	*/
class Sig_model extends CI_Model {
	
	public function get_sigs_name_id()
	{
		$sql = 'SELECT `sig_name` as name, `sig_id` as id FROM `signature`';
		$query = $this->db->query($sql);
			
		return $query->result_array();
	}
}