<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
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
	if(document.getElementById("content_mobile").value==""){
		alert("请填写您的手机号");
		document.getElementById("content_mobile").focus();
		return false;
	}else{
		var mobile_reg = new RegExp('^[1][3578][0-9]{9}$');
		if(!mobile_reg.test(document.getElementById("content_mobile").value)){
			alert("输入的手机号格式不正确");
			document.getElementById("content_mobile").focus();
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
					url: "index.php?acl=member&method=getChangeMobileMsg_2",
					dataType:'json',
					data:"content_mobile="+encodeURI(document.getElementById("content_mobile").value)+"&validateNUM="+encodeURI(document.getElementById("validateNUM").value),
					success:function(data){
						if(data.result){
							$(obj).addClass("get-vode-grey");
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
							}, 1000);
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
	
	
	
	//发送请求
	$.ajax({
		type: "post",
		url: "index.php?acl=member&method=getResetPasswordMobileMsg",
		dataType:'json',
		data:"content_mobile="+encodeURI(document.getElementById("content_mobile").value),
		success:function(data){
			if(data.result){
				msgFlag=false;
				setTimeout(function(){msgFlag=true;},300000);
			}
			alert(data.msg);
		}
	});
}

//执行找回密码的下一步
function forgetPwdNextStep(){
	//判断手机号是否输入
	if(document.getElementById("content_mobile").value==""){
		alert("请输入您的新手机号");
		document.getElementById("content_mobile").focus();
		return false;
	}else{
		var mobile_reg = new RegExp('^[1][3578][0-9]{9}$');
		if(!mobile_reg.test(document.getElementById("content_mobile").value)){
			alert("输入的手机号格式不正确");
			document.getElementById("content_mobile").focus();
			return false;
		}	
	}
	
	if(document.getElementById("mobile_randnum").value==""){
		alert("请输入短信验证码");
		document.getElementById("mobile_randnum").focus();
		return false;
	}
	
	
	$.ajax({
		type: "post",
		url: "index.php?acl=member&method=saveMemberMobile",
		data:"content_mobile="+encodeURI(document.getElementById("content_mobile").value)+"&mobile_randnum="+encodeURI(document.getElementById("mobile_randnum").value),
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


</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<div class="mem-inners-r">
<div class="mem-toptits">修改手机号</div>
<div class="mems-wraps">

<div class="responsive-frms">








<div class="respon-cell"><div class="respon-tits">新手机号:</div>
<div class="respon-input"><input id="content_mobile" name="content_mobile" placeholder="请输入您新的手机号" type="text"></div>
<div class="respon-tips"></div>
</div>

<div class="respon-cell respon-yzm"><div class="respon-tits">验证码:</div>
<div class="respon-input"><input name="mobile_randnum" id="mobile_randnum" placeholder="请输入验证码" type="text"></div><a href="javascript:" onClick="getResetPasswordMobileMsg(this)" class="small-btn">获取验证码</a><!--验证等待样式 small-btn-grey-->
<div class="respon-tips"></div>
</div>


<div class="responsive-btn">
<a href="javascript:" onClick="forgetPwdNextStep()" class="btns">提交</a>
</div>















</div>



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
