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
		
		//$this->load->model('cache_model');
		//$low = $this->cache_model->get_statistic_graph( '{"time":{"start":' . strtotime('-1 day +1 second') . ',"end":' . time() . '},"protocol":{"checkAll":true},"signature":{"checkAll":true},"sensor":{"checkAll":true}}');
		//print_r($low);
		//echo strtotime("-1 year");
		//echo " ";
		//echo time();
		//print_r(implode(",",explode(",", "1,2,3,")));
		//$arr = $this->cache_model->get_sensor_metrics("month");
		
		//$arr = array_merge(array(1=>2, 3=>4), array(3=>4,5=>4));
		//echo date("Y-m-d H:i:s", strtotime('-1 day +5 hour'));//echo date("Y-m-d H:i:s"); //print_r(time());
		//foreach(get_declared_classes() as $class )
		//{
		//	Reflection::export(new ReflectionClass($class));
		//}
		//$this->load->view('404');
		//$this->load->model('cache_model');
		//$result = $this->cache_model->get_threat_ip('acid_event as e');//('{"time":{"start":1360819440,"end":1360905840,"axis":"hour"},"protocol":"6,","signature":"1,4,","ip":{"src":"192.168.118.1,192.178.127.1,,"},"sensor":"1,"}');//get_axis_array(strtotime('2013-01-04'), strtotime('2013-01-04 01:03:30'), "minute");
		//var_dump($result);
		//$result = file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=202.120.2.100');
		//$result = json_decode(($result), true);
		//var_dump($result);
		//printf("%u",ip2long('202.120.2.100'));
		//$this->load->view('dashboard/ipmap');
		//$this->load->library('demonGeoIP');
		//$stime = microtime(true);
		//var_dump($this->demongeoip->get_ip_geo('192.168.116.1'));
		//$etime = microtime(true);
		//echo $stime - $etime;
		//echo BASEPATH . "../uploads/";//$_SERVER['path'];
		$this->load->model('cache_model');
		$result = $this->cache_model->get_event_list(NULL);
		var_dump($result);
			
		//var_dump($this->demonGeoIP);

	}
}
?>