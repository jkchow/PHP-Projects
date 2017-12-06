<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script src="<?=$global->sysTplUrlPath?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/md5.js" type="text/javascript"></script>
<script>

function submit_login_form(){
	var user=document.getElementById("login_user").value;
	var pass=document.getElementById("login_pass").value;
	if(user==""){
		alert("请输入手机号或邮箱");
		document.getElementById("login_user").focus();
		return false;
	}
	
	
	if(pass==""){
		alert("请输入密码");
		document.getElementById("login_pass").focus();
		return false;
	}

	var options = {   
		url:       "index.php?acl=member&method=doLogin",         // override for form's 'action' attribute    
		type:      "post" ,       // 'get' or 'post', override for form's 'method' attribute    
		dataType:  'json',        // 'html','xml', 'script', or 'json' (expected server response type)     
		timeout:   10000,
		beforeSerialize: function(){
			document.getElementById("login_pass").value=md5(pass);
		},
		success:function(responseText, statusText){
			document.getElementById("login_pass").value="";
			if(responseText.result){		
				//执行论坛同步登录的操作				//$("#downloadframe").attr("src",siteUrlPath+"/index.php?acl=member&method=uc_user_synlogin");
							
				var loginJump=WebTools.getCookie("redirectUrl");
				//var redirect=responseText.redirect;
				if(loginJump!=null && loginJump!=""){
					WebTools.deleteCookie("redirectUrl");
					location.href=loginJump;
					return;
				}
				location.href="index.php?acl=member&method=member";
				
			}else{
				alert(responseText.msg);
				//location.reload();
			}
		}
    };
	
	$("#login_form").ajaxSubmit(options);//ajax方式提交表单
	return false;
}

</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>

<div class="mem-com-wrap">
<div class="m-login-tit">用户登录</div>
<form id="login_form" name="login_form">
<div class="mem-inner-wrap">

            <div class="head-portrait"><a><img src="<?=$global->tplUrlPath?>images/head-portrait-img.gif" alt=""></a></div>
            <div class="login-box">
              <div class="pop-layer-btn"><span class="pop-bg1"></span><span class="pop-bg2">
                <input class="pop-input" value="<?=urldecode($_COOKIE["username"])?>" id="login_user" name="content_user" type="text" placeholder="手机号/邮箱">
                </span><span class="pop-bg3"></span></div>
              <div class="pop-layer-btn"><span class="pop-bg1"></span><span class="pop-bg2">
                <input class="pop-input" id="login_pass" name="content_pass" type="password" placeholder="密码"/>
                </span><span class="pop-bg3"></span></div>
                <div class="forgetting-passwords"><span><input type="checkbox" name="remember_pwd" value="1" checked="checked"/>&nbsp;记住密码</span>&nbsp;&nbsp;&nbsp;<a href="<?=$global_link["forgetPassword"]?>" id="php-forget-psw">忘记密码?</a></div>
              <div class="pop-btn-box"><a href="javascript:;" id="php-submit" onClick="submit_login_form()">登录</a>
           
              </div>
            </div>
            
            <div class="clear"></div>
            <div class="third-party login-mar">
              <div class="third-party-text">使用第三方账号登录</div>
              <!--<div class="third-party-ico"><a class="third-ico1" href="javascript:;" id="sina-login"></a><a class="third-ico3" href="javascript:;" id="qq-login"></a>
                <div id="wb_connect_btn" style="display: none;">
                  <div class="WB_loginButton WB_widgets"><a href="javascript:void(0);"><img src="http://timg.sjs.sinajs.cn/t4/appstyle/widget/images/loginButton/loginButton_24.png"></a></div>
                </div>
                <div id="qq_login_btn" style="display: none;"><a href="javascript:;" onClick="return window.open('https://graph.qq.com/oauth2.0/authorize?client_id=100235449&amp;response_type=token&amp;scope=all&amp;redirect_uri=http%3A%2F%2Fwww.topys.cn%2Fconnect%2Fqq', 'oauth2Login_10925' ,'height=525,width=585, toolbar=no, menubar=no, scrollbars=no, status=no, location=yes, resizable=yes');"><img src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_7.png" alt="QQ登录" border="0"></a></div>
              </div>-->
              <div class="third-party-not log-edge">还不是会员？<a href="<?=$global_link["register"]?>" class="php-registered">马上注册！</a></div>
            </div>
          </div>
</form>
</div>


<div class="clear"></div>
<div class="item-height"></div>
<div class="clear"></div>

<!--公共底部-->
<? include($global->tplAbsolutePath."common/member_footer.php"); ?>
</body>
</html>
