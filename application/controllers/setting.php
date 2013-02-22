<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 设置
 * @author LiHaibo_ISLee
 * @time 2013/2/17
 */
class Setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		
		if(!$this->session->userdata('login'))
		{
			redirect('users/login');
		}
	}
	
	public function index()
	{
		$data = array();
		$this->load->model('sig_model');
		$this->load->model('sensors_model');
		$data['signatures'] = $this->sig_model->get_sigs_name_id();
		$data['sensors'] = $this->sensors_model->get_all_sensors();
		$data['type'] = 'setting';
		$data['page'] = 'setting';
		$data['user'] = $this->session->userdata('user_info');
		$this->load->view('header', $data);
		$this->load->view('setting/setting');
		$this->load->view('_footer');
	}
	
	public function update_password()
	{
		$username = $this->input->post('username');
		$ori_pass = $this->input->post('ori_pass');
		$new_pass = $this->input->post('new_pass');
		$new_pass_verify = $this->input->post('new_pass_verify');
		
		$this->load->model('users_model');
		if($this->users_model->validate_user($username, $ori_pass) && $new_pass == $new_pass_verify)
		{
			$this->users_model->update_pwd($username, $new_pass);
			redirect(site_url('users/logout'));
		}
		
		else 
		{
			redirect(site_url('users/error_page'));
		}
		
		
	}
	
	public function ajaxRefreshDemonEvent()
	{
		$this->load->model('cache_model');
		$this->cache_model->refreshDemonEvent();
		echo "success";
	}
	
	public function uploadGeoIP()
	{
	  $config['upload_path'] = '../uploads/';
	  $config['allowed_types'] = 'csv|CSV';
	  $config['max_size'] = '0';
	  
	  $this->load->library('upload', $config);
	 
	  if ( !$this->upload->do_upload('geoLocation'))
	  {
	   $error = array('error' => $this->upload->display_errors());
	   var_dump($error);
	  // $this->load->view('upload_form', $error);
	  } 
	  else
	  {
	   $data = array('upload_data' => $this->upload->data());
	   var_dump($data);
	   //$this->load->view('upload_success', $data);
  }
	}
}