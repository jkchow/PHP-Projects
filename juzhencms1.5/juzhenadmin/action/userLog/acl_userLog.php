<?

class acl_userLog extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	
	function listsData(){

		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->user_log} where 1=1 ";
		
			
		if($_REQUEST["searchKeyword"]!=""){
			//$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
			$where.=" and {$_REQUEST["searchFieldName"]} = '{$_REQUEST["searchKeyword"]}' ";
		}
			
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,auto_id desc";
		}else{
			$orderby.=" order by auto_id desc";
		}
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["create_user"]}'",array("content_name"));
			//$list[$key]["create_user"]=$user["content_name"];
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);

	}
	

	

	

	
	function view(){
		$this->tpl_file="view.php";
		$record=array();
		
		/*if($_REQUEST["auto_id"]!=""){
			$recordData=$dao->get_row_by_where($dao->tables->user_log,"where auto_id='{$_REQUEST["auto_id"]}'");	
			ob_start();
			print_r(json_decode($recordData["request_data"]));
			$recordData["request_data_arr"]=ob_get_contents();
			ob_end_clean();
			
			ob_start();
			print_r(json_decode($recordData["return_data"]));
			$recordData["return_data_arr"]=ob_get_contents();
			ob_end_clean();
			
			$record["data"]=$recordData;
		}*/
		
		
		return $record;
	}
}

?>