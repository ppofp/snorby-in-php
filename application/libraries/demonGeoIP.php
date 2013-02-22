<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/geoipcity.inc";
require_once APPPATH."/third_party/geoipregionvars.php";

class DemonGeoIP
{
	var $gi;
	
	public function __construct()
	{
		$this->gi = geoip_open(BASEPATH . "../uploads/" . "GeoLiteCity.dat", GEOIP_STANDARD);
	}
	
	/**
	 * 
	 * @param string $ip dotted decimal notation
	 * @return array latlng
	 */
	public function get_ip_latlng($ip)
	{
		$record = geoip_record_by_addr($this->gi,$ip);
		$result = array();
		$result['latitude'] = $record->latitude;
		$result['longitude'] = $record->longitude;
		return $result;
	}
	
	public function get_ip_city($ip)
	{
		$record = geoip_record_by_addr($this->gi,$ip);
		return $record->city;
	}
	
	/**
	 * 
	 * @param string $ip dotted decimal notation
	 * @return array ip geo detail, if it is not a valid ip, NULL will be returned
	 */
	public function get_ip_geo($ip)
	{
		$record = geoip_record_by_addr($this->gi,$ip);
		if(!is_object($record))
			return NULL;
		
		$result = array();
		$result['latitude'] = $record->latitude;
		$result['longitude'] = $record->longitude;
		$result['country'] = $record->country_name;
		$result['city'] = $record->city;
		
		return $result;		
	}
	
	
	public function __destruct()
	{
		geoip_close($this->gi);
	}
}