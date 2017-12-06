<?
class addressService{
	function getCityByName($cityName){
		global $dao;
		//$cityName=str_replace("สะ","",$cityName);
		$city=$dao->get_row_by_where($dao->tables->address_city,"where name like '{$cityName}%'");
		return $city;
	}

	
	
	
}
?>