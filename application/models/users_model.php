<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*�û�ģ��
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Users_model extends CI_Model {
	
	/**
	*��֤�û��û����������Ƿ���ȷ
	*/
	public function validate_user($user, $pwd)
	{
		return true;
	}
	
	/**
	*��ȡ�û���Ϣ
	*/
	public function get_user_info($user)
	{
		return Array('name'=>'ADMIN');
	}
}