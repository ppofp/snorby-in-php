<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*�û�����
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/15
	*/
class Users extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	/**
	*��¼ҳ �� ��¼��Ϣ���ύ����ҳ
	*/
	public function login()
	{
		$user = $this->input->post('user');
		$pwd = $this->input->post('password');
		
		$data = Array();
		$data['error_message'] = "";
		
		$this->load->helper('url');
		
		//�û���һ�ε���ҳ��
		if( empty($user) )
		{
			$this->load->view('users/login', $data);
		}
		
		//�����û��ύ�ĵ�¼��Ϣ
		else
		{
			$this->load->model('users_model');
			$validation = $this->users_model->validate_user($user, $pwd);
			
			//�ɹ���¼
			if( $validation )
			{
				$user_info = $this->users_model->get_user_info($user);
				
				//����session
				$this->session->set_userdata('user_info', $user_info);
				$this->session->set_userdata('login', "true");
				
				redirect(site_url('home'));
			}
			
			//��������û�������ȷ
			else
			{
					$data['error_message'] = "��������û�������";
					$this->load->view('users/login', $data);
			}
		}
	}
}