<?



/*header("location:juzhenadmin");
exit;*/

require("global.php");
session_start(); //开启session

//定义前台模板所在目录的url路径，末尾包含"/"，用于引入模板下的js、样式表、图片
$global->tplUrlPath=$global->siteUrlPath."/res/tpl/default/";
//定义前台模板所在目录的物理路径，末尾包含"/"，用于引入php模板文件
$global->tplAbsolutePath=$global->absolutePath."/res/tpl/default/";
//系统模板目录的url路径，末尾包含"/"，用于引入系统标准的js和样式表
$global->sysTplUrlPath=$global->siteUrlPath."/res/tpl/system/";


//根据伪静态参数获取控制器及方法以及其他参数
if(CONFIG_STATIC_HTML && $_GET["alias"]!=""){
	$alias=$_GET["alias"];
	
	
	//判断文件或目录是否真的存在，优先级最高
	preg_match('/([^\/]+)\.([^\/]+)$/i',$alias,$preg_result);
	if($preg_result[0]!=""){//如果文件名存在
		if(file_exists($global->absolutePath.$alias)){
			
			if($preg_result[2]!="php"){
				readfile($global->absolutePath.$alias);
				exit;
			}else{
				//获取文件名
				header("Location: {$preg_result[0]}");
				exit;
			}
			
			readfile($global->absolutePath.$alias);
			exit;
		}
	}else{//如果路径中没写文件名，判断目录下是否存在默认页面
		
		//如果没有文件名，将目录结尾的/去掉
		$alias=preg_replace('/(.+)\/$/',"$1",$alias);
		
		$tmpalias=preg_replace('/^\/(.+)/',"$1",$alias);
		
		if(file_exists($tmpalias."/index.html")){
			readfile($tmpalias."/index.html");
			exit;
		}elseif(file_exists($tmpalias."/index.php")){	
			header("Location:{$global->siteUrlPath}/{$tmpalias}/index.php");
			exit;
		}
	}
	//伪静态判断部分==================================
	
	//拆分目录名与文件名
	$fileName="";
	preg_match('/([^\/]+)\.\w+$/i',$alias,$preg_result);
	
	if($preg_result[0]!=""){//如果文件名存在
		$fileName=$preg_result[0];
	}
	
	$pathName=$alias;
	if($fileName!="")
		$pathName=str_replace("/".$fileName,"",$alias);
	
	/*echo $pathName;
	echo "<br/>---<br/>";
	echo $fileName;
	echo "<br/>---<br/>";
	echo "<pre>";
	print_r($_GET);
	exit;*/
	
	//先判断文件名，文件名匹配的优先级高于目录
	if($fileName!=""){
		/*//去掉扩展名
		preg_match('/([^\/]+)\.\w+$/i',$fileName,$preg_result);
		$fileName=$preg_result[1];*/
		$pathRecord=$dao->get_row_by_where($dao->tables->define_url,"where file_name='{$fileName}' and  url_path='{$pathName}'");
		

		
		if(is_array($pathRecord)){
			if(!empty($pathRecord["menu_id"])){
				$_REQUEST["menu"]=$_GET["menu"]=$pathRecord["menu_id"];
			}else{
				if($pathRecord["acl"]!="")
					$_REQUEST["acl"]=$_GET["acl"]=$pathRecord["acl"];
				if($pathRecord["method"]!="")
					$_REQUEST["method"]=$_GET["method"]=$pathRecord["method"];
			}
			
			if(!empty($pathRecord["data_id"]) && !empty($pathRecord["id_field"]) ){
				$_REQUEST[$pathRecord["id_field"]]=$_GET[$pathRecord["id_field"]]=$pathRecord["data_id"];
			}	
			
		}
		
	}elseif($pathName!=""){
		//根据目录确定栏目或控制器
		$pathRecord=$dao->get_row_by_where($dao->tables->define_url,"where url_path='{$pathName}' and (file_name='' or file_name is null)");	
		
		if(is_array($pathRecord)){
			if(!empty($pathRecord["menu_id"])){
				$_REQUEST["menu"]=$_GET["menu"]=$pathRecord["menu_id"];
			}else{
				if($pathRecord["acl"]!="")
					$_REQUEST["acl"]=$_GET["acl"]=$pathRecord["acl"];
				if($pathRecord["method"]!="")
					$_REQUEST["method"]=$_GET["method"]=$pathRecord["method"];
			}
			
			if(!empty($pathRecord["data_id"]) && !empty($pathRecord["id_field"]) ){
				$_REQUEST[$pathRecord["id_field"]]=$_GET[$pathRecord["id_field"]]=$pathRecord["data_id"];
			}
		}
	}
	
	

}



//执行自动登录操作
$memberService=new memberService();
$mid=$memberService->getLoginMemberInfo("auto_id");
if($mid=="" && $_COOKIE["username"]!="" && $_COOKIE["pwd"]!=""){
	$content_user=addslashes(urldecode($_COOKIE["username"]));
	$content_pass=addslashes(urldecode($_COOKIE["pwd"]));
	//查询数据库	
	$member=$dao->get_row_by_where($dao->tables->member,"where (content_mobile='{$content_user}' or content_email='{$content_user}' or content_user='{$content_user}') and content_pass='{$content_pass}' and publish='1'");	
	//若用户名及密码正确,存入session和cookie
	if(is_array($member)){
		//将用户信息存入session
		$memberService->setLoginMemberInfo($member);
	}else{
		//setcookie("username","",time()+60,"/");
		setcookie("pwd","",time()+60,"/");
	}
}else{
	//setcookie("username","",time()+60,"/");
	//setcookie("pwd","",time()+60,"/");
}


//全局链接，可以在这里统一定义
$global_link=array();
//登录链接
$global_link["login"]=$global->siteUrlPath."/index.php?acl=member&method=login";
//忘记密码链接
//$global_link["forgetPassword"]=$global->siteUrlPath."/index.php?acl=member&method=forgetPassword_email";//邮箱找回密码
$global_link["forgetPassword"]=$global->siteUrlPath."/index.php?acl=member&method=forgetPassword";//短信找回密码
//注册链接
$global_link["register"]=$global->siteUrlPath."/index.php?acl=member&method=registerAgreement";
//会员中心
$global_link["member"]=$global->siteUrlPath."/index.php?acl=member&method=member";
//退出链接
$global_link["logout"]=$global->siteUrlPath."/index.php?acl=member&method=logout";
//$global_link["logout"]="javascript:ajax_logout()";

//引入前台控制器的基础类
include($global->absolutePath."/res/action/base/base_acl.php");

//获取前台控制器的方法,内部设置变量，只允许在入口处执行一次
function get_acl($acl_name){
	global $global;
	
	if($global->requestAclName!="" && $acl_name!="error") exit("只能初始化一个控制器");
	$global->requestAclName=$acl_name;
	
	$class_name="acl_".$acl_name;
	$file=$global->absolutePath."/res/action/{$class_name}.php";
	if(file_exists($file)){
		include($file);
		return new $class_name();
	}else{
		
		$_REQUEST["acl"]="error";
		$_REQUEST["method"]="error404";
		$file=$global->absolutePath."/res/action/acl_error.php";
		if(file_exists($file)){
			include($file);
			return new acl_error();
		}else{
			echo "action not exists";
			exit;
		}
	}
}


//设定导航菜单是否需要聚焦
$top_menu_focus=true;
if($_REQUEST["menu"]!=""){
	//获取当前栏目信息(SEO信息),如果当前栏目没有模板，且模型为空，需要找到下一级节点
	$menuService=new menuService();
	//获取当前聚焦栏目，如果当前栏目为目录且无频道模板，则自动找下一级数据
	$local_menu=$menuService->getLocalMenu($_REQUEST["menu"]);
	
	if(is_array($local_menu)){
		
		if($local_menu["content_link"]!="" && $_REQUEST["method"]==""){//当存在栏目外链并且method参数为空时跳转至外链地址
			header("Location: {$local_menu["content_link"]}");
			exit;
		}	
	
		if($_REQUEST["acl"]=="" && $local_menu["content_module"]!="")
			$_REQUEST["acl"]=$local_menu["content_module"];
		if($_REQUEST["method"]=="" ){
			if($_REQUEST["id"]!=""){
				if($local_menu["detail_method"]!=""){
					
					
					if(preg_match('/.+\.\w+$/i',$local_menu["detail_method"])){
						if(file_exists($global->tplAbsolutePath.$local_menu["detail_method"])){
							$_REQUEST["method"]="detailTplFile";
						}else{
							echo "模板{$local_menu["detail_method"]}不存在";
							exit;
						}
					}else{
						$_REQUEST["method"]=$local_menu["detail_method"];
					}
					
					
					
				}else{
					$_REQUEST["method"]="detail";
				}
			}elseif($local_menu["action_method"]!=""){
				//判断是函数还是模板文件名
				if(preg_match('/.+\.\w+$/i',$local_menu["action_method"])){
					if(file_exists($global->tplAbsolutePath.$local_menu["action_method"])){
						$_REQUEST["method"]="tplFile";
					}else{
						echo "模板{$local_menu["action_method"]}不存在";
						exit;
					}
				}else{
					$_REQUEST["method"]=$local_menu["action_method"];
				}	
			}
		}
	}else{
		$_REQUEST["acl"]="error";
		$_REQUEST["method"]="error404";
	}
}

//如果有专题栏目的参数
if($_REQUEST["topicMenu"]!=""){
	//获取当前栏目信息(SEO信息),如果当前栏目没有模板，且模型为空，需要找到下一级节点
	$topicMenuService=new topicMenuService();
	//获取当前聚焦栏目，如果当前栏目为目录且无频道模板，则自动找下一级数据
	$local_menu=$topicMenuService->getLocalMenu($_REQUEST["topicMenu"]);
	if($_REQUEST["acl"]=="" && $local_menu["content_module"]!="")
		$_REQUEST["acl"]=$local_menu["content_module"];
	if($_REQUEST["method"]=="" ){
		if($_REQUEST["id"]!=""){
			$_REQUEST["method"]="detail";
		}elseif($local_menu["action_method"]!=""){
			$_REQUEST["method"]=$local_menu["action_method"];
		}
	}
	//设置专题id
	global $topicId;
	$topicId=$local_menu["topic_id"];

	
}

//定义控制网站标题及SEO关键词的全局变量，可以在控制器中进行重新设定，如不设定则会采用默认设置
$cacheId="global_params";
$global_params=cache::getData($cacheId);
if(!$global_params){

	$paramsService=new paramsService();
	$global_params=$paramsService->getParams(array("content_title","seo_keywords","seo_description","content_copyright","service_tel","company_address","count_code"));
	cache::setData($cacheId,$global_params);
}
	
	
	
if($local_menu["seo_keywords"]!="")
	$global_params["seo_keywords"]=$local_menu["seo_keywords"];
if($local_menu["seo_description"]!="")
	$global_params["seo_description"]=$local_menu["seo_description"];


if($_REQUEST["acl"]=="")
	$_REQUEST["acl"]="index";
	

//验证action是否存在，不存在跳转到首页
$action=get_acl($_REQUEST["acl"]);

//输出到日志文件,可以通过tail -f debug.log实时查看打印信息
//$DebugTool=new DebugTool();
//$DebugTool->printVar($_REQUEST["acl"]."->".$_REQUEST["method"]);



$action->forward($_REQUEST["method"]);

?>