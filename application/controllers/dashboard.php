<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*仪表盘，显示统计信息等
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Dashboard extends CI_Controller {

	/**
	*构造函数
	*身份验证
	*/
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		
		if(!$this->session->userdata('login'))
		{
			redirect('users/login');
		}
	}
	
	/**
	*仪表盘的首页
	*/
	public function index()
	{
		//$this->output->cache(1);

		
		$data = Array();
		
		$params = $this->input->post('params');
		
		$this->load->model('cache_model');
		$this->load->model('sig_model');
		$this->load->model('sensors_model');
		$data = $this->cache_model->get_statistic_graph($params);
		$data['signatures'] = $this->sig_model->get_sigs_name_id();
		$data['sensors'] = $this->sensors_model->get_all_sensors();
		$data['params'] = $params;
		$data['type'] = 'graph';
		$data['page'] = 'dashboard';
		$this->load->view('header', $data);
		$this->load->view('search_options');
		///var_dump($data);
		$this->load->view('dashboard/dashboard');
		$this->load->view('dashboard/ipmap');
		$this->load->view('_footer');
	}
}