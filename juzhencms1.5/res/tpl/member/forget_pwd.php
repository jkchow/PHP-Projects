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
		//alert("请稍后再进行操作");
		return;
	}
	
	//判断手机号是否输入
	if(document.getElementById("content_mobile").value==""){
		WebTools.impromptuAlert("请填写您注册的手机号");
		document.getElementById("content_mobile").focus();
		return ;
	}else{
		var mobile_reg = new RegExp('^[1][3578][0-9]{9}$');
		if(!mobile_reg.test(document.getElementById("content_mobile").value)){
			WebTools.impromptuAlert("输入的手机号格式不正确");
			document.getElementById("content_mobile").focus();
			return ;
		}	
	}
	
	
	var timenow = new Date().getTime();
	$.prompt('<div style="height:50px;"><input id="validateNUM" type="text" style="width:145px;height:28px;"/> <a href="javascript:changeValidateImg()" style="position:relative; top:11px;"><img id="validateImg" src="'+siteUrlPath+'/index.php?acl=img&method=validateImg&timenow='+timenow+'" width="65" height="32"/></a> <a href="javascript:changeValidateImg()" style="position:relative; top:4px;">看不清楚，换一张</a></div>', {
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
					url: "index.php?acl=member&method=getResetPasswordMobileMsg",
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
							WebTools.impromptuAlert(data.msg);
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
	if(document.getElementById("content_mobile").value==""){
		WebTools.impromptuAlert("请输入注册手机号");
		document.getElementById("content_mobile").focus();
		return false;
	}else{
		var mobile_reg = new RegExp('^[1][3578][0-9]{9}$');
		if(!mobile_reg.test(document.getElementById("content_mobile").value)){
			WebTools.impromptuAlert("输入的手机号格式不正确");
			document.getElementById("content_mobile").focus();
			return false;
		}	
	}
	
	if(document.getElementById("mobile_randnum").value==""){
		WebTools.impromptuAlert("请输入短信验证码");
		document.getElementById("mobile_randnum").focus();
		return false;
	}
	
	
	$.ajax({
		type: "post",
		url: "index.php?acl=member&method=checkResetPasswordMobileMsg",
		data:"mobile_randnum="+encodeURI(document.getElementById("mobile_randnum").value),
		dataType:'json',
		success:function(data){
			
			//alert(data.msg);
			
			
			$.prompt(data.msg, {
				title: "提示",
				buttons: { "确定": 1 },
				submit: function(e,v,m,f){
					if(data.result){
						location.href="index.php?acl=member&method=resetPasswordForm";
					}
					
				}
			});
		}
	});
}


</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>




<div class="mem-com-wrap">
<div class="m-login-tit">忘记密码</div>
<div class="mem-inner-wrap">

            <div class="head-portrait"><a><img src="<?=$global->tplUrlPath?>/images/head-portrait-img.gif" alt=""></a></div>
            <div class="login-box">
              <div class="pop-layer-btn"><span class="pop-bg1"></span><span class="pop-bg2">
                <input class="pop-input" name="content_mobile" id="content_mobile" value="" placeholder="请输入手机号" type="text">
                </span><span class="pop-bg3"></span></div>
              
                <div class="pop-layer-btn">
                            <div class="per-regs">
                                <span class="pop-bg1"></span>
                                <span class="pop-bg2 personal">
                                    <input class="pop-reg-input" name="mobile_randnum" id="mobile_randnum" type="text" placeholder="输入验证码" />
                                </span>
                                <span class="pop-bg3"></span>
                            </div>
                           
                           <div class="get-btn"><a href="javascript:" onclick="getResetPasswordMobileMsg(this)">获取验证码</a></div>
                        </div>
 <br>
<br>

              <div class="pop-btn-box"><a href="javascript:" onclick="forgetPwdNextStep()">下一步</a>

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
