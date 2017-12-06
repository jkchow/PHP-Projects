<?
class areaService{
	private function baiduIpApi($ip){
		$url="http://api.map.baidu.com/location/ip?ak=185165ebf9bc8ca67193ff24a03e07ee&coor=bd09ll"; 
		
		if($ip!=""){
			$url.="&ip=".$ip;
		}
		//$url="http://api.map.baidu.com/location/ip?ak=WGqhM9sQgeIuE9TngsVeEO5u&ip=202.198.16.3&coor=bd09ll"; 
		//$url="http://api.map.baidu.com/location/ip?ak=E4805d16520de693a3fe707cdc962045&ip=202.198.16.3&coor=bd09ll";
		$mapArr=(array)json_decode(@file_get_contents($url));
		
		//CN|河北|廊坊|None|CHINANET|None|None
		preg_match('/^[^\|]+\|([^\|]+)\|([^\|]+)\|/i',$mapArr["address"],$preg_result);
		/*echo "<pre>";
		print_r($preg_result);
		exit;*/
		
		$return_arr=array();
		$return_arr["province"]=$preg_result[1];
		$return_arr["city"]=$preg_result[2];
		return $return_arr;	
	}
	
	private function ipRecordFile($ip){
		
	}
	
	function getDefaultCityInfo(){
		$return_arr=array();
		$return_arr["province_name"]="北京市";
		$return_arr["province_id"]="1";
		$return_arr["city_name"]="北京市";
		$return_arr["city_id"]="1";	
		return $return_arr;
	}
	
	
	function getCityInfoByIp(){
		global $dao;
		$ip=$this->getIP();
		$return_arr=array();
		if($ip=="" || $ip=="unknown" || $ip=="127.0.0.1" || strpos($ip, "192.168.")!==false){
			return $this->getDefaultCityInfo();
		}
			
		
		$info_arr=$this->baiduIpApi($ip);
		
		
		//获取省
		$province=$dao->get_row_by_where($dao->tables->address_province,"where name like'{$info_arr["province"]}%' ");
		
		if(is_array($province)){
			
			$return_arr["province_name"]=$province["name"];
			$return_arr["province_id"]=$province["id"];
			//获取城市
			$city=$dao->get_row_by_where($dao->tables->address_city,"where province_id='{$province["id"]}' and name like'{$info_arr["city"]}%' ");
			
			if(is_array($city)){
				$return_arr["city_name"]=$city["name"];
				$return_arr["city_id"]=$city["id"];			
			}else{
				return $this->getDefaultCityInfo();
			}		
		}else{
			return $this->getDefaultCityInfo();
		}
		
		/*echo "<pre>";
		print_r($return_arr);
		exit;*/
		
		return $return_arr;
	}
	
	function getIP(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		     $ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		     $ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		     $ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		     $ip = $_SERVER['REMOTE_ADDR'];
		else
		     $ip = "unknown";
		return($ip);
	}
	
	function changeLocationCity($cityId){
		global $dao;
		//获取城市信息
		$city=$dao->get_row_by_where($dao->tables->address_city,"where id='{$cityId}'");
		$province=$dao->get_row_by_where($dao->tables->address_province,"where id='{$city["province_id"]}'");
		$cityInfo=array();
		$cityInfo["province_name"]=$province["name"];
		$cityInfo["province_id"]=$province["id"];
		$cityInfo["city_name"]=$city["name"];
		$cityInfo["city_id"]=$city["id"];	
		$_SESSION["cityInfo"]=$cityInfo;
		//获取经销商信息
		$agentService=new agentService();
		$agent=$agentService->getAgent($_SESSION["cityInfo"]["province_id"],$_SESSION["cityInfo"]["city_id"]);
		$_SESSION["cityInfo"]["agent_id"]=$agent["auto_id"];
	}
	
	
	function getProvinceLists(){
		global $dao;
		return $dao->get_datalist("select * from {$dao->tables->address_province} order by id asc");
	}
	
	function getCityLists($provinceId){
		global $dao;
		return $dao->get_datalist("select * from {$dao->tables->address_city} where province_id='{$provinceId}' order by city_index asc,id asc");
	}
	
	function getProvinceName($provinceId){
		global $dao;
		$province=$dao->get_row_by_where($dao->tables->address_province,"where id='{$provinceId}'");
		return $province["name"];
	}
	
	function getCityName($cityId){
		global $dao;
		$city=$dao->get_row_by_where($dao->tables->address_city,"where id='{$cityId}'");
		return $city["name"];
	}
	
	
}
?>