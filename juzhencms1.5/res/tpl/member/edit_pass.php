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

	$("#editpwd_form").validate({
		debug:false,//为true时表示只进行验证不提交，用于调试js
		rules: {
			"old_pass": {
			 	required: true
			},
			"new_pass": {
			 	required: true,
			 	pwd: true
			},
			"confirm_password": {
			 	required: true,
				//minlength: 6,
			 	equalTo: "#new_pass"
			}
		},
        messages: {
			"old_pass": {
			 	required: "请输入原密码"
			},
			"new_pass": {
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
			    url:       "index.php?acl=member&method=savePassword",         // override for form's 'action' attribute    
			    type:      "post" ,       // 'get' or 'post', override for form's 'method' attribute    
			    dataType:  'json',        // 'html','xml', 'script', or 'json' (expected server response
			    timeout:   10000,
				beforeSerialize: function(){
					document.getElementById("old_pass").value=md5(document.getElementById("old_pass").value);
					document.getElementById("new_pass").value=md5(document.getElementById("new_pass").value);
					document.getElementById("confirm_password").value=md5(document.getElementById("confirm_password").value);
				},
			    success:function(responseText,statusText){
						document.getElementById("old_pass").value="";
						document.getElementById("new_pass").value="";
						document.getElementById("confirm_password").value="";
						
						$.prompt(responseText.msg, {
							title: "提示",
							buttons: { "确定": 1 },
							close: function(e,v,m,f){
								if(responseText.result=="1"){
									location.href=siteUrlPath+"/index.php?acl=member&method=member";
								}else{
									location.reload();
								}
								
							}
						});	
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



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<div class="mem-inners-r">
<div class="mem-toptits">修改密码</div>
<div class="mems-wraps">
<form id="editpwd_form">
<div class="adjust-frm">

<!--<div class="frm-cell">
<div class="frm-tit">邮箱:</div>
<div class="frm-text">textvips</div>
</div>-->

<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>旧密码:</div>
<div class="frm-inputs"><input class="comm-inputs" id="old_pass" name="old_pass" type="password" /></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>

<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>新密码:</div>
<div class="frm-inputs"><input class="comm-inputs" id="new_pass" name="new_pass" type="password" /></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>

<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>确认密码:</div>
<div class="frm-inputs"><input class="comm-inputs" id="confirm_password" name="confirm_password" type="password" /></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>





<!--<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>验证码:</div>
<div class="frm-inputs"><input class="comtexts" name="" type="text"></div><div class="codes-css"><img src="images/yzm.jpg" width="86" height="30"></div>
</div>-->

<div class="frm-cell"><div class="frm-tit">&nbsp;</div>
  <div class="frms-btns"><a href="javascript:" onClick="$('#editpwd_form').submit()">提交</a></div>

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
