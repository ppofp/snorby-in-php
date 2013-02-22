<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*用户模型
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Users_model extends CI_Model {
	
	/**
	*验证用户用户名和密码是否正确
	*/
	public function validate_user($user, $pwd)
	{	
		$sql = "SELECT * FROM `users` WHERE name=? AND password=?";
		$query = $this->db->query($sql, array($user, md5($pwd)));
		
		return ($query->num_rows() > 0);
	}
	
	/**
	*获取用户信息
	*/
	public function get_user_info($user)
	{
		$sql = 'SELECT * FROM `users` WHERE name=?';
		$query = $this->db->query($sql, array($user));
		
		if($query->num_rows() > 0 )
		{
			return $query->row_array();
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * update user's password
	 * @param string $user username 
	 * @param string $pwd new password
	 */
	public function update_pwd($user, $pwd)
	{
		$sql = 'UPDATE `users` SET password=? WHERE name=?';
		$this->db->query($sql, array(md5($pwd),$user));
	}
}