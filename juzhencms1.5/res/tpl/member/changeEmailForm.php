<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/jquery.validate.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/extend.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery.form.js" type="text/javascript"></script>
<script>

$(function(){
	
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
					/*alert(responseText.msg);
					location.reload();*/
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
	
	
	
	
	
});

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
<div class="respon-input"><input id="content_email" name="frm[content_email]" placeholder="请输入您的邮箱" type="text" value="<?=$_record["member"]["content_email"]?>"></div>
<div class="respon-tips"></div>
</div>


<div class="responsive-btn">
<a href="#this" onClick="$('#email_form').submit()" class="btns">提交</a>
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
