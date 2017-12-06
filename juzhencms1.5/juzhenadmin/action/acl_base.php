<?
class acl_base{
	var $default_method="";
	var $tpl_file="";
	
	protected function getLoginUserId(){
		$passport=new Passport();
		$userInfo=$passport->get_passport();
		return $userInfo["ID"];
	}
	
	protected function getLoginUser(){
		$passport=new Passport();
		$userInfo=$passport->get_passport();
		return $userInfo;
	}
	
	
	function forward($method){
		global $global,$dao,$enumVars;
		if($method==""){
			$method=$this->default_method;
		}
		if(method_exists($this,$method)){
			$global->requestMethodName=$method;
			
			//记录到系统操作日志
			$passport=new passport();
			$userInfo=$passport->get_passport();
			$logArr=array();
			$logArr["user_id"]=$userInfo["ID"];
			$logArr["content_user"]=$userInfo["USER"];
			$logArr["content_name"]=$userInfo["NAME"];
			$logArr["acl"]=$global->requestAclName;
			$logArr["method"]=$global->requestMethodName;
			$IpTool=new IpTool();
			$logArr["ip"]=$IpTool->getClientIp();
			$logArr["url"]=$_SERVER["REQUEST_URI"];
			$logArr["request_data"]=json_encode(array("GET"=>$_GET,"POST"=>$_POST));
			$logArr["create_time"]=date("Y-m-d H:i:s");
			$dao->insert($dao->tables->user_log,$logArr);
			
			$_record=$this->$method();
			if($this->tpl_file!=""){
				
 				$acl_class=get_class($this);
				$acl_name=str_replace("acl_","",$acl_class);

				
				$tpl_file=$global->admin_absolutePath."/action/{$acl_name}/tpl/{$this->tpl_file}";
				
				if(file_exists($tpl_file))
					include($tpl_file);
				else
					echo "模板不存在";
			}
		}else{
			//$action=get_acl("error");
			//$action->forward("error404");
			echo "method not exist ";
		}
		exit;
	}
	
	protected function redirect($url,$alertMsg=NULL){
		if($alertMsg==NULL && $alertMsg=="" && !headers_sent()){
			header("location:{$url}");
			exit;
		}else{
			echo "<script>";
			if($alertMsg!=NULL && $alertMsg!="")
				echo "alert('{$alertMsg}');";
			echo "location.href='{$url}';</script>";
			exit;
		}
	}
	
	protected function redirectBack($alertMsg=NULL){
		if($alertMsg!=""){
			$alertStr="alert('{$alertMsg}');";
		}
		echo "<script>{$alertStr}history.back();</script>";
		exit;
	}
	//获取当前职位下管理的用户的ID
	protected function getManageUserIdStr(){
		global $dao;
		$passport=new passport();
		$userInfo=$passport->get_passport();
		$org_id=$userInfo["ORG"];
		$user_id=$userInfo["ID"];
		$user_name=$userInfo["USER"];
		
		//如果是超级管理员，返回所有用户id
		if($user_name=="admin"){
			$userList=$dao->get_datalist("select auto_id from {$dao->tables->user} where 1=1 ");
			$userArr=array();
			if(is_array($userList))
			foreach($userList as $key=>$vl){
				$userArr[]=$vl["auto_id"];
			}
			$userIdStr=implode(',',$userArr);
			if($userIdStr=="")
				return $user_id;
			else
				return $userIdStr;
		}
		
		
		if($org_id=="" || $org_id=="0")
			return $user_id;
		//查询下级职位
		$org=$dao->get_row_by_where($dao->tables->user_level,"where auto_id='{$org_id}'");
		if(!is_array($org))
			return $user_id;
		$subOrgList=$dao->get_datalist("select auto_id from {$dao->tables->user_level} where auto_code like '{$org["auto_code"]}____'");
		$subOrgArr=array();
		if(is_array($subOrgList))
		foreach($subOrgList as $key=>$vl){
			$subOrgArr[]=$vl["auto_id"];
		}
		$subOrgIdStr=implode(',',$subOrgArr);
		if($subOrgIdStr=="")
			return $user_id;
		
		//查询下级职位对应的用户ID
		$userList=$dao->get_datalist("select auto_id from {$dao->tables->user} where org_id in({$subOrgIdStr})");
		$userArr=array();
		$userArr[]=$user_id;
		if(is_array($userList))
		foreach($userList as $key=>$vl){
			$userArr[]=$vl["auto_id"];
		}
		$userIdStr=implode(',',$userArr);
		if($userIdStr=="")
			return $user_id;
		else
			return $userIdStr;
	}
	
	
}
?>