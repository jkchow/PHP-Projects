<?

class acl_area extends acl_base{
	var $acl_name="area";
	var $default_method="provinceData";
	function provinceData(){
		global $dao;
		
		$list_sql="select id as id,name as text from {$dao->tables->address_province} order by id asc";
		$list=$dao->get_datalist($list_sql);
		echo json_encode($list);
		
	}
	
	function cityData(){
		global $dao;
		$list=array();
		if($_GET["pid"]!=""){
			$list_sql="select id as id,name as text from {$dao->tables->address_city} where province_id='{$_GET["pid"]}' order by city_index asc";
			$list=$dao->get_datalist($list_sql);
		}
		echo json_encode($list);
		
	}

}

?>