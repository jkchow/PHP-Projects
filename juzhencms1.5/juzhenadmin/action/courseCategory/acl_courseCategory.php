<?

class acl_courseCategory extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->course_category,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
			if($key!="auto_id" && $key!="auto_code")
				$formData["frm[{$key}]"]=$vl;
			else
				$formData["{$key}"]=$vl;
		}
		
		if($formData["auto_code"]!="" && strlen($formData["auto_code"])>4){
			$formData["p_code"]=substr($formData["auto_code"],0,strlen($formData["auto_code"])-4);
		}
		
		$record["formData"]=$formData;

		
		
		return $record;
	}
	
	function treeGridJsonData(){
		global $dao;
		
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->course_category} where auto_code like '____' ";
			
		$orderby.=" order by auto_position asc,auto_id asc";

		$pagesize=10;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		
		
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,auto_code,content_name,publish,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//获取下级数据
			$children=$this->getSubGridLists($vl["auto_code"]);
			if(is_array($children) && count($children)>0)
				$list[$key]["children"]=$children;
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		/*echo "<pre>";
		print_r($return_arr);
		exit;*/
		
		echo json_encode($return_arr);
	}
	
	private function getSubGridLists($code){
		global $dao;
		$where=" from {$dao->tables->course_category} where auto_code like '{$code}____' ";
			
		$orderby.=" order by auto_position asc,auto_id asc";
		
		$list_sql="select auto_id,auto_code,content_name,publish,create_time "
		.$where.$orderby;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//获取下级数据
			$children=$this->getSubGridLists($vl["auto_code"]);
			if(is_array($children) && count($children)>0)
				$list[$key]["children"]=$children;
		}
		return $list;
		
	}
	
	
	//获取栏目编辑时上级栏目的选择数据
	function pcodeFormJsonData(){
		
		if($_REQUEST["editCode"]!="")
			$sqlStr="auto_code not like '{$_REQUEST["editCode"]}%'";
		
		$return_arr=$this->getTreeData($sqlStr);
		echo json_encode($return_arr);
	}
	
	//获取商品列表的分类表单数据
	function categoryFormJsonData(){	
		$return_arr=$this->getTreeData();
		echo json_encode($return_arr);
	}
	
	private function getTreeData($where="",$pCode=""){
		
		if(trim($where)!="")
			$whereStr=" and ".$where;
		
		global $dao;
		$list_sql="select auto_id,auto_code,content_name as text from {$dao->tables->course_category} where auto_code like '{$pCode}____' {$whereStr} order by auto_position asc,auto_code asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);
		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){
			$subList=$this->getTreeData($where,$vl["auto_code"]);
			if(is_array($subList) && count($subList)>0)
				$list[$key]["children"]=$subList;
		}
		return $list;
	}
	
	
	
	
	function save(){
		global $dao;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		

		/*if(($dataArray["content_module"]!="" && $dataArray["content_module"]!="null") || $dataArray["action_method"]!=""){
			if($dataArray["content_module"]=="" || $dataArray["content_module"]=="null")
				$acl_class="index";
			else
				$acl_class=$dataArray["content_module"];
			$acl_class="acl_".$acl_class;
			$tmp_acl=new $acl_class;
			
		}*/
		
		if($_POST["auto_id"]==""){
			
			//生成code编码
			
			//如果pcode为空，查询当前级别code最大值，然后加1
			$tmp=$dao->get_datalist("select max(right(auto_code,4)) as max_code from {$dao->tables->course_category} where auto_code like '{$_POST["p_code"]}____'");

			
			
			if($tmp[0]["max_code"]==NULL || $tmp[0]["max_code"]=="")
				$dataArray["auto_code"]=$_POST["p_code"]."1000";
			else
				$dataArray["auto_code"]=$_POST["p_code"].(1+$tmp[0]["max_code"]);

			$dataArray["auto_position"]=time();
			$dataArray["create_user"]=$this->getLoginUserId();
			
			
			$dao->insert($dao->tables->course_category,$dataArray);			
		}else{
			
			$dao->update($dao->tables->course_category,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
			
			//保存时需要判断$_POST["auto_code"]与$_POST["p_code"]
			
			//auto_code 与 pcode对比
			if(substr($_POST["auto_code"],0,strlen($dataArray["auto_code"])-4)!=$_POST["p_code"]){
				
				//如果pcode为空，查询当前级别code最大值，然后加1
				$tmp=$dao->get_datalist("select max(right(auto_code,4)) as max_code from {$dao->tables->course_category} where auto_code like '{$_POST["p_code"]}____'");

				
				if($tmp[0]["max_code"]==NULL || $tmp[0]["max_code"]=="")
					$new_code=$_POST["p_code"]."1000";
				else
					$new_code=$_POST["p_code"].(1+$tmp[0]["max_code"]);

				
				$code_length=strlen($_POST["auto_code"])+1;
				
				$update_sql="update {$dao->tables->course_category} "
							."set auto_code=concat('{$new_code}',substring(auto_code,{$code_length})) "
							."where auto_code like '{$_POST["auto_code"]}%'";			
				
				$dao->query($update_sql);	
			}	
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		//$this->redirectBack();
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->course_category,"where auto_id='{$_REQUEST["auto_id"]}'");	
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	//栏目顺序向前移动
	function position_up(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->course_category,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","auto_code","auto_position"));
			$p_code=substr($this_record["auto_code"],0,strlen($this_record["auto_code"])-4);
			//查找上一栏目
			$previous_record=$dao->get_row_by_where($dao->tables->course_category,"where auto_code like '{$p_code}____' and auto_position <='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position desc",array("auto_id","auto_code","auto_position"));
			
			if(is_array($previous_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$previous_record["auto_position"]){
					$this_position["auto_position"]=$previous_record["auto_position"];
					$dao->update($dao->tables->course_category,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$previous_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->course_category,$previous_position,"where auto_id='{$previous_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$previous_record["auto_position"]-1;
					$dao->update($dao->tables->course_category,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//栏目顺序向后移动
	function position_down(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->course_category,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","auto_code","auto_position"));
			$p_code=substr($this_record["auto_code"],0,strlen($this_record["auto_code"])-4);
			//查找下一栏目
			$next_record=$dao->get_row_by_where($dao->tables->course_category,"where auto_code like '{$p_code}____' and auto_position >='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position asc",array("auto_id","auto_code","auto_position"));
			
			if(is_array($next_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$next_record["auto_position"]){
					$this_position["auto_position"]=$next_record["auto_position"];
					$dao->update($dao->tables->course_category,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$next_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->course_category,$next_position,"where auto_id='{$next_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$next_record["auto_position"]+1;
					$dao->update($dao->tables->course_category,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	
	
}

?>