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
		return true;
	}
	
	/**
	*获取用户信息
	*/
	public function get_user_info($user)
	{
		return Array('name'=>'ADMIN');
	}
}