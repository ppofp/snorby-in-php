<?php

class Test extends CI_Controller {

	public function index()
	{
		/*date_default_timezone_set('Etc/GMT-8');
		echo "this year:";
		echo date('Y') . '-01-01';
		echo date('Y') . '-12-31';
		echo "<br/>";
		
		echo "this day:";
		echo date('Y-m-d');
		echo "<br/>";
		
		echo "yesterday:";
		echo date('Y-m-d', strtotime("-1 day"));
		echo "<br/>";
		
		echo "this week:";
		echo date('Y-m-d', strtotime("-1 week Monday"));
		echo date('Y-m-d', strtotime("-0 week Sunday"));
		echo "<br/>";
		
		echo "this month:";
		echo date('Y-m-1');
		echo date('Y-m-' . date('t'));
		echo "<br/>";
		
		echo "this quarter:";
		$season = ceil((date("n"))/3);//当月是第几季度
		echo date('Y-' . ($season*3-3+1) . '-1');
		echo date('Y-' . ($season*3) . '-' . date('t',mktime(0, 0 , 0,$season*3,1,date('Y'))));
		echo "<br/>";
		
		echo date("Y-m-d H:0:0", strtotime('-1 day'));*/
		
		$this->load->model('cache_model');
		$arr = $this->cache_model->get_sensor_metrics("month");
		print_r($arr);
	}
}
?>