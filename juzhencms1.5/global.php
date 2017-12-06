<?

$global=new StdClass();
$global->version="1.6.9";//版本号
$global->debug=false;//调试模式，目前还没有用到

//安全防护代码开始============================================

//进行sql防注入处理


$global->auto_addslashes=get_magic_quotes_gpc();
if(!$global->auto_addslashes){
	$global->auto_addslashes=true;
	
	function daddslashes($string) { 
		if(!is_array($string)) return addslashes($string); 
		foreach($string as $key => $val) 
			$string[$key] = daddslashes($val); 
		return $string;
	}
	
	$_COOKIE=daddslashes($_COOKIE); 
	$_REQUEST=daddslashes($_REQUEST);
	$_POST=daddslashes($_POST);
	$_GET=daddslashes($_GET); 
	//$_FILES = daddslashes($_FILES);//转义会造成文件路径不正确
}





//拦截开关(1为开启，0关闭)
$webscan_switch=0;




if(!isset($no_filter) || $no_filter!=true)//如果不需要过滤request参数，需要在引入global.php之前定义$no_filter=true;
	$webscan_switch=1;
else
	$webscan_switch=0;
	
	
	
	
//提交方式拦截(1开启拦截,0关闭拦截,post,get,cookie,referre选择需要拦截的方式)
$webscan_post=1;
$webscan_get=1;
$webscan_cookie=1;
$webscan_referre=1;

//防护脚本MD5值
define("WEBSCAN_MD5", md5(@file_get_contents(__FILE__)));
//get拦截规则
$getfilter = "<[^>]*?=[^>]*?&#[^>]*?>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b[^>]*?>|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//post拦截规则
$postfilter = "<[^>]*?=[^>]*?&#[^>]*?>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b[^>]*?>|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//cookie拦截规则
$cookiefilter = "\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//referer获取
$webscan_referer = empty($_SERVER['HTTP_REFERER']) ? array() : array('HTTP_REFERER'=>$_SERVER['HTTP_REFERER']);

/**
 *  参数拆分
 */
function webscan_arr_foreach($arr) {
  static $str;
  if (!is_array($arr)) {
    return $arr;
  }
  foreach ($arr as $key => $val ) {

    if (is_array($val)) {

      webscan_arr_foreach($val);
    } else {

      $str[] = $val;
    }
  }
  return implode($str);
}

/**
 *  攻击检查拦截
 */
function webscan_StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq,$method) {
  $StrFiltValue=webscan_arr_foreach($StrFiltValue);
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
    //webscan_slog(array('ip' => $_SERVER["REMOTE_ADDR"],'time'=>strftime("%Y-%m-%d %H:%M:%S"),'page'=>$_SERVER["PHP_SELF"],'method'=>$method,'rkey'=>$StrFiltKey,'rdata'=>$StrFiltValue,'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'request_url'=>$_SERVER["REQUEST_URI"]));
    //exit(webscan_pape());
	exit;
  }
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
    //webscan_slog(array('ip' => $_SERVER["REMOTE_ADDR"],'time'=>strftime("%Y-%m-%d %H:%M:%S"),'page'=>$_SERVER["PHP_SELF"],'method'=>$method,'rkey'=>$StrFiltKey,'rdata'=>$StrFiltKey,'user_agent'=>$_SERVER['HTTP_USER_AGENT'],'request_url'=>$_SERVER["REQUEST_URI"]));
    //exit(webscan_pape());
	exit;
  }

}


if($webscan_switch) {
  if ($webscan_get) {
    foreach($_GET as $key=>$value) {
      webscan_StopAttack($key,$value,$getfilter,"GET");
    }
  }
  if ($webscan_post) {
    foreach($_POST as $key=>$value) {
      webscan_StopAttack($key,$value,$postfilter,"POST");
    }
  }
  if ($webscan_cookie) {
    foreach($_COOKIE as $key=>$value) {
      webscan_StopAttack($key,$value,$cookiefilter,"COOKIE");
    }
  }
  if ($webscan_referre) {
    foreach($webscan_referer as $key=>$value) {
      webscan_StopAttack($key,$value,$postfilter,"REFERRER");
    }
  }
}

//安全防护代码结束====================================================



ini_set('display_errors', 1);
error_reporting(E_ALL ^E_NOTICE ^E_DEPRECATED);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR);
ini_set('date_default_timezone_set', 'Asia/Shanghai');
date_default_timezone_set("Asia/Shanghai");
ini_set("session.cookie_httponly", 1); 
//session_set_cookie_params(0, NULL, NULL, NULL, TRUE);
header("Content-type: text/html; charset=utf-8");
header('X-Frame-Options: SAMEORIGIN');


$global->html_filter=false;
if(!isset($no_filter) || $no_filter!=true){
	$_GET=vars_filter($_GET);
	$_POST=vars_filter($_POST);
	$_REQUEST=vars_filter($_REQUEST);
	$global->html_filter=true;
}



$global->url=getUrl();
$global->sysAbsolutePath=str_replace("\\","/",dirname (__FILE__));//自动获取系统根目录所在的服务器物理路径
$global->sysSiteUrlPath=getSiteUrlPath();//自动获取系统根目录的网址(站点根目录url)
$global->absolutePath=$global->sysAbsolutePath;//当前站点所在的服务器物理路径
$global->siteUrlPath=$global->sysSiteUrlPath;//当前站点的网址(站点根目录url))
$global->requestUrlPath=getRequestUrlPath();//获取请求的url路径，可能请求的不是站点的根目录
$global->fileAbsolutePath=$global->sysAbsolutePath."/file";//用户文件存储目录，用于文件上传、日志、数据库备份、临时文件等，当使用文件服务器时，此目录需要修改
$global->uploadAbsolutePath=$global->fileAbsolutePath."/upload/";//上传文件保存的物理目录
$global->uploadUrlPath=$global->sysSiteUrlPath."/file/upload/";//文件上传后的url目录

$global->ossEnable=false;//是否使用oss上传文件
if($global->ossEnable){
	$global->ossBucket="juzhencms";//bucket名称
	$global->uploadUrlPath="http://juzhencms.oss-cn-beijing.aliyuncs.com/";//oss访问域名,也可以不重置此路径
}
	

$global->clientOS=getOS();
if($global->clientOS=="Android" || $global->clientOS=="iPhone" || $global->clientOS=="iPod"){
	$global->clientDeviceType="mobile";
}

$global->use_ucenter=false;//是否使用ucenter

$global->baidu_js_ak="7p3V5W65d9s0I1ULQlAdqzHQ";
$global->baidu_server_ak="YmnprCzYYI3Kmj17x07PjHuD";

$global->use_cache=false;//是否开启广告、资讯类的缓存功能
$global->cache_time=3600;//缓存时间，单位是秒



//为了适应高版本的spl_autoload_register,下面的类名不再使用__autoload,改为loadClass
function loadClass($className){
	$class_file=dirname (__FILE__)."/include/class/{$className}.php";
	if(file_exists($class_file)){
		include($class_file);
	}else{
		$class_file=dirname (__FILE__)."/include/service/{$className}.php";
		if(file_exists($class_file)){
			include($class_file);
		}
	}
}
//注册自动加载函数
spl_autoload_register("loadClass");


//手动引入类(会在include目录下按照路径进行查找)，参数例如service/menuService
function import($classPath){
	$i=strrpos($classPath,".");
	$className=substr($classPath,$i+1);
	if(class_exists($className))
		return true;
	$classPath=$classPath.".php";
	$class_file=dirname (__FILE__)."/include/".$classPath;
	if(file_exists($class_file)){
		include($class_file);
	}
}

//过滤参数，进行html转义
function vars_filter($vars){
	if(is_array($vars))
	foreach($vars as $key=>$vl){
		if(!is_array($vl)){
			$vars[$key]=htmlspecialchars($vl);
		}else{
			$vars[$key]=vars_filter($vl);
		}
	}
	return $vars;
}

//获取站点的url目录
function getSiteUrlPath(){
	//$url_this = 'http://'.$_SERVER['SERVER_NAME'];
	if(!empty($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS'])=='ON'){
		$url_path = 'https://'.$_SERVER['HTTP_HOST'];
		if($_SERVER["SERVER_PORT"]!=443)
			$url_path.=':'.$_SERVER["SERVER_PORT"];
	}else{
		$url_path = 'http://'.$_SERVER['HTTP_HOST'];
		if($_SERVER["SERVER_PORT"]!=80)
			$url_path.=':'.$_SERVER["SERVER_PORT"];
	}
		
	$documentDir=str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']);
	$fileDir=str_replace("\\","/",dirname (__FILE__));
	
	$pos = strpos($fileDir,$documentDir);
	if ($pos === false ){//如果出现无法匹配(如大小写不一致的问题)
		//判断是否是大小写不一致的问题
		$tmpFileDir=strtolower($fileDir);
		$tmpDocumentDir=strtolower($documentDir);
		$tmppos = strpos($tmpFileDir,$tmpDocumentDir);
		if ($tmppos !== false ){
			$path=substr($fileDir,strlen($documentDir));
		}else{
			$path="";
			//依次循环目录判断
			$tmpPathArr=explode('/',$fileDir);
			if(is_array($tmpPathArr))
			foreach($tmpPathArr as $key=>$vl){
				if($vl=="")
					continue;
				if(preg_match('/\/?'.$vl.'\/?(.*)/',$documentDir,$preg_result)){
					preg_match('/\/?'.$vl.'\/?(.*)/',$fileDir,$preg_result2);
					$tmpFileDir=$preg_result2[1];
					$tmpDocumentDir=$preg_result[1];
					$tmppos = strpos($tmpFileDir,$tmpDocumentDir);
					if($tmppos!==false){
						$path=str_replace($tmpDocumentDir,"",$tmpFileDir);
						break;
					}
				}
			}
		}
		
	}else{
		$path=str_replace($documentDir,"",$fileDir);
	}
	$url_path.=$path;
	return $url_path;
}

//获取当前请求的url目录
function getRequestUrlPath(){
	if(strtoupper($_SERVER['HTTPS'])=='ON'){
		$url_this = 'https://'.$_SERVER['HTTP_HOST'];
		if($_SERVER["SERVER_PORT"]!=443)
			$url_this.=':'.$_SERVER["SERVER_PORT"];	
	}else{
		$url_this = 'http://'.$_SERVER['HTTP_HOST'];
		if($_SERVER["SERVER_PORT"]!=80)
			$url_this.=':'.$_SERVER["SERVER_PORT"];			
	}
	preg_match('/^\/[^=\?\&]+\//',$_SERVER["REQUEST_URI"],$preg_result);
	if(is_array($preg_result) && $preg_result[0]!="")
		$url_this.=$preg_result[0];
	
	$url_path=substr($url_this,0,strrpos($url_this,"/"));

	return $url_path;
}

//获取当前url
function getUrl(){
	if(strtoupper($_SERVER['HTTPS'])=='ON'){
		$url_this = 'https://'.$_SERVER['HTTP_HOST'];
		if($_SERVER["SERVER_PORT"]!=443)
			$url_this.=':'.$_SERVER["SERVER_PORT"];	
	}else{
		$url_this = 'http://'.$_SERVER['HTTP_HOST'];
		if($_SERVER["SERVER_PORT"]!=80)
			$url_this.=':'.$_SERVER["SERVER_PORT"];			
	}
	
	return $url_this.$_SERVER["REQUEST_URI"];
}

//获取IP地址
function GetIP(){
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		 $ip = getenv("HTTP_CLIENT_IP");
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		 $ip = getenv("HTTP_X_FORWARDED_FOR");
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		 $ip = getenv("REMOTE_ADDR");
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		 $ip = $_SERVER['REMOTE_ADDR'];
	else
		$ip = "unknown";
	return($ip);
}
//获取当前操作系统
function getOS(){
	$agent = $_SERVER["HTTP_USER_AGENT"];

	if (preg_match('/Win/i', $agent) && preg_match('/NT 5.2/i', $agent)){
		// Windows 2003
		$os = "Win2003";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/NT 5.1/i', $agent)){
		// Windows XP
		$os = "WinXP";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/NT 5.0/i', $agent)){
		// Windows 2000
		$os = "Win2000";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/NT/i', $agent)){
		// Windows NT
		$os = "Win2000";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/4.90/i', $agent)){
		// Windows ME
		$os = "Win9X";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/98/i', $agent)){
		// Windows 98
		$os = "Win9X";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/95/i', $agent)){
		// Windows 95
		$os = "Win9X";
	}
	elseif (preg_match('/Win/i', $agent) && preg_match('/32/i', $agent)){
		// Windows 32
		$os = "Win9X";
	}
	elseif (preg_match('/android/i', $agent)){
		// linux
		$os = "Android";
	}
	elseif (preg_match('/iphone/i', $agent)){
		// linux
		$os = "iPhone";
	}
	elseif (preg_match('/ipod/i', $agent)){
		// linux
		$os = "iPod";
	}
	elseif (preg_match('/ipad/i', $agent)){
		// linux
		$os = "iPad";
	}
	elseif (preg_match('/Linux/i', $agent)){
		// linux
		$os = "Linux";
	}
	elseif (preg_match('/BSD/i', $agent)){
		// *BSD
		$os = "Unix";
	}
	elseif (preg_match('/Unix/i', $agent)){
		// Unix
		$os = "Unix";
	}
	elseif (preg_match('/Sun/i', $agent)){
		// SunOS
		$os = "SunOS";
	}
	elseif (preg_match('/Mac/i', $agent)){
		// Macintosh
		$os = "Macintosh";
	}
	elseif (preg_match('/IBM/i', $agent)){
		// IBMOS
		$os = "IBMOS";
	} else { // Other
		$os = "Other";
	}

	return trim($os);
}

//数据库连接配置==========================================
/*$db_config=array(
	"server"=>"182.92.118.84:3306",
	"user"=>"beta",
	"pass"=>"prbetayjn40ks",
	"database"=>"juzhencms",
);*/

$db_config=array(
	"server"=>"127.0.0.1:3306",
	"user"=>"root",
	"pass"=>"root",
	"database"=>"juzhencms1.5",
);


//定义的数据表=================================================
$db_table=new StdClass();

//系统基础表-------------------------------------
$db_table->example="cms_example";//示例开发模块
$db_table->user="cms_user";//管理员用户
$db_table->role="cms_role";//管理员角色
$db_table->user_level="cms_user_level";//管理员职位级别
$db_table->user_department="cms_user_department";//管理员部门机构
$db_table->user_login_log="cms_user_login_log";//管理员登录日志
$db_table->user_log="cms_user_log";//管理员操作日志
$db_table->menu="cms_menu";//栏目菜单
$db_table->sql_debug="cms_sql_debug";//sql报错日志
$db_table->params="cms_params";//网站参数配置
$db_table->ad_space="cms_ad_space";//广告位
$db_table->ad="cms_ad";//广告
$db_table->ad_apply="cms_ad_apply";//广告申请

$db_table->dictionary="cms_dictionary";//数据字典
$db_table->dictionary_item="cms_dictionary_item";//数据字典选项

$db_table->define_url="cms_define_url";//静态化链接
$db_table->vistor_log="cms_vistor_log";//访问记录

$db_table->news="cms_news";//资讯
$db_table->article="cms_article";//文章介绍
$db_table->links="cms_links";//友情链接


//模块扩展表---------------------------------

$db_table->job="cms_job";//职位
$db_table->job_apply="cms_job_apply";//简历
$db_table->message_board="cms_message_board";//留言板
$db_table->product="cms_product";//产品

$db_table->magazine="cms_magazine";//期刊
$db_table->magazine_item="cms_magazine_item";//期刊每期
$db_table->magazine_item_news="cms_magazine_item_news";//期刊新闻


//会员部分
$db_table->member="cms_member";//会员
$db_table->member_group="cms_member_group";//会员分组
$db_table->member_account="cms_member_account";//会员账户记录
$db_table->member_credits="cms_member_credits";//会员积分
$db_table->event_type="cms_event_type";//事件类型
$db_table->cash_apply="cms_cash_apply";//提现申请
$db_table->order="cms_order";//订单表



$db_table->subject="cms_subject";//话题主题
$db_table->subject_category="cms_subject_category";//话题分类
$db_table->subject_reply="cms_subject_reply";//话题回复

//省市县数据
$db_table->address_province="cms_address_province";
$db_table->address_city="cms_address_city";

//邮件和短信
$db_table->mobile_msg_record="cms_mobile_msg_record";//短信记录表
$db_table->mobile_msg_templet="cms_mobile_msg_templet";//短信模板表
$db_table->email_record="cms_email_record";//邮件记录表
$db_table->email_templet="cms_email_templet";//邮件模板表

//调查问卷
$db_table->exam="cms_exam";//调查问卷
$db_table->exam_question="cms_exam_question";//调查问卷的问题
$db_table->exam_question_answer="cms_exam_question_answer";//问题的答案选项
$db_table->exam_record="cms_exam_record";//用户答题记录
$db_table->exam_record_answer="cms_exam_record_answer";//用户答题记录的答案选项
$db_table->exam_result="cms_exam_result";//问卷结果设定
$db_table->exam_result_product="cms_exam_result_product";//问卷结果关联的产品



$db_table->comment="cms_comment";//评论表
$db_table->member_collect="cms_member_collect";//会员收藏表

$db_table->course_category="cms_course_category";//课程分类表
$db_table->course="cms_course";//课程表
$db_table->course_apply="cms_course_apply";//课程申请

$db_table->join_apply="cms_join_apply";//加盟申请

//专题相关
$db_table->topic="cms_topic";
$db_table->topic_menu="cms_topic_menu";
$db_table->topic_quick_links="cms_topic_quick_links";
$db_table->topic_links="cms_topic_links";
$db_table->topic_ad_space="cms_topic_ad_space";
$db_table->topic_ad="cms_topic_ad";
$db_table->topic_article="cms_topic_article";
$db_table->topic_news="cms_topic_news";

//O2O服务
$db_table->service_category="cms_service_category";//服务分类
$db_table->service_product="cms_service_product";//服务产品
$db_table->service_product_comment="cms_service_product_comment";//产品评价
$db_table->shop="cms_shop";//店铺表
$db_table->member_address="cms_member_address";//会员常用地址
$db_table->member_photos="cms_member_photos";//会员相册表
$db_table->service_order="cms_service_order";//订单

$db_table->order_log="cms_order_log";//订单操作日志



//app相关
$db_table->app_version="cms_app_version";//app版本(用于下载app)
$db_table->app_device="cms_app_device";//app设备记录
$db_table->app_datalog="cms_app_datalog";//app接口调用记录

$db_table->app_api="cms_app_api";//app接口
$db_table->app_api_type="cms_app_api_type";//app接口分类
$db_table->app_api_param="cms_app_api_param";//app接口参数(多级)
$db_table->app_api_datafield="cms_app_api_datafield";//app接口返回数据字段(多级)

//在线支付
$db_table->onlinepay_log="cms_onlinepay_log";//订单在线支付记录

$db_table->forbidden_ip="cms_forbidden_ip";//禁止访问网站的ip地址


//实例化数据库操作对象
$dao=new mysqliDao();
$dao->tables=$db_table;
unset($db_table);
$dao->debug=true;
$dao->init($db_config["server"],$db_config["user"],$db_config["pass"],$db_config["database"]);
unset($db_config);




//系统数据字典
$enumVars=array(
	"boolVars"=>array(
		array("id"=>"0","text"=>"否"),
		array("id"=>"1","text"=>"是"),
	),
	"successVars"=>array(
		array("id"=>"1","text"=>"成功"),				 
		array("id"=>"0","text"=>"失败"),	
	),
	"sexVars"=>array(
		array("id"=>"1","text"=>"男士"),
		array("id"=>"2","text"=>"女士"),
	),
	"publishVars"=>array(
		array("id"=>"0","text"=>"未发布"),
		array("id"=>"1","text"=>"已发布"),
	),

	"agreeVars"=>array(
		array("id"=>"0","text"=>"未审核"),
		array("id"=>"1","text"=>"已审核"),
		array("id"=>"2","text"=>"审核未通过"),
	),
	"dealStatusVars"=>array(
		array("id"=>"0","text"=>"未处理"),
		array("id"=>"1","text"=>"已处理"),
		array("id"=>"2","text"=>"已忽略"),
	),
	"adTypeVars"=>array(
		array("id"=>"1","text"=>"静态图片"),
		array("id"=>"2","text"=>"图片轮播"),
		//array("id"=>"3","text"=>"flash广告"),
	),
	"adLocationVars"=>array(
		array("id"=>"999","text"=>"通用"),
		array("id"=>"1","text"=>"首页"),
		array("id"=>"0","text"=>"其他"),
	),

	"memberTypeVars"=>array(
		array("id"=>"1","text"=>"个人会员"),
		array("id"=>"2","text"=>"企业会员"),
	),
	"appDeviceTypeVars"=>array(
		array("id"=>"1","text"=>"IOS"),
		array("id"=>"2","text"=>"Android"),
	),
	//话题状态
	"subjectStatus"=>array(
		array("id"=>"0","text"=>"待审核"),				   
		array("id"=>"1","text"=>"已发布"),
		array("id"=>"2","text"=>"已关闭"),
	),
	//附件类型
	"attachmentType"=>array(				   
		array("id"=>"1","text"=>"图片"),
		array("id"=>"2","text"=>"文档"),
	),
	//专题分站栏目类型
	"topicMenuModuleVars"=>array(
		array("id"=>"topicNews","text"=>"资讯功能"),
		array("id"=>"topicArticle","text"=>"文章介绍"),
		array("id"=>"topicLinks","text"=>"友情链接"),
	),
	//评价等级
	"commentLevelVars"=>array(				   
		array("id"=>"1","text"=>"一星"),
		array("id"=>"2","text"=>"二星"),
		array("id"=>"3","text"=>"三星"),
		array("id"=>"4","text"=>"四星"),
		array("id"=>"5","text"=>"五星"),
	),
	
	"orderStatusVars"=>array(
		array("id"=>"0","text"=>"待确认"),
		array("id"=>"1","text"=>"已确认"),
		/*array("id"=>"2","text"=>"待发货"),
		array("id"=>"3","text"=>"待收货"),
		array("id"=>"4","text"=>"已签收"),*/
		array("id"=>"5","text"=>"已完成"),
		array("id"=>"6","text"=>"已取消"),
	),
	
	
	"payStatusVars"=>array(
		array("id"=>"0","text"=>"未支付"),
		array("id"=>"1","text"=>"已支付"),
	),
	
	//app接口调用结果
	"appDataLogStatusVars"=>array(
		array("id"=>"1","text"=>"成功"),				 
		array("id"=>"0","text"=>"失败"),	
		array("id"=>"-1","text"=>"需登录"),
	),
	
	//订单类型
	"orderTypeVars"=>array(				   
		array("id"=>"1","text"=>"提问"),
		array("id"=>"2","text"=>"预约"),
		array("id"=>"3","text"=>"偷看"),
		array("id"=>"4","text"=>"充值"),
	),
	
	//事件分类
	"eventTypeVars"=>array(				
		array("id"=>"1","text"=>"积分事件"),
		array("id"=>"2","text"=>"账户事件"),	
	),
	
);


//定义常量，如果php文件中未定义此常量则不允许访问
define( "ALLOW_ACCESS", 1 );

//是否开启静态化
define( "CONFIG_STATIC_HTML", 1 );

//检测是否禁用IP
ipService::checkClientIP();

?>