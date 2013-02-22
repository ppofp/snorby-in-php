<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*事件列表页面
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Event extends CI_Controller {

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
	
	
	
	public function index()
	{
		$params = $this->input->post('params');
		$page = $this->input->post('page');
		$page = intval($page) > 0 ? intval($page) : 1;
		$this->load->model('cache_model');
		$this->load->model('sig_model');
		$this->load->model('sensors_model');
		$data['params'] = $params;
		$data['type'] = 'list';
		$data['page'] = 'event';
		$data['eventlist'] = $this->cache_model->get_event_list($params, $page);
		$data['event_count'] = $this->cache_model->get_event_count($params);
		$data['current_page'] = $page;
		$data['signatures'] = $this->sig_model->get_sigs_name_id();
		$data['sensors'] = $this->sensors_model->get_all_sensors();
		$data['sensors_hostname'] = $this->sensors_model->get_sensors_hostname();
		
		$this->load->view('header', $data);
		$this->load->view('search_options');
		$this->load->view('event/eventlist');
		$this->load->view('_footer');
	}
	
	public function results()
	{
		$params = array( 'time_start'=>null, 'time_end'=>null, 'ip'=>null, 'tcp'=>null, 'udp'=>null, 'dns'=>null );
		
		$this->load->model('events_model');
		$data = array();
		$data['events'] = $this->events_model->get_events($params);
		
		$this->load->view('_header', $data);
		$this->load->view('search/results');
		$this->load->view('_footer');
	}
	
	public function ajax_options()
	{
		print_r(json_decode($this->input->post('params')));
		//$this->load->view('header', $data);
		//$this->load->view('options', $data);
	}
	
	public function exportList()
	{
		$params = $this->input->post('params');
		$this->load->model('cache_model');
		$data = $this->cache_model->get_export_event_list($params);
		$this->load->library('excel');
		
		$filename='Events.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$this->load->library('excel');
		$this->excel->simple_output($data['fields'], $data['list']);
	}
}