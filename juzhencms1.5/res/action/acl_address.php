<?
class acl_address extends base_acl{
	var $default_method="";
	
	function cityData(){
		global $dao;
		$list=array();
		if($_GET["pid"]!=""){
			$list_sql="select id as id,name as text from {$dao->tables->address_city} where province_id='{$_GET["pid"]}' order by city_index asc";
			$list=$dao->get_datalist($list_sql);
			if(is_array($list))
			foreach($list as $key=>$vl){
				if($vl["id"]==$_REQUEST["selectedId"]){
					$list[$key]["selected"]=1;
				}
			}
		}
		//$list=array_merge(array(array("id"=>"","text"=>"选择城市")),$list);
		$record=json_encode($list);
		echo json_encode($list);
		
	}


	
	
	
	
	
	
}
?>