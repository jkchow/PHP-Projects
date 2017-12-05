<?

class acl_member extends base_acl
{
    //默认方法是会员中心首页
    var $default_method = "member";

    function __construct()
    {
        global $global;
        $global->tplAbsolutePath = $global->absolutePath . "/res/tpl/member/";
        $global->tplUrlPath = $global->siteUrlPath . "/res/tpl/member/";
    }


    //ajax获取登录的会员信息
    function ajaxGetLoginInfo()
    {
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $member = $memberService->getMember($member["auto_id"]);
        $memberService->setLoginMemberInfo($member);
        $memberRecord = array();
        $memberRecord["id"] = $member["auto_id"];
        $memberRecord["usrname"] = $member["content_name"];
        $memberRecord["type"] = $member["content_type"];
        $memberRecord["is_agree"] = $member["is_agree"];
        $memberRecord["is_auth"] = $member["is_auth"];


        if ($memberRecord["usrname"] == "")
            $memberRecord["usrname"] = $member["content_user"];
        if ($member["auto_id"] != "") {
            $memberRecord["isLogin"] = "1";

            if ($_REQUEST["account"] == "1") {
                //查询会员账户余额
                $memberAccountService = new memberAccountService();
                $memberRecord["account_balance"] = $memberAccountService->getAccountBalance($member["auto_id"]);
            }


        } else {
            $memberRecord["isLogin"] = "0";
        }
        echo json_encode($memberRecord);
    }

    //选择注册类型
    function registerType()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;

        if ($_SESSION["accessReg"] == "") {
            $_SESSION["accessReg"] = 1;
        }

        $this->tpl_file = "regindex.php";
        $record = array();
        $record["page_title"] = "会员注册";

        return $record;
    }

    //注册协议页面
    function registerAgreement()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;

        if ($_SESSION["accessReg"] == "") {
            $_SESSION["accessReg"] = 1;
        }

        $this->tpl_file = "reg_agreement.php";
        $record = array();
        $record["page_title"] = "会员注册";
        $record["back_link"] = $global->siteUrlPath . "/index.php";
        return $record;
    }

    //注册页面
    function register()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;

        if ($_SESSION["accessReg"] == "") {
            $_SESSION["accessReg"] = 1;
        }

        $this->tpl_file = "reg.php";
        $record = array();
        $record["page_title"] = "会员注册";
        $record["back_link"] = $global->siteUrlPath . "/index.php";
        return $record;
    }

    //企业注册
    function companyRegister()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;

        if ($_SESSION["accessReg"] == "") {
            $_SESSION["accessReg"] = 1;
        }

        $this->tpl_file = "regCompany.php";
        $record = array();
        $record["page_title"] = "会员注册";
        $record["back_link"] = $global->siteUrlPath . "/index.php";
        return $record;
    }

    //验证手机是否可以注册
    function checkRegMobile()
    {
        global $dao;
        if ($_POST["content_mobile"] != "") {
            $member_sql = "select auto_id from {$dao->tables->member} where content_mobile='" . $_POST["content_mobile"] . "' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //验证邮箱是否可以注册
    function checkRegEmail()
    {
        global $dao;
        if ($_POST["content_email"] != "") {

            if ($global->use_ucenter) {
                include $global->absolutePath . '/uc_client/config.inc.php';
                include $global->absolutePath . '/uc_client/client.php';
                if (uc_user_checkemail($_POST["content_email"]) != 1) {
                    echo "false";
                    return;
                }
            }

            $member_sql = "select auto_id from {$dao->tables->member} where content_email='" . $_POST["content_email"] . "' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //验证邮箱是否可以注册
    function checkCompanyName()
    {
        global $dao;
        if ($_POST["content_email"] != "") {

            $member_sql = "select auto_id from {$dao->tables->member} where content_type=2 and content_name='" . $_POST["content_name"] . "' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //获取注册的短信验证码
    function getRegMobileMsg()
    {
        global $global_params, $global, $dao;

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            unset($_SESSION["validateNUM"]);
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);

        if ($_SESSION["accessReg"] == "") {
            echo json_encode(array("result" => 0, "msg" => "系统超时，请重试"));
            exit;
        } else {
            $_SESSION["accessReg"] += 1;
            if ($_SESSION["accessReg"] > 10) {
                echo json_encode(array("result" => 0, "msg" => "您获取验证码的操作过于频繁，请明天再试"));
                exit;
            }
        }
        $content_mobile = $_POST["content_mobile"];

        //判断手机号格式是否正确
        if (!preg_match('/^1[3578][0-9]{9}$/', $content_mobile)) {
            echo json_encode(array("result" => 0, "msg" => "手机号格式不正确"));
            exit;
        }


        $member = $dao->get_row_by_where($dao->tables->member, "where content_mobile='{$content_mobile}'");
        if (is_array($member)) {
            //判断手机号是否已经注册
            echo json_encode(array("result" => -1, "msg" => "此手机号已经注册，请直接登录"));
            exit;
        }

        //查询短信记录表
        $today = date("Y-m-d");
        $recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
        if (is_array($recordList) && count($recordList) >= 10) {
            //每天最多使用3次
            echo json_encode(array("result" => 0, "msg" => "您获取验证码的操作过于频繁，请明天再试"));
            exit;
        }

        //生成验证码
        $num = rand(10000, 99999);

        //验证码写入session
        $_SESSION["regRandNum"] = $num;
        $_SESSION["regMobile"] = $content_mobile;
        $_SESSION["validateErrorCount"] = 0;

        //获取网站名称
        $paramsService = new paramsService();
        $site_name = $paramsService->getParamValue("content_name");


        $eventName = "memberRegCode";
        //获取下单成功的短信模板
        $mobileTemplet = $dao->get_row_by_where($dao->tables->mobile_msg_templet, "where content_event='{$eventName}' and publish='1'");
        if (is_array($mobileTemplet)) {
            $text = str_replace('{msg_code}', $num, $mobileTemplet["content_text"]);
            $mobileMsgService = new mobileMsgService();
            $mobileMsgService->sendMsg($content_mobile, $text, array("content_type" => "reg", "validate_code" => $num));
            echo json_encode(array("result" => 1, "msg" => "验证码已经发送到您的手机，有效期20分钟，请注意查收"));
        } else {
            echo json_encode(array("result" => 0, "msg" => "短信功能暂不可用，请联系网站管理员"));
        }

    }

    function saveRegister()
    {
        global $global, $dao, $global_link;

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
        $record = $_POST["frm"];
        if ($record["content_mobile"] == "" || $_SESSION["regMobile"] == "" || $record["content_mobile"] != $_SESSION["regMobile"]) {
            echo json_encode(array("result" => 0, "msg" => "手机号未验证"));
            exit;
        }

        $mobile_randnum = $_POST["mobile_randnum"];
        if ($mobile_randnum == "" || $_SESSION["regRandNum"] == "" || $_SESSION["regRandNum"] != $mobile_randnum) {
            $_SESSION["validateErrorCount"]++;
            if ($_SESSION["validateErrorCount"] > 5) {
                $_SESSION["regRandNum"] = "";
                echo json_encode(array("result" => 0, "msg" => "验证码失败次数过多，请重新获取验证码"));
                exit;
            }


            echo json_encode(array("result" => 0, "msg" => "短信验证码输入有误，请重试"));
            exit;
        }


        $record["content_type"] = 0;

        //判断用户名、手机号、邮箱是否重复
        /*$member_sql = "select * from {$dao->tables->member} where content_user='".$record['content_user']."'";
		$data = $dao->get_datalist( $member_sql );

		if(is_array($data) && count($data)>0 ){
			//$this->redirect($global_link["register"],"已经存在相同的用户名，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"已经存在相同用户名，注册失败"));
			exit;
		}*/

        $member_sql = "select * from {$dao->tables->member} where content_mobile='" . $record['content_mobile'] . "'";
        $data = $dao->get_datalist($member_sql);
        if (is_array($data) && count($data) > 0) {
            //$this->redirect($global_link["register"],"已经存在相同手机号，注册失败");
            echo json_encode(array("result" => 0, "msg" => "已经存在相同手机号，注册失败"));
            exit;
        }

        if ($record['content_email'] != "") {
            $member_sql = "select * from {$dao->tables->member} where content_email='" . $record['content_email'] . "'";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
                echo json_encode(array("result" => 0, "msg" => "已经存在相同邮箱，注册失败"));
                exit;
            }
        }

        //如果注册的是机构会员
        if ($record["content_type"] == "2") {
            //验证单位名称
            if ($record['content_name'] == "") {
                echo json_encode(array("result" => 0, "msg" => "必须输入企业名称"));
                exit;
            } else {
                $member_sql = "select * from {$dao->tables->member} where content_type=2 and content_name='" . $record['content_name'] . "'";
                $data = $dao->get_datalist($member_sql);
                if (is_array($data) && count($data) > 0) {
                    //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
                    echo json_encode(array("result" => 0, "msg" => "该企业名称已经被注册，注册失败"));
                    exit;
                }
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

        $record["publish"] = "1";
        $record["create_time"] = date("Y-m-d H:i:s");


        //密码加密
        $record["pass_randstr"] = rand(1000000, 9999999);
        $record["content_pass"] = md5($record["content_pass"] . $record["pass_randstr"]);

        $dao->insert($dao->tables->member, $record);

        $member_id = $dao->get_insert_id();

        if ($member_id == "" || $member_id == "0") {
            //$this->redirect($global_link["register"],"信息不符合要求，请再次注册");
            echo json_encode(array("result" => 0, "msg" => "信息不符合要求，请重新注册"));
            exit;
        }
        $memberService = new memberService();
        $memberInfo = $memberService->getMember($member_id);
        //将用户信息存入session

        $memberService->setLoginMemberInfo($memberInfo);
        //清空session中存储的注册短信验证码
        unset($_SESSION["regRandNum"]);


        memberEventService::doEvent("register");

        //$this->redirect($global_link["login"],"注册信息提交成功，欢迎登录系统");
        echo json_encode(array("result" => 1, "msg" => "注册成功，您当前的身份是游客，需要认证后才能发布策略及资金属性", "redirect" => $_SESSION["redirectUrl"]));
        unset($_SESSION["redirectUrl"]);

    }

    //登录页面
    function login()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        $this->tpl_file = "login.php";
        $record = array();
        $record["page_title"] = "会员登录";
        $record["back_link"] = $global->siteUrlPath . "/index.php";
        return $record;
    }

    //登录处理
    function doLogin()
    {
        global $dao, $global;
        $content_user = $_POST["content_user"];
        $content_pass = $_POST["content_pass"];
        if ($content_user == '' || $content_pass == '') {
            echo json_encode(array("result" => 0, "msg" => "用户名和密码不能为空"));
            exit;
        }

        $tmp = $dao->get_row_by_where($dao->tables->member, "where content_mobile='{$content_user}' or content_email='{$content_user}' or content_user='{$content_user}' ", array("auto_id", "pass_randstr", "last_login_fail_time", "login_fail_times"));


        //判断是否存在登录限制
        if (strtotime("+1 day", strtotime($tmp["last_login_fail_time"])) >= strtotime(date("Y-m-d H:i:s")) && $tmp["login_fail_times"] >= 3) {
            echo json_encode(array("result" => 0, "msg" => "登录失败次数过多，请明天再试"));
            exit;
        }


        $content_pass = md5($content_pass . $tmp["pass_randstr"]);
        //查询数据库
        $member = $dao->get_row_by_where($dao->tables->member, "where (content_mobile='{$content_user}' or content_email='{$content_user}' or content_user='{$content_user}') and content_pass='{$content_pass}' and publish='1'");

        //若用户名及密码正确,存入session和cookie
        if (is_array($member)) {

            //将用户信息存入session
            $memberService = new memberService();
            $member = $memberService->getMember($member["auto_id"]);
            $memberService->setLoginMemberInfo($member);


            //记录用户名到cookie
            $expire = 3600 * 24 * 365;
            setcookie('username', urlencode($content_user), time() + $expire);

            //如果用户选择了自动登录，将密码存入cookie,用md5加密
            if ($_REQUEST["remember_pwd"] == "1") {
                setcookie('pwd', urlencode($content_pass), time() + $expire);
            } else {
                setcookie("pwd");
            }

            //如果存在登录限制，则清除限制
            if ($member["login_fail_times"] > 0) {
                $arr = array();
                $arr["login_fail_times"] = 0;
                $dao->update($dao->tables->member, $arr, "where auto_id='{$member["auto_id"]}'");
            }

            memberEventService::doEvent("login");

            echo json_encode(array("result" => 1, "msg" => "登录成功", "redirect" => $_SESSION["redirectUrl"]));
            unset($_SESSION["redirectUrl"]);
            exit;
        } else {

            //记录登录失败的信息
            $arr = array();
            $arr["last_login_fail_time"] = date("Y-m-d H:i:s");
            //如果上次登录失败时间到现在小于24小时，则次数加1
            if (strtotime("+1 day", strtotime($tmp["last_login_fail_time"])) >= strtotime(date("Y-m-d H:i:s"))) {
                $arr["login_fail_times"] = $tmp["login_fail_times"] + 1;
            } else {
                //否则此时置为1
                $arr["login_fail_times"] = 1;
            }
            $dao->update($dao->tables->member, $arr, "where auto_id='{$tmp["auto_id"]}'");

            echo json_encode(array("result" => 0, "msg" => "用户名或密码错误"));
            exit;
        }
    }

    //退出
    function logout()
    {
        global $global_link;
        $memberService = new memberService();
        $memberService->cleanLoginMemberInfo();

        $this->redirect($global_link["login"], "您已经成功退出，欢迎您再次光临");
    }

    //ajax退出
    function ajaxLogout()
    {
        $memberService = new memberService();
        $memberService->cleanLoginMemberInfo();

        echo json_encode(array("result" => 1, "msg" => "退出成功"));
        exit;
    }

    //选择找回密码的方式
    function forgetPasswordType()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        $record = array();
        $record["page_title"] = "忘记密码";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=login";
        $this->tpl_file = "select_pwd.php";
        return $record;
    }

    //短信找回密码页面
    function forgetPassword()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        $record = array();
        $record["page_title"] = "忘记密码";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=login";
        $this->tpl_file = "forget_pwd.php";
        return $record;
    }

    //获取短信验证码
    function getResetPasswordMobileMsg()
    {

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            unset($_SESSION["validateNUM"]);
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);

        global $global_params, $global, $dao;
        $content_mobile = $_POST["content_mobile"];
        $member = $dao->get_row_by_where($dao->tables->member, "where content_mobile='{$content_mobile}'");
        if (!is_array($member)) {
            //判断手机号是否已经注册
            echo json_encode(array("result" => 0, "msg" => "此手机号未注册，请确认您的手机号是否正确"));
            exit;
        }

        //查询短信记录表
        $today = date("Y-m-d");
        $recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
        if (is_array($recordList) && count($recordList) >= 5) {
            //每天最多使用5次
            echo json_encode(array("result" => 0, "msg" => "您获取验证码的操作过于频繁，请明天再试"));
            exit;
        }

        //生成验证码
        $num = rand(10000, 99999);

        //验证码写入session
        $_SESSION["resetPwdRandNum"] = $num;
        $_SESSION["resetPwdMobile"] = $content_mobile;
        $_SESSION["validateErrorCount"] = 0;

        //获取网站名称
        $paramsService = new paramsService();
        $site_name = $paramsService->getParamValue("content_name");

        //发送短信验证码
        $mobileMsgService = new mobileMsgService();
        //$mobileMsgService->sendMsg($content_mobile,"您正在使用{$global_params["content_title"]}网站的密码找回功能,验证码为{$num},请保管好验证码并切勿转告他人","forgetPwd");

        $eventName = "forgetPwd";
        //获取下单成功的短信模板
        $mobileTemplet = $dao->get_row_by_where($dao->tables->mobile_msg_templet, "where content_event='{$eventName}' and publish='1'");
        if (is_array($mobileTemplet)) {
            $text = str_replace('{msg_code}', $num, $mobileTemplet["content_text"]);
            $mobileMsgService = new mobileMsgService();
            $mobileMsgService->sendMsg($content_mobile, $text, array("content_type" => "forgetPwd", "validate_code" => $num));

            //$mobileMsgService->sendMsg($content_mobile,"您正在使用{$site_name}的密码找回功能,验证码为{$num},请妥善保管并切勿转告他人",array("content_type"=>"forgetPwd"));

            echo json_encode(array("result" => 1, "msg" => "验证码已经发送到您的手机，有效期20分钟，请注意查收"));
        } else {
            echo json_encode(array("result" => 0, "msg" => "短信功能暂不可用，请联系网站管理员"));
        }


    }

    function checkResetPasswordMobileMsg()
    {

        $mobile_randnum = $_POST["mobile_randnum"];
        if ($mobile_randnum == "" || $_SESSION["resetPwdRandNum"] == "" || $_SESSION["resetPwdRandNum"] != $mobile_randnum) {
            $_SESSION["validateErrorCount"]++;
            if ($_SESSION["validateErrorCount"] > 5) {
                $_SESSION["resetPwdRandNum"] = "";
                echo json_encode(array("result" => 0, "msg" => "验证码失败次数过多，请重新获取验证码"));

                exit;
            }


            echo json_encode(array("result" => 0, "msg" => "短信验证码输入有误，请重试"));
            exit;
        }

        //设置session标志位
        $_SESSION["resetPwdFlag"] = "1";

        echo json_encode(array("result" => 1, "msg" => "验证成功，请重新设置您的密码"));
    }

    //重置密码页面
    function resetPasswordForm()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        //判断如果没有session标志位，返回到忘记密码的页面
        if ($_SESSION["resetPwdFlag"] != "1" || $_SESSION["resetPwdRandNum"] == "" || $_SESSION["resetPwdMobile"] == "") {
            $this->redirect("{$global->siteUrlPath}/index.php?acl=member&method=forgetPassword");
            exit;
        }
        $record = array();
        //$record["page_title"]="重置密码";
        //$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=login";
        $this->tpl_file = "reset_pwd.php";
        return $record;

    }

    //短信找回密码处理
    function resetPassword()
    {
        global $dao, $global;
        //判断当前操作是否允许
        if ($_SESSION["resetPwdFlag"] != "1" || $_SESSION["resetPwdRandNum"] == "" || $_SESSION["resetPwdMobile"] == "") {
            echo json_encode(array("result" => 0, "msg" => "验证出错,请重试"));
            exit;
        }

        if ($_POST["content_pass"] == "") {
            echo json_encode(array("result" => 0, "msg" => "新密码不能为空"));
            exit;
        }

        //修改密码

        $record["pass_randstr"] = rand(1000000, 9999999);
        $record["content_pass"] = md5($_POST["content_pass"] . $record["pass_randstr"]);

        $dao->update($dao->tables->member, $record, "where content_mobile='{$_SESSION["resetPwdMobile"]}'");

        if ($global->use_ucenter) {
            include $global->absolutePath . '/uc_client/config.inc.php';
            include $global->absolutePath . '/uc_client/client.php';
            //查询用户信息并调用同步接口
            $member = $dao->get_row_by_where($dao->tables->member, "where content_mobile='{$_SESSION["resetPwdMobile"]}' ", array("uc_id", "content_user", "content_email"));
            if (is_array($member) && $member["uc_id"] != "") {
                $result = uc_user_edit($member["content_user"], "", $_POST["content_pass"], "", true);
                if ($result < 0) {
                    echo json_encode(array("result" => 0, "msg" => "密码修改失败"));
                    exit;
                }
            }
        }

        //清除session标志位
        unset($_SESSION["resetPwdRandNum"]);
        unset($_SESSION["resetPwdFlag"]);
        unset($_SESSION["resetPwdMobile"]);

        echo json_encode(array("result" => 1, "msg" => "密码重置成功，请注意保管好您的密码"));

    }

    //重置密码成功页面
    function resetPasswordSuccess()
    {
        $record = array();
        $this->tpl_file = "pwd_sucess.php";
        return $record;
    }

    //邮件找回密码
    function forgetPassword_email()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        $record = array();
        $record["page_title"] = "忘记密码";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=login";
        $this->tpl_file = "forget_pwd_email.php";
        return $record;
    }

    //邮件找回密码，ajax发送邮件
    function sendResetPasswordEmail()
    {
        global $global, $dao, $global_link;

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);


        $email = $_POST["content_email"];

        if ($email == "") {
            echo json_encode(array("result" => 0, "msg" => "请输入邮箱"));
            exit;
        }

        //判断邮箱是否存在
        $member = $dao->get_row_by_where($dao->tables->member, "where content_email='{$email}'");

        if (!is_array($member)) {
            echo json_encode(array("result" => 0, "msg" => "会员信息不存在，请检查邮箱是否正确"));
            exit;
        }
        //发送验证邮件
        $paramsService = new paramsService();
        $email_params = $paramsService->getParams(array("content_name"));

        $time = time();
        $link = $global->siteUrlPath . "/index.php?acl=member&method=resetPasswordForm_email&email=" . urlencode($email) . "&time={$time}&validate=" . md5($email . $member["pass_randstr"] . $time);


        $eventName = "forgetPwd";
        //获取下单成功的短信模板
        $emailTemplet = $dao->get_row_by_where($dao->tables->email_templet, "where content_event='{$eventName}' and publish='1'");
        if (is_array($emailTemplet)) {
            $linkStr = "<a target=\"_blank\" href=\"{$link}\">{$link}</a>";
            $body = str_replace('{link}', $linkStr, $emailTemplet["content_body"]);
            $title = $emailTemplet["content_title"];

            $emailService = new emailService();
            $result = $emailService->sendEmail($email, $title, $body);
            if ($result) {
                echo json_encode(array("result" => 1, "msg" => "邮件发送成功"));
                exit;
            } else {
                echo json_encode(array("result" => 0, "msg" => "邮件发送失败，请联系管理员"));
                exit;
            }

        } else {
            echo json_encode(array("result" => 0, "msg" => "邮件功能暂不可用，请联系网站管理员"));
        }


    }

    //发送找回密码邮件成功
    function resetPassword_email_sendsuccess()
    {
        $record = array();
        $this->tpl_file = "pwd_sendemail_sucess.php";
        return $record;
    }

    //发送找回密码邮件成功
    function member_email_sendsuccess()
    {
        global $global, $dao;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;
        }

        $this->tpl_file = "member_sendemail_sucess.php";
        //判断邮箱是否存在
        $email = $member['content_email'];
        //echo "<pre>";print_r($email);die;
        //发送验证邮件
        $paramsService = new paramsService();
        $email_params = $paramsService->getParams(array("content_name"));

        $time = time();
        $link = $global->siteUrlPath . "/index.php?acl=member&method=changeEmailForms&email=" . urlencode($email) . "&time={$time}&validate=" . md5($email . $member["pass_randstr"] . $time);
        $eventName = "editEmail";
        //获取下单成功的短信模板
        $emailTemplet = $dao->get_row_by_where($dao->tables->email_templet, "where content_event='{$eventName}' and publish='1'");
        if (is_array($emailTemplet)) {
            $linkStr = "<a target=\"_blank\" href=\"{$link}\">{$link}</a>";
            $body = str_replace('{link}', $linkStr, $emailTemplet["content_body"]);
            $title = $emailTemplet["content_title"];
            // echo "<pre>";print_r($title);die;
            $emailService = new emailService();
            $result = $emailService->sendEmail($email, $title, $body);
        }


        return $record;
    }

    //邮件重置密码
    function resetPasswordForm_email()
    {
        global $global, $dao;
        $failUrl = "{$global->siteUrlPath}/index.php?acl=member&method=forgetPassword_email";

        //参数校验
        if ($_GET["email"] == "" || $_GET["time"] == "" || $_GET["validate"] == "") {
            $this->redirect($failUrl, "参数有误");
            exit;
        }

        //有效期校验
        if ($_GET["time"] + 7200 < time()) {
            $this->redirect($failUrl, "链接已失效，请重新操作");
            exit;
        }


        //用户校验
        $member = $dao->get_row_by_where($dao->tables->member, "where content_email='{$_GET["email"]}'");
        if (!is_array($member)) {
            $this->redirect($failUrl, "信息有误，请重新操作");
            exit;
        }

        //md5校验
        if (md5($member["content_email"] . $member["pass_randstr"] . $_GET["time"]) != $_GET["validate"]) {
            $this->redirect($failUrl, "信息校验失败，请重新操作");
            exit;
        }

        $_SESSION["resetPwdEmail"] = $member["content_email"];

        $record = array();
        //$record["page_title"]="重置密码";
        //$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=login";
        $this->tpl_file = "reset_pwd_email.php";
        return $record;
    }

    //邮件验证重置密码处理
    function resetPassword_email()
    {
        global $dao, $global;
        //判断当前操作是否允许
        if ($_SESSION["resetPwdEmail"] == "") {
            echo json_encode(array("result" => 0, "msg" => "验证出错,请重试"));
            exit;
        }

        if ($_POST["content_pass"] == "") {
            echo json_encode(array("result" => 0, "msg" => "新密码不能为空"));
            exit;
        }


        //修改密码
        $record = array();
        $record["pass_randstr"] = rand(1000000, 9999999);
        $record["content_pass"] = md5($_POST["content_pass"] . $record["pass_randstr"]);

        $dao->update($dao->tables->member, $record, "where content_email='{$_SESSION["resetPwdEmail"]}'");

        if ($global->use_ucenter) {
            include $global->absolutePath . '/uc_client/config.inc.php';
            include $global->absolutePath . '/uc_client/client.php';
            //查询用户信息并调用同步接口
            $member = $dao->get_row_by_where($dao->tables->member, "where content_email='{$_SESSION["resetPwdEmail"]}' ", array("uc_id", "content_user", "content_email"));
            if (is_array($member) && $member["uc_id"] != "") {
                $result = uc_user_edit($member["content_user"], "", $_POST["content_pass"], "", true);
                if ($result < 0) {
                    echo json_encode(array("result" => 0, "msg" => "密码修改失败"));
                    exit;
                }
            }
        }

        //清除session标志位
        unset($_SESSION["resetPwdEmail"]);

        echo json_encode(array("result" => 1, "msg" => "密码重置成功，请注意保管好您的密码"));

    }

    //显示会员资料
    function memberInfo()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        $memberType = $member["content_type"];
        if ($memberType == "1") {
            $this->tpl_file = "memberinfo.php";
        } elseif ($memberType == "2") {
            $this->tpl_file = "memberinfo_company.php";
        } else {
            $this->redirect($global->siteUrlPath . "/index.php?acl=member&method=goAuth");
        }


        $record["location_title"] = "注册信息";

        return $record;


    }

    //显示认证资料
    function memberAuthInfo()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        $this->tpl_file = "memberAuthInfo.php";


        $record["location_title"] = "认证信息";

        return $record;


    }


    //认证资料页面
    function memberAuthForm()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }


        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;

        }

        $this->tpl_file = "memberAuthForm.php";


        $record["location_title"] = "会员认证";
        //$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";


        /*echo "<pre>";
		print_r($record);
		exit;*/

        return $record;

    }


    //修改资料页面
    function editInfoForm()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }


        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;

        }

        $memberType = $member["content_type"];
        if ($memberType != "0") {
            if ($memberType == "1") {
                $this->tpl_file = "edit_memberinfo.php";
            } elseif ($memberType == "2") {
                $this->tpl_file = "edit_memberinfo_company.php";
            }
        } else {
            if ($_REQUEST["type"] == "1") {
                $this->tpl_file = "edit_memberinfo.php";
            } elseif ($_REQUEST["type"] == "2") {
                $this->tpl_file = "edit_memberinfo_company.php";
            }
        }


        $record["location_title"] = "个人信息";
        //$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";


        /*echo "<pre>";
		print_r($record);
		exit;*/

        return $record;

    }

    //会员修改资料时验证手机是否可以使用
    function checkEditMobile()
    {
        global $dao;
        if ($_POST["content_mobile"] != "") {

            $memberService = new memberService();
            $mid = $memberService->getLoginMemberInfo("auto_id");

            $member_sql = "select auto_id from {$dao->tables->member} where content_mobile='" . $_POST["content_mobile"] . "' and auto_id!='{$mid}' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //会员修改资料时验证邮箱是否可以使用
    function checkEditEmail()
    {
        global $dao;
        if ($_POST["content_email"] != "") {

            $memberService = new memberService();
            $mid = $memberService->getLoginMemberInfo("auto_id");

            $member_sql = "select auto_id from {$dao->tables->member} where content_email='" . $_POST["content_email"] . "' and auto_id!='{$mid}' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //会员修改资料时验证QQ号码是否可以使用
    function checkEditQQ()
    {
        global $dao;
        if ($_POST["content_qq"] != "") {

            $memberService = new memberService();
            $mid = $memberService->getLoginMemberInfo("auto_id");

            $member_sql = "select auto_id from {$dao->tables->member} where content_qq='" . $_POST["content_qq"] . "' and auto_id!='{$mid}' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //会员修改资料时验证名称是否可以使用
    function checkEditName()
    {
        global $dao;
        if ($_POST["content_name"] != "") {

            $memberService = new memberService();
            $mid = $memberService->getLoginMemberInfo("auto_id");

            $member_sql = "select auto_id from {$dao->tables->member} where content_name='" . $_POST["content_name"] . "' and content_type={$_REQUEST["type"]} and auto_id!='{$mid}' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //保存个人资料
    function saveInfo()
    {
        global $global, $dao, $global_link;

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

        $record = $_POST["frm"];
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];

        if ($mid == "") {
            //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
            echo json_encode(array("result" => 0, "msg" => "请先登录后再进行操作"));
            exit;
        }

        $member_type = $member["content_type"];
        if ($member_type != "0") {
            unset($record["content_type"]);
        } else {
            $member_type = $record["content_type"];
        }

        if ($member_type == 1) {//个人会员校验
            //校验昵称
            if ($record['content_name'] != "") {
                $member_sql = "select * from {$dao->tables->member} where content_name='" . $record['content_name'] . "' and content_type={$member_type} and auto_id!='{$mid}'";
                $data = $dao->get_datalist($member_sql);

                if (is_array($data) && count($data) > 0) {
                    //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
                    echo json_encode(array("result" => 0, "msg" => "已经存在相同昵称，请更换"));
                    exit;
                }
            }

        } elseif ($member_type == 2) {//企业会员校验
            //校验企业名称
            if ($record['content_name'] != "") {
                $member_sql = "select * from {$dao->tables->member} where content_name='" . $record['content_name'] . "' and content_type={$member_type} and auto_id!='{$mid}'";
                $data = $dao->get_datalist($member_sql);

                if (is_array($data) && count($data) > 0) {
                    //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
                    echo json_encode(array("result" => 0, "msg" => "已经存在相同企业名称，请更换"));
                    exit;
                }

            }


        }


        if ($record['content_email'] != "") {
            $member_sql = "select * from {$dao->tables->member} where content_email='" . $record['content_email'] . "' and auto_id!='{$mid}'";
            $data = $dao->get_datalist($member_sql);

            if (is_array($data) && count($data) > 0) {
                //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
                echo json_encode(array("result" => 0, "msg" => "已经存在相同邮箱，请更换其他邮箱"));
                exit;
            }
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

        if (is_array($_POST["expert_field"]))
            $record["expert_field"] = ";" . implode(';', $_POST["expert_field"]) . ";";
        else
            $record["expert_field"] = "";


        if ($_GET["task"] == "info") {
            if ($member["content_type"] == "0") {//若之前未认证过
                $record["is_agree"] = "3";//审核状态变为等待审核
            }
        } elseif ($_GET["task"] == "auth") {
            $record["is_auth"] = "3";//审核状态变为等待审核
        }


        $dao->update($dao->tables->member, $record, "where auto_id='{$mid}'");

        //更新session存储
        $memberNew = $memberService->getMember($member["auto_id"]);
        $memberService->setLoginMemberInfo($memberNew);

        //若当前是完善资料的操作
        $next = "";
        if ($_GET["task"] == "info") {
            //若当前未认证且没有填写过认证信息
            if ($memberNew["is_auth"] == "0") {
                $next = "auth";
            }
        } elseif ($_GET["task"] == "auth") {

        }

        if ($next == "auth") {//若需要去认证
            echo json_encode(array("result" => 1, "msg" => "信息提交成功，请继续填写认证资料？", "next" => $next));
        } elseif ($member["content_type"] == "0") {//若之前是游客
            echo json_encode(array("result" => 1, "msg" => "信息提交成功，请等待审核"));
        } else {
            echo json_encode(array("result" => 1, "msg" => "信息提交成功"));
        }
        exit;

    }

    //头像上传页面
    function uploadHeadImgForm()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        //验证登录
        global $global_link;
        //如果没有登录，跳转回登录页面
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsRedirect($global_link["login"], "您需要登录后才能进行操作");
            exit;
        }
        $record = array();
        $record["location_title"] = "修改头像";
        //$record["back_link"]=$global->siteUrlPath."/index.php?acl=member&method=index";
        $this->tpl_file = "edit_head.php";
        return $record;

    }

    //处理上传头像的操作
    function uploadHeadImg()
    {
        global $dao;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsAlert("您需要登录后才能进行操作");
            exit;
        }

        $field_name = "content_head_file";
        $filearr = pathinfo($_FILES[$field_name]['name']);
        $filetype = strtolower($filearr["extension"]);

        if (!in_array($filetype, array("jpeg", "jpg", "gif", "png", "bmp"))) {
            ?>
            <script>
                alert("文件类型不符合要求");
                window.parent.window.document.getElementById("content_head_file").value = "";
            </script>
            <?
            exit;
        }

        if ($_FILES[$field_name]['size'] > (4 * 1024 * 1024)) {
            ?>
            <script>
                alert("文件太大，请选择4MB以内的文件");
                window.parent.window.document.getElementById("content_head_file").value = "";
            </script>
            <?
            exit;
        }

        $uploadFile = new UploadFile();
        //$_record=$uploadFile->save_upload_file($field_name);
        $_record = $uploadFile->save_upload_img($field_name, 320, 320);
        //$_record['savePath']
        //$_record['urlPath']

        ?>
        <script>
            window.parent.window.document.getElementById("content_head_file").value = "";
            window.parent.window.document.getElementById("content_head").value = "<?=$_record['savePath']?>";
            window.parent.window.document.getElementById("member_head_img").src = "<?=$_record['urlPath']?>";
            window.parent.window.document.getElementById("member_head_img2").src = "<?=$_record['urlPath']?>";
            window.parent.window.document.getElementById("member_head_img3").src = "<?=$_record['urlPath']?>";
        </script>
        <?

        //将新的头像存入数据库
        $record = array();
        //$record["content_head"]=$_record['savePath'];
        //$dao->update($dao->tables->member,$record,"where auto_id='{$mid}'");

        return $record;

    }

    //保存头像字段到数据库
    function saveHeadImgValue()
    {
        global $dao;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            echo json_encode(array("result" => 0, "msg" => "登录后才可以进行操作"));
            exit;
        }


        $record = array();
        $record["content_head"] = $_GET["content_head"];
        $dao->update($dao->tables->member, $record, "where auto_id='{$mid}'");


        echo json_encode(array("result" => 1, "msg" => "保存成功"));

    }


    //修改密码页面
    function passwordForm()
    {
        global $top_menu_focus, $global;
        $top_menu_focus = false;
        //验证登录
        global $global_link;
        //如果没有登录，跳转回登录页面
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsRedirect($global_link["login"], "您需要登录后才能进行操作");
            exit;
        }
        $this->tpl_file = "edit_pass.php";
        $record = array();
        $record["location_title"] = "修改密码";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=index";

        return $record;
    }

    //修改密码处理
    function savePassword()
    {
        global $dao, $global;

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
        $record = $_POST;

        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");

        if ($mid == "") {
            //$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
            echo json_encode(array("result" => 0, "msg" => "请先登录后再进行操作"));
            exit;
        }

        //查询出原有的数据
        $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
        $oldpass = $member["content_pass"];


        if (md5($record["old_pass"] . $member["pass_randstr"]) != $oldpass) {
            //$this->redirect("index.php?acl=member&method=passwordForm","旧密码输入错误");
            echo json_encode(array("result" => 0, "msg" => "旧密码输入错误"));
            exit;
        }


        //生成新密码
        $password = md5($record['new_pass'] . $member["pass_randstr"]);

        $password_record = array();
        $password_record["content_pass"] = $password;


        $dao->update($dao->tables->member, $password_record, "where auto_id='{$mid}'");
        //$this->redirect($global->siteUrlPath,"您已经成功修改了密码");
        echo json_encode(array("result" => 1, "msg" => "您已经成功修改了密码"));
    }


    //生成随机数的函数
    private function random($length, $numeric = 0)
    {
        PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
        $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        $hash = '';
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed[mt_rand(0, $max)];
        }
        return $hash;
    }

    //会员中心首页
    function member()
    {
        global $global, $global_link;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }
        $this->tpl_file = "member.php";
        $record = array();
        //$record["page_title"]="会员中心";
        //$record["back_link"]=$global->siteUrlPath."/index.php";
        return $record;
    }

    //会员中心-我的账户
    function account()
    {
        global $global, $global_link;
        //如果没有登录，跳转回登录页面
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsRedirect($global_link["login"], "您需要登录后才能进行操作");
            exit;
        }
        $this->tpl_file = "account.php";
        $record = array();
        return $record;
    }

    //处理账户充值
    function fillMoney()
    {
        global $global, $global_link, $dao;
        //检验登录
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            echo json_encode(array("result" => 0, "msg" => "请先登录"));
            exit;
        }


        //校验充值金额
        $money = $_REQUEST["fill_money"];
        if (!is_numeric($money) || $money < 0.01 || $money > 1000000) {
            echo json_encode(array("result" => 0, "msg" => "充值金额不符合要求"));
            exit;
        }
        $money = round($money, 2);
        //保存充值订单
        $record = array();
        $orderService = new orderService();
        $record["order_sn"] = $orderService->createOrderSn();
        $record["name"] = "账户充值";
        $record["type"] = 4;
        $record["member_id"] = $mid;
        $record["pay_money"] = $money;
        $record["create_time"] = date("Y-m-d H:i:s");
        $dao->insert($dao->tables->order, $record, true);
        $record["auto_id"] = $dao->get_insert_id();

        //支付成功跳转地址
        $success_url = $global->siteUrlPath . "/index.php?acl=member&method=account";
        //支付失败跳转地址
        $fail_url = $global->siteUrlPath . "/index.php?acl=member&method=account";
        //获取支付链接
        $payUrl = $global->siteUrlPath . "/index.php?acl=member&method=pay&order_sn={$record["order_sn"]}&success_url=" . base64_encode($success_url) . "&fail_url=" . base64_encode($fail_url);

        echo json_encode(array("result" => 1, "msg" => "", "url" => $payUrl));

    }

    //会员中心-提现申请
    function accountApply()
    {
        global $global, $global_link;
        //如果没有登录，跳转回登录页面
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsRedirect($global_link["login"], "您需要登录后才能进行操作");
            exit;
        }
        $this->tpl_file = "account_apply.php";
        $record = array();
        return $record;
    }

    //保存提现申请记录
    function saveCashApply()
    {

        global $global, $dao;
        $memberService = new memberService();
        $memberInfo = $memberService->getLoginMemberInfo();
        $member_id = $memberInfo["auto_id"];
        $member_mobile = $memberInfo["content_mobile"];
        if ($member_id == "") {
            echo json_encode(array("result" => 0, "msg" => "请先登录"));
            exit;
        }


        //判断是否存在未审核的提现申请
        $tmp = $dao->get_row_by_where($dao->tables->cash_apply, "where member_id='{$member_id}' and content_status='0'");
        if ($tmp["auto_id"] != "") {
            echo json_encode(array("result" => 0, "msg" => "您目前尚有未审核的提现申请，请不要重复申请"));
            exit;
        }

        $record = $_POST["frm"];

        if ($record["content_money"] == "") {
            echo json_encode(array("result" => 0, "msg" => "请输入提现金额"));
            exit;
        }

        $memberAccountService = new memberAccountService();
        $accountBalance = $memberAccountService->getAccountBalance($member_id);

        //获取系统设定的最低提现金额
        $paramsService = new paramsService();
        $min_apply_money = $paramsService->getParamValue("min_cash_apply");
        if ($min_apply_money == "") {
            $min_apply_money = 100;
        }

        if ($record["content_money"] < $min_apply_money) {
            echo json_encode(array("result" => 0, "msg" => "提现金额不能小于{$min_apply_money}元"));
            exit;
        }

        if ($record["content_money"] > $accountBalance) {
            echo json_encode(array("result" => 0, "msg" => "提现金额不能大于账户余额"));
            exit;
        }

        $record["member_id"] = $member_id;
        $record["content_mobile"] = $member_mobile;
        $record["create_time"] = date("Y-m-d H:i:s");

        $dao->insert($dao->tables->cash_apply, $record);


        echo json_encode(array("result" => 1, "msg" => "信息提交成功，我们会尽快处理您的请求"));

    }


    //订单支付
    function pay()
    {
        global $global, $global_link, $dao;
        //如果没有登录，跳转回登录页面
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsRedirect($global_link["login"], "您需要登录后才能进行操作");
        }
        $record = array();
        //判断订单是否存在
        $record["order"] = $dao->get_row_by_where($dao->tables->order, "where order_sn='{$_GET["order_sn"]}'");
        //判断是否有权限支付
        if ($record["order"]["member_id"] != $mid) {
            $this->redirect($global->siteUrlPath, "没有权限查看此订单");
        }

        //判断此订单当前是否可以支付
        if ($record["order"]["pay_money"] > 0 && $record["order"]["pay_status"] == "0" && $record["order"]["pay_type"] == "1" && $record["order"]["pay_status"] == "0") {

        } else {
            $this->redirect(base64_decode($_GET["fail_url"]));
        }

        //如果不是账户充值，并且账户余额足够，直接在账户余额中扣除订单费用
        if ($record["order"]["type"] != 4) {

            //查询会员账户余额
            $memberAccountService = new memberAccountService();
            $account_balance = $memberAccountService->getAccountBalance($mid);
            if ($account_balance >= $record["order"]["pay_money"]) {
                //此时还没有生成在线支付记录，只能直接调用支付回调而不能调用支付通知响应函数payOrder
                //考虑到此处是封装的，所有的订单支付都会调用这里,可以在此处处理扣除余额及支付成功回调等

                $order = $record["order"];

                $onlinePayService = new onlinePayService();

                $balance_monay = $account_balance - $order["pay_money"];

                //扣除账户余额
                $dataArray = array();
                $dataArray["member_id"] = $order["member_id"];
                $dataArray["content_type"] = 2;
                $dataArray["content_event"] = "account_pay";
                $dataArray["content_desc"] = "支付订单{$order["order_sn"]}";
                $dataArray["content_money"] = $order["pay_money"] * (-1);
                $dataArray["balance_monay"] = $balance_monay;
                $dataArray["order_id"] = $order["auto_id"];
                $dataArray["order_sn"] = $order["order_sn"];
                $dataArray["create_time"] = date("Y-m-d H:i:s");
                $dao->insert($dao->tables->member_account, $dataArray);
                //修改账户余额字段
                $dao->update($dao->tables->member, array("account_balance" => $dataArray["balance_monay"]), "where auto_id='{$dataArray["member_id"]}'");

                //写入订单日志
                $orderService = new orderService();
                $orderService->addOrderLog($order["auto_id"], "用户", "账户余额支付{$order["pay_money"]}元");

                //设置订单为已支付
                $tmp = array();
                $tmp["pay_status"] = "1";
                $dao->update($dao->tables->order, $tmp, "where auto_id='{$order["auto_id"]}'");

                //调用支付成功事件
                $order["pay_status"] = "1";
                $onlinePayService->paySuccessCallback($order);

                //跳转至支付成功页面
                $this->redirect(base64_decode($_GET["success_url"]));
                exit;
            }
        }

        $this->tpl_file = "pay.php";
        return $record;
    }

    //资金管理
    function capital()
    {
        global $global_link;
        $this->tpl_file = "capital.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);
        $capital = new capitalService();
        $record = $capital->listsPage($params);
        return $record;
    }

    //资金表单
    function capitalform()
    {
        global $global_link;
        $this->tpl_file = "capitalform.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {
            global $dao;
            $record = $dao->get_row_by_where($dao->tables->capital, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");
        }
        $dic = new DictionaryVars();
        $record['cycleT'] = $dic->getVars('capitalCycle');
        $record['revenueT'] = $dic->getVars('expectedRevenue');
        $record['policyT'] = $dic->getVars('captialPolicy');
        $record['riskabideT'] = $dic->getVars('capitalRisk');
        $record['risktypeT'] = $dic->getVars('riskType');
        return $record;
    }

    //添加或编辑资金
    function saveCapital()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            global $dao;
            if (!empty($_POST['auto_id'])) {//编辑
                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";
                $frm['create_time'] = date("Y-m-d H:i:s");
                $dao->update($dao->tables->capital, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功", "data_id" => $_POST['auto_id']);
            } else {//添加
                $frm['member_id'] = $mid;
                $frm['create_time'] = date("Y-m-d H:i:s");
                $id = $dao->insert($dao->tables->capital, $frm);
                $arr = array("result" => 1, "msg" => "恭喜您，添加成功", "data_id" => $id);
            }
        }
        echo json_encode($arr);
        exit;
    }

    //删除资金
    function delCapital()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->capital, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }

    //策略管理
    function strategy()
    {
        global $global_link;
        $this->tpl_file = "strategy.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid, 'orderby' => 'order by create_time desc');
        $capital = new strategyService();
        $record = $capital->listsPage($params);
        return $record;
    }

    //策略表单
    function strategyform()
    {
        global $global_link;
        $this->tpl_file = "strategyform.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $record['reply'] = array();
        if (!empty($_GET['id'])) {
            global $dao;
            $record = $dao->get_row_by_where($dao->tables->strategy, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");
            $reply = new strategyReplyService();
            $params = array('strategy_id' => $record['auto_id']);
            $record['reply'] = $reply->lists($params);
        }

        $sub_id = trim($record["submodule"], ';');
        $idArr = explode(';', $sub_id);
        // $submodule_id=preg_replace("/(;)/" ,',' ,$sub_id);

        $dic = new DictionaryVars();
        $strategyService = new strategyService();
        $where = "1=1";
        $scategory = $strategyService->getTreeData($where = "", $pid = "0");
        $record['cycleT'] = $dic->getVars('strategyCycle');
        $record['software'] = $dic->getVars('softwareVars');//回测软件
        $record['marketVars'] = $dic->getVars('marketVars');//市场状态依赖
        $record['capitalScale'] = $dic->getVars('capitalScale');//资金规模容纳
        $record['monitoring'] = $dic->getVars('monitoringVars');//监测/交易软件
        $record['revenueT'] = $dic->getVars('strategyRevenue');
        $record['investT'] = $dic->getVars('strategyInvest');
        $record['processVars'] = $dic->getVars('processVars');
        $record['cateT'] = $scategory;
        $record['submodule'] = $dic->getVars('strategySubVars');
        $record['tradeT'] = $dic->getVars('strategyTrade');
        $record['rateT'] = $dic->getVars('strategyRate');
        $record['riskT'] = $dic->getVars('strategyRisk');
        $record['sub_id'] = $idArr;
        $record['strater'] = $dic->getVars('straterRoleVars');
        $record['strategyFormVars'] = $dic->getVars('strategyFormVars');
        $record['strategyScheduleVars'] = $dic->getVars('strategyScheduleVars');
        return $record;
    }

    //添加或编辑策略
    function saveStrategy()
    {


        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        // echo "<pre>";print_r($_POST['frm']);die;
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            // $frm['serial']=10000000+$_POST['auto_id'];
            $num = $_POST['auto_id'];
            $bit = 8;//产生8位数的数字编号
            $num_len = strlen($num);
            $zero = '';
            for ($i = $num_len; $i < $bit; $i++) {
                $zero .= "0";
            }
            $frm['serial'] = $num . $zero;
            // echo "<pre>";print_r($frm);die;
            $frm['uptime'] = date("Y-m-d H:i:s");
            // $frm['submodule']=";".implode(';',$_POST['submodule']).";";
            global $dao;
            if (!empty($_POST['auto_id'])) {//编辑

                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";

                $dao->update($dao->tables->strategy, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功", "data_id" => $_POST['auto_id']);
            } else {//添加
                $frm['member_id'] = $mid;
                $frm['create_time'] = date("Y-m-d H:i:s");
                // echo "<pre>";print_r($frm);die;

                $id = $dao->insert($dao->tables->strategy, $frm);
                $arr = array("result" => 1, "msg" => "恭喜您，添加成功", "data_id" => $id);
            }
        }
        echo json_encode($arr);
        exit;
    }

    //删除策略
    function delStrategy()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->strategy, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }

    // 删除直播或者路演
    function delVideo()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->video, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }

    //策略附件管理
    function strategyReply()
    {
        global $global_link;
        $this->tpl_file = "strategyReply.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid, "strategy_id" => $_REQUEST["strategy_id"], 'orderby' => 'order by create_time desc');
        $strategyReplyService = new strategyReplyService();
        $record = $strategyReplyService->listsPage($params);
        return $record;
    }

    //策略附件表单
    function strategyReplyForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "strategyReplyForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }

        $record = array();
        if ($_REQUEST["id"] != "") {
            $data = $dao->get_row_by_where($dao->tables->strategy_reply, "where auto_id='{$_REQUEST['id']}' and member_id='{$mid}'");
            if (!is_array($data)) {
                $this->redirect($global_link["member"], "无权查看");
            }
            $record["data"] = $data;
        }
        $dic = new DictionaryVars();
        $strategyService = new strategyService();
        $record['cycleT'] = $dic->getVars('strategySubVars');
        // echo "<pre>";
        // print_r($record);
        // exit;

        return $record;
    }

    //保存策略附件
    function saveStrategyReply()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];

            preg_match('/^(.*)([^\/]+)\\.(\w+)/', $frm["content_file"], $preg_result);
            $frm["fileType"] = strtolower($preg_result[3]);


            global $dao;
            if (!empty($_POST['auto_id'])) {//编辑
                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";
                $id = $dao->update($dao->tables->strategy_reply, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功");
            } else {//添加
                $frm['member_id'] = $mid;
                $frm['create_time'] = date("Y-m-d H:i:s");
                // echo "<pre>";print_r($frm);die;
                $id = $dao->insert($dao->tables->strategy_reply, $frm);
                memberEventService::doEvent("uploadStrategyFile");
                $arr = array("result" => 1, "msg" => "恭喜您，添加成功");
            }
        }
        echo json_encode($arr);
        exit;
    }

    //删除策略附件
    function delStrategyReply()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->strategy_reply, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }


    //合作产品
    function product()
    {
        global $global_link;
        $this->tpl_file = "product.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);
        $product = new strategyProductService();
        $record = $product->listsPage($params);
        return $record;
    }

    //产品表单
    function productform()
    {
        global $global_link;
        $this->tpl_file = "productform.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        global $dao;
        if (!empty($_GET['id'])) {
            $record = $dao->get_row_by_where($dao->tables->strategy_product, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");
        }
        $sql = "select auto_id as id,content_name as text from {$dao->tables->strategy} where member_id='{$mid}'";
        $record['strategy'] = $dao->get_datalist($sql);
        return $record;
    }

    //添加或编辑产品
    function saveProduct()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            global $dao;
            if (!empty($_POST['auto_id'])) {//编辑
                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";
                $dao->update($dao->tables->strategy_product, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功", "data_id" => $_POST['auto_id']);
            } else {//添加
                $frm['member_id'] = $mid;
                $frm['create_time'] = date("Y-m-d H:i:s");
                $id = $dao->insert($dao->tables->strategy_product, $frm);
                $arr = array("result" => 1, "msg" => "恭喜您，添加成功", "data_id" => $id);
            }
        }
        echo json_encode($arr);
        exit;
    }

    //删除资金
    function delProduct()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->strategy_product, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }

    //视频列表
    function video()
    {
        global $global_link, $dao;
        $this->tpl_file = "video.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);
        $video = new videoService();
        $record = $video->listsPage($params);
        //获取视频观看人数的数据
        if (is_array($record["list"]))
            foreach ($record["list"] as $key => $vl) {
                $tmp = $dao->get_datalist("select count(auto_id) as visit_num from {$dao->tables->video_enroll} where object_id='{$vl["auto_id"]}'");
                $record[$key]["visit_num"] = $tmp[0]["visit_num"];
                if ($record["list"][$key]["visit_num"] == "")
                    $record["list"][$key]["visit_num"] = 0;
            }
        return $record;
    }

    //视频表单
    function videoform()
    {
        global $global_link, $dao, $enumVars;
        $this->tpl_file = "videoform.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {
            $record = $dao->get_row_by_where($dao->tables->video, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");
        }
        $sql = "select auto_id as id,content_name as text from {$dao->tables->strategy} where member_id='{$mid}'";
        $record['strategy'] = $dao->get_datalist($sql);
        $dic = new DictionaryVars();
        $record['cateT'] = $dic->getVars('strategySort');
        $record['sortyT'] = $dic->getVars('videoSort');
        $record['revenueT'] = $dic->getVars('strategyRevenue');
        $record['investT'] = $dic->getVars('strategyInvest');
        $record['typeT'] = $enumVars['videoType'];
        $record['carryT'] = $enumVars['carryStatus'];
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    function saveVideo()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            //获取关联策略的相关属性

            global $dao;
            $strategy = $dao->get_row_by_where($dao->tables->strategy, "where auto_id='{$frm["relate_id"]}'");
            $frm['cate_id'] = $strategy['cate_id'];
            $frm['revenue'] = $strategy['revenue'];
            $frm['invest'] = $strategy['invest'];
            // echo "<pre>";print_r($strategy);die;
            if (!empty($_POST['auto_id'])) {//编辑
                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";
                $id = $dao->update($dao->tables->video, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功");
            } else {//添加
                $frm['member_id'] = $mid;
                $frm['create_time'] = date("Y-m-d H:i:s");
                $id = $dao->insert($dao->tables->video, $frm);
                $arr = array("result" => 1, "msg" => "恭喜您，添加成功");
            }
        }
        echo json_encode($arr);
        exit;
    }

    function strategycollect()
    {
        global $global_link;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $this->tpl_file = "collect.php";
        $collect = new memberCollectService();
        $params = array('member_id' => $mid, 'type' => 3);
        $record = $collect->listsPage($params);
        $record['content_name'] = '策略';
        return $record;
    }

    function expertcollect()
    {
        global $global_link;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $this->tpl_file = "collect.php";
        $collect = new memberCollectService();
        $params = array('member_id' => $mid, 'type' => 1);
        $record = $collect->listsPage($params);
        $record['content_name'] = '策略人';
        return $record;
    }

    function expertComCollect()
    {
        global $global_link;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $this->tpl_file = "collect.php";
        $collect = new memberCollectService();
        $params = array('member_id' => $mid, 'type' => 2);
        $record = $collect->listsPage($params);
        $record['content_name'] = '投资机构';
        return $record;
    }

    function capitalCollect()
    {
        global $global_link;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $this->tpl_file = "collect.php";
        $collect = new memberCollectService();
        $params = array('member_id' => $mid, 'type' => 4);
        $record = $collect->listsPage($params);
        $record['content_name'] = '资金';
        return $record;
    }

    //删除资金
    function delCollect()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->member_collect, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }

    //发布策略需求
    function strategyRequire()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsAlert("您需要登录后才能进行操作");
            exit;
        }
        $type = $memberService->getLoginMemberInfo("content_type");
        if ($type == 2) {//机构会员才可发布
            global $dao, $enumVars;
            $this->tpl_file = "strategyrequireform.php";
            $record = array();
            $dic = new DictionaryVars();
            $strategyService = new strategyService();
            $where = "1=1";
            $scategory = $strategyService->getTreeData($where = "", $pid = "0");
            $record['cycleT'] = $dic->getVars('strategyCycle');
            $record['revenueT'] = $dic->getVars('expectedRevenue');
            $record['cateT'] = $scategory;
            $record['risktypeT'] = $dic->getVars('riskType');
            $record['mobile'] = $memberService->getLoginMemberInfo('content_mobile');
            return $record;
        } else {
            $this->jsAlert("抱歉，机构会员才可发布策略需求");
            exit;
        }
    }

    //提交策略需求
    function saveStrategyRequire()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            global $dao;
            $frm['member_id'] = $mid;
            $frm['create_time'] = date("Y-m-d H:i:s");
            $dao->insert($dao->tables->strategy_require, $frm);
            $arr = array("result" => 1, "msg" => "您已提交成功，我们会尽快与您联系");
        }
        echo json_encode($arr);
        exit;
    }

    //发布策略需求
    function capitalRequire()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsAlert("您需要登录后才能进行操作");
            exit;
        }
        $type = $memberService->getLoginMemberInfo("content_type");
        if ($type == 1) {//策略人才可发布
            global $global_link, $dao, $enumVars;
            $this->tpl_file = "capitalrequireform.php";
            $record = array();
            $dic = new DictionaryVars();
            $record['cycleT'] = $dic->getVars('capitalCycle');
            $record['revenueT'] = $dic->getVars('expectedRevenue');
            $record['policyT'] = $dic->getVars('captialPolicy');
            $record['riskabideT'] = $dic->getVars('capitalRisk');
            $record['risktypeT'] = $dic->getVars('riskType');
            $record['mobile'] = $memberService->getLoginMemberInfo('content_mobile');
            return $record;
        } else {
            $this->jsAlert("抱歉，策略人才可发布资金需求");
            exit;
        }
    }

    //提交资金需求
    function saveCapitalRequire()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            global $dao;
            $frm['member_id'] = $mid;
            $frm['create_time'] = date("Y-m-d H:i:s");
            $dao->insert($dao->tables->capital_require, $frm);
            $arr = array("result" => 1, "msg" => "您已提交成功，我们会尽快与您联系");
        }
        echo json_encode($arr);
        exit;
    }

    //处理上传图片的操作  产品或视频
    function uploadProductImg()
    {
        global $dao;
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->jsAlert("您需要登录后才能进行操作");
            exit;
        }

        $field_name = "productimg";

        $filearr = pathinfo($_FILES[$field_name]['name']);
        $filetype = strtolower($filearr["extension"]);

        if (!in_array($filetype, array("jpeg", "jpg", "gif", "png", "bmp"))) {
            ?>
            <script>
                alert("文件类型不符合要求");
                window.parent.window.document.getElementById("uploadImg").value = "";
            </script>
            <?
            exit;
        }

        if ($_FILES[$field_name]['size'] > (4 * 1024 * 1024)) {
            ?>
            <script>
                alert("文件太大，请选择4MB以内的文件");
                window.parent.window.document.getElementById("uploadImg").value = "";
            </script>
            <?
            exit;
        }
        $uploadFile = new UploadFile();
        $_record = $uploadFile->save_upload_img($field_name);
        ?>
        <script>
            window.parent.window.document.getElementById("uploadImg").value = "";
            window.parent.window.document.getElementById("productimg").value = "<?=$_record['savePath']?>";
            window.parent.window.document.getElementById("productSrc").src = "<?=$_record['urlPath']?>";
        </script>
        <?

    }

    //服务管理
    function serviceProduct()
    {
        global $global_link;
        $this->tpl_file = "serviceProduct.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);
        $serviceProductService = new serviceProductService();
        $record["data"] = $serviceProductService->listsPage($params);
        return $record;
    }

    //我的预约
    function serviceOrder()
    {
        global $global_link;
        $this->tpl_file = "serviceOrder.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");

        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);

        $serviceOrderService = new serviceOrderService();
        $record["data"] = $serviceOrderService->listsPage($params);
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    //我的订单
    function myServiceOrder()
    {
        global $global_link;
        $this->tpl_file = "myserviceOrder.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");

        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('service_member_id' => $mid);

        $serviceOrderService = new serviceOrderService();
        $record["data"] = $serviceOrderService->listsPage($params);
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    //我的订单
    function myServiceOrderForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "myServiceOrderForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {

            $record = $dao->get_row_by_where($dao->tables->service_order, "where auto_id='{$_GET['id']}' and service_member_id='{$mid}'");

        }
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    function saveOrderStatus()
    {
        global $global_link, $dao;
        $dataArray['order_status'] = $_POST['i'];
        // echo "<pre>";print_r($_REQUEST);die;
        $add = $dao->update($dao->tables->service_order, $dataArray, "where auto_id='{$_POST["id"]}'");
        $record = $dao->get_row_by_where($dao->tables->service_order, "where auto_id='{$_REQUEST['id']}' ");
        if ($add) {
            echo '1';
            //获取下单成功的短信模板、
            $eventName = "confirmOrderMsg";
            $mobileTemplet = $dao->get_row_by_where($dao->tables->mobile_msg_templet, "where content_event='{$eventName}' and publish='1'");
            $data['service_member_mobile'] = $record['content_mobile'];
            $order["order_sn"] = $record["order_sn"];
            if (is_array($mobileTemplet)) {
                $text = str_replace('{order_sn}', $order["order_sn"], $mobileTemplet["content_text"]);
                // echo "<pre>";print_r($text);die;
                $mobileMsgService = new mobileMsgService();
                $mobileMsgService->sendMsg($data['service_member_mobile'], $text);

            }
            die();

        } else {
            echo '0';
            die();
        }

    }

    // 我的预约详情
    function serviceOrderForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "serviceOrderForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {

            $record = $dao->get_row_by_where($dao->tables->service_order, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");

        }
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    // 保存我的评论
    function saveServiceOrderForm()
    {
        global $dao, $global;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $record = array();
        $record = $_POST['frm'];
        $record['is_comment'] = '1';
        $record['order_status'] = '5';
        $record["comment_time"] = date("Y-m-d H:i:s");
        $dao->update($dao->tables->service_order, $record, "where auto_id='{$_POST["auto_id"]}'");
        $myAskInfo = $dao->get_row_by_where($dao->tables->service_order, "where auto_id='{$_POST["auto_id"]}' and is_comment='1' ");
        if (!empty($myAskInfo)) {
            //若订单修改为已完成，则付80%费用给服务人
            $accountRecord = array();
            $accountRecord["member_id"] = $myAskInfo["service_member_id"];
            $accountRecord["content_money"] = $myAskInfo["pay_money"] * 0.8;
            $accountRecord["content_desc"] = "预约服务费";
            $memberAccountService = new memberAccountService();
            $memberAccountService->addAccountRecord($accountRecord);
        }
        $records = $dao->get_row_by_where($dao->tables->service_order, "where auto_id='{$_POST["auto_id"]}'", array("service_member_id"));
        $jifen = $dao->get_datalist("select count(auto_id) as total,sum(comment_level) as jtotal from {$dao->tables->service_order} where auto_id='{$_POST["auto_id"]}'");
        $jifen1 = $dao->get_datalist("select count(auto_id) as total,sum(comment_level) as jtotal from {$dao->tables->ask} where service_member_id='{$records["service_member_id"]}'");
        $zTotal = $jifen['0']['jtotal'] + $jifen1['0']['jtotal'];//总积分
        $zpeo = $jifen['0']['total'] + $jifen1['0']['total'];//总人数

        if ($zpeo != "") {
            $addArr['comment_level'] = round($zTotal / $zpeo);
            $dao->update($dao->tables->member, $addArr, "where auto_id='{$records["service_member_id"]}'");
        }

        $backUrl = $global->siteUrlPath . "/index.php?acl=member&method=serviceOrder";
        echo json_encode(array("result" => 1, "msg" => "信息提交成功!!!"));
    }

    //策略表单
    function serviceProductForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "serviceProductForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {

            $record = $dao->get_row_by_where($dao->tables->service_product, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");

        }

        return $record;
    }

    //添加或编辑策略
    function saveServiceProduct()
    {
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        $mobile = $member["content_mobile"];
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            $frm["member_id"] = $mid;
            $frm["member_mobile"] = $mobile;
            global $dao;
            if (!empty($_POST['auto_id'])) {//编辑
                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";
                $dao->update($dao->tables->service_product, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功", "data_id" => $_POST['auto_id']);
            } else {//添加
                $frm['create_time'] = date("Y-m-d H:i:s");
                $id = $dao->insert($dao->tables->service_product, $frm);
                $arr = array("result" => 1, "msg" => "恭喜您，添加成功", "data_id" => $id);
            }
        }
        echo json_encode($arr);
        exit;
    }

    //删除资金
    function deleteServiceProduct()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->service_product, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }


    //话题管理
    function mySubject()
    {
        global $global_link;
        $this->tpl_file = "mySubject.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);
        $subjectService = new subjectService();
        $record["data"] = $subjectService->listsPage($params);
        return $record;
    }

    //话题表单
    function mySubjectForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "mySubjectForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {

            $record = $dao->get_row_by_where($dao->tables->subject, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");

        }


        return $record;
    }

    //添加或编辑话题
    function saveSubject()
    {
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        $mobile = $member["content_name"];
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            $frm = $_POST['frm'];
            $frm["member_id"] = $mid;
            $frm["content_author"] = $mobile;
            global $dao;
            if (!empty($_POST['auto_id'])) {//编辑
                $where = "where auto_id='{$_POST['auto_id']}' and member_id='{$mid}'";
                $dao->update($dao->tables->subject, $frm, $where);
                $arr = array("result" => 1, "msg" => "恭喜您，修改成功", "data_id" => $_POST['auto_id']);
            } else {//添加
                $frm['create_time'] = date("Y-m-d H:i:s");
                $id = $dao->insert($dao->tables->subject, $frm);

                memberEventService::doEvent("publishSubject");


                $arr = array("result" => 1, "msg" => "恭喜您，添加成功", "data_id" => $id);
            }
        }
        echo json_encode($arr);
        exit;
    }

    //删除话题
    function deleteSubject()
    {
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $arr = array("result" => 0, "msg" => "您还没有登录,请先登录");
        } else {
            global $dao;
            $dao->delete($dao->tables->subject, "where auto_id='{$_POST['id']}' and member_id='{$mid}'");
            $arr = array("result" => 1, "msg" => "删除成功");
        }
        echo json_encode($arr);
        exit;
    }

    function createOrderSn()
    {
        return date("ymdHis") . substr(microtime(), 2, 4);
    }

    //提交预约服务的订单
    function saveServiceOrder()
    {
        global $global_link, $dao, $global;
        //验证登录
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            echo json_encode(array("result" => 0, "msg" => "您还没有登录,请先登录"));
            exit;
        }

        $data = $_POST["frm"];

        //验证服务是否有效
        $serviceProduct = $dao->get_row_by_where($dao->tables->service_product, "where auto_id='{$data["product_id"]}'");
        if (!is_array($serviceProduct) || $serviceProduct["publish"] == 0) {
            echo json_encode(array("result" => 0, "msg" => "服务当前不存在或不允许预约"));
            exit;
        }
        //不能预约自己的服务
        if ($serviceProduct["member_id"] == $mid) {
            echo json_encode(array("result" => 0, "msg" => "不能预约自己的服务"));
            exit;
        }
        //验证账户金额
        $memberAccountService = new memberAccountService();
        $account_balance = $memberAccountService->getAccountBalance($mid);
        $account_balance = $account_balance - $serviceProduct["content_price"];
        if ($account_balance < 0) {
            echo json_encode(array("result" => 0, "msg" => "账户余额不足，请先充值"));
            exit;
        }

        $data["member_id"] = $mid;
        $data["service_member_id"] = $serviceProduct["member_id"];

        $serviceMember = $memberService->getMember($serviceProduct["member_id"]);
        $data["order_sn"] = $this->createOrderSn();
        $data["service_member_name"] = $serviceMember["content_name"];
        $data["service_member_mobile"] = $serviceMember["content_mobile"];

        $data["product_name"] = $serviceProduct["content_name"];
        $data["pay_money"] = $serviceProduct["content_price"];
        $data["pay_status"] = 1;
        //检测是都预约过

        $orderinfo = $dao->get_row_by_where($dao->tables->service_order, "where member_id='{$mid}' and service_member_id='{$data["service_member_id"]}' and product_id='{$data["product_id"]}'");

        if (!empty($orderinfo)) {
            echo json_encode(array("result" => 1, "msg" => "您已经预约成功！！！"));
            exit;
        } else {

            //保存数据
            $serviceOrderService = new serviceOrderService();
            $serviceOrderService->saveOrder($data);
            //更新预约记录数
            $num = $dao->get_row_by_where($dao->tables->service_product, "where auto_id='{$data["product_id"]}'", array("sales_num"));
            $dataArray['sales_num'] = $num['sales_num'] + 1;
            $dao->update($dao->tables->service_product, $dataArray, "where auto_id='{$data["product_id"]}'");
            //生成账户记录
            $accountRecord = array();
            $accountRecord["member_id"] = $mid;
            $accountRecord["content_money"] = -1 * $serviceProduct["content_price"];
            $accountRecord["content_desc"] = "服务预约";
            $memberAccountService->addAccountRecord($accountRecord);
            //
        }
        //获取下单成功的短信模板、
        $eventName = "sendOrderMsg";
        $mobileTemplet = $dao->get_row_by_where($dao->tables->mobile_msg_templet, "where content_event='{$eventName}' and publish='1'");
        $data['service_member_mobile'] = 13261118682;
        $order["order_sn"] = $data["order_sn"];
        if (is_array($mobileTemplet)) {

            $text = str_replace('{order_sn}', $order["order_sn"], $mobileTemplet["content_text"]);
            $mobileMsgService = new mobileMsgService();

            $mobileMsgService->sendMsg($data['service_member_mobile'], $text);

        } else {
            echo json_encode(array("result" => 0, "msg" => "短信功能暂不可用，请联系网站管理员"));
        }
        echo json_encode(array("result" => 1, "msg" => "预约成功"));
        exit;

    }

    // 我的提问
    function myAsk()
    {
        global $global_link;
        $this->tpl_file = "myAsk.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('member_id' => $mid);
        $askService = new askService();
        $record["data"] = $askService->listsPage($params);
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    //我的提问表单
    function myAskForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "myAskForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {

            $record = $dao->get_row_by_where($dao->tables->ask, "where auto_id='{$_GET['id']}' and member_id='{$mid}'");

        }
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    // 提问我的
    function askMy()
    {
        global $global_link;
        $this->tpl_file = "askMy.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $params = array('service_member_id' => $mid);
        $askService = new askService();
        $record["data"] = $askService->listsPage($params);
        // echo "<pre>";print_r($record);die;
        return $record;
    }

    //提问我的表单
    function askMyForm()
    {
        global $global_link, $dao;
        $this->tpl_file = "askMyForm.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        if (!empty($_GET['id'])) {

            $record = $dao->get_row_by_where($dao->tables->ask, "where auto_id='{$_GET['id']}' and service_member_id='{$mid}'");

        }
        return $record;
    }

    // 保存我的评论
    function myAskSave()
    {
        global $dao, $global;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }
        $record = array();
        $record = $_POST['frm'];
        $record["comment_time"] = date("Y-m-d H:i:s");

        $dao->update($dao->tables->ask, $record, "where auto_id='{$_POST["auto_id"]}'");
        $myAskInfo = $dao->get_row_by_where($dao->tables->ask, "where auto_id='{$_POST["auto_id"]}' and comment_status='1' ");
        if (!empty($myAskInfo)) {
            //若订单修改为已完成，则付80%费用给服务人
            $accountRecord = array();
            $accountRecord["member_id"] = $myAskInfo["service_member_id"];
            $accountRecord["content_money"] = $myAskInfo["pay_money"] * 0.8;
            $accountRecord["content_desc"] = "咨询费用";
            $memberAccountService = new memberAccountService();
            $memberAccountService->addAccountRecord($accountRecord);
        }

        // 保存评分
        $records = $dao->get_row_by_where($dao->tables->ask, "where auto_id='{$_POST["auto_id"]}'", array("service_member_id"));
        $jifen = $dao->get_datalist("select count(auto_id) as total,sum(comment_level) as jtotal from {$dao->tables->ask} where auto_id='{$_POST["auto_id"]}'");
        $jifen1 = $dao->get_datalist("select count(auto_id) as total,sum(comment_level) as jtotal from {$dao->tables->service_order} where service_member_id='{$records["service_member_id"]}'");
        $zTotal = $jifen['0']['jtotal'] + $jifen1['0']['jtotal'];//总积分
        $zpeo = $jifen['0']['total'] + $jifen1['0']['total'];//总人数
        // echo "<pre>";print_r($zpeo);die;
        if ($zpeo != "") {
            $addArr['comment_level'] = round($zTotal / $zpeo);
            $dao->update($dao->tables->member, $addArr, "where auto_id='{$records["service_member_id"]}'");
        }
        $backUrl = $global->siteUrlPath . "/index.php?acl=member&method=myAsk";
        echo json_encode(array("result" => 1, "msg" => "信息提交成功!!!"));
    }

    //保存提问内容
    function saveAsk()
    {
        global $global_link, $dao, $global;
        //验证登录
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            echo json_encode(array("result" => 0, "msg" => "您还没有登录,请先登录"));
            exit;
        }

        $data = $_POST["frm"];
        //查询提问某人的a币
        $ask_money = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$data["service_member_id"]}'", array("ask_gold"));
        $data["pay_money"] = $ask_money["ask_gold"];
        $data["pay_status"] = 1;
        // echo "<pre>";print_r($data);die;
        //验证专家是否存在
        $expert = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$data["service_member_id"]}'");


        if (!is_array($expert) || $expert["publish"] == 0) {
            echo json_encode(array("result" => 0, "msg" => "此用户当前不存在或不允许提问"));
            exit;
        }
        //不能向自己提问
        if ($expert["auto_id"] == $mid) {
            echo json_encode(array("result" => 0, "msg" => "不能向自己提问"));
            exit;
        }
        //验证账户金额
        $memberAccountService = new memberAccountService();
        $account_balance = $memberAccountService->getAccountBalance($mid);
        $account_balance = $account_balance - $data["pay_money"];
        if ($account_balance < 0) {
            echo json_encode(array("result" => 0, "msg" => "账户余额不足，请先充值"));
            exit;
        }

        $data["member_id"] = $mid;
        $data["member_name"] = $member["content_name"];
        $data["member_mobile"] = $member["content_mobile"];

        $data["service_member_id"] = $data["service_member_id"];

        $serviceMember = $memberService->getMember($data["service_member_id"]);

        $data["service_member_name"] = $serviceMember["content_name"];
        $data["service_member_mobile"] = $serviceMember["content_mobile"];


        $data["create_time"] = date("Y-m-d H:i:s");

        //保存数据
        $dao->insert($dao->tables->ask, $data);

        //生成账户记录
        $accountRecord = array();
        $accountRecord["member_id"] = $mid;
        $accountRecord["content_money"] = -1 * $data["pay_money"];
        $accountRecord["content_desc"] = "付费提问";
        $memberAccountService->addAccountRecord($accountRecord);

        echo json_encode(array("result" => 1, "msg" => "提问成功，等待对方回复"));
        exit;

    }

    //我的积分
    function memberCredits()
    {
        global $global_link, $dao;
        $this->tpl_file = "memberCredits.php";
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }

        return $record;
    }

    //去认证
    function goAuth()
    {
        global $global_link, $dao, $global;

        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            $this->redirect($global_link["login"]);
        }

        $member = $memberService->getMember($mid);

        $member_type = $member["content_type"];
        if ($member_type != "0") {

            if ($member["is_auth"] == "0") {
                //如果是未认证,直接展示表单页面
                $this->redirect($global->siteUrlPath . "/index.php?acl=member&method=memberAuthForm");
            } else {
                //如果是已认证或认证未通过或审核中
                $this->redirect($global->siteUrlPath . "/index.php?acl=member&method=memberAuthInfo");
            }

        }

        $this->tpl_file = "goAuth.php";

        return $record;
    }

    function downloadStrategyFile()
    {
        global $dao, $global;

        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        //判断登录
        $mid = $member["auto_id"];
        if ($mid == "") {
            $this->jsAlert("请求出错，请刷新页面后重试");
            exit;
        }


        //判断是否是本人的文件
        $file = $dao->get_row_by_where($dao->tables->strategy_reply, "where auto_id='{$_REQUEST["id"]}' and member_id='{$mid}'");

        if (is_array($file)) {
            $fileName = $file["content_name"];
            $filePath = $global->uploadAbsolutePath . $file["content_file"];
            if (!file_exists($filePath)) {
                $this->jsAlert("抱歉，文件不存在");
                exit;
            }

            header("Pragma: public");
            header("Expires: 0"); // set expiration time
            header("Cache-Component: must-revalidate, post-check=0, pre-check=0");
            header("Content-type:application/octet-stream");
            header("Content-Length: " . filesize($filePath));
            header("Content-Disposition: attachment; filename=\"{$fileName}\"");
            header('Content-Transfer-Encoding: binary');
            readfile($filePath);
            exit;
        } else {
            $this->jsAlert("文件不存在或无权查看");
        }

    }

    //积分兑换a币
    function exchangeMoney()
    {
        global $global, $global_link, $dao;
        //检验登录
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            echo json_encode(array("result" => 0, "msg" => "请先登录"));
            exit;
        }


        //校验充值金额
        $money = round($_REQUEST["fill_money"]);
        if (!is_numeric($money) || $money < 1 || $money > 1000000) {
            echo json_encode(array("result" => 0, "msg" => "兑换金额不符合要求"));
            exit;
        }

        $memberCreditsService = new memberCreditsService();
        $credits = $memberCreditsService->getTotalCredits($mid);
        $needCredits = $money * 10;
        if ($credits < $needCredits) {
            echo json_encode(array("result" => 0, "msg" => "积分不足"));
            exit;
        }

        $memberAccountService = new memberAccountService();

        $accountRecord = array();
        $accountRecord["member_id"] = $mid;
        $accountRecord["content_money"] = $money;
        $accountRecord["content_desc"] = "积分兑换a币";
        $memberAccountService->addAccountRecord($accountRecord);

        $creditsRecord = array();
        $creditsRecord["member_id"] = $mid;
        $creditsRecord["content_credits"] = $needCredits * -1;
        $creditsRecord["content_desc"] = "积分兑换a币";
        $memberCreditsService->addRecord($creditsRecord);

        echo json_encode(array("result" => 1, "msg" => "兑换成功"));
    }

    //大转盘游戏页面
    function gameDazhuanpan()
    {
        global $global, $global_link;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        $this->tpl_file = "game_dazhuanpan.php";
        $record = array();
        $record["page_title"] = "幸运大转盘";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=gameLists";
        return $record;
    }

    //获取大转盘游戏结果
    function gameDazhuanpanResult()
    {
        global $global, $dao;
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();

        $todayTime = date("Y-m-d") . " 00:00:00";
        $todayCount = $dao->get_datalist("select count(auto_id) as count_num from {$dao->tables->game_log} where member_id='{$member["auto_id"]}' and game_id='dazhuanpan' and create_time>='{$todayTime}'");

        //查询用户的积分
        // content_credits
        $my_credits = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$member["auto_id"]}' ", array("content_credits"));
        if (!empty($my_credits)) {
            if ($my_credits['content_credits'] > 0) {
                if ($my_credits['content_credits'] >= 20) {
                    $memberCreditsService = new memberCreditsService();
                    $credits_record = array();
                    $credits_record["member_id"] = $member["auto_id"];
                    $credits_record["content_credits"] = -20;
                    $credits_record["content_desc"] = "抽奖花费";
                    $memberCreditsService->addRecord($credits_record);
                } else {
                    echo json_encode(array("result" => 0, "angle" => 0, "msg" => "您的积分不足抽奖了，想抽奖赶快去充积分"));
                    exit;
                }
            } else {
                echo json_encode(array("result" => 0, "angle" => 0, "msg" => "您的积分不足抽奖了，想抽奖赶快去充积分"));
                exit;
            }
        }
        // if($todayCount[0]["count_num"]>=3){
        // 	//超过次数，今天不能进行游戏
        // 	echo json_encode(array("result"=>0,"angle"=>0,"msg"=>"您今天的机会用完了，请明天再来"));
        // 	exit;
        // }

        $gameData = $dao->get_datalist("select * from {$dao->tables->game_dazhuanpan} order by auto_id asc");

        //获取游戏结果
        $rand = rand(0, 10000);
        $sum = 0;
        $result = NULL;
        if (is_array($gameData))
            foreach ($gameData as $key => $vl) {
                $sum += $vl["chance_percent"] * 100;
                if ($sum >= $rand) {
                    $result = $vl;
                    break;
                }
            }

        if (!is_array($result)) {
            $result = array();
            $result["content_name"] = "没有得奖，再接再厉";
            //游戏结果提示
            $msg = $result["content_name"];
        } else {
            //游戏结果提示
            $msg = "恭喜您获得" . $result["content_name"] . ($result["content_desc"] != "" ? (":" . $result["content_desc"]) : "");
        }

        //计算返回的角度
        if ($result["auto_id"] != "") {
            $angle = 60 * ($result["auto_id"] - 1) + rand(0, 59);
        } else {
            $angle = 300 + rand(0, 59);
        }


        //增加游戏日志
        $log_record = array();
        $log_record["member_id"] = $member["auto_id"];
        $log_record["member_name"] = $member["content_name"];
        $log_record["game_id"] = "dazhuanpan";
        $log_record["game_name"] = "大转盘";
        $log_record["content_result"] = $msg;
        $log_record["create_time"] = date("Y-m-d H:i:s");


        $dao->insert($dao->tables->game_log, $log_record, true);

        //如果有奖品，生成领奖记录
        if ($result["gift_id"] > 0) {
            $gift_record = array();
            $gift_record["member_id"] = $member["auto_id"];
            $gift_record["member_name"] = $member["content_name"];
            $gift_record["content_type"] = "2";
            $gift_record["gift_id"] = $result["gift_id"];
            $gift_record["gift_name"] = $result["gift_name"];
            $gift_record["content_desc"] = "游戏得奖";
            $gift_record["content_status"] = "0";
            $gift_record["create_time"] = date("Y-m-d H:i:s");
            $dao->insert($dao->tables->gift_order, $gift_record, true);
            $gift_record_id = $dao->get_insert_id();
        }

        //如果有积分奖励，生成积分记录
        if ($result["content_credits"] > 0) {
            $memberCreditsService = new memberCreditsService();
            $credits_record = array();
            $credits_record["member_id"] = $member["auto_id"];
            $credits_record["content_credits"] = $result["content_credits"];
            $credits_record["content_desc"] = "游戏得积分";
            $memberCreditsService->addRecord($credits_record);
        }

        echo json_encode(array("result" => 1, "angle" => $angle, "msg" => $msg, "gameGift" => "" . $gift_record_id));
    }

    //领奖页面(填写联系方式)
    function gameGiftForm()
    {
        global $global, $global_link;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        //判断奖品是否存在
        $giftOrderService = new giftOrderService();
        $giftOrder = $giftOrderService->getData($_REQUEST["id"]);

        //判断是否有权限领奖
        if (!is_array($giftOrder)) {
            $this->redirect($global->siteUrlPath, "订单不存在");
        }

        if ($giftOrder["member_id"] != $member_id) {
            $this->redirect($global->siteUrlPath, "没有浏览权限");
        }

        //判断领奖状态
        if ($giftOrder["content_status"] != "0") {
            $this->redirect($global->siteUrlPath . "/index.php?acl=member&method=gameGiftOrderInfo&id=" . $giftOrder["auto_id"]);
        }


        $giftService = new giftService();
        $gift = $giftService->getData($giftOrder["gift_id"]);

        if (!is_array($gift)) {
            $this->redirect($global->siteUrlPath, "礼品不存在");
        }

        $this->tpl_file = "gameGiftForm.php";
        $record = array();
        $record["page_title"] = "去领奖";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=gameGiftOrderLists";
        $record["gift"] = $gift;
        $record["order"] = $giftOrder;
        return $record;
    }

    function saveGameGiftOrder()
    {
        global $global, $dao;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");

        //判断奖品是否存在
        $giftOrderService = new giftOrderService();
        $giftOrder = $giftOrderService->getData($_REQUEST["id"]);

        //判断是否有权限领奖
        if (!is_array($giftOrder)) {
            echo json_encode(array("result" => 0, "msg" => "订单不存在"));
            exit;
        }

        if ($giftOrder["member_id"] != $member_id) {
            echo json_encode(array("result" => 0, "msg" => "没有浏览权限"));
            exit;
        }

        //判断领奖状态
        if ($giftOrder["content_status"] != "0") {
            echo json_encode(array("result" => 0, "msg" => "当前无法领奖，请重试"));
            exit;
        }


        $giftService = new giftService();
        $gift = $giftService->getData($giftOrder["gift_id"]);

        if (!is_array($gift)) {
            echo json_encode(array("result" => 0, "msg" => "奖品不存在"));
            exit;
        }


        //保存收货人信息
        $record = $_POST["frm"];

        $addressService = new addressService();

        $record["province_name"] = $addressService->getProviceNameById($record["province_id"]);
        $record["city_name"] = $addressService->getCityNameById($record["city_id"]);


        //修改订单状态
        $record["content_status"] = 1;
        //$record["create_time"]=date("Y-m-d H:i:s");

        //保存订单信息

        $dao->update($dao->tables->gift_order, $record, "where auto_id='{$giftOrder["auto_id"]}'", true);


        echo json_encode(array("result" => 1, "msg" => "信息提交成功", "id" => $giftOrder["auto_id"]));


        //返回订单id
    }

    //购买VIP的页面
    function buyVIPForm()
    {
        global $global, $global_link;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            $this->redirect($global_link["login"]);
        }

        $this->tpl_file = "buyVIPForm.php";
        $record = array();

        return $record;
    }

    //购买VIP
    function buyVIP()
    {
        global $global, $dao;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");

        //判断是否有权限领奖
        if (member_id == "") {
            echo json_encode(array("result" => -1, "msg" => "请先登录"));
            exit;
        }

        //参数有误
        if ($_GET["group"] == "" || $_GET["group"] == "1") {
            echo json_encode(array("result" => 0, "msg" => "参数有误"));
            exit;
        }

        $group = $dao->get_row_by_where($dao->tables->member_group, "where auto_id='{$_GET["group"]}'");
        if (!is_array($group)) {
            echo json_encode(array("result" => 0, "msg" => "参数有误"));
            exit;
        }

        if ($group["during_days"] <= 0 || $group["price"] <= 0) {
            echo json_encode(array("result" => 0, "msg" => "无法购买此类VIP会员"));
            exit;
        }


        //余额不足
        $memberAccountService = new memberAccountService();
        $account_balance = $memberAccountService->getAccountBalance($member_id);
        if ($account_balance < $group["price"]) {
            echo json_encode(array("result" => 0, "msg" => "账户余额不足，请先充值"));
            exit;
        }

        if ($_GET["task"] == "check") {
            echo json_encode(array("result" => 1, "msg" => "确认要花费{$group["price"]}a币购买VIP会员？"));
        } else {

            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$member_id}'");

            //计算新的有效期
            $vip_period = "";
            if ($member["vip_period"] > date("Y-m-d H:i:s")) {
                $vip_period = date("Y-m-d H:i:s", strtotime("+{$group["during_days"]} day", strtotime($member["vip_period"])));
            } else {
                $vip_period = date("Y-m-d H:i:s", strtotime("+{$group["during_days"]} day"));
            }


            //更新会员分组及有效期
            $record = array();
            $record["group_id"] = $group["auto_id"];
            $record["vip_period"] = $vip_period;
            $dao->update($dao->tables->member, $record, "where auto_id='{$member["auto_id"]}'", true);


            //生成账户记录
            $accountRecord = array();
            $accountRecord["member_id"] = $member["auto_id"];
            $accountRecord["content_money"] = -1 * $group["price"];
            $accountRecord["content_desc"] = "购买VIP会员";
            $memberAccountService->addAccountRecord($accountRecord);

            echo json_encode(array("result" => 1, "msg" => "购买成功"));

        }

    }

    //判断会员是否发布过资金信息
    function hasCapital()
    {
        global $global, $dao;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");

        if ($member_id == "") {
            echo json_encode(array("result" => 0, "msg" => "请先登录"));
            exit;
        }

        $tmp = $dao->get_datalist("select count(auto_id) as count_num from {$dao->tables->capital} where member_id='{$member_id}'");


        if ($tmp[0]["count_num"] > 0) {
            echo json_encode(array("result" => 1, "msg" => ""));
        } else {
            echo json_encode(array("result" => 0, "msg" => ""));
        }

    }

    //判断会员是否发布过策略信息
    function hasStrategy()
    {
        global $global, $dao;
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");

        if ($member_id == "") {
            echo json_encode(array("result" => 0, "msg" => "请先登录"));
            exit;
        }

        $tmp = $dao->get_datalist("select count(auto_id) as count_num from {$dao->tables->strategy} where member_id='{$member_id}'");


        if ($tmp[0]["count_num"] > 0) {
            echo json_encode(array("result" => 1, "msg" => ""));
        } else {
            echo json_encode(array("result" => 0, "msg" => ""));
        }
    }

    //验证名称是否可以使用
    function checkStrategyCName()
    {
        global $dao;
        if ($_POST["content_name"] != "") {

            $memberService = new memberService();
            $mid = $memberService->getLoginMemberInfo("auto_id");
            // echo "<pre>";print_r($mid);
            $member_sql = "select auto_id from {$dao->tables->strategy} where content_name='" . $_POST["content_name"] . "'  and auto_id!='" . $_POST["auto_id"] . "' limit 0,1";
            // echo "<pre>";print_r($member_sql);die;
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    //验证名称是否可以使用
    function checkStrategySubName()
    {
        global $dao;
        if ($_POST["content_subname"] != "") {

            $memberService = new memberService();
            $mid = $memberService->getLoginMemberInfo("auto_id");

            $member_sql = "select auto_id from {$dao->tables->strategy} where content_name='" . $_POST["content_name"] . "'  and auto_id!='" . $_POST["auto_id"] . "' limit 0,1";
            $data = $dao->get_datalist($member_sql);
            if (is_array($data) && count($data) > 0) {
                echo "false";
                return;
            } else {
                echo "true";
                return;
            }
        }
    }

    // 我的策略需求
    function myStrategyReply()
    {
        global $dao, $global, $global_link, $enumVars;
        $this->tpl_file = "myStrategyReplyList.php";
        $dict = new DictionaryVars();
        $memberService = new memberService();
        $policy = $dict->getVars('captialPolicy');
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            $this->redirect($global_link["login"]);
        } else {
            if ($_GET['id'] != "") {
                $this->tpl_file = "myStrategyReplyInfo.php";
                $record = $dao->get_row_by_where($dao->tables->strategy_require, "where auto_id='{$_GET["id"]}' ");
                if (!empty($record)) {
                    $stra = $dict->getVars('strategyCycle');
                    $expert = $dict->getVars('expectedRevenue');
                    $risktype = $dict->getVars('riskType');
                    $riskabide = $dict->getVars('capitalRisk');
                    $risktype = $dict->getVars('riskType');
                    $record['cate_id'] = $dao->get_row_by_where($dao->tables->strategy_category, "where auto_id='{$record["cate_id"]}' ");
                    $record['publish'] = $dict->getText($enumVars["dealStatusVars"], $record['publish']);
                    $record['cycle'] = $dict->getText($stra, $record['cycle']);
                    $record['revenue'] = $dict->getText($expert, $record['revenue']);
                    $record['risktype'] = $dict->getText($risktype, $record['risktype']);

                }
            } else {
                $record = array();
                $record = $dao->get_datalist("select * from {$dao->tables->strategy_require} where member_id='{$member_id}' ");
                if (!empty($record)) {
                    foreach ($record as $key => $va) {
                        $record[$key]['publish'] = $dict->getText($enumVars["dealStatusVars"], $va['publish']);
                        $record[$key]['cate_id'] = $dao->get_row_by_where($dao->tables->strategy_category, "where auto_id='{$va["cate_id"]}' ");
                    }
                }
            }
            // echo "<pre>";print_r($record);die;
            return $record;
            // echo "<pre>";print_r($record);die;
        }

    }

    function myCapitalRequire()
    {
        global $dao, $global, $global_link, $enumVars;
        $this->tpl_file = "myCapitalRequireList.php";
        $dict = new DictionaryVars();
        $memberService = new memberService();
        $capt = $dict->getVars('captialPolicy');
        $policy = $dict->getVars('captialPolicy');
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            $this->redirect($global_link["login"]);
        } else {
            if ($_GET['id'] != "") {
                $this->tpl_file = "myCapitalRequireInfo.php";
                $record = $dao->get_row_by_where($dao->tables->capital_require, "where auto_id='{$_GET["id"]}' ");
                if (!empty($record)) {
                    $stra = $dict->getVars('strategyCycle');
                    $expert = $dict->getVars('expectedRevenue');
                    $risktype = $dict->getVars('riskType');
                    $riskabide = $dict->getVars('capitalRisk');
                    $risktype = $dict->getVars('riskType');
                    $record['cate_id'] = $dao->get_row_by_where($dao->tables->strategy_category, "where auto_id='{$record["cate_id"]}' ");
                    $record['publish'] = $dict->getText($enumVars["dealStatusVars"], $record['publish']);
                    $record['cycle'] = $dict->getText($stra, $record['cycle']);
                    $record['revenue'] = $dict->getText($expert, $record['revenue']);
                    $record['policy'] = $dict->getText($capt, $record['policy']);
                    $record['risktype'] = $dict->getText($risktype, $record['risktype']);

                }
            } else {
                $record = array();
                $capitalService = new capitalService();
                $params['mmember_id'] = $member_id;
                $record = $capitalService->listsPage($params);
                // $record=$dao->get_datalist("select * from {$dao->tables->capital_require} where member_id='{$member_id}' ");
                // if(!empty($record)){
                // 	foreach ($record as $key => $va) {
                // 		$record[$key]['publish']=$dict->getText($enumVars["dealStatusVars"], $va['publish']);
                // 		$record[$key]['policy']=$dict->getText($capt, $va['policy']);
                // 		$record[$key]['cate_id']=$dao->get_row_by_where($dao->tables->strategy_category,"where auto_id='{$va["cate_id"]}' ");
                // 	}
                // }
            }
            // echo "<pre>";print_r($record);die;
            return $record;
            // echo "<pre>";print_r($record);die;
        }
    }

    function myVideoEnroll()
    {
        global $dao, $global, $global_link, $enumVars;
        $this->tpl_file = "myVideoEnrollList.php";
        $dict = new DictionaryVars();
        $memberService = new memberService();
        $capt = $dict->getVars('captialPolicy');
        $policy = $dict->getVars('captialPolicy');
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        if ($member_id == "") {
            $this->redirect($global_link["login"]);
        } else {
            if ($_GET['id'] != "") {
                $this->tpl_file = "myVideoEnrollInfo.php";
                $record = $dao->get_row_by_where($dao->tables->video, "where auto_id='{$_GET["id"]}' ");
                if (!empty($record)) {
                    $videoSort = $dict->getVars('videoSort');
                    $expert = $dict->getVars('expectedRevenue');
                    $risktype = $dict->getVars('riskType');
                    $riskabide = $dict->getVars('capitalRisk');
                    $strategyRevenue = $dict->getVars('strategyRevenue');
                    $strategyInvest = $dict->getVars('strategyInvest');
                    $record['relate_id'] = $dao->get_row_by_where($dao->tables->strategy, "where auto_id='{$record["relate_id"]}' ");
                    // $record['publish']=$dict->getText($enumVars["dealStatusVars"], $record['publish']);
                    $record['sorty'] = $dict->getText($videoSort, $record['sorty']);
                    $record['carry_status'] = $dict->getText($enumVars["carryStatus"], $record['carry_status']);
                    $record['cate_id'] = $dao->get_row_by_where($dao->tables->strategy_category, "where auto_id='{$record["cate_id"]}' ");
                    $record['policy'] = $dict->getText($capt, $record['policy']);
                    $record['type'] = $dict->getText($enumVars["videoType"], $record['type']);
                    $record['revenue'] = $dict->getText($strategyRevenue, $record['revenue']);
                    $record['invest'] = $dict->getText($strategyInvest, $record['invest']);

                }
            } else {
                // $record=array();
                $page = $_GET["page"];
                if ($page == "")
                    $page = 1;
                if ($params["pagesize"] == "")
                    $pagesize = 10;
                else
                    $pagesize = $params["pagesize"];
                $begin_count = ($page - 1) * $pagesize;
                $list = $dao->get_datalist("select * from {$dao->tables->video_enroll} where member_id='{$member_id}' limit {$begin_count},{$pagesize}");
                $count_sql = $dao->get_datalist("select count(auto_id) as total from {$dao->tables->video_enroll} where member_id='{$member_id}' ");
// echo "<pre>";print_r($list);die;
                if (!empty($list)) {
                    foreach ($list as $key => $va) {

                        $list[$key]['policy'] = $dict->getText($capt, $va['policy']);
                        $list[$key]['cate_id'] = $dao->get_row_by_where($dao->tables->video, "where auto_id='{$va["object_id"]}' ");
                    }


                }
                $list_count = $dao->get_datalist($count_sql);
                $total = $list_count[0]["total"] > 0 ? $list_count[0]["total"] : 0;
                $page_class = new page_class();
                $page_class->page_size = $pagesize;
                $page_class->init($total);
                $pageBar = $page_class->getPageBar();
                // $record=array();
                $record['total'] = $total;
                $record["list"] = $list;
                $record["page"] = $pageBar;
            }

            return $record;

        }
    }

    //安全设置
    function safe()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $member = $memberService->getLoginMemberInfo();
        $mid = $member["auto_id"];
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        $this->tpl_file = "mem_safety.php";


        $record["location_title"] = "安全设置";

        return $record;
    }

    function changeMobileForm_1()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");

        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }


        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;
        }

        //如果之前没有设置过手机号
        if ($record["member"]["content_mobile"] == "") {
            //直接跳转到设置新手机号的页面
            $_SESSION["changeMobileFlag"] = "1";
            $this->redirect($global->siteUrlPath . "/index.php?acl=member&method=changeMobileForm_2");
        }

        $this->tpl_file = "changeMobile_1.php";

        $record["page_title"] = "修改手机号";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=index";


        return $record;
    }

    function getChangeMobileMsg_1()
    {
        global $global_params, $global, $dao;

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            unset($_SESSION["validateNUM"]);
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);

        $memberService = new memberService();
        $content_mobile = $memberService->getLoginMemberInfo("content_mobile");

        /*$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
		if(!is_array($member)){
			//判断手机号是否已经注册
			echo json_encode(array("result"=>0,"msg"=>"此手机号未注册，请确认您的手机号是否正确"));
			exit;
		}*/

        //查询短信记录表
        $today = date("Y-m-d");
        $recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
        if (is_array($recordList) && count($recordList) >= 10) {
            //每天最多使用3次
            echo json_encode(array("result" => 0, "msg" => "您获取验证码的操作过于频繁，请明天再试"));
            exit;
        }

        //生成验证码
        $num = rand(10000, 99999);

        //验证码写入session
        $_SESSION["changeMobileRandNum"] = $num;
        $_SESSION["changeMobileNo"] = $content_mobile;

        //获取网站名称
        $paramsService = new paramsService();
        $site_name = $paramsService->getParamValue("content_name");

        //发送短信验证码
        $mobileMsgService = new mobileMsgService();
        //$mobileMsgService->sendMsg($content_mobile,"您正在使用{$global_params["content_title"]}网站的密码找回功能,验证码为{$num},请保管好验证码并切勿转告他人","forgetPwd");
        $mobileMsgService->sendMsg($content_mobile, "您正在使用{$site_name}的重置手机号功能,验证码为{$num},请妥善保管并切勿转告他人", array("content_type" => "changeMobile"));

        echo json_encode(array("result" => 1, "msg" => "验证码已经发送到您的手机，有效期20分钟，请注意查收"));
    }

    function validateMobileMsg_1()
    {
        $mobile_randnum = $_POST["mobile_randnum"];
        if ($mobile_randnum == "" || $_SESSION["changeMobileRandNum"] == "" || $_SESSION["changeMobileRandNum"] != $mobile_randnum) {
            echo json_encode(array("result" => 0, "msg" => "短信验证码输入有误，请重试"));
            exit;
        }

        //设置session标志位
        $_SESSION["changeMobileFlag"] = "1";

        echo json_encode(array("result" => 1, "msg" => "验证成功，请重新设置您的手机号"));
    }

    function changeMobileForm_2()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");

        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        //验证标识位是否存在
        if ($_SESSION["changeMobileFlag"] != "1" || $_SESSION["changeMobileNo"] == "") {
            $this->redirect("index.php?acl=member");
            exit;
        }

        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;
        }

        $this->tpl_file = "changeMobile_2.php";

        $record["page_title"] = "修改手机号";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=index";


        return $record;
    }

    function getChangeMobileMsg_2()
    {
        global $global_params, $global, $dao;

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            unset($_SESSION["validateNUM"]);
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);

        //标识位是否存在
        if ($_SESSION["changeMobileFlag"] != "1" || $_SESSION["changeMobileNo"] == "") {
            echo json_encode(array("result" => 0, "msg" => "验证过期，请重新验证手机"));
            exit;
        }


        $content_mobile = $_POST["content_mobile"];
        //不能与原手机号相同
        if ($content_mobile == $_SESSION["changeMobileNo"]) {
            echo json_encode(array("result" => 0, "msg" => "新手机号不能与原手机号相同"));
            exit;
        }

        //手机号是否注册过
        $member = $dao->get_row_by_where($dao->tables->member, "where content_mobile='{$content_mobile}'");
        if (is_array($member)) {
            //判断手机号是否已经注册
            echo json_encode(array("result" => 0, "msg" => "此手机号已注册，请确认您的手机号是否正确"));
            exit;
        }

        //查询短信记录表
        $today = date("Y-m-d");
        $recordList = $dao->get_datalist("select auto_id from {$dao->tables->mobile_msg_record} where content_mobile='{$content_mobile}' and create_time>='{$today}'");
        if (is_array($recordList) && count($recordList) >= 10) {
            //每天最多使用3次
            echo json_encode(array("result" => 0, "msg" => "您获取验证码的操作过于频繁，请明天再试"));
            exit;
        }

        //生成验证码
        $num = rand(10000, 99999);

        //验证码写入session
        $_SESSION["changeMobileRandNum2"] = $num;
        $_SESSION["changeMobileNo2"] = $content_mobile;

        //获取网站名称
        $paramsService = new paramsService();
        $site_name = $paramsService->getParamValue("content_name");

        //发送短信验证码
        $mobileMsgService = new mobileMsgService();
        //$mobileMsgService->sendMsg($content_mobile,"您正在使用{$global_params["content_title"]}网站的密码找回功能,验证码为{$num},请保管好验证码并切勿转告他人","forgetPwd");
        $mobileMsgService->sendMsg($content_mobile, "您正在{$site_name}的进行重置手机号操作,验证码为{$num},请妥善保管并切勿转告他人", array("content_type" => "changeMobile"));

        echo json_encode(array("result" => 1, "msg" => "验证码已经发送到您的手机，有效期20分钟，请注意查收"));
    }

    function saveMemberMobile()
    {
        global $dao, $global;
        $mobile_randnum = $_POST["mobile_randnum"];
        if ($mobile_randnum == "" || $_SESSION["changeMobileRandNum2"] == "" || $_SESSION["changeMobileRandNum2"] != $mobile_randnum) {
            echo json_encode(array("result" => 0, "msg" => "短信验证码输入有误，请重试"));
            exit;
        }

        //判断当前操作是否允许
        if ($_SESSION["changeMobileFlag"] != "1" || $_SESSION["changeMobileNo"] == "" || $_SESSION["changeMobileNo2"] == "") {
            echo json_encode(array("result" => 0, "msg" => "验证出错,请重试"));
            exit;
        }

        $content_mobile = $_POST["content_mobile"];
        if ($content_mobile != $_SESSION["changeMobileNo2"]) {
            echo json_encode(array("result" => 0, "msg" => "提交的手机号与验证手机不一致，请重新操作"));
            exit;
        }

        //修改手机号

        $record["content_mobile"] = $content_mobile;

        $dao->update($dao->tables->member, $record, "where content_mobile='{$_SESSION["changeMobileNo"]}'");

        $memberService = new memberService();
        $memberInfo = $memberService->getLoginMemberInfo();


        if ($memberInfo["content_name"] == $memberInfo["content_mobile"])
            $memberInfo["content_name"] = $record["content_mobile"];
        $memberInfo["content_mobile"] = $record["content_mobile"];
        $memberService->setLoginMemberInfo($memberInfo);

        //清除session标志位
        unset($_SESSION["changeMobileRandNum"]);
        unset($_SESSION["changeMobileRandNum2"]);
        unset($_SESSION["changeMobileNo"]);
        unset($_SESSION["changeMobileNo2"]);
        unset($_SESSION["changeMobileFlag"]);


        echo json_encode(array("result" => 1, "msg" => "手机号重置成功"));
    }

    //提交修改第一步
    function changeEmailForm()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;
        }

        if ($member["content_email"] != "") {
            $this->tpl_file = "changeEmailForm_1.php";
        } else {
            $_SESSION["changeEmailFlag"] = "1";

            $this->tpl_file = "changeEmailForm_2.php";
        }


        $record["page_title"] = "修改手机号";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=index";


        return $record;
    }

    //完成修改
    function changeEmailForm_2()
    {
        global $dao, $top_menu_focus, $global, $global_link;
        $top_menu_focus = false;
        $record = array();
        $memberService = new memberService();
        $mid = $memberService->getLoginMemberInfo("auto_id");
        if ($mid == "") {
            //$this->redirect($global->siteUrlPath,"请先登录");
            $this->redirect($global_link["login"]);
        }

        //验证标识位是否存在
        if ($_SESSION["changeEmailFlag"] != "1") {
            $this->redirect("index.php?acl=member");
            exit;
        }

        if ($mid != "") {
            //查询会员信息
            $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$mid}'");
            $record["member"] = $member;
        }


        $this->tpl_file = "changeEmailForm_2.php";


        $record["page_title"] = "修改手机号";
        $record["back_link"] = $global->siteUrlPath . "/index.php?acl=member&method=index";


        return $record;
    }

    function getChangeEmailMsg_1()
    {
        global $global_params, $global, $dao;

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            unset($_SESSION["validateNUM"]);
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);

        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");
        $member = $dao->get_row_by_where($dao->tables->member, "where auto_id='{$member_id}'");

        $content_email = $member["content_email"];

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
        $num = rand(10000, 99999);

        //验证码写入session
        $_SESSION["changeEmailRandNum"] = $num;
        $_SESSION["changeEmail"] = $content_email;

        //获取网站名称
        $paramsService = new paramsService();
        $site_name = $paramsService->getParamValue("content_name");

        $time = time();
        $link = $global->siteUrlPath . "/index.php?acl=member&method=changeEmailForms&email=" . urlencode($email) . "&time={$time}&validate=" . md5($email . $member["pass_randstr"] . $time);
        $eventName = "editEmail";
        //获取下单成功的短信模板
        $emailTemplet = $dao->get_row_by_where($dao->tables->email_templet, "where content_event='{$eventName}' and publish='1'");
        if (is_array($emailTemplet)) {

            $body = str_replace('{code}', $num, $emailTemplet["content_body"]);
            $title = $emailTemplet["content_title"];
            // echo "<pre>";print_r($title);die;
            $emailService = new emailService();
            $result = $emailService->sendEmail($content_email, $title, $body);
        }

        echo json_encode(array("result" => 1, "msg" => "验证码已经发送到您的邮箱，有效期20分钟，请注意查收"));
    }

    function validateEmailMsg_1()
    {
        $email_randnum = $_POST["email_randnum"];
        if ($email_randnum == "" || $_SESSION["changeEmailRandNum"] == "" || $_SESSION["changeEmailRandNum"] != $email_randnum) {
            echo json_encode(array("result" => 0, "msg" => "验证码输入有误，请重试"));
            exit;
        }

        //设置session标志位
        $_SESSION["changeEmailFlag"] = "1";

        echo json_encode(array("result" => 1, "msg" => "验证成功，请重新设置您的邮箱"));
    }

    function getChangeEmailMsg_2()
    {
        global $global_params, $global, $dao;

        //检查验证码
        if (
            $_POST["validateNUM"] == "" ||
            $_SESSION["validateNUM"] == "" ||
            strtolower($_POST["validateNUM"]) != strtolower($_SESSION["validateNUM"])
        ) {
            //$this->redirect($global_link["register"],"验证码输入错误");
            unset($_SESSION["validateNUM"]);
            echo json_encode(array("result" => 0, "msg" => "验证码输入错误"));
            exit;
        }
        unset($_SESSION["validateNUM"]);

        //标识位是否存在
        if ($_SESSION["changeEmailFlag"] != "1" /*|| $_SESSION["changeEmail"]==""*/) {
            echo json_encode(array("result" => 0, "msg" => "验证过期，请重新验证邮箱"));
            exit;
        }


        $content_email = $_POST["content_email"];
        /*//不能与原手机号相同
		if($content_email==$_SESSION["changeEmail"]){
			echo json_encode(array("result"=>0,"msg"=>"新邮箱不能与原邮箱相同"));
			exit;
		}*/
        $memberService = new memberService();
        $member_id = $memberService->getLoginMemberInfo("auto_id");


        //手机号是否注册过
        $member = $dao->get_row_by_where($dao->tables->member, "where content_email='{$content_email}' and auto_id!='{$member_id}'");
        if (is_array($member)) {
            //判断手机号是否已经注册
            echo json_encode(array("result" => 0, "msg" => "此邮箱已注册，请确认您的邮箱是否正确"));
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
        $num = rand(10000, 99999);

        //验证码写入session
        $_SESSION["changeEmailRandNum2"] = $num;
        $_SESSION["changeEmail2"] = $content_email;

        //获取网站名称
        $paramsService = new paramsService();
        $site_name = $paramsService->getParamValue("content_name");

        $time = time();
        $link = $global->siteUrlPath . "/index.php?acl=member&method=changeEmailForms&email=" . urlencode($email) . "&time={$time}&validate=" . md5($email . $member["pass_randstr"] . $time);
        $eventName = "editEmail";
        //获取下单成功的短信模板
        $emailTemplet = $dao->get_row_by_where($dao->tables->email_templet, "where content_event='{$eventName}' and publish='1'");
        if (is_array($emailTemplet)) {

            $body = str_replace('{code}', $num, $emailTemplet["content_body"]);
            $title = $emailTemplet["content_title"];
            // echo "<pre>";print_r($title);die;
            $emailService = new emailService();
            $result = $emailService->sendEmail($content_email, $title, $body);
        }

        echo json_encode(array("result" => 1, "msg" => "验证码已经发送到您的邮箱，有效期20分钟，请注意查收"));
    }

    function saveMemberEmail()
    {
        global $dao, $global;
        $mobile_randnum = $_POST["email_randnum"];
        if ($mobile_randnum == "" || $_SESSION["changeEmailRandNum2"] == "" || $_SESSION["changeEmailRandNum2"] != $mobile_randnum) {
            echo json_encode(array("result" => 0, "msg" => "短信验证码输入有误，请重试"));
            exit;
        }

        //判断当前操作是否允许
        if ($_SESSION["changeEmailFlag"] != "1" || $_SESSION["changeEmail2"] == "") {
            echo json_encode(array("result" => 0, "msg" => "验证出错,请重试"));
            exit;
        }

        $content_email = $_POST["content_email"];
        if ($content_email != $_SESSION["changeEmail2"]) {
            echo json_encode(array("result" => 0, "msg" => "提交的邮箱与验证邮箱不一致，请重新操作"));
            exit;
        }

        $memberService = new memberService();
        $memberInfo = $memberService->getLoginMemberInfo();

        //修改手机号

        $record["content_email"] = $content_email;

        $dao->update($dao->tables->member, $record, "where auto_id='{$memberInfo["auto_id"]}'");


        $memberInfo["content_email"] = $record["content_email"];
        $memberService->setLoginMemberInfo($memberInfo);

        //清除session标志位
        unset($_SESSION["changeEmailRandNum"]);
        unset($_SESSION["changeEmailRandNum2"]);
        unset($_SESSION["changeEmail"]);
        unset($_SESSION["changeEmail2"]);
        unset($_SESSION["changeEmailFlag"]);


        echo json_encode(array("result" => 1, "msg" => "邮箱修改成功"));
    }


}

?>
