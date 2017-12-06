<?
class acl_member extends base_acl{
	//默认方法是会员中心首页
	var $default_method="member";
	
	function __construct(){
		global $global;
    	$global->tplAbsolutePath=$global->absolutePath."/res/tpl/member/";
		$global->tplUrlPath=$global->siteUrlPath."/res/tpl/member/";
    }
	
	//ajax获取登录的会员信息
	function ajaxGetLoginInfo(){
		$memberService=new memberService();
		$member=$memberService->getLoginMemberInfo();
		
		$memberRecord=array();
		$memberRecord["id"]=$member["auto_id"];
		$memberRecord["usrname"]=$member["content_name"];
		if($memberRecord["usrname"]=="")
			$memberRecord["usrname"]=$member["content_user"];
		if($member["auto_id"]!=""){
			$memberRecord["isLogin"]="1";
		}else{
			$memberRecord["isLogin"]="0";
		}
		echo json_encode($memberRecord);
	}
	
	//注册协议页面
	function registerAgreement(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		
		if($_SESSION["accessReg"]==""){
			$_SESSION["accessReg"]=1;
		}
		
		$this->tpl_file="reg_agreement.php";
		$record=array();
		$record["page_title"]="会员注册";
		$record["back_link"]=$global->siteUrlPath."/index.php";
		return $record;
	}
	
	//注册页面
	function register(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		
		if($_SESSION["accessReg"]==""){
			$_SESSION["accessReg"]=1;
		}
		
		$this->tpl_file="reg.php";
		$record=array();
		$record["page_title"]="会员注册";
		$record["back_link"]=$global->siteUrlPath."/index.php";
		return $record;
	}
	
	//验证手机是否可以注册
	function checkRegMobile(){
		global $dao;
		if($_POST["content_mobile"]!=""){
			$member_sql = "select auto_id from {$dao->tables->member} where content_mobile='".$_POST["content_mobile"]."' limit 0,1"; 			
			$data = $dao->get_datalist( $member_sql );
			if(is_array($data) && count($data)>0){
				echo "false";
				return;
			}else{
				echo "true";
				return;
			}
		}
	}
	
	//验证邮箱是否可以注册
	function checkRegEmail(){
		global $dao;
		if($_POST["content_email"]!=""){
			
			if($global->use_ucenter){
				include $global->absolutePath.'/uc_client/config.inc.php';
				include $global->absolutePath.'/uc_client/client.php';
				if(uc_user_checkemail($_POST["content_email"])!=1){
					echo "false";
					return;
				}
			}
			
			$member_sql = "select auto_id from {$dao->tables->member} where content_email='".$_POST["content_email"]."' limit 0,1"; 			
			$data = $dao->get_datalist( $member_sql );
			if(is_array($data) && count($data)>0){
				echo "false";
				return;
			}else{
				echo "true";
				return;
			}
		}
	}
	
	//获取注册的短信验证码
	function getRegMobileMsg(){
		global $global_params,$global,$dao;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			unset($_SESSION["validateNUM"]);
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		if($_SESSION["accessReg"]==""){
			echo json_encode(array("result"=>0,"msg"=>"系统超时，请重试"));
			exit;
		}else{
			$_SESSION["accessReg"]+=1;
			if($_SESSION["accessReg"]>10){
				echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
				exit;
			}	
		}
		$content_mobile=$_POST["content_mobile"];
		
		//判断手机号格式是否正确
		if(!preg_match('/^1[3578][0-9]{9}$/',$content_mobile)){
			echo json_encode(array("result"=>0,"msg"=>"手机号格式不正确"));
			exit;
		}
		
		
		$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
		if(is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此手机号已经注册，请直接登录"));
			exit;
		}
		
		//查询短信记录表
		$today=date("Y-m-d");
		$recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
		if(is_array($recordList) && count($recordList)>=10){
			//每天最多使用3次
			echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
			exit;
		}
		
		//生成验证码
		$num=rand(10000,99999);
		
		//验证码写入session
		$_SESSION["regRandNum"]=$num;
		$_SESSION["regMobile"]=$content_mobile;
		$_SESSION["validateErrorCount"]=0;
		
		//获取网站名称
		$paramsService=new paramsService();
		$site_name=$paramsService->getParamValue("content_name");
		
		
		$eventName="memberRegCode";
		//获取下单成功的短信模板
		$mobileTemplet=$dao->get_row_by_where($dao->tables->mobile_msg_templet,"where content_event='{$eventName}' and publish='1'");
		if(is_array($mobileTemplet)){
			$text=str_replace('{msg_code}',$num,$mobileTemplet["content_text"]);
			$mobileMsgService=new mobileMsgService();
			$mobileMsgService->sendMsg($content_mobile,$text,array("content_type"=>"reg","validate_code"=>$num));
			echo json_encode(array("result"=>1,"msg"=>"验证码已经发送到您的手机，有效期20分钟，请注意查收"));
		}else{
			echo json_encode(array("result"=>0,"msg"=>"短信功能暂不可用，请联系网站管理员"));
		}
		
	}
	
	function saveRegister(){
		global $global,$dao,$global_link;
		
		/*//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);*/
		
		$record=$_POST["frm"];
		if($record["content_mobile"]=="" || $_SESSION["regMobile"]=="" || $record["content_mobile"]!=$_SESSION["regMobile"]){
			echo json_encode(array("result"=>0,"msg"=>"手机号未验证"));
			exit;
		}
		
		$mobile_randnum=$_POST["mobile_randnum"];
		if($mobile_randnum=="" || $_SESSION["regRandNum"]=="" || $_SESSION["regRandNum"]!=$mobile_randnum){
			$_SESSION["validateErrorCount"]++;
			if($_SESSION["validateErrorCount"]>5){
				$_SESSION["regRandNum"]="";
				echo json_encode(array("result"=>0,"msg"=>"验证码失败次数过多，请重新获取验证码"));	
				exit;
			}
			
			echo json_encode(array("result"=>0,"msg"=>"短信验证码输入有误，请重试"));
			exit;
		}
		
		
		
		
		//判断用户名、手机号、邮箱是否重复
		/*$member_sql = "select * from {$dao->tables->member} where content_user='".$record['content_user']."'"; 			
		$data = $dao->get_datalist( $member_sql ); 
		
		if(is_array($data) && count($data)>0 ){ 
			//$this->redirect($global_link["register"],"已经存在相同的用户名，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同用户名，注册失败"));
			exit;
		}*/
		
		$member_sql = "select * from {$dao->tables->member} where content_mobile='".$record['content_mobile']."'"; 			
		$data = $dao->get_datalist( $member_sql ); 
		if(is_array($data) && count($data)>0 ){ 
			//$this->redirect($global_link["register"],"已经存在相同手机号，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同手机号，注册失败"));
			exit;
		}
		
		if($record['content_email']!=""){
			$member_sql = "select * from {$dao->tables->member} where content_email='".$record['content_email']."'"; 			
			$data = $dao->get_datalist( $member_sql ); 
			if(is_array($data) && count($data)>0 ){ 
				//$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
				echo json_encode(array("result"=>0,"msg"=>"已经存在相同邮箱，注册失败"));
				exit;
			}
		}
		
		
		/*$member_sql = "select * from {$dao->tables->member} where content_qq='".$record['content_qq']."'"; 			
		$data = $dao->get_datalist( $member_sql ); 
		
		if(is_array($data) && count($data)>0 ){ 
			//$this->redirect($global_link["register"],"已经存在相同QQ号码，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同QQ号码，注册失败"));
			exit;
		} */
		
		
		//保存城市信息
		/*$city_info=$_SESSION["cityInfo"];
		$record["province_name"]=$city_info["province_name"];
		$record["province_code"]=$city_info["province_code"];
		$record["city_name"]=$city_info["city_name"];
		$record["city_code"]=$city_info["city_code"];*/
		
		$record["publish"]="1";
		$record["create_time"]=date("Y-m-d H:i:s");
		
		
		
		
		//密码加密
		$record["pass_randstr"]=rand(1000000,9999999);
		$record["content_pass"]=md5($record["content_pass"].$record["pass_randstr"]);
		
		$dao->insert($dao->tables->member,$record);
		
		$member_id=$dao->get_insert_id();
		
		if($member_id=="" || $member_id=="0"){
			//$this->redirect($global_link["register"],"信息不符合要求，请再次注册");
			echo json_encode(array("result"=>0,"msg"=>"信息不符合要求，请重新注册"));
			exit;
		}
		$memberService=new memberService();
		$memberInfo=$memberService->getMember($member_id);
		//将用户信息存入session
		
		$memberService->setLoginMemberInfo($memberInfo);
		//清空session中存储的注册短信验证码
		unset($_SESSION["regRandNum"]);
		//$this->redirect($global_link["login"],"注册信息提交成功，欢迎登录系统");
		echo json_encode(array("result"=>1,"msg"=>"注册成功","redirect"=>$_SESSION["redirectUrl"]));
		unset($_SESSION["redirectUrl"]);
		
	}
	
	//登录页面
	function login(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		$this->tpl_file="login.php";
		$record=array();
		$record["page_title"]="会员登录";
		$record["back_link"]=$global->siteUrlPath."/index.php";
		return $record;
	}
	
	//登录处理
	function doLogin(){
		global $dao,$global;
		$content_user=$_POST["content_user"];
		$content_pass=$_POST["content_pass"];
		if($content_user=='' || $content_pass=='' ){
			echo json_encode(array("result"=>0,"msg"=>"用户名和密码不能为空"));
			exit;
		}
		
		$tmp=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_user}' or content_email='{$content_user}' or content_user='{$content_user}' ",array("auto_id","pass_randstr","last_login_fail_time","login_fail_times"));
		
		//判断是否存在登录限制
		if(strtotime("+1 day",strtotime($tmp["last_login_fail_time"]))>=strtotime(date("Y-m-d H:i:s")) && $tmp["login_fail_times"]>=3){
			echo json_encode(array("result"=>0,"msg"=>"登录失败次数过多，请明天再试"));
			exit;
		}
		
		
		
		$content_pass=md5($content_pass.$tmp["pass_randstr"]);
		//查询数据库	
		$member=$dao->get_row_by_where($dao->tables->member,"where (content_mobile='{$content_user}' or content_email='{$content_user}' or content_user='{$content_user}') and content_pass='{$content_pass}' and publish='1'");
		
		//若用户名及密码正确,存入session和cookie
		if(is_array($member)){
			
			//将用户信息存入session
			$memberService=new memberService();
			$member=$memberService->getMember($member["auto_id"]);
			$memberService->setLoginMemberInfo($member);
			
			
			//记录用户名到cookie
			$expire = 3600*24*365;
			setcookie('username',urlencode($content_user),time()+$expire,"/");
			
			//如果用户选择了自动登录，将密码存入cookie,用md5加密
			if($_REQUEST["remember_pwd"]=="1"){
				setcookie('pwd',urlencode($content_pass),time()+$expire,"/");		
			}else{
				setcookie("pwd","",time()+60,"/");
			}
			
			//如果存在登录限制，则清除限制
			if($member["login_fail_times"]>0){
				$arr=array();
				$arr["login_fail_times"]=0;
				$dao->update($dao->tables->member,$arr,"where auto_id='{$member["auto_id"]}'");
			}
			
			echo json_encode(array("result"=>1,"msg"=>"登录成功","redirect"=>$_SESSION["redirectUrl"]));
			unset($_SESSION["redirectUrl"]);
			exit;
		}else{
			
			//记录登录失败的信息
			$arr=array();
			$arr["last_login_fail_time"]=date("Y-m-d H:i:s");
			//如果上次登录失败时间到现在小于24小时，则次数加1
			if(strtotime("+1 day",strtotime($tmp["last_login_fail_time"]))>=strtotime(date("Y-m-d H:i:s"))){
				$arr["login_fail_times"]=$tmp["login_fail_times"]+1;
			}else{
				//否则此时置为1
				$arr["login_fail_times"]=1;
			}
			$dao->update($dao->tables->member,$arr,"where auto_id='{$tmp["auto_id"]}'");
			
			echo json_encode(array("result"=>0,"msg"=>"用户名或密码错误"));
			exit;
		}
	}
	
	//退出
	function logout(){
		global $global_link;
		$memberService=new memberService();
		$memberService->cleanLoginMemberInfo();
		
		$this->redirect($global_link["login"],"您已经成功退出，欢迎您再次光临");
	}
	
	//ajax退出
	function ajaxLogout(){
		$memberService=new memberService();
		$memberService->cleanLoginMemberInfo();
		
		echo json_encode(array("result"=>1,"msg"=>"退出成功"));
		exit;
	}
	
	//短信找回密码页面
	function forgetPassword(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		$record=array();
		$record["page_title"]="忘记密码";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=login";
		$this->tpl_file="forget_pwd.php";
		return $record;
	}
	
	//获取短信验证码
	function getResetPasswordMobileMsg(){
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			unset($_SESSION["validateNUM"]);
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		global $global_params,$global,$dao;
		$content_mobile=$_POST["content_mobile"];
		$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
		if(!is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此手机号未注册，请确认您的手机号是否正确"));
			exit;
		}
		
		//查询短信记录表
		$today=date("Y-m-d");
		$recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
		if(is_array($recordList) && count($recordList)>=5){
			//每天最多使用5次
			echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
			exit;
		}
		
		//生成验证码
		$num=rand(10000,99999);
		
		//验证码写入session
		$_SESSION["resetPwdRandNum"]=$num;
		$_SESSION["resetPwdMobile"]=$content_mobile;
		$_SESSION["validateErrorCount"]=0;
		
		//获取网站名称
		$paramsService=new paramsService();
		$site_name=$paramsService->getParamValue("content_name");
		
		//发送短信验证码
		$mobileMsgService=new mobileMsgService();
		//$mobileMsgService->sendMsg($content_mobile,"您正在使用{$global_params["content_title"]}网站的密码找回功能,验证码为{$num},请保管好验证码并切勿转告他人","forgetPwd");
		$mobileMsgService->sendMsg($content_mobile,"您正在使用{$site_name}的密码找回功能,验证码为{$num},请妥善保管并切勿转告他人",array("content_type"=>"forgetPwd"));
		
		echo json_encode(array("result"=>1,"msg"=>"验证码已经发送到您的手机，有效期20分钟，请注意查收"));
	}
	
	function checkResetPasswordMobileMsg(){
		
		$mobile_randnum=$_POST["mobile_randnum"];
		if($mobile_randnum=="" || $_SESSION["resetPwdRandNum"]=="" || $_SESSION["resetPwdRandNum"]!=$mobile_randnum){
			$_SESSION["validateErrorCount"]++;
			if($_SESSION["validateErrorCount"]>5){
				$_SESSION["resetPwdRandNum"]="";
				echo json_encode(array("result"=>0,"msg"=>"验证码失败次数过多，请重新获取验证码"));
				
				exit;
			}
			
			echo json_encode(array("result"=>0,"msg"=>"短信验证码输入有误，请重试"));
			exit;
		}
		
		//设置session标志位
		$_SESSION["resetPwdFlag"]="1";
		
		echo json_encode(array("result"=>1,"msg"=>"验证成功，请重新设置您的密码"));
	}
	
	//重置密码页面
	function resetPasswordForm(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		//判断如果没有session标志位，返回到忘记密码的页面
		if($_SESSION["resetPwdFlag"]!="1" || $_SESSION["resetPwdRandNum"]=="" || $_SESSION["resetPwdMobile"]==""){
			$this->redirect("{$global->siteUrlPath}/index.php?acl=member&method=forgetPassword");
			exit;
		}
		$record=array();
		//$record["page_title"]="重置密码";
		//$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=login";
		$this->tpl_file="reset_pwd.php";
		return $record;
		
	}
	
	//短信找回密码处理
	function resetPassword(){
		global $dao,$global; 
		//判断当前操作是否允许
		if($_SESSION["resetPwdFlag"]!="1" || $_SESSION["resetPwdRandNum"]=="" || $_SESSION["resetPwdMobile"]==""){
			echo json_encode(array("result"=>0,"msg"=>"验证出错,请重试"));
			exit;
		}
		
		if($_POST["content_pass"]==""){
			echo json_encode(array("result"=>0,"msg"=>"新密码不能为空"));
			exit;
		}
		
		//修改密码
		
		$record["pass_randstr"]=rand(1000000,9999999);
		$record["content_pass"]=md5($_POST["content_pass"].$record["pass_randstr"]);
		
		$dao->update($dao->tables->member,$record,"where content_mobile='{$_SESSION["resetPwdMobile"]}'");
		
		if($global->use_ucenter){
			include $global->absolutePath.'/uc_client/config.inc.php';
			include $global->absolutePath.'/uc_client/client.php';
			//查询用户信息并调用同步接口
			$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$_SESSION["resetPwdMobile"]}' ",array("uc_id","content_user","content_email"));	
			if(is_array($member) && $member["uc_id"]!=""){
				$result=uc_user_edit($member["content_user"] , "" , $_POST["content_pass"] , "" ,true);
				if($result<0){
					echo json_encode(array("result"=>0,"msg"=>"密码修改失败"));
					exit;
				}			
			}
		}
		
		//清除session标志位
		unset($_SESSION["resetPwdRandNum"]);
		unset($_SESSION["resetPwdFlag"]);
		unset($_SESSION["resetPwdMobile"]);
		
		echo json_encode(array("result"=>1,"msg"=>"密码重置成功，请注意保管好您的密码"));
		
	}
	
	//重置密码成功页面
	function resetPasswordSuccess(){
		$record=array();
		$this->tpl_file="pwd_sucess.php";
		return $record;
	}
	
	//邮件找回密码
	function forgetPassword_email(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		$record=array();
		$record["page_title"]="忘记密码";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=login";
		$this->tpl_file="forget_pwd_email.php";
		return $record;
	}
	
	//邮件找回密码，ajax发送邮件
	function sendResetPasswordEmail(){
		global $global,$dao,$global_link;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		
		
		$email=$_POST["content_email"];
		
		if($email==""){
			echo json_encode(array("result"=>0,"msg"=>"请输入邮箱"));
			exit;
		}
		
		//判断邮箱是否存在
		$member=$dao->get_row_by_where($dao->tables->member,"where content_email='{$email}'");
		
		if(!is_array($member)){
			echo json_encode(array("result"=>0,"msg"=>"会员信息不存在，请检查邮箱是否正确"));
			exit;
		}
		//发送验证邮件
		$paramsService=new paramsService();
		$email_params=$paramsService->getParams(array("content_name"));
		$title=$email_params["content_name"]."密码找回邮件";
		$time=time();
		$link=$global->siteUrlPath."/index.php?acl=member&method=resetPasswordForm_email&email=".urlencode($email)."&time={$time}&validate=".md5($email.$member["pass_randstr"].$time);
		ob_start();
		?>
		尊敬的用户，您好，您正在使用<?=$email_params["content_name"]?>的密码找回功能，请点击下方链接进行下一步操作（或将链接复制到浏览器地址栏运行），如非本人操作请忽略本邮件。<br/><br/>
        <a target="_blank" href="<?=$link?>"><?=$link?></a>
		<?
		$body=ob_get_contents();
		ob_end_clean();
		$emailService=new emailService();
		$result=$emailService->sendEmail($email,$title,$body);
		if($result)
		{
			echo json_encode(array("result"=>1,"msg"=>"邮件发送成功"));
			exit;
		}
		else{
			echo json_encode(array("result"=>0,"msg"=>"邮件发送失败，请联系管理员"));
			exit;
		}
		
	}
	
	//发送找回密码邮件成功
	function resetPassword_email_sendsuccess(){
		$record=array();
		$this->tpl_file="pwd_sendemail_sucess.php";
		return $record;
	}
	
	//邮件重置密码
	function resetPasswordForm_email(){
		global $global,$dao;
		$failUrl="{$global->siteUrlPath}/index.php?acl=member&method=forgetPassword_email";
		
		//参数校验
		if($_GET["email"]=="" || $_GET["time"]=="" || $_GET["validate"]==""){
			$this->redirect($failUrl,"参数有误");
			exit;
		}
		
		//有效期校验
		if($_GET["time"]+7200<time()){
			$this->redirect($failUrl,"链接已失效，请重新操作");
			exit;
		}
		
		
		//用户校验
		$member=$dao->get_row_by_where($dao->tables->member,"where content_email='{$_GET["email"]}'");
		if(!is_array($member)){
			$this->redirect($failUrl,"信息有误，请重新操作");
			exit;
		}
		
		//md5校验
		if(md5($member["content_email"].$member["pass_randstr"].$_GET["time"])!=$_GET["validate"]){
			$this->redirect($failUrl,"信息校验失败，请重新操作");
			exit;
		}
		
		$_SESSION["resetPwdEmail"]=$member["content_email"];
		
		$record=array();
		//$record["page_title"]="重置密码";
		//$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=login";
		$this->tpl_file="reset_pwd_email.php";
		return $record;
	}
	
	//邮件验证重置密码处理
	function resetPassword_email(){
		global $dao,$global; 
		//判断当前操作是否允许
		if($_SESSION["resetPwdEmail"]==""){
			echo json_encode(array("result"=>0,"msg"=>"验证出错,请重试"));
			exit;
		}
		
		if($_POST["content_pass"]==""){
			echo json_encode(array("result"=>0,"msg"=>"新密码不能为空"));
			exit;
		}
		
		
		
		//修改密码
		$record=array();
		$record["pass_randstr"]=rand(1000000,9999999);
		$record["content_pass"]=md5($_POST["content_pass"].$record["pass_randstr"]);
		
		$dao->update($dao->tables->member,$record,"where content_email='{$_SESSION["resetPwdEmail"]}'");
		
		if($global->use_ucenter){
			include $global->absolutePath.'/uc_client/config.inc.php';
			include $global->absolutePath.'/uc_client/client.php';
			//查询用户信息并调用同步接口
			$member=$dao->get_row_by_where($dao->tables->member,"where content_email='{$_SESSION["resetPwdEmail"]}' ",array("uc_id","content_user","content_email"));	
			if(is_array($member) && $member["uc_id"]!=""){
				$result=uc_user_edit($member["content_user"] , "" , $_POST["content_pass"] , "" ,true);
				if($result<0){
					echo json_encode(array("result"=>0,"msg"=>"密码修改失败"));
					exit;
				}			
			}
		}
		
		//清除session标志位
		unset($_SESSION["resetPwdEmail"]);
		
		echo json_encode(array("result"=>1,"msg"=>"密码重置成功，请注意保管好您的密码"));
		
	}
	
	//显示会员资料
	function memberInfo(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		$this->tpl_file="memberinfo.php";
		
		$record["location_title"]="个人信息";
		
		return $record;
		
		
	}
	
	
	//修改资料页面
	function editInfoForm(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		
		
		
		if($mid!=""){
			//查询会员信息
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
			
			
			$record["member"]=$member;
			
		}
		
		$this->tpl_file="edit_memberinfo.php";
		
		$record["location_title"]="个人信息";
		//$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		
		
		/*echo "<pre>";
		print_r($record);
		exit;*/
		
		return $record;

	}
	
	//会员修改资料时验证手机是否可以使用
	function checkEditMobile(){
		global $dao;
		if($_POST["content_mobile"]!=""){
			
			$memberService=new memberService();
			$mid=$memberService->getLoginMemberInfo("auto_id");
			
			$member_sql = "select auto_id from {$dao->tables->member} where content_mobile='".$_POST["content_mobile"]."' and auto_id!='{$mid}' limit 0,1"; 			
			$data = $dao->get_datalist( $member_sql );
			if(is_array($data) && count($data)>0){
				echo "false";
				return;
			}else{
				echo "true";
				return;
			}
		}
	}
	
	//会员修改资料时验证邮箱是否可以使用
	function checkEditEmail(){
		global $dao;
		if($_POST["content_email"]!=""){
			
			$memberService=new memberService();
			$mid=$memberService->getLoginMemberInfo("auto_id");
			
			$member_sql = "select auto_id from {$dao->tables->member} where content_email='".$_POST["content_email"]."' and auto_id!='{$mid}' limit 0,1"; 			
			$data = $dao->get_datalist( $member_sql );
			if(is_array($data) && count($data)>0){
				echo "false";
				return;
			}else{
				echo "true";
				return;
			}
		}
	}
	
	//会员修改资料时验证QQ号码是否可以使用
	function checkEditQQ(){
		global $dao;
		if($_POST["content_qq"]!=""){
			
			$memberService=new memberService();
			$mid=$memberService->getLoginMemberInfo("auto_id");
			
			$member_sql = "select auto_id from {$dao->tables->member} where content_qq='".$_POST["content_qq"]."' and auto_id!='{$mid}' limit 0,1"; 			
			$data = $dao->get_datalist( $member_sql );
			if(is_array($data) && count($data)>0){
				echo "false";
				return;
			}else{
				echo "true";
				return;
			}
		}
	}
	
	//保存个人资料
	function saveInfo(){
		global $global,$dao,$global_link;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		$record=$_POST["frm"];
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		
		if($mid==""){ 
			//$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"请先登录后再进行操作"));
			exit;
		} 
		
		$member_sql = "select * from {$dao->tables->member} where content_email='".$record['content_email']."' and auto_id!='{$mid}'"; 			
		$data = $dao->get_datalist( $member_sql ); 
		
		if(is_array($data) && count($data)>0 ){ 
			//$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同邮箱，请更换其他邮箱"));
			exit;
		} 
		
		/*$member_sql = "select * from {$dao->tables->member} where content_mobile='".$record['content_mobile']."' and auto_id!='{$mid}'"; 			
		$data = $dao->get_datalist( $member_sql ); 
		
		if(is_array($data) && count($data)>0 ){ 
			//$this->redirect($global_link["register"],"已经存在相同手机号，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同手机号，请更换其他手机号"));
			exit;
		}*/
		
		/*$member_sql = "select * from {$dao->tables->member} where content_qq='".$record['content_qq']."' and auto_id!='{$mid}'"; 			
		$data = $dao->get_datalist( $member_sql ); 
		
		if(is_array($data) && count($data)>0 ){ 
			//$this->redirect($global_link["register"],"已经存在相同QQ号码，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同QQ号码，请更换其他QQ号码"));
			exit;
		}*/ 
		
		/*if($record["content_name"]!=""){
			//保存首字拼音first_letter
			$Pinyin=new Pinyin();
			$record["first_letter"]=$Pinyin->getFirstCharPinyinLetter($record["content_name"]);
		}*/
		
		/*//保存城市信息
		$province=$dao->get_row_by_where($dao->tables->address_province,"where id='{$record["province_id"]}'");
		$city=$dao->get_row_by_where($dao->tables->address_city,"where id='{$record["city_id"]}'");
		
		$record["province_name"]=$province["name"];
		
		$record["city_name"]=$city["name"];*/
		
		
		

		$dao->update($dao->tables->member,$record,"where auto_id='{$mid}'");
		echo json_encode(array("result"=>1,"msg"=>"信息修改成功"));
		exit;
		
	}
	
	//头像上传页面
	function uploadHeadImgForm(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		//验证登录
		global $global_link;
		//如果没有登录，跳转回登录页面
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->redirect($global_link["login"],"您需要登录后才能进行操作");
			exit;
		}
		$record=array();
		$record["location_title"]="修改头像";
		//$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		$this->tpl_file="edit_head.php";
		return $record;
		
	}
	//处理上传头像的操作
	function uploadHeadImg(){
		global $dao;
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->jsAlert("您需要登录后才能进行操作");
			exit;
		}
		
		$field_name="content_head_file";
		
		$filearr=pathinfo($_FILES[$field_name]['name']);
		$filetype=strtolower($filearr["extension"]);
		
		if(!in_array($filetype,array("jpeg","jpg","gif","png","bmp"))){
			?>
            <script>
			alert("文件类型不符合要求");
			window.parent.window.document.getElementById("content_head_file").value="";
			</script>
			<?            
			exit;
		}
			
		if($_FILES[$field_name]['size']>(4*1024*1024)){
			?>
            <script>
			alert("文件太大，请选择4MB以内的文件");
			window.parent.window.document.getElementById("content_head_file").value="";
			</script>
			<?            
			exit;
		}
		
		$uploadFile=new UploadFile();
		//$_record=$uploadFile->save_upload_file($field_name);
		$_record=$uploadFile->save_upload_img($field_name,320,320);
		//$_record['savePath']
		//$_record['urlPath']
		
		?>
        <script>
        window.parent.window.document.getElementById("content_head_file").value="";
		window.parent.window.document.getElementById("content_head").value="<?=$_record['savePath']?>";
        window.parent.window.document.getElementById("member_head_img").src="<?=$_record['urlPath']?>";
		window.parent.window.document.getElementById("member_head_img2").src="<?=$_record['urlPath']?>";
		window.parent.window.document.getElementById("member_head_img3").src="<?=$_record['urlPath']?>";
        </script>
        <?
		
		//将新的头像存入数据库
		$record=array();
		//$record["content_head"]=$_record['savePath'];
		//$dao->update($dao->tables->member,$record,"where auto_id='{$mid}'");
		
		return $record;
		
	}
	
	//保存头像字段到数据库
	function saveHeadImgValue(){
		global $dao;
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			echo json_encode(array("result"=>0,"msg"=>"登录后才可以进行操作"));
			exit;
		}
		

		$record=array();
		$record["content_head"]=$_GET["content_head"];
		$dao->update($dao->tables->member,$record,"where auto_id='{$mid}'");
		
		
		echo json_encode(array("result"=>1,"msg"=>"保存成功"));
		
	}
	
	
	
	//修改密码页面
	function passwordForm(){
		global $top_menu_focus,$global;
		$top_menu_focus=false;
		//验证登录
		global $global_link;
		//如果没有登录，跳转回登录页面
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->redirect($global_link["login"],"您需要登录后才能进行操作");
			exit;
		}
		$this->tpl_file="edit_pass.php";
		$record=array();
		$record["location_title"]="修改密码";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		
		return $record;
	}
	
	//修改密码处理
	function savePassword(){
		global $dao,$global;
		
		/*//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			$this->redirect("index.php?acl=member&method=passwordForm","验证码输入错误");
			exit;
		}
		unset($_SESSION["validateNUM"]);*/
		$record=$_POST;
		
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		
		if($mid==""){ 
			//$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"请先登录后再进行操作"));
			exit;
		}
		
		//查询出原有的数据
		$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
		$oldpass=$member["content_pass"];
		
		
		if(md5($record["old_pass"].$member["pass_randstr"])!=$oldpass){
			//$this->redirect("index.php?acl=member&method=passwordForm","旧密码输入错误");
			echo json_encode(array("result"=>0,"msg"=>"旧密码输入错误"));
			exit;
		}
			

		
		//生成新密码
		$password = md5($record['new_pass'].$member["pass_randstr"]);
		
		$password_record=array();
		$password_record["content_pass"]=$password;

		
		$dao->update($dao->tables->member,$password_record,"where auto_id='{$mid}'");
		//$this->redirect($global->siteUrlPath,"您已经成功修改了密码");
		echo json_encode(array("result"=>1,"msg"=>"您已经成功修改了密码"));
	}
	
	
	//生成随机数的函数
	private function random($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}
	
	//会员中心首页
	function member(){
		global $global,$global_link;
		$memberService=new memberService();
		$member_id=$memberService->getLoginMemberInfo("auto_id");
		if($member_id==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		$this->tpl_file="member.php";
		$record=array();
		//$record["page_title"]="会员中心";
		//$record["back_link"]=$global->siteUrlPath."/index.php";
		return $record;
	}
	
	//会员中心-我的账户
	function account(){
		global $global,$global_link;
		//如果没有登录，跳转回登录页面
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->redirect($global_link["login"],"您需要登录后才能进行操作");
			exit;
		}
		$this->tpl_file="account.php";
		$record=array();
		return $record;
	}
	
	//处理账户充值
	function fillMoney(){
		global $global,$global_link,$dao;
		//检验登录
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			echo json_encode(array("result"=>0,"msg"=>"请先登录"));
			exit;
		}
		
		
		//校验充值金额
		$money=$_REQUEST["fill_money"];
		if(!is_numeric($money) || $money<0.01 || $money>1000000){
			echo json_encode(array("result"=>0,"msg"=>"充值金额不符合要求"));
			exit;
		}
		$money=round($money,2);
		//保存充值订单
		$record=array();
		$orderService=new orderService();
		$record["order_sn"]=$orderService->createOrderSn();
		$record["name"]="账户充值";
		$record["type"]=4;
		$record["member_id"]=$mid;
		$record["pay_money"]=$money;
		$record["create_time"]=date("Y-m-d H:i:s");
		$dao->insert($dao->tables->order,$record,true);
		$record["auto_id"]=$dao->get_insert_id();
		
		//支付成功跳转地址
		$success_url=$global->siteUrlPath."/index.php?acl=member&method=account";
		//支付失败跳转地址
		$fail_url=$global->siteUrlPath."/index.php?acl=member&method=account";
		//获取支付链接
		$payUrl=$global->siteUrlPath."/index.php?acl=member&method=pay&order_sn={$record["order_sn"]}&success_url=".base64_encode($success_url)."&fail_url=".base64_encode($fail_url);
		
		echo json_encode(array("result"=>1,"msg"=>"","url"=>$payUrl));
		
	}
	
	//会员中心-提现申请
	function accountApply(){
		global $global,$global_link;
		//如果没有登录，跳转回登录页面
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->redirect($global_link["login"],"您需要登录后才能进行操作");
			exit;
		}
		$this->tpl_file="account_apply.php";
		$record=array();
		return $record;
	}
	
	//保存提现申请记录
	function saveCashApply(){
		
		global $global,$dao;
		$memberService=new memberService();
		$memberInfo=$memberService->getLoginMemberInfo();
		$member_id=$memberInfo["auto_id"];
		$member_mobile=$memberInfo["content_mobile"];
		if($member_id==""){
			echo json_encode(array("result"=>0,"msg"=>"请先登录"));
			exit;
		}
		
		
		//判断是否存在未审核的提现申请
		$tmp=$dao->get_row_by_where($dao->tables->cash_apply,"where member_id='{$member_id}' and content_status='0'");
		if($tmp["auto_id"]!=""){
			echo json_encode(array("result"=>0,"msg"=>"您目前尚有未审核的提现申请，请不要重复申请"));
			exit;
		}
		
		$record=$_POST["frm"];
		
		if($record["content_money"]==""){
			echo json_encode(array("result"=>0,"msg"=>"请输入提现金额"));
			exit;
		}
		
		$memberAccountService=new memberAccountService();
		$accountBalance=$memberAccountService->getAccountBalance($member_id);
		
		//获取系统设定的最低提现金额
		$paramsService=new paramsService();
		$min_apply_money=$paramsService->getParamValue("min_cash_apply");
		if($min_apply_money==""){
			$min_apply_money=100;
		}
		
		if($record["content_money"]<$min_apply_money){
			echo json_encode(array("result"=>0,"msg"=>"提现金额不能小于{$min_apply_money}元"));
			exit;
		}
		
		if($record["content_money"]>$accountBalance){
			echo json_encode(array("result"=>0,"msg"=>"提现金额不能大于账户余额"));
			exit;
		}
		
		$record["member_id"]=$member_id;
		$record["content_mobile"]=$member_mobile;
		$record["create_time"]=date("Y-m-d H:i:s");
		
		$dao->insert($dao->tables->cash_apply,$record);
		
		
		
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功，我们会尽快处理您的请求"));	
		
	}
	
	
	//订单支付
	function pay(){
		global $global,$global_link,$dao;
		//如果没有登录，跳转回登录页面
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->redirect($global_link["login"],"您需要登录后才能进行操作");
		}
		$record=array();
		//判断订单是否存在
		$record["order"]=$dao->get_row_by_where($dao->tables->order,"where order_sn='{$_GET["order_sn"]}'");
		//判断是否有权限支付
		if($record["order"]["member_id"]!=$mid){
			$this->redirect($global->siteUrlPath,"没有权限查看此订单");
		}
		
		//判断此订单当前是否可以支付
		if($record["order"]["pay_money"]>0 && $record["order"]["pay_status"]=="0" && $record["order"]["pay_type"]=="1" && $record["order"]["pay_status"]=="0"){
			
		}else{
			$this->redirect(base64_decode($_GET["fail_url"]));
		}
		
		//如果不是账户充值，并且账户余额足够，直接在账户余额中扣除订单费用
		if($record["order"]["type"]!=4){
			
			//查询会员账户余额
			$memberAccountService=new memberAccountService();
			$account_balance=$memberAccountService->getAccountBalance($mid);
			if($account_balance>=$record["order"]["pay_money"]){
				//此时还没有生成在线支付记录，只能直接调用支付回调而不能调用支付通知响应函数payOrder
				//考虑到此处是封装的，所有的订单支付都会调用这里,可以在此处处理扣除余额及支付成功回调等
				
				$order=$record["order"];
				
				$onlinePayService=new onlinePayService();
				
				$balance_monay=$account_balance-$order["pay_money"];
				
				//扣除账户余额
				$dataArray=array();
				$dataArray["member_id"]=$order["member_id"];
				$dataArray["content_type"]=2;
				$dataArray["content_event"]="account_pay";
				$dataArray["content_desc"]="支付订单{$order["order_sn"]}";
				$dataArray["content_money"]=$order["pay_money"]*(-1);
				$dataArray["balance_monay"]=$balance_monay;
				$dataArray["order_id"]=$order["auto_id"];
				$dataArray["order_sn"]=$order["order_sn"];			
				$dataArray["create_time"]=date("Y-m-d H:i:s");
				$dao->insert($dao->tables->member_account,$dataArray);
				//修改账户余额字段
				$dao->update($dao->tables->member,array("account_balance"=>$dataArray["balance_monay"]),"where auto_id='{$dataArray["member_id"]}'");
				
				//写入订单日志
				$orderService=new orderService();
				$orderService->addOrderLog($order["auto_id"],"用户","账户余额支付{$order["pay_money"]}元");
				
				//设置订单为已支付
				$tmp=array();
				$tmp["pay_status"]="1";
				$dao->update($dao->tables->order,$tmp,"where auto_id='{$order["auto_id"]}'");
				
				//调用支付成功事件
				$order["pay_status"]="1";
				$onlinePayService->paySuccessCallback($order);
				
				//跳转至支付成功页面
				$this->redirect(base64_decode($_GET["success_url"]));
				exit;
			}
		}
		
		$this->tpl_file="pay.php";
		return $record;
	}
	
		//安全设置
	function safe(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$member=$memberService->getLoginMemberInfo();
		$mid=$member["auto_id"];
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		
		$this->tpl_file="mem_safety.php";

		
		
		$record["location_title"]="安全设置";
		
		return $record;
	}
	
	function changeMobileForm_1(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		
		
		
		if($mid!=""){
			//查询会员信息
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
			$record["member"]=$member;
		}
		
		//如果之前没有设置过手机号
		if($record["member"]["content_mobile"]==""){
			//直接跳转到设置新手机号的页面
			$_SESSION["changeMobileFlag"]="1";
			$this->redirect($global->siteUrlPath."/index.php?acl=member&method=changeMobileForm_2");
		}
		
		$this->tpl_file="changeMobile_1.php";
		
		$record["page_title"]="修改手机号";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		
		
		return $record;
	}
	
	function getChangeMobileMsg_1(){
		global $global_params,$global,$dao;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			unset($_SESSION["validateNUM"]);
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		$memberService=new memberService();
		$content_mobile=$memberService->getLoginMemberInfo("content_mobile");
		
		/*$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
		if(!is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此手机号未注册，请确认您的手机号是否正确"));
			exit;
		}*/
		
		//查询短信记录表
		$today=date("Y-m-d");
		$recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
		if(is_array($recordList) && count($recordList)>=10){
			//每天最多使用3次
			echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
			exit;
		}
		
		//生成验证码
		$num=rand(10000,99999);
		
		//验证码写入session
		$_SESSION["changeMobileRandNum"]=$num;
		$_SESSION["changeMobileNo"]=$content_mobile;
		
		//获取网站名称
		$paramsService=new paramsService();
		$site_name=$paramsService->getParamValue("content_name");
		
		//发送短信验证码
		$mobileMsgService=new mobileMsgService();
		//$mobileMsgService->sendMsg($content_mobile,"您正在使用{$global_params["content_title"]}网站的密码找回功能,验证码为{$num},请保管好验证码并切勿转告他人","forgetPwd");
		$mobileMsgService->sendMsg($content_mobile,"您正在使用{$site_name}的重置手机号功能,验证码为{$num},请妥善保管并切勿转告他人",array("content_type"=>"changeMobile"));
		
		echo json_encode(array("result"=>1,"msg"=>"验证码已经发送到您的手机，有效期20分钟，请注意查收"));
	}
	
	function validateMobileMsg_1(){
		$mobile_randnum=$_POST["mobile_randnum"];
		if($mobile_randnum=="" || $_SESSION["changeMobileRandNum"]=="" || $_SESSION["changeMobileRandNum"]!=$mobile_randnum){
			echo json_encode(array("result"=>0,"msg"=>"短信验证码输入有误，请重试"));
			exit;
		}
		
		//设置session标志位
		$_SESSION["changeMobileFlag"]="1";
		
		echo json_encode(array("result"=>1,"msg"=>"验证成功，请重新设置您的手机号"));
	}
	
	function changeMobileForm_2(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		
		//验证标识位是否存在
		if($_SESSION["changeMobileFlag"]!="1" || $_SESSION["changeMobileNo"]==""){
			$this->redirect("index.php?acl=member");
			exit;
		}
		
		if($mid!=""){
			//查询会员信息
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
			$record["member"]=$member;
		}
		
		$this->tpl_file="changeMobile_2.php";
		
		$record["page_title"]="修改手机号";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		
		
		return $record;
	}
	
	function getChangeMobileMsg_2(){
		global $global_params,$global,$dao;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			unset($_SESSION["validateNUM"]);
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		//标识位是否存在
		if($_SESSION["changeMobileFlag"]!="1" || $_SESSION["changeMobileNo"]==""){
			echo json_encode(array("result"=>0,"msg"=>"验证过期，请重新验证手机"));
			exit;
		}
		
		
		
		$content_mobile=$_POST["content_mobile"];
		//不能与原手机号相同
		if($content_mobile==$_SESSION["changeMobileNo"]){
			echo json_encode(array("result"=>0,"msg"=>"新手机号不能与原手机号相同"));
			exit;
		}
		
		//手机号是否注册过
		$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
		if(is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此手机号已注册，请确认您的手机号是否正确"));
			exit;
		}
		
		//查询短信记录表
		$today=date("Y-m-d");
		$recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
		if(is_array($recordList) && count($recordList)>=10){
			//每天最多使用3次
			echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
			exit;
		}
		
		//生成验证码
		$num=rand(10000,99999);
		
		//验证码写入session
		$_SESSION["changeMobileRandNum2"]=$num;
		$_SESSION["changeMobileNo2"]=$content_mobile;
		
		//获取网站名称
		$paramsService=new paramsService();
		$site_name=$paramsService->getParamValue("content_name");
		
		//发送短信验证码
		$mobileMsgService=new mobileMsgService();
		//$mobileMsgService->sendMsg($content_mobile,"您正在使用{$global_params["content_title"]}网站的密码找回功能,验证码为{$num},请保管好验证码并切勿转告他人","forgetPwd");
		$mobileMsgService->sendMsg($content_mobile,"您正在{$site_name}的进行重置手机号操作,验证码为{$num},请妥善保管并切勿转告他人",array("content_type"=>"changeMobile"));
		
		echo json_encode(array("result"=>1,"msg"=>"验证码已经发送到您的手机，有效期20分钟，请注意查收"));
	}
	
	function saveMemberMobile(){
		global $dao,$global; 
		$mobile_randnum=$_POST["mobile_randnum"];
		if($mobile_randnum=="" || $_SESSION["changeMobileRandNum2"]=="" || $_SESSION["changeMobileRandNum2"]!=$mobile_randnum){
			echo json_encode(array("result"=>0,"msg"=>"短信验证码输入有误，请重试"));
			exit;
		}

		//判断当前操作是否允许
		if($_SESSION["changeMobileFlag"]!="1" || $_SESSION["changeMobileNo"]=="" || $_SESSION["changeMobileNo2"]==""){
			echo json_encode(array("result"=>0,"msg"=>"验证出错,请重试"));
			exit;
		}
		
		$content_mobile=$_POST["content_mobile"];
		if($content_mobile!=$_SESSION["changeMobileNo2"]){
			echo json_encode(array("result"=>0,"msg"=>"提交的手机号与验证手机不一致，请重新操作"));
			exit;
		}
		
		//修改手机号
		
		$record["content_mobile"]=$content_mobile;
		
		$dao->update($dao->tables->member,$record,"where content_mobile='{$_SESSION["changeMobileNo"]}'");
		
		$memberService=new memberService();
		$memberInfo=$memberService->getLoginMemberInfo();
		
		
		if($memberInfo["content_name"]==$memberInfo["content_mobile"])
			$memberInfo["content_name"]=$record["content_mobile"];
		$memberInfo["content_mobile"]=$record["content_mobile"];
		$memberService->setLoginMemberInfo($memberInfo);
		
		//清除session标志位
		unset($_SESSION["changeMobileRandNum"]);
		unset($_SESSION["changeMobileRandNum2"]);
		unset($_SESSION["changeMobileNo"]);
		unset($_SESSION["changeMobileNo2"]);
		unset($_SESSION["changeMobileFlag"]);
		
		
		echo json_encode(array("result"=>1,"msg"=>"手机号重置成功"));
	}
	
	//提交修改第一步
	function changeEmailForm(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		
		if($mid!=""){
			//查询会员信息
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
			$record["member"]=$member;
		}
		
		if($member["content_email"]!=""){
			$this->tpl_file="changeEmailForm_1.php";
		}else{
			$_SESSION["changeEmailFlag"]="1";
			
			$this->tpl_file="changeEmailForm_2.php";
		}
		
		
		
		$record["page_title"]="修改手机号";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		
		
		return $record;
	}
	//完成修改
	function changeEmailForm_2(){
		global $dao,$top_menu_focus,$global,$global_link;
		$top_menu_focus=false;
		$record=array();
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			//$this->redirect($global->siteUrlPath,"请先登录");
			$this->redirect($global_link["login"]);
		}
		
		//验证标识位是否存在
		if($_SESSION["changeEmailFlag"]!="1"){
			$this->redirect("index.php?acl=member");
			exit;
		}
		
		if($mid!=""){
			//查询会员信息
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
			$record["member"]=$member;
		}
		
		
		$this->tpl_file="changeEmailForm_2.php";
		
		
		$record["page_title"]="修改手机号";
		$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
		
		
		return $record;
	}
	
	function getChangeEmailMsg_1(){
		global $global_params,$global,$dao;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			unset($_SESSION["validateNUM"]);
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		$memberService=new memberService();
		$member_id=$memberService->getLoginMemberInfo("auto_id");
		$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$member_id}'");
		
		$content_email=$member["content_email"];
		
		/*$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
		if(!is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此手机号未注册，请确认您的手机号是否正确"));
			exit;
		}*/
		
		/*//查询短信记录表
		$today=date("Y-m-d");
		$recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
		if(is_array($recordList) && count($recordList)>=10){
			//每天最多使用3次
			echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
			exit;
		}*/
		
		//生成验证码
		$num=rand(10000,99999);
		
		//验证码写入session
		$_SESSION["changeEmailRandNum"]=$num;
		$_SESSION["changeEmail"]=$content_email;
		
		//获取网站名称
		$paramsService=new paramsService();
		$site_name=$paramsService->getParamValue("content_name");
		
		$time=time();
		$link=$global->siteUrlPath."/index.php?acl=member&method=changeEmailForms&email=".urlencode($email)."&time={$time}&validate=".md5($email.$member["pass_randstr"].$time);
		$eventName="editEmail";
		//获取下单成功的短信模板
		$emailTemplet=$dao->get_row_by_where($dao->tables->email_templet,"where content_event='{$eventName}' and publish='1'");
		if(is_array($emailTemplet)){
			
			$body=str_replace('{code}',$num,$emailTemplet["content_body"]);
			$title=$emailTemplet["content_title"];
			// echo "<pre>";print_r($title);die;
			$emailService=new emailService();
			$result=$emailService->sendEmail($content_email,$title,$body);
		}
		
		echo json_encode(array("result"=>1,"msg"=>"验证码已经发送到您的邮箱，有效期20分钟，请注意查收"));
	}
	
	function validateEmailMsg_1(){
		$email_randnum=$_POST["email_randnum"];
		if($email_randnum=="" || $_SESSION["changeEmailRandNum"]=="" || $_SESSION["changeEmailRandNum"]!=$email_randnum){
			echo json_encode(array("result"=>0,"msg"=>"验证码输入有误，请重试"));
			exit;
		}
		
		//设置session标志位
		$_SESSION["changeEmailFlag"]="1";
		
		echo json_encode(array("result"=>1,"msg"=>"验证成功，请重新设置您的邮箱"));
	}
	
	function getChangeEmailMsg_2(){
		global $global_params,$global,$dao;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			unset($_SESSION["validateNUM"]);
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		//标识位是否存在
		if($_SESSION["changeEmailFlag"]!="1" /*|| $_SESSION["changeEmail"]==""*/){
			echo json_encode(array("result"=>0,"msg"=>"验证过期，请重新验证邮箱"));
			exit;
		}
		
		
		
		$content_email=$_POST["content_email"];
		/*//不能与原手机号相同
		if($content_email==$_SESSION["changeEmail"]){
			echo json_encode(array("result"=>0,"msg"=>"新邮箱不能与原邮箱相同"));
			exit;
		}*/
		$memberService=new memberService();
		$member_id=$memberService->getLoginMemberInfo("auto_id");
		
		
		//手机号是否注册过
		$member=$dao->get_row_by_where($dao->tables->member,"where content_email='{$content_email}' and auto_id!='{$member_id}'");
		if(is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此邮箱已注册，请确认您的邮箱是否正确"));
			exit;
		}
		
		/*//查询短信记录表
		$today=date("Y-m-d");
		$recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
		if(is_array($recordList) && count($recordList)>=10){
			//每天最多使用3次
			echo json_encode(array("result"=>0,"msg"=>"您获取验证码的操作过于频繁，请明天再试"));
			exit;
		}*/
		
		//生成验证码
		$num=rand(10000,99999);
		
		//验证码写入session
		$_SESSION["changeEmailRandNum2"]=$num;
		$_SESSION["changeEmail2"]=$content_email;
		
		//获取网站名称
		$paramsService=new paramsService();
		$site_name=$paramsService->getParamValue("content_name");
		
		$time=time();
		$link=$global->siteUrlPath."/index.php?acl=member&method=changeEmailForms&email=".urlencode($email)."&time={$time}&validate=".md5($email.$member["pass_randstr"].$time);
		$eventName="editEmail";
		//获取下单成功的短信模板
		$emailTemplet=$dao->get_row_by_where($dao->tables->email_templet,"where content_event='{$eventName}' and publish='1'");
		if(is_array($emailTemplet)){
			
			$body=str_replace('{code}',$num,$emailTemplet["content_body"]);
			$title=$emailTemplet["content_title"];
			// echo "<pre>";print_r($title);die;
			$emailService=new emailService();
			$result=$emailService->sendEmail($content_email,$title,$body);
		}
		
		echo json_encode(array("result"=>1,"msg"=>"验证码已经发送到您的邮箱，有效期20分钟，请注意查收"));
	}
	
	function saveMemberEmail(){
		global $dao,$global; 
		$mobile_randnum=$_POST["email_randnum"];
		if($mobile_randnum=="" || $_SESSION["changeEmailRandNum2"]=="" || $_SESSION["changeEmailRandNum2"]!=$mobile_randnum){
			echo json_encode(array("result"=>0,"msg"=>"短信验证码输入有误，请重试"));
			exit;
		}

		//判断当前操作是否允许
		if($_SESSION["changeEmailFlag"]!="1" || $_SESSION["changeEmail2"]==""){
			echo json_encode(array("result"=>0,"msg"=>"验证出错,请重试"));
			exit;
		}
		
		$content_email=$_POST["content_email"];
		if($content_email!=$_SESSION["changeEmail2"]){
			echo json_encode(array("result"=>0,"msg"=>"提交的邮箱与验证邮箱不一致，请重新操作"));
			exit;
		}
		
		$memberService=new memberService();
		$memberInfo=$memberService->getLoginMemberInfo();
		
		//修改手机号
		
		$record["content_email"]=$content_email;
		
		$dao->update($dao->tables->member,$record,"where auto_id='{$memberInfo["auto_id"]}'");
		
		
		
		
		
		$memberInfo["content_email"]=$record["content_email"];
		$memberService->setLoginMemberInfo($memberInfo);
		
		//清除session标志位
		unset($_SESSION["changeEmailRandNum"]);
		unset($_SESSION["changeEmailRandNum2"]);
		unset($_SESSION["changeEmail"]);
		unset($_SESSION["changeEmail2"]);
		unset($_SESSION["changeEmailFlag"]);
		
		
		echo json_encode(array("result"=>1,"msg"=>"邮箱修改成功"));
	}
	
}
?>