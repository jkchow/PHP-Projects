<?

class acl_userLoginLog extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	
	function listsData(){

		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->user_login_log} where 1=1 ";
			
		if($_REQUEST["searchKeyword"]!=""){
			if($_REQUEST["searchFieldName"]=="user_id"){
				$where.=" and {$_REQUEST["searchFieldName"]}='{$_REQUEST["searchKeyword"]}' ";
			}else{
				$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
			}
			
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
		
		$list_sql="select auto_id,user_id,content_user,content_name,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		/*if(is_array($list))
		foreach($list as $key=>$vl){
			$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["user_id"]}'",array("content_name","content_user"));
			$list[$key]["content_name"]=$user["content_name"];
			$list[$key]["content_user"]=$user["content_user"];
		}*/
		
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);

	}

}

?>