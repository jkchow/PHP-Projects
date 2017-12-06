<?

class acl_memberPhotos extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->member_photos,"where auto_id='{$_REQUEST["auto_id"]}'");	
		}else{
			$recordData=array();
			$recordData["member_id"]=$_REQUEST["member_id"];
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
		
		
		$where=" from {$dao->tables->member_photos} where 1=1 ";
		
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
		
		/*if($_REQUEST["menu"]!='')
			$where.=" and menu_id = '{$_REQUEST["menu"]}' ";*/
			
		if($_REQUEST["member_id"]!='')
			$where.=" and member_id = '{$_REQUEST["member_id"]}' ";
			
			
		if($_REQUEST["searchKeyword"]!="")
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,create_time desc,auto_id desc";
		}else{
			$orderby.=" order by create_time desc,auto_id desc";
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
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		
		
		
		
		if(is_array($list))
		foreach($list as $key=>$vl){
			$city=$dao->get_row_by_where($dao->tables->address_city,"where id='{$vl["city_id"]}'",array("name"));
			$list[$key]["city_id"]=$city["name"];
			//$list[$key]["content_status"]=$DictionaryVars->getText($caseTypeVars,$vl["content_status"]);
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
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		
		
		if($_POST["auto_id"]==""){
			//$dataArray["is_agree"]="1";
			//$dataArray["is_system"]="1";
			//$dataArray["create_user"]=$this->getLoginUserId();
			//$dataArray["auto_position"]=time();
			$dao->insert($dao->tables->member_photos,$dataArray);			
		}else{
			$dao->update($dao->tables->member_photos,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
		
		
			
		//$backUrl=base64_decode($_REQUEST["backUrl"]);	
		//$this->redirect($backUrl);
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$idStr=trim($_REQUEST["auto_id"],',');
			$idArr=explode(',',$idStr);
			if(is_array($idArr) && count($idArr)>0){
				foreach($idArr as $key=>$vl){
					if($vl=="")
						unset($idArr[$key]);
				}
				$idStr=implode(',',$idArr);
				$dao->delete($dao->tables->member_photos,"where auto_id in({$idStr})");
			}
		}	
		//$backUrl=base64_decode($_REQUEST["backUrl"]);	
		//$this->redirect($backUrl);	
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
			$dao->update($dao->tables->member_photos,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	
	
}

?>