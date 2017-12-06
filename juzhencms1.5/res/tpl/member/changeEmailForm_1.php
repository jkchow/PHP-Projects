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
					url: "index.php?acl=member&method=getChangeEmailMsg_1",
					dataType:'json',
					data:"validateNUM="+encodeURI(document.getElementById("validateNUM").value),
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
									$(obj).html("获取验证码");
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
	
}

//执行找回密码的下一步
function forgetPwdNextStep(){
	//判断手机号是否输入
	
	if(document.getElementById("mobile_randnum").value==""){
		alert("请输入验证码");
		document.getElementById("mobile_randnum").focus();
		return false;
	}
	
	
	$.ajax({
		type: "post",
		url: "index.php?acl=member&method=validateEmailMsg_1",
		data:"email_randnum="+encodeURI(document.getElementById("mobile_randnum").value),
		dataType:'json',
		success:function(data){
			
			if(data.result==1){
				$.prompt(data.msg, {
					title: "提示",
					buttons: { "确定": 1 },
					close: function(e,v,m,f){
						location.href="index.php?acl=member&method=changeEmailForm_2";
					}
				});
				
			}else{
				$.prompt(data.msg, {
					title: "提示",
					buttons: { "确定": 1 },
					close: function(e,v,m,f){
						location.reload();
					}
				});
			}
			
		}
	});
}


/*$(function(){
	$("#regValidateImg").click(function(){
		var timenow = new Date().getTime();
		$(this).attr("src","index.php?acl=img&method=validateImg&timenow="+timenow);						
	});
	var timenow = new Date().getTime();
	$("#regValidateImg").attr("src","?acl=img&method=validateImg&timenow="+timenow);
	$("#regValidateImg").show();
});
function edit_email (email) {
	if(document.getElementById("validateNUM").value=="" || document.getElementById("validateNUM").value=="输入验证码"){
		WebTools.impromptuAlert("请输入验证码");
		document.getElementById("validateNUM").focus();
		return false;
	}
	if(email){
			window.location.href=siteUrlPath+"/index.php?acl=member&method=member_email_sendsuccess&email="+email;
	}else{
		alert(邮箱不能为空);
	}
}*/
</script>

</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<div class="mem-inners-r">
<div class="mem-toptits">修改邮箱</div>
<div class="mems-wraps">

<form id="email_form">
<div class="responsive-frms">




<div class="respon-cell"><div class="respon-tits">邮箱:</div>
<div class="frm-text"><?=$_record["member"]["content_email"]?></div>
<div class="respon-tips"></div>
</div>

<div class="respon-cell respon-yzm"><div class="respon-tits">验证码:</div>
<div class="respon-input"><input name="mobile_randnum" id="mobile_randnum" placeholder="请输入验证码" type="text"></div><a href="javascript:" onClick="getResetPasswordMobileMsg(this)" class="small-btn">获取验证码</a><!--验证等待样式 small-btn-grey-->
<div class="respon-tips"></div>
</div>


<!--<div class="respon-cell respon-yzm"><div class="respon-tits">验证码:</div>
<div class="respon-input"><input class="pop-reg-input" name="validateNUM" id="validateNUM" type="text" placeholder="输入验证码"/></div><a  href="javascript:;"><img id="regValidateImg" width="86" height="40" style="display:none; cursor:pointer;"/></a>
<div class="respon-tips"></div>
</div>-->

<div class="responsive-btn">
<a href="javascript:;" onClick="forgetPwdNextStep()" class="btns">下一步</a>
</div>

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
