<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*Events Model
	*@Author:LiHaibo_ISLee
	*@Time:2013/1/20
	*/
	
	class Events_model extends CI_Model{
	
	/**
	*查询符合参数要求的事件并返回
	*
	*/
	public function get_events($params = array())
	{
		if( $this->input->get('time_horizon') == 'checked' )
		{
			$params['time_start'] = $this->input->get('time_start');
			$params['time_end'] = $this->input->get('time_end');
		}
		
		if( $this->input->get('engine') == 'checked' )
		{
			$params['tcp'];
		}
		
	}
	
	}