<?

class acl_product extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->product,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
		
		
		$where=" from {$dao->tables->product} where 1=1 ";
		
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
			
		if($_REQUEST["content_type"]!='')
			$where.=" and content_type = '{$_REQUEST["content_type"]}' ";
			
		if($_REQUEST["content_status"]!='')
			$where.=" and content_status = '{$_REQUEST["content_status"]}' ";
			
		if($_REQUEST["earnings_type"]!='')
			$where.=" and earnings_type = '{$_REQUEST["earnings_type"]}' ";
		
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
		
		$list_sql="select auto_id,content_name,content_org,content_status,member_id,content_type,recommend,publish,position,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		
		
		$DictionaryVars=new DictionaryVars();
		$caseTypeVars=$DictionaryVars->getVars("sellStatusVars");
		
		
		if(is_array($list))
		foreach($list as $key=>$vl){
			//$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["create_user"]}'",array("content_name"));
			//$list[$key]["create_user"]=$user["content_name"];
			$list[$key]["content_status"]=$DictionaryVars->getText($caseTypeVars,$vl["content_status"]);
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
			//$dataArray["menu_id"]=$_REQUEST["menu"];
			$dataArray["create_user"]=$this->getLoginUserId();
			//$dataArray["auto_position"]=time();
			$dao->insert($dao->tables->product,$dataArray);			
		}else{
			$dao->update($dao->tables->product,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");	
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
				$dao->delete($dao->tables->product,"where auto_id in({$idStr})");
			}
		}	
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
			$dao->update($dao->tables->product,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	
	/*//栏目顺序向前移动
	function position_up(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->product,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","menu_id","auto_position"));
			
			//查找上一栏目
			$previous_record=$dao->get_row_by_where($dao->tables->product,"where menu_id='{$this_record["menu_id"]}' and auto_position >='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position asc",array("auto_id","menu_id","auto_position"));
			
			if(is_array($previous_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$previous_record["auto_position"]){
					$this_position["auto_position"]=$previous_record["auto_position"];
					$dao->update($dao->tables->product,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$previous_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->product,$previous_position,"where auto_id='{$previous_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$previous_record["auto_position"]-1;
					$dao->update($dao->tables->product,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//栏目顺序向后移动
	function position_down(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->product,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","menu_id","auto_position"));
			$p_code=substr($this_record["auto_code"],0,strlen($this_record["auto_code"])-4);
			//查找下一栏目
			$next_record=$dao->get_row_by_where($dao->tables->product,"where menu_id='{$this_record["menu_id"]}' and auto_position <='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position desc",array("auto_id","menu_id","auto_position"));
			
			if(is_array($next_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$next_record["auto_position"]){
					$this_position["auto_position"]=$next_record["auto_position"];
					$dao->update($dao->tables->product,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$next_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->product,$next_position,"where auto_id='{$next_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$next_record["auto_position"]+1;
					$dao->update($dao->tables->product,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}*/
	
	
}

?>