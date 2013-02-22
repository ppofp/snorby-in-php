<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*用户中心
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		redirect(site_url('user/login'));
	}
	
	/**
	*登录页 和 登录信息的提交处理页
	*/
	public function login()
	{
		$user = $this->input->post('user');
		$pwd = $this->input->post('password');
		
		$data = Array();
		$data['error_message'] = "";
		
		
		//用户第一次到本页面
		if( empty($user) )
		{
			$this->load->view('users/login', $data);
		}
		
		//处理用户提交的登录信息
		else
		{
			$this->load->model('users_model');
			$validation = $this->users_model->validate_user($user, $pwd);
			
			//成功登录
			if( $validation )
			{
				$user_info = $this->users_model->get_user_info($user);
				
				//设置session
				$this->session->set_userdata('user_info', $user_info);
				$this->session->set_userdata('login', true);
				
				redirect(site_url('home'));
			}
			
			//密码或者用户名不正确
			else
			{
				$data['error_message'] = "密码或者用户名错误！";
				$this->load->view('users/login', $data);
			}
		}
	}
	
	/**
	*登出
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url('users/login'));
	}
	
	/**
	*404
	*/
	public function notfound()
	{
		$this->load->view('404');
	}
}