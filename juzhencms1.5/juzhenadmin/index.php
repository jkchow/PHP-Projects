<?
if(isset($_REQUEST["acl"]) && !in_array($_REQUEST["acl"],array("login","error")))
	$no_filter=true;
include("../global.php");

//是否只能通过https协议进行访问
if(false && strtoupper($_SERVER['HTTPS'])!='ON'){
	$tmpUrl=str_replace("http:","https:",$global->requestUrlPath);
	header("location:{$tmpUrl}");
	exit;
}

//不允许根据backUrl参数跳转至其他域名
if($_REQUEST["backUrl"]!=""){
	$backUrl=base64_decode($_REQUEST["backUrl"]);	
	if(strpos($backUrl,getSiteUrlPath())!==0){
		echo "非法参数";
		exit;
	}
}


define( "USER_LEVEL", 0 );//是否开启管理员用户的职位级别

//以下是cms后台权限配置(定义在后台的入口文件中)=============================================

//公共权限，任何人都可以访问(优先级最高，修改需慎重若删除必要的公共权限会导致系统无法正常访问)
$publicPermissions=array(
	"text"=>"公共权限(不需登录也可以访问 )",
	"actions"=>array(
		"login"=>array("loginJump","loginform","dologin","logout","validateImg"), 
		"error"=>array("error404","noPermission"),
	),
);

//通用权限，登录即可操作的功能
$commonPermissions=array(
	"text"=>"不限制的请求",
	"actions"=>array(
		"main"=>array("main","menuTreeData"), 
		"welcome"=>array("welcome"),
		"vars"=>array("jsEnumVars","getDictionaryVars"),
		"upload"=>array("formImgUpload","formFileUpload","formImgUpload_flash","formFileUpload_flash","formVideoUpload","uploadFile","uploadImg","uploadImgCallback","uploadFileCallback"),
		"download"=>array("downloadFile"),
		"ckeditor"=>array("formCkeditor","ckeditorUpload"),
		"img"=>array("QRcode"),
	),
);

//需要绑定栏目的功能模块的权限
$menuModulePermissions=array(
	//注意key用于查找默认的控制器
	"news"=>array(
		"text"=>"资讯功能",
		"actions"=>array(
			"news"=>array("lists","listsData","savePosition","changeRecommend","changePublish"), 
		),
		"sub"=>array(
			"edit"=>array(
				"text"=>"(编辑)",
				"actions"=>array(
					"news"=>array("form","save","delete","formImgUpload","formVideoUpload","formFileUpload","formCkeditor"),
				),
			),		
		),
	),
	"article"=>array(
		"text"=>"文章单页",
		"actions"=>array(
			"article"=>array("form","save","formImgUpload","formCkeditor","formVideoUpload"), 
		),
	),
	
	"links"=>array(
		"text"=>"友情链接",
		"actions"=>array(
			"links"=>array("lists","listsData"), 
		),
		"sub"=>array(
			"edit"=>array(
				"text"=>"(编辑)",
				"actions"=>array(
					"links"=>array("form","save","delete","savePosition"),
				),
			),		 
		),
	),

	"job"=>array(
		"text"=>"招聘功能",
		"actions"=>array(
			"job"=>array("lists","listsData","position_up","position_down"), 
		),
		"sub"=>array(
			"edit"=>array(
				"text"=>"(编辑)",
				"actions"=>array(
					"job"=>array("form","save","delete","formImgUpload","formVideoUpload"),
				),
			),
			/*"jobApply"=>array(
				"text"=>"(查看简历)",
				"actions"=>array(
					"jobApply"=>array("lists","listsData","position_up","position_down","form","save","delete","formImgUpload","formVideoUpload"),
				),
			),*/	
		),
	),
	/*"magazine"=>array(
		"text"=>"期刊功能",
		"actions"=>array(
			"magazine"=>array("lists","listsData","form","save","delete","savePosition"),
			"magazineItem"=>array("lists","listsData","form","save","delete","savePosition","formFileUpload","formCkeditor"),
		),
	),*/
	"messageBoard"=>array(
		"text"=>"留言板",
		"actions"=>array(
			"messageBoard"=>array("lists","listsData","form","save","delete"),
		),
	),
	
);


//不关联栏目的权限
$modulePermissions=array(
	//当不同模块中出现相同的权限路径时，应做以下两个选择：1.将此路径写入到开放权限中。2.修改路径名称，避免出现相同的，不然会导致可能即使不授权也可以访问，因为此用户在其他模块中已经拥有此权限				   
	
	"modules"=>array(
		"text"=>"功能模块",			
		"sub"=>array(
			//注意key用于查找默认的控制器
			"params"=>array(
				"text"=>"网站设置",
				"actions"=>array(
					"params"=>array("form","save"), 
				),
			),
			
			/*"topic"=>array(
				"text"=>"分站管理",
				"actions"=>array(
					"topic"=>array("lists","treeGridJsonData","form","save","delete","formImgUpload","formCkeditor",),
				),
			),*/
			
			
			/*"serviceProductComment"=>array(
				"text"=>"评论管理",
				"actions"=>array(
					"serviceProductComment"=>array("lists","listsData","form","save","delete","formImgUpload","formCkeditor"),
				),
			),*/
			
			"menu"=>array(
				"text"=>"栏目管理",
				"actions"=>array(
					"menu"=>array("lists","treeGridJsonData","position_up","position_down"), 
				),
				"sub"=>array(
					"edit"=>array(
						"text"=>"(编辑)",
						"actions"=>array(
							"menu"=>array("form","pcodeFormJsonData","save","delete"),
						),
					),		 
				),
			),
			
			"adSpace"=>array(
				"text"=>"广告管理",
				"actions"=>array(
					"adSpace"=>array("lists","listsData"),
					"ad"=>array("lists","listsData"),
				),
				"sub"=>array(
					"edit"=>array(
						"text"=>"(编辑)",
						"actions"=>array(
							"adSpace"=>array("form","save","delete","savePosition"),
							"ad"=>array("form","save","delete"),
							"menu"=>array("adMenuFormJsonData"),//选择广告显示的栏目
						),
					),		 
				),
			),
			
			
			"exam"=>array(
				"text"=>"调查问卷",
				"actions"=>array(
					"exam"=>array("lists","treeGridJsonData","form","save","delete","savePosition"),
					"examQuestion"=>array("lists","treeGridJsonData","form","save","delete","savePosition"),
					"examQuestionAnswer"=>array("lists","treeGridJsonData","form","save","delete","savePosition"),
					"examRecord"=>array("lists","treeGridJsonData","form","save","delete"),
					"examRecordAnswer"=>array("lists","treeGridJsonData","form","save","delete"),
					"examResult"=>array("lists","treeGridJsonData","form","save","delete","savePosition"),
				),
			),
			
			"example"=>array(
				"text"=>"测试模块",
				"actions"=>array(
					"example"=>array("lists","listsData","form","save","delete"), 
				),
			),
			
			
			
			
			
			
			
			
			
			
			"comment"=>array(
				"text"=>"评论管理",
				"actions"=>array(
					"comment"=>array("lists","treeGridJsonData","form","save","delete"), 
				),
			),
			
			"adApply"=>array(
				"text"=>"广告申请",
				"actions"=>array(
					"adApply"=>array("lists","treeGridJsonData","form","save","delete"), 
				),
			),
			"subjectCategory"=>array(
				"text"=>"话题分类",
				"actions"=>array(
					"subjectCategory"=>array("lists","treeGridJsonData","form","save","delete"), 
				),
				
			),
			"subject"=>array(
				"text"=>"话题管理",
				"actions"=>array(
					"subject"=>array("lists","treeGridJsonData","form","save","delete"), 
					"subjectReply"=>array("lists","treeGridJsonData","form","save","delete"), 
				),
				
			),
		),
	),
	"member"=>array(
		"text"=>"会员功能",			
		"sub"=>array(
			"member"=>array(
				"text"=>"会员管理",
				"actions"=>array(
					"member"=>array("lists","listsData","form","save","delete","formImgUpload","formCkeditor",),
				),
				"sub"=>array(
					"memberGroup"=>array(
						"text"=>"会员分组管理",
						"actions"=>array(
							"memberGroup"=>array("lists","listsData","form","save","delete","formImgUpload","formCkeditor",),
						),
					),
				),
			),
			
			"memberAccount"=>array(
				"text"=>"账户记录",
				"actions"=>array(
						"memberAccount"=>array("lists","listsData","form","save","delete","savePosition"),
				),
			),
			"cashApply"=>array(
				"text"=>"提现申请",
				"actions"=>array(
						"cashApply"=>array("lists","listsData","form","save","delete","savePosition"),
				),
			),
			"eventType"=>array(
				"text"=>"积分\账户规则",
				"actions"=>array(
					"eventType"=>array("lists","listsData","form","save","delete","formImgUpload","formCkeditor",),
				),
			),
			"mobileMsgTemplet"=>array(
				"text"=>"短信模板管理",
				"actions"=>array(
					"mobileMsgTemplet"=>array("lists","listsData","form","save","delete","savePosition"),
				),
			),
			"mobileMsgRecord"=>array(
				"text"=>"短信记录",
				"actions"=>array(
					"mobileMsgRecord"=>array("lists","listsData","form","save","delete","savePosition"),
				),
			),
			"emailTemplet"=>array(
				"text"=>"邮件模板管理",
				"actions"=>array(
						"emailTemplet"=>array("lists","listsData","form","save","delete","savePosition"),
				),
			),
			"emailRecord"=>array(
				"text"=>"邮件记录",
				"actions"=>array(
						"emailRecord"=>array("lists","listsData","form","save","delete","savePosition"),
				),
			),
			
		),						
	),
	"app"=>array(
		"text"=>"app管理",			
		"sub"=>array(
		
			"appDevice"=>array(
				"text"=>"app设备管理",
				"actions"=>array(
					"appDevice"=>array("lists","listsData","form","save","delete","formImgUpload","formCkeditor"),
				),
			),
			"appVersion"=>array(
				"text"=>"app版本管理",
				"actions"=>array(
					"appVersion"=>array("lists","listsData","form","save","savePosition","delete"), 
				),
			),
			"appDataLog"=>array(
				"text"=>"app接口日志",
				"actions"=>array(
					"appDataLog"=>array("lists","listsData","form","save","savePosition","delete"), 
				),
			),	
		),						
	),
	"system"=>array(
		"text"=>"系统功能",			
		"sub"=>array(
			"password"=>array(
				"text"=>"修改密码",
				"actions"=>array(
					"user"=>array("passwordForm","changePassword"), 
				),
			),
			"user"=>array(
				"text"=>"用户管理",
				"actions"=>array(
					"user"=>array("lists","listsData"), 
				),
				"sub"=>array(
					"edit"=>array(
						"text"=>"(编辑)",
						"actions"=>array(
							"user"=>array("form","save","delete"),
						),
					),		 
				),
			),
			
			"role"=>array(
				"text"=>"角色管理",
				"actions"=>array(
					"role"=>array("lists","listsData","form","save","delete","permissionJsonData"), 
				),
			),
			"userLevel"=>array(
				"text"=>"职位级别",
				"actions"=>array(
					"userLevel"=>array("lists","treeGridJsonData","pcodeFormJsonData","position_up","position_down","form","save","delete"),
					"userDepartment"=>array("lists","treeGridJsonData","pcodeFormJsonData","departmentFormJsonData","position_up","position_down","form","save","delete"),
				),
			),
			"dictionary"=>array(
				"text"=>"数据字典",
				"actions"=>array(
					"dictionary"=>array("lists","listsData"), 
					"dictionaryItem"=>array("lists","listsData"),
				),
				"sub"=>array(
					"edit"=>array(
						"text"=>"(编辑)",
						"actions"=>array(
							"dictionary"=>array("form","save","savePosition","delete"),
							"dictionaryItem"=>array("form","save","savePosition","delete"),
						),
					),		 
				),
			),
			"userLoginLog"=>array(
				"text"=>"登录日志",
				"actions"=>array(
					"userLoginLog"=>array("lists","listsData"), 
				),
			),
			"userLog"=>array(
				"text"=>"操作日志",
				"actions"=>array(
					"userLog"=>array("lists","listsData","view"), 
				),
			),
			
			"dbBack"=>array(
				"text"=>"数据备份",
				"actions"=>array(
					"dbBack"=>array("lists","listsData","delete","dbBack","downloadDbFile","dbRestore","logLists","logListsData"), 
				),
			),
			
			"forbiddenIp"=>array(
				"text"=>"IP地址禁用",
				"actions"=>array(
					"forbiddenIp"=>array("lists","listsData","form","save","savePosition","delete","changePublish"), 	
				),
			),
			"environmentTest"=>array(
				"text"=>"运行环境",
				"actions"=>array(
					"welcome"=>array("environmentTest"),
				),
			),
			"aboutSystem"=>array(
				"text"=>"关于系统",
				"actions"=>array(
					"welcome"=>array("about"), 
				),
			),
		),						
	),
);

Passport::$publicPermissions=$publicPermissions;
unset($publicPermissions);
Passport::$commonPermissions=$commonPermissions;
unset($commonPermissions);

$enumVars["menuModuleVars"]=array();
if(is_array($menuModulePermissions))
foreach($menuModulePermissions as $key=>$vl){
	$enumVars["menuModuleVars"][]=array("id"=>$key,"text"=>$vl["text"]);
}

//权限部分结束==================================================
//定义后台目录的物理路径，结尾不包含"/"
$global->admin_absolutePath=dirname (__FILE__);

//定义后台url路径
$tmpUrl=$_SERVER["REQUEST_URI"];
$tmppos=strrpos($tmpUrl,"/index.php?");
if($tmppos===false)
	$tmppos=strrpos($tmpUrl,"/?");
$global->admin_siteUrlPath=substr($tmpUrl,0,$tmppos);




//引入后台控制器的基础类
include("action/acl_base.php");
//获取后台控制器的方法
function get_acl($acl_name){
	global $global;
	//如果是栏目路径，将栏目转换为action参数
	//正则匹配栏目
	preg_match('/^(\d+)(\.(\w+))?$/',$acl_name,$preg_result);
	if($preg_result[1]!=""){//如果是栏目
		global $dao;
		$menu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$preg_result[1]}'",array("content_module"));
		
		if($preg_result[3]!=""){
			$acl_name=$preg_result[3];
			//$_REQUEST["acl"]=$acl_name;
		}else{
			//将$_REQUEST["acl"]设置为10.news的形式
			$_REQUEST["acl"]=$acl_name.".".$menu["content_module"];
			$acl_name=$menu["content_module"];
		}	
		
		$_REQUEST["menu"]=$preg_result[1];
	}else{
		//$_REQUEST["acl"]=$acl_name;
	}
	
	
	
	$class_name="acl_".$acl_name;
	
	//if($global->requestAclName!="") exit("只能初始化一个控制器");
	$global->requestAclName=$class_name;
	
	if(!class_exists($class_name)){
		$file=$global->admin_absolutePath."/action/{$acl_name}/{$class_name}.php";
		if(file_exists($file)){
			include($file);	
		}else{
			echo "action not exists";
			exit;
			//$class_name="acl_error";
			//if(!class_exists($class_name))
				//include($global->admin_absolutePath."/action/error/{$class_name}.php");
		}
	}
	$acl=new $class_name();
	return $acl;
}

if($_REQUEST["acl"]=="")
	$_REQUEST["acl"]="main";
//验证action是否存在，不存在跳转到首页
$action=get_acl($_REQUEST["acl"]);

if($_REQUEST["method"]=="")
	$_REQUEST["method"]=$action->default_method;

//如果访问的方法存在
if(method_exists($action,$_REQUEST["method"])){

	
	$passport=new Passport();
	//登录验证及权限验证
	$passport->validate();
}else{
	echo "您访问的路径不存在";
	exit;
}


$action->forward($_REQUEST["method"]);


?>