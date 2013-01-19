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
		$ran = $this->input->get('range');
		$range = $ran ? strtolower($ran) : "last_24";
		
		$data = Array();
		
		$data['range'] = $range;
		
		$this->load->model('cache_model');
		
		//protocol
		$data['tcp'] = $this->cache_model->get_protocol_count("tcp", $range);
		$data['udp'] = $this->cache_model->get_protocol_count("udp", $range);
		$data['icmp'] = $this->cache_model->get_protocol_count("icmp", $range);
		
		//severity
		$data['high'] = $this->cache_model->get_severity_count('high', $range);
		$data['medium'] = $this->cache_model->get_severity_count('medium', $range);
		$data['low'] = $this->cache_model->get_severity_count('low', $range);
		$data['event_count'] = array_sum($data['high']) + array_sum($data['medium']) + array_sum($data['low']); 
		
		//sensor metrics
		$data['sensor_metrics'] = $this->cache_model->get_sensor_metrics($range);
		
		//src metrics
		$data['src_metrics'] = $this->cache_model->get_src_metrics($range);
		
		//dst metrics
		$data['dst_metrics'] = $this->cache_model->get_dst_metrics($range);
		
		//signature metrics
		$data['signature_metrics'] = $this->cache_model->get_sig_metrics($range);
		
		$data['axis'] = $this->cache_model->get_axis($range);
		
		$this->load->view('_header', $data);
		$this->load->view('dashboard/dashboard');
		$this->load->view('_footer');
	}
}