<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *统计页面
 *@Author:LiHaibo_ISLee
 *@Time:2013/1/15
*/
class Statistic extends CI_Controller {
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
		//echo "statistic";
		$time_start = $this->input->post('time_start');
		$time_end = $this->input->post('time_end');
		
		$this->load->model('statistic_model');
		$data = $this->statistic_model->get_statistic_data($time_start, $time_end);
		$data['page'] = 'statistic';
		
		$this->load->view('header', $data);
		$this->load->view('statistic/statistic');
		$this->load->view('_footer');
	}
}