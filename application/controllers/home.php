<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*��ҳ
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Home extends CI_Controller {

	/**
	*���캯��
	*�����֤
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
	 */
	public function index()
	{
		redirect(site_url('dashboard'));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */