<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/jquery.validate.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/extend.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/md5.js" type="text/javascript"></script>
<script>
//发送短信验证码的计时任务
var msgTimeTask;

//获取找回密码的短信验证码
function getRegMobileMsg(obj){
	
	if($(obj).hasClass("get-vode-grey")){
		return;
	}
	
	//判断手机号是否输入
	if(document.getElementById("content_mobile").value=="" || document.getElementById("content_mobile").value=="手机号"){
		WebTools.impromptuAlert("请填写您的手机号");
		document.getElementById("content_mobile").focus();
		return;
	}else{
		var mobile_reg = new RegExp('^[1][3578][0-9]{9}$');
		if(!mobile_reg.test(document.getElementById("content_mobile").value)){
			WebTools.impromptuAlert("输入的手机号格式不正确");
			document.getElementById("content_mobile").focus();
			return;
		}	
	}
	
	var timenow = new Date().getTime();
	$.prompt('<div style="height:50px;"><input id="validateNUM" type="text" style="width:145px;height:28px;"/> <a href="javascript:WebTools.changeValidateImg(\'validateImg\')" style="position:relative; top:11px;"><img id="validateImg" src="'+siteUrlPath+'/index.php?acl=img&method=validateImg&timenow='+timenow+'" width="65" height="32"/></a> <a href="javascript:WebTools.changeValidateImg(\'validateImg\')" style="position:relative; top:4px;">看不清楚，换一张</a></div>', {
		title: "请输入验证码",
		buttons: { "确定": 1 ,"取消":0},
		submit: function(e,v,m,f){
			if(v==1){
				//ajax提交，如果出错则再弹出提示框
				if($("#validateNUM").val()==""){
					alert("请输入验证码");
					return false;
				}
				
				$.ajax({
					type: "post",
					url: siteUrlPath+"/index.php?acl=member&method=getRegMobileMsg",
					dataType:'json',
					data:"content_mobile="+encodeURI(document.getElementById("content_mobile").value)+"&validateNUM="+encodeURI(document.getElementById("validateNUM").value),
					success:function(data){
						if(data.result){
							$(obj).addClass("get-vode-grey");
							var lastSecond=60;
							msgTimeTask=window.setInterval(function(){
								if(lastSecond<=0){
									window.clearInterval(msgTimeTask);
									$(obj).html("获取验证码");
									$(obj).removeClass("get-vode-grey");
								}else{
									lastSecond=lastSecond-1;
									$(obj).html(lastSecond+"秒后重试");
								}
							}, 1000);
						}else{
							window.clearInterval(msgTimeTask);
							$(obj).removeClass("get-vode-grey");
							WebTools.impromptuAlert(data.msg);
						}
					}
				});	
				
			}
			
			
		}
	});

}




$(function(){
	$("#regValidateImg").click(function(){
		var timenow = new Date().getTime();
		$(this).attr("src","index.php?acl=img&method=validateImg&timenow="+timenow);						
	});
	var timenow = new Date().getTime();
	$("#regValidateImg").attr("src","?acl=img&method=validateImg&timenow="+timenow);
	$("#regValidateImg").show();
	
	
	$("#reg_form").validate({
		debug:false,//为true时表示只进行验证不提交，用于调试js
		
		rules: {
			
			/*"frm[content_user]": {
				required:true,
				username:true,
				remote: {
					url: "index.php?acl=member&method=checkRegUsername",     //后台处理程序,后台程序只能输出"true"或者"false"
					type: "post",               //数据发送方式
					dataType: "json",           //接受数据格式   
					data: {                     //要传递的数据
						content_user: function() {
							return $("#content_user").val();
						}
					}
				}
			},*/
			"frm[content_mobile]": {
			 	required:true,
			 	mobile:true,
				remote: {
					url: "index.php?acl=member&method=checkRegMobile",     //后台处理程序,后台程序只能输出"true"或者"false"
					type: "post",               //数据发送方式
					dataType: "json",           //接受数据格式   
					data: {                     //要传递的数据
						content_mobile: function() {
							return $("#content_mobile").val();
						}
					}
				}
			},
			"mobile_randnum": {
			 	required: true
			},
			
			
			"frm[content_email]": {
			 	required: false,
			 	email: true,
				remote: {
					url: "index.php?acl=member&method=checkRegEmail",     //后台处理程序,后台程序只能输出"true"或者"false"
					type: "post",               //数据发送方式
					dataType: "json",           //接受数据格式   
					data: {                     //要传递的数据
						content_email: function() {
							return $("#content_email").val();
						}
					}
				}
			},
			
			
			"frm[content_pass]": {
			 	required: true,
			 	pwd: true
			},
			"confirm_password": {
			 	required: true,
				//minlength: 6,
			 	equalTo: "#content_pass"
			}
			
			
			
			/*"frm[content_qq]": {
			 	required: true,
				qq: true,
				remote: {
					url: "index.php?acl=member&method=checkRegQQ",     //后台处理程序,后台程序只能输出"true"或者"false"
					type: "post",               //数据发送方式
					dataType: "json",           //接受数据格式   
					data: {                     //要传递的数据
						content_qq: function() {
							return $("#content_qq").val();
						}
					}
				}
			},*/
			
			
			
			/*"validateNUM": {
			 	required: true
			}*/
			
			
		},
        messages: {
			"frm[content_user]": {
				required: "请输入用户名",
				remote: "此用户名已被注册，请更换"
			},
			
			"frm[content_mobile]": {
			 	required:"请输入您的手机号",
			 	mobile:"请输入正确的手机号",
				remote: "手机号已被注册，请使用其他手机号"
			},
			"mobile_randnum": {
				required:"请输入短信验证码"
			},
			
			"frm[content_email]": {
			 	required: "请输入您的邮箱",
			 	email: "请输入正确的邮箱",
				remote: "此邮箱已被注册，请使用其他邮箱注册"
			},
			"frm[content_pass]": {
			 	required: "请输入密码",
			 	minlength: jQuery.validator.format("密码不能小于{0}个字符")
			},
			"confirm_password": {
			 	required: "请再次输入密码",
			 	minlength: "密码不能小于{0}个字符",
			 	equalTo: "两次输入密码不一致"
			},
			"validateNUM": {
			 	required: "请输入验证码"
			}
			
		},
		
		//验证通过的处理函数					
		submitHandler:function(form){
            //alert("验证通过");   
            //form.submit();//普通方式提交表单
			//return;
			var options = {   
			    url:       "index.php?acl=member&method=saveRegister",         // override for form's 'action' attribute    
			    type:      "post" ,       // 'get' or 'post', override for form's 'method' attribute    
			    dataType:  'json',        // 'html','xml', 'script', or 'json' (expected server response type)       
			    timeout:   10000,
			    beforeSerialize: function(){
					document.getElementById("content_pass").value=md5(content_pass);
					document.getElementById("confirm_password").value=md5(content_pass);
				},
				success:function(responseText, statusText){
					document.getElementById("content_pass").value="";
					document.getElementById("confirm_password").value="";
					if(responseText.result){
						
						
						//执行论坛同步登录的操作
						//$("#downloadframe").attr("src",siteUrlPath+"/index.php?acl=member&method=uc_user_synlogin");
						
						$.prompt(responseText.msg, {
							title: "提示",
							buttons: { "确定": 1 },
							close: function(e,v,m,f){
								var redirectUrl=WebTools.getCookie("redirectUrl");
								if(redirectUrl!=null && redirectUrl!=""){
									deleteCookie("redirectUrl");
									location.href=redirectUrl;
								}else{
									location.href=siteUrlPath+"/index.php?acl=member&method=member";
								}
							}
						});
						
						//alert(responseText.msg);
						/*setTimeout(function(){
							var redirectUrl=getCookie("redirectUrl");
							if(redirectUrl!=null && redirectUrl!=""){
								deleteCookie("redirectUrl");
								location.href=redirectUrl;
							}else{
								location.href=siteUrlPath+"/index.php?acl=member&method=member";
							}			
						},0);*/
						
					}else{
						alert(responseText.msg);
						//return;
						location.reload();
					}
				}
		   };
			
			$(form).ajaxSubmit(options);//ajax方式提交表单
        },
		onfocusout: function(element){	
			$(element).valid();
		},
		/*success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("success");
		},*/
		errorPlacement: function(error, element) {		
			if(element.attr("id")=="validateNUM" || element.attr("id")=="mobile_randnum"){
				error.appendTo(element.parent().next().next().find(".onShow").eq(0));
			}else{
			    error.appendTo(element.parent().next().find(".onShow").eq(0));
			}
				
		}
	});

});
</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>




<div class="mem-com-wrap">
<div class="m-login-tit">用户注册</div>
<div class="mem-inner-wrap">

            <div class="head-portrait"><a><img src="<?=$global->tplUrlPath?>images/head-portrait-img.gif" alt=""></a></div>
<form id="reg_form">         
<div class="adjust-frm">


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>手机号:</div>
<div class="frm-inputs"><input name="frm[content_mobile]" id="content_mobile" type="text"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>

<div class="frm-cell frm-yzm">
<div class="frm-tit"><font class="redclass">*</font>验证码:</div>
<div class="frm-inputs"><input name="mobile_randnum" id="mobile_randnum" type="text"></div>
<a href="javascript:" onClick="getRegMobileMsg(this);" class="jh-css">获取验证码</a>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass"></font>邮箱:</div>
<div class="frm-inputs"><input name="frm[content_email]" id="content_email" type="text"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>密码:</div>
<div class="frm-inputs"><input id="content_pass" name="frm[content_pass]" type="password"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>

<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>确认密码:</div>
<div class="frm-inputs"><input id="confirm_password" name="confirm_password" type="password"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>












<div class="frm-cell frm-regbtn">
<div class="frms-btns"><a href="javascript:" onClick="$('#reg_form').submit();">注册</a></div>

</div>


</div>
</form>
          
          </div>


</div>

<div class="clear"></div>
<div class="item-height"></div>
<div class="clear"></div>

<!--公共底部-->
<? include($global->tplAbsolutePath."common/member_footer.php"); ?>
</body>
</html>
