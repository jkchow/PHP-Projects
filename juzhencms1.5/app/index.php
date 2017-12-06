<?
$no_filter=true;
require("../global.php");



//设定此入口对应的app_id
$global->app_id="1";

//引入前台控制器的基础类
include($global->absolutePath."/app/action/base/base_acl.php");

//获取前台控制器的方法
function get_acl($acl_name){
	global $global;
	$class_name="acl_".$acl_name;
	$file=$global->absolutePath."/app/action/{$class_name}.php";
	if(file_exists($file)){
		require_once ($file);
		return new $class_name();
	}else{
		echo "class {$acl_name} not exists";
		exit;
	}
}

//对数组进行sql转义
function stripslashesRecursive(array $array){
	foreach ($array as $k => $v) {
		if (is_string($v)) {
			$array[$k] = stripslashes($v);
		} else if (is_array($v)) {
			$array[$k] = stripslashesRecursive($v);
		}
	}
	return $array;
}


if($_REQUEST["param"]!=""){
	$json_str=$_REQUEST["param"];
	
	if($global->auto_addslashes){
		$json_str=stripslashes($json_str);
	}
	
	$requestData=json_decode($json_str,true);
	
	//若当前开启了magic_quotes_gpc,但是json中解析出的参数不会自动进行sql转义，下面代码手动对参数进行sql转义
	if ($global->auto_addslashes) {
		$requestData=stripslashesRecursive($requestData);
	}
}

if($requestData["acl"]!=""){//执行app数据接口控制器
	$_REQUEST["acl"]=$requestData["acl"];
	$_REQUEST["method"]=$requestData["method"];
	
	
	
	if($_REQUEST["acl"]==""){
		echo "param acl is null";
		exit;
	}
	
	if($_REQUEST["method"]==""){
		echo "param method is null";
		exit;
	}
	
	if(!empty($requestData['device_id']) && !empty($requestData['validate'])){
		$where="where device_id='{$requestData['device_id']}' and app_id='{$global->app_id}'";
		$device=$dao->get_row_by_where($dao->tables->app_device,$where);
		if(is_array($device) && !empty($device)){
			
			if($device['member_id']>0){
				$where="where auto_id='{$device['member_id']}'";
				$member=$dao->get_row_by_where($dao->tables->member,$where);
				
				if(is_array($member) && !empty($member)){
					$string=md5($member['token'].$requestData['timestamp']);
					
					if($requestData['validate']==$string){
						$memberService=new memberService();
						$memberService->setLoginMemberInfo($member);
					}	 
				}	
			}
		}
	}
	
	$action=get_acl($_REQUEST["acl"]);
	$action->returnData($_REQUEST["method"],$requestData);
	
	
}else{//执行普通控制器
	if($_REQUEST["acl"]=="")
		$_REQUEST["acl"]="index";
	//验证action是否存在，不存在跳转到首页
	$action=get_acl($_REQUEST["acl"]);
	$action->forward($_REQUEST["method"]);

}


?>