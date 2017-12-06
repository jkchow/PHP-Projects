<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script>
$(function(){
	$("#regValidateImg").click(function(){
		var timenow = new Date().getTime();
		$(this).attr("src","index.php?acl=img&method=validateImg&timenow="+timenow);						
	});
	var timenow = new Date().getTime();
	$("#regValidateImg").attr("src","?acl=img&method=validateImg&timenow="+timenow);
	$("#regValidateImg").show();
});

//执行找回密码的下一步
function forgetPwdNextStep(){
	//判断邮箱是否输入
	if(document.getElementById("content_email").value=="" || document.getElementById("content_email").value=="请输入邮箱"){
		WebTools.impromptuAlert("请输入注册邮箱");
		document.getElementById("content_email").focus();
		return false;
	}else{
		var email_reg = new RegExp('^([a-zA-Z0-9\-]+[_|\\_|\\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\\_]?)+\\.[a-zA-Z]{2,10}(\\.[a-zA-Z]{2,3})?$');
		
		if(!email_reg.test(document.getElementById("content_email").value)){
			WebTools.impromptuAlert("输入的邮箱格式不正确");
			document.getElementById("content_email").focus();
			return false;
		}	
	}
	
	if(document.getElementById("validateNUM").value=="" || document.getElementById("validateNUM").value=="输入验证码"){
		WebTools.impromptuAlert("请输入验证码");
		document.getElementById("validateNUM").focus();
		return false;
	}
	
	
	$.ajax({
		type: "post",
		url: "index.php?acl=member&method=sendResetPasswordEmail",
		data:"validateNUM="+encodeURI(document.getElementById("validateNUM").value)+"&content_email="+encodeURI(document.getElementById("content_email").value),
		dataType:'json',
		success:function(data){
			
			if(data.result){
				location.href="index.php?acl=member&method=resetPassword_email_sendsuccess&email="+encodeURI(document.getElementById("content_email").value);
			}else{
				$.prompt(data.msg, {
					title: "提示",
					buttons: { "确定": 1 },
					submit: function(e,v,m,f){
						
					}
				});
			}	
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
                <input class="pop-input" id="content_email" name="content_email" placeholder="请输入邮箱" type="text">
                </span><span class="pop-bg3"></span></div>
              
                <div class="pop-layer-btn">
                            <div class="per-regs">
                                <span class="pop-bg1"></span>
                                <span class="pop-bg2 personal">
                                    <input class="pop-reg-input" name="validateNUM" id="validateNUM" type="text" placeholder="输入验证码"/>
                                </span>
                                <span class="pop-bg3"></span>
                            </div>
                           
                           <div class="get-btn"><img id="regValidateImg" width="86" height="30" style="display:none; cursor:pointer;"/></div>
                        </div>
 <br>
<br>

              <div class="pop-btn-box"><a href="javascript:forgetPwdNextStep()">下一步</a>

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
