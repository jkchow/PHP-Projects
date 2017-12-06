<?

class acl_user extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$_REQUEST["auto_id"]}'");	
			if($recordData["org_id"]=="0"){
				unset($recordData["org_id"]);
			}
				
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
			if($key=="auto_id")
				$formData["{$key}"]=$vl;
			elseif($key=="content_pass")
				$formData["frm[{$key}]"]="";
			else
				$formData["frm[{$key}]"]=$vl;
		
		}
		$record["formData"]=$formData;
		
		//查询角色表单及聚焦数据
		$roleValue=explode(',',$recordData["content_role"]);
		//查询超级管理员角色
		$tmp=$dao->get_datalist("select auto_id as value,content_name as text from {$dao->tables->role} order by auto_id asc");
		$adminRole=array();
		$commonRole=array();
		if(is_array($tmp))
		foreach($tmp as $key=>$vl){
			
			if(is_array($roleValue))
			foreach($roleValue as $k=>$v){
				if($v==$vl["value"])
					$vl["ischecked"]=true;
			}
			
			if($vl["value"]=="1")
				$adminRole[]=$vl;
			else
				$commonRole[]=$vl;		
		}
		
		if(is_array($adminRole) && count($adminRole)=="1"){
			$adminRole[0]["children"]=$commonRole;
			$record["roleVars"]=$adminRole;
		}else{
			$record["roleVars"]=$commonRole;
		}
		
		/*echo "<pre>";
		print_r($record["roleVars"]);
		exit;*/
		
		
		/*//前台表单checkbox无法自动聚焦，手动设置聚焦
		if($recordData["content_role"]!=""){
			$role_arr=explode(';',$recordData["content_role"]);
			
			if(is_array($record["roleVars"]))
			foreach($record["roleVars"] as $key=>$vl){
				if(in_array($vl["id"],$role_arr))
					$record["roleVars"][$key]["ischecked"]=true;
			}
		}*/
		return $record;
	}
	function listsData(){

		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->user} where content_user!='admin' ";
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
			
		if($_REQUEST["searchKeyword"]!="")
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		
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
		
		$list_sql="select auto_id,content_user,content_name,content_role,publish,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//$role=$dao->get_row_by_where($dao->tables->role,"where auto_id='{$vl["content_role"]}'",array("content_name"));
			//$list[$key]["content_role"]=$role["content_name"];
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
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		if($dataArray["content_pass"]!=""){
			
			/*//校验密码强度是否符合要求
			$StringTool=new StringTool();
			if(strlen($dataArray["content_pass"])<8 || $StringTool->getPasswordLevel($dataArray["content_pass"])<3){
				echo json_encode(array("result"=>0,"msg"=>"密码强度不符合要求，密码必须是8位以上并且包含数字及大小写字母"));
				exit;
			}*/
			
			
			$dataArray["pass_randstr"]=rand(1000000,9999999);
			$dataArray["content_pass"]=md5($dataArray["content_pass"].$dataArray["pass_randstr"]);
			$dataArray["content_token"]=rand(1000000,9999999);
		}else{
			unset($dataArray["content_pass"]);
		}
		
		//判断用户名不允许重复
		$tmp=$dao->get_datalist("select auto_id from {$dao->tables->user} where auto_id!='{$_POST["auto_id"]}' and content_user='{$dataArray["content_user"]}'");
		if(is_array($tmp) && count($tmp)>0){
			//$this->redirectBack("已经存在同样用户名的用户，请更换用户名");
			echo json_encode(array("result"=>0,"msg"=>"已经存在同样用户名的用户，请更换用户名"));
			exit;
		}
		
		
		if($_POST["auto_id"]==""){
			$dataArray["create_user"]=$this->getLoginUserId();
			$dataArray["content_token"]=rand(1000000,9999999);
			$dao->insert($dao->tables->user,$dataArray);		
		}else{
			$dao->update($dao->tables->user,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl=user&method=lists");	
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
				$dao->delete($dao->tables->user,"where auto_id in({$idStr})");
			}
		}	
		//$this->redirect("?acl=user&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	
	function passwordForm(){
		$this->tpl_file="password.php";
		$record=array();
		$userInfo=$this->getLoginUser();
		$record["formData"]["auto_id"]=$userInfo["ID"];
		$record["formData"]["content_user"]=$userInfo["USER"];
		return $record;
	}
	
	function changePassword(){
		global $dao;
		
		$userID=$this->getLoginUserId();
		$olduser=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$userID}' ");
		$old_pass=md5($_POST["old_pass"].$olduser["pass_randstr"]);

		
		$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$userID}' and content_pass='{$old_pass}'",array("auto_id"));
		
		if($user["auto_id"]!=""){
			
			
			/*//校验密码强度是否符合要求
			$StringTool=new StringTool();
			if(strlen($_POST["new_pass"])<8 || $StringTool->getPasswordLevel($_POST["new_pass"])<3){
				echo json_encode(array("result"=>0,"msg"=>"密码强度不符合要求，密码必须是8位以上并且包含数字及大小写字母"));
				exit;
			}*/
			
			$new_randstr=rand(1000000,9999999);
			$new_pass=md5($_POST["new_pass"].$new_randstr);
			$new_token=rand(1000000,9999999);
			
			$dao->update($dao->tables->user,array("content_pass"=>$new_pass,"pass_randstr"=>$new_randstr,"content_token"=>$new_token),"where auto_id='{$userID}' and content_pass='{$old_pass}'");
			$msg="密码修改成功";
		}else{
			$msg="原密码输入错误";
		}
		
		
		//$this->redirect("?acl=user&method=passwordForm",$msg);
		echo json_encode(array("result"=>1,"msg"=>$msg));
		
	}
	
	
	
	
}

?>