<?
class base_acl{
	var $default_method="";
	var $tpl_file="";
	function returnData($method,$requestData){
		global $global;
		if($method==""){
			$method=$this->default_method;
			if($method==""){
				echo "method is null";
				exit;
			}
			$_REQUEST["method"]=$method;
		}
		
		if(method_exists($this,$method)){
			$_record=$this->$method($requestData);
			
			//将接口调用日志存入数据库-------------------------------
			
			global $dao,$global;
			$logRecord=array();
			$logRecord["acl"]=$requestData["acl"];
			$logRecord["method"]=$requestData["method"];
			$json_str=$_REQUEST["param"];
			if($global->auto_addslashes){
				$json_str=stripslashes($json_str);
			}
			$logRecord["request_data"]=$json_str;
			
			
			if(is_array($_record)){
				$logRecord["result"]=$_record["result"];
				$logRecord["return_data"]=json_encode($_record);
			}else{
				$tmp=(array)json_decode($_record);
				$logRecord["result"]=$tmp["result"];
				$logRecord["return_data"]=$_record;	
			}
			$logRecord['app_id']=$global->app_id;
			$logRecord["device_id"]=$requestData["device_id"];
			
			$memberService=new memberService();
			$member=$memberService->getLoginMemberInfo();
			
			if($member["auto_id"]!=""){
				$logRecord["member_id"]=$member["auto_id"];
			}elseif($requestData["device_id"]!="" && $member["auto_id"]==""){
				$deviceRecord=$dao->get_row_by_where($dao->tables->app_device,"where device_id='{$requestData["device_id"]}' and app_id='{$global->app_id}'");
				if($deviceRecord["member_id"]!=""){
					$logRecord["member_id"]=$deviceRecord["member_id"];
				}
			}
			import("class/IpTool");
			$IpTool=new IpTool();
			$logRecord["ip_address"]=$IpTool->getClientIp();
			$logRecord["create_time"]=date("Y-m-d H:i:s");
			
			
			$dao->insert($dao->tables->app_datalog,$logRecord,true);
			//$dao->insert($dao->tables->app_datalog,$logRecord);
			//日志部分结束----------------------------
			
			
			if($this->tpl_file!=""){
				if(file_exists($global->tplAbsolutePath.$this->tpl_file))
					include($global->tplAbsolutePath.$this->tpl_file);
				else
					echo "模板不存在";
			}else{
				if($_record!=""){
					if(is_array($_record)){
						echo json_encode($_record);
					}else{
						echo $_record;
					}
				}
			}
			
		}else{
			echo "method {$method} not exist ";
		}
		exit;
   }
   
   function forward($method){
		global $global,$dao,$enumVars;
		
		//引入自定义的全局变量
		global $top_menu_focus,$local_menu,$global_params,$global_link;
		
		if($method==""){
			$method=$this->default_method;
			$_REQUEST["method"]=$method;
			if($method==""){
				echo "method is null";
				exit;
			}
		}
			
		if(method_exists($this,$method)){
			$global->requestMethodName=$method;
			$_record=$this->$method();
			if($this->tpl_file!=""){
				if(file_exists($global->tplAbsolutePath.$this->tpl_file))
					include($global->tplAbsolutePath.$this->tpl_file);
				else
					echo "模板{$this->tpl_file}不存在";
			}
		}else{
			//echo "method {$method} not exist ";
			$action=get_acl("error");
			$action->forward("error404");
		}
		exit;
	}
 
}
?>