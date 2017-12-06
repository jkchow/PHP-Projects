<?

class acl_course extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	function form(){
		global $dao;
		$this->tpl_file="form.php";
		$record=array();
		
		if($_REQUEST["auto_id"]!=""){
			$recordData=$dao->get_row_by_where($dao->tables->course,"where auto_id='{$_REQUEST["auto_id"]}'");	
		}else{
			$recordData=array();
			$recordData["publish"]='1';
			$recordData["create_time"]=date("Y-m-d H:i:s");
		}

		$formData=array();
		if(is_array($recordData))
		foreach($recordData as $key=>$vl){
			if($vl==NULL)
				continue;
			if($key!="auto_id")
				$formData["frm[{$key}]"]=$vl;
			else
				$formData["{$key}"]=$vl;
		}
		
		
		
		$record["formData"]=$formData;
		
		
		
		//$record["menuVars"]=$dao->get_datalist("select auto_id as id,content_name as text from {$dao->tables->menu} order by position asc");
		
		return $record;
	}
	function listsData(){

		global $dao,$global;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->course} where 1=1 ";
		
		//用于选择框筛选
		if($_REQUEST["condition"]!=''){
			$str=urldecode($_REQUEST["condition"]);
			if($global->auto_addslashes)
				$str=stripslashes($str);
			$conditionArr=(array)json_decode($str);
			if(is_array($conditionArr))
			foreach($conditionArr as $key=>$vl){
				$vl=(array)$vl;
				if($vl["value"]!=""){
					if($vl["op"]=="like"){
						$where.=" and {$vl["field"]} like '%{$vl["value"]}%' ";
					}elseif($vl["op"]=="="){
						$where.=" and {$vl["field"]} = '{$vl["value"]}' ";
					}
				}	
			}
		}
			
		
		
		if($_REQUEST["category_id"]!='')
			$where.=" and category_id = '{$_REQUEST["category_id"]}' ";
			
			
		if($_REQUEST["category_code"]!=''){
			$category_list=$dao->get_datalist("select auto_id from {$dao->tables->course_category} where auto_code like '{$_REQUEST["category_code"]}%'");
			
			$category_id_arr=array();
			if(is_array($category_list) && count($category_list)>0)
			foreach($category_list as $key=>$vl){
				$category_id_arr[]=$vl["auto_id"];
			}
			if(count($category_id_arr)>0){
				$category_id_str=implode(',',$category_id_arr);
			}else{
				$category_id_str="0";
			}
			$where.=" and category_id in ({$category_id_str})  ";	
		}
			
		
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
		
		if($_REQUEST["recommend"]!='')
			$where.=" and recommend = '{$_REQUEST["recommend"]}' ";
			
			
		if($_REQUEST["searchKeyword"]!="")
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,create_time desc,auto_id desc";
		}else{
			$orderby.=" order by position asc,create_time desc,auto_id desc";
		}
		/*if($_REQUEST["recommend"]=='1'){
			$orderby.=" order by auto_position desc,create_time desc,auto_id desc";
		}elseif($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,auto_id desc";
		}else{
			$orderby.=" order by create_time desc,auto_id desc";
		}*/
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,content_name,category_id,content_price,content_num,recommend,publish,position,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["create_user"]}'",array("content_name"));
			$list[$key]["create_user"]=$user["content_name"];
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);

	}
	
	function save(){
		global $dao;
		
		
		$dataArray=$_POST["frm"];
		
		
		
		
		
		if($_POST["auto_id"]==""){
			$dataArray["create_user"]=$this->getLoginUserId();
			//$dataArray["auto_position"]=time();
			$dao->insert($dao->tables->course,$dataArray);			
		}else{
			$dao->update($dao->tables->course,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->course,"where auto_id='{$_REQUEST["auto_id"]}'");	
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");	
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	
	
	//保存排序操作
	function savePosition(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["position"]=$_REQUEST["position"];	
			
			if($dataArray["position"]=="")
				$dataArray["position"]="0";
			$dao->update($dao->tables->course,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	
	//保存库存操作
	function saveContentNum(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["content_num"]=$_REQUEST["content_num"];	
			
			if($dataArray["content_num"]=="")
				$dataArray["content_num"]="0";
			$dao->update($dao->tables->course,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	
	//保存价格操作
	function saveContentPrice(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["content_price"]=$_REQUEST["content_price"];	
			
			if($dataArray["content_price"]=="")
				$dataArray["content_price"]="0";
			$dao->update($dao->tables->course,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	

	
}

?>