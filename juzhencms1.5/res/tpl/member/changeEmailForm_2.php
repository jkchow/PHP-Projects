<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/jquery.validate.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/extend.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery.form.js" type="text/javascript"></script>
<script>

//发送短信验证码的计时任务
var msgTimeTask;

function changeValidateImg(){
	var timenow = new Date().getTime();
	$("#validateImg").attr("src",siteUrlPath+"/index.php?acl=img&method=validateImg&timenow="+timenow);
}

//获取找回密码的短信验证码
function getResetPasswordMobileMsg(obj){
	if($(obj).hasClass("get-vode-grey")){
		alert("请稍后再进行操作");
		return;
	}
	
	//判断手机号是否输入
	if(document.getElementById("content_email").value==""){
		alert("请填写您的邮箱");
		document.getElementById("content_email").focus();
		return false;
	}else{
		var mobile_reg = new RegExp('^([a-zA-Z0-9\-]+[_|\\_|\\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\\_]?)+\\.[a-zA-Z]{2,10}(\\.[a-zA-Z]{2,3})?$');
		if(!mobile_reg.test(document.getElementById("content_email").value)){
			alert("输入的邮箱格式不正确");
			document.getElementById("content_email").focus();
			return false;
		}	
	}
	
	var timenow = new Date().getTime();
	$.prompt('<div style="height:50px;"><input id="validateNUM" type="text" style="width:125px;height:28px;display:inline-block;border:#ccc 1px solid;"/> <a href="javascript:changeValidateImg()" style="display:inline-block;"><img style="height:28px;position:relative; top:9px;" id="validateImg" src="'+siteUrlPath+'/index.php?acl=img&method=validateImg&timenow='+timenow+'"/></a> <a href="javascript:changeValidateImg()" style="position:relative; top:4px;">换一张</a></div>', {
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
					url: "index.php?acl=member&method=getChangeEmailMsg_2",
					dataType:'json',
					data:"content_email="+encodeURI(document.getElementById("content_email").value)+"&validateNUM="+encodeURI(document.getElementById("validateNUM").value),
					success:function(data){
						if(data.result){
							
							$.prompt(data.msg, {
								title: "提示",
								buttons: { "确定": 1 },
								close: function(e,v,m,f){
									//location.href="index.php?acl=member&method=changeEmailForms";
								}
							});
							
							/*$(obj).addClass("get-vode-grey");
							var lastSecond=60;
							msgTimeTask=window.setInterval(function(){
								if(lastSecond<=0){
									window.clearInterval(msgTimeTask);
									$(obj).html("获取短信验证码");
									$(obj).removeClass("get-vode-grey");
								}else{
									lastSecond=lastSecond-1;
									$(obj).html(lastSecond+"秒后重试");
								}
							}, 1000);*/
						}else{
							window.clearInterval(msgTimeTask);
							$(obj).removeClass("get-vode-grey");
							alert(data.msg);
						}
					}
				});
				
			}
			
			
		}
	});
	return;
}

//执行找回密码的下一步
function forgetPwdNextStep(){
	//判断手机号是否输入
	if(document.getElementById("content_email").value==""){
		alert("请输入您的新邮箱");
		document.getElementById("content_email").focus();
		return false;
	}else{
		var mobile_reg =new RegExp('^([a-zA-Z0-9\-]+[_|\\_|\\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\\_]?)+\\.[a-zA-Z]{2,10}(\\.[a-zA-Z]{2,3})?$');
		if(!mobile_reg.test(document.getElementById("content_email").value)){
			alert("输入的邮箱格式不正确");
			document.getElementById("content_email").focus();
			return false;
		}	
	}
	
	if(document.getElementById("mobile_randnum").value==""){
		alert("请输入验证码");
		document.getElementById("mobile_randnum").focus();
		return false;
	}
	
	
	$.ajax({
		type: "post",
		url: "index.php?acl=member&method=saveMemberEmail",
		data:"content_email="+encodeURI(document.getElementById("content_email").value)+"&email_randnum="+encodeURI(document.getElementById("mobile_randnum").value),
		dataType:'json',
		success:function(data){
			$.prompt(data.msg, {
				title: "提示",
				buttons: { "确定": 1 },
				close: function(e,v,m,f){
					location.href="index.php?acl=member";
				}
			});
		}
	});
}



/*$(function(){
	
	$("#email_form").validate({
		debug:false,//为true时表示只进行验证不提交，用于调试js
		rules: {
			
			"frm[content_email]": {
			 	required: true,
			 	email: true,
				remote: {
					url: "index.php?acl=member&method=checkEditEmail",     //后台处理程序,后台程序只能输出"true"或者"false"
					type: "post",               //数据发送方式
					dataType: "json",           //接受数据格式   
					data: {                     //要传递的数据
						content_email: function() {
							return $("#content_email").val();
						}
					}
				}
			}	
		},
        messages: {
			"frm[content_email]": {
			 	required: "请输入您的邮箱",
			 	email: "请输入正确的邮箱",
				remote: "此邮箱已被注册，请更换"
			}
		},
		
		//验证通过的处理函数			
		submitHandler:function(form){
            //alert("验证通过");
            //form.submit();//普通方式提交表单
			//return;
			var options = {
			    url:       "index.php?acl=member&method=saveEmail",         // override for form's 'action' attribute    
			    type:      "post" ,       // 'get' or 'post', override for form's 'method' attribute    
			    dataType:  'json',        // 'html','xml', 'script', or 'json' (expected server response type)       
			    timeout:   10000,
			    success:function(responseText, statusText){
					if(responseText!=null && responseText.result=="1"){
						$.prompt(responseText.msg, {
							title: "提示",
							buttons: { "确定": 1 },
							close: function(e,v,m,f){
								location.href="index.php?acl=member&method=member";
							}
						});
					}else{
						$.prompt(responseText.msg, {
							title: "提示",
							buttons: { "确定": 1 },
							close: function(e,v,m,f){
								location.reload();
							}
						});
					}
					
					
					
				}
		   };
			
			$(form).ajaxSubmit(options);//ajax方式提交表单
        },
		onfocusout: function(element){
			$(element).valid();
		},
		errorPlacement: function(error, element) {
			if(element.attr("id")=="validateNUM" || element.attr("id")=="mobile_randnum"){
				error.appendTo(element.parent().next().next());
			}else{
			    error.appendTo(element.parent().next());
			}
				
		}
	});
	
	
	
	
	
});*/

</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<div class="mem-inners-r">
<div class="mem-toptits">新邮箱</div>
<div class="mems-wraps">

<form id="email_form">
<div class="responsive-frms">




<div class="respon-cell"><div class="respon-tits">新邮箱:</div>
<div class="respon-input"><input id="content_email" name="frm[content_email]" placeholder="请输入您的新邮箱" type="text" value=""></div>
<div class="respon-tips"></div>
</div>

<div class="respon-cell respon-yzm"><div class="respon-tits">验证码:</div>
<div class="respon-input"><input name="mobile_randnum" id="mobile_randnum" placeholder="请输入验证码" type="text"></div><a href="javascript:" onClick="getResetPasswordMobileMsg(this)" class="small-btn">获取验证码</a><!--验证等待样式 small-btn-grey-->
<div class="respon-tips"></div>
</div>


<div class="responsive-btn">
<a href="javascript:" onClick="forgetPwdNextStep()" class="btns">提交</a>
</div>


<!--<div class="responsive-btn">
<a href="#this" onClick="$('#email_form').submit()" class="btns">提交</a>
</div>-->

</div>
</form>


</div>


</div>

</div>


</div>

<div class="clear"></div>
<div class="item-height"></div>
<div class="clear"></div>

<!--公共底部-->
<? include($global->tplAbsolutePath."common/member_footer.php"); ?>

</body>
</html>
