<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/jquery.validate.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/extend.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery.form.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/md5.js" type="text/javascript"></script>
<script>

$(function(){
	/*$("#show_content_pass").focus(function(){
		var text_value = $(this).val();
		if (text_value == "新密码" || text_value == "") {
			$("#show_content_pass").hide();
			$("#content_pass").show().focus();
		}
	});
	$("#content_pass").blur(function(){
		var text_value = $(this).val();
		if (text_value == "") {
			$("#show_content_pass").show();
			$("#content_pass").hide();
		}				   
	});	  
	
	$("#show_confirm_password").focus(function(){
		var text_value = $(this).val();
		if (text_value == "再次输入" || text_value == "") {
			$("#show_confirm_password").hide();
			$("#confirm_password").show().focus();
		}
	});
	$("#confirm_password").blur(function(){
		var text_value = $(this).val();
		if (text_value == "") {
			$("#show_confirm_password").show();
			$("#confirm_password").hide();
		}		   
	});*/
		    

	$("#resetpwd_form").validate({
		debug:false,//为true时表示只进行验证不提交，用于调试js
		rules: {
			"content_pass": {
				required: true,
				pwd: true
			},
			"confirm_password": {
				required: true,
				//minlength: 6,
				equalTo: "#content_pass"
			}
		},
		messages: {
			"content_pass": {
				required: "请输入新密码",
				minlength: "密码不能小于{0}个字符"
			},
			"confirm_password": {
				required: "请再次输入密码",
				minlength: "密码确认不能小于{0}个字符",
				equalTo: "两次输入的密码不一致"
			}
		},
		
		//验证通过的处理函数					
		submitHandler:function(form){
			//alert("验证通过");   
			//form.submit();//普通方式提交表单
			//return;
			var options = {
				url:       "index.php?acl=member&method=resetPassword_email",         // override for form's 'action' attribute    
				type:      "post" ,       // 'get' or 'post', override for form's 'method' attribute    
				dataType:  'json',        // 'html','xml', 'script', or 'json' (expected server response
				timeout:   10000,
				beforeSerialize: function(){
					document.getElementById("content_pass").value=md5(document.getElementById("content_pass").value);
					document.getElementById("confirm_password").value=md5(document.getElementById("confirm_password").value);
				},
				success:function(responseText,statusText){
						document.getElementById("content_pass").value="";
						document.getElementById("confirm_password").value="";
						
						if(responseText.result){
							location.href="index.php?acl=member&method=resetPasswordSuccess";
						}else{
							$.prompt(responseText.msg,{
								title: "提示",
								buttons: { "确定": 1 },
								submit: function(e,v,m,f){
									location.href="index.php?acl=member&method=forgetPassword_email";
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
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("success");
		},
		errorPlacement: function(error, element) {
			//error.appendTo( element.next() );
			//error.insertAfter( element);
			error.appendTo(element.next().find(".onShow").eq(0));
				
		}
	});



});




</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>




<div class="mem-com-wrap">
<div class="m-login-tit">重置密码</div>
         <div class="head-portrait"><a><img src="<?=$global->tplUrlPath?>images/head-portrait-img.gif" alt=""></a></div><br>
         
<form id="resetpwd_form"> 
<div class="mem-inner-wrap">

<div class="pass-cell">
<!--<input class="setpass" name="" id="show_content_pass" type="text" placeholder="请输入新密码">-->
<input class="setpass"  type="password" name="content_pass" id="content_pass" placeholder="请输入新密码"/>
<div class="frm-tips"><em class="onShow"></em></div>
</div>

<div class="pass-cell">
<!--<input class="setpass" name="" id="show_confirm_password" type="text" placeholder="再次输入新密码">-->
<input class="setpass"  type="password" name="confirm_password" id="confirm_password" placeholder="再次输入新密码"/>
<div class="frm-tips"><em class="onShow"></em></div>
</div>

<div class="coms-btn"><a href="javascript:" onClick="$('#resetpwd_form').submit()">提交</a></div>
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
