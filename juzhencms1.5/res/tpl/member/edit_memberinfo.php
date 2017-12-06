<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/jquery.validate.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery-validation-1.13.0/extend.js" type="text/javascript"></script>
<script src="<?=$global->sysTplUrlPath?>js/jquery.form.js" type="text/javascript"></script>
<script>
$(function(){
		   
	$("#regValidateImg").click(function(){
		var timenow = new Date().getTime();
		$(this).attr("src","index.php?acl=img&method=validateImg&timenow="+timenow);						
	});
	var timenow = new Date().getTime();
	$("#regValidateImg").attr("src","?acl=img&method=validateImg&timenow="+timenow);
	$("#regValidateImg").show();	   
		   
		   
	$("#province_id").change(function(){
		var province_id	=$(this).val();
		var city_id	=$("#city_id").val();
		showCitySelect(province_id,city_id);
	});
	
	
	$("#memberinfo_form").validate({
		debug:false,//为true时表示只进行验证不提交，用于调试js
		rules: {
			
			
			"frm[content_name]": {
				required: true
			},
			"frm[content_sex]": {
				required: true
			},
			/*"frm[content_email]": {
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
			},*/
			
			/*"frm[content_mobile]": {
			 	required:true,
			 	mobile:true,
				remote: {
					url: "index.php?acl=member&method=checkEditMobile",     //后台处理程序,后台程序只能输出"true"或者"false"
					type: "post",               //数据发送方式
					dataType: "json",           //接受数据格式   
					data: {                     //要传递的数据
						content_mobile: function() {
							return $("#content_mobile").val();
						}
					}
				}
			},*/
			/*"frm[city_id]": {
				required: true
			},*/
			"frm[content_address]": {
				required: true
			},
			
			"validateNUM": {
			 	required: true
			}
			
			
			
		},
        messages: {
			"frm[content_name]": {
				required: "请输入您的姓氏"
			},
			"frm[content_sex]": {
				required: "请选择您的性别"
			},
			"frm[content_mobile]": {
			 	required:"请输入您的手机号",
			 	mobile:"请输入正确的手机号",
				remote: "手机号已被注册，请使用其他手机号"
			},
			
			"frm[content_address]": {
			 	required: "请输入您的联系地址"
			},
			"frm[content_email]": {
			 	required: "请输入您的邮箱",
			 	email: "请输入正确的邮箱",
				remote: "此邮箱已被注册，请更换"
			},
			
			"validateNUM": {
			 	required: "请输入验证码"
			}/*,
			"mobile_randnum": {
			 	required: "请输入短信验证码"
			}*/
		},
		
		//验证通过的处理函数					
		submitHandler:function(form){
            //alert("验证通过");   
            //form.submit();//普通方式提交表单
			//return;
			var options = {   
			    url:       "index.php?acl=member&method=saveInfo",         // override for form's 'action' attribute    
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
								location.href="index.php?acl=member&method=memberInfo";
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
				error.appendTo(element.parent().next().next().find(".onShow").eq(0));
			}else{
			    error.appendTo(element.parent().next().find(".onShow").eq(0));
			}
				
		}
	});
	
	
	
	var province_id	=$("#province_id").val();
	var city_id	="<?=$member["city_id"]?>";
	showCitySelect(province_id,city_id);
});

//根据省份ID，城市ID，显示城市select表单
function showCitySelect(province_id,city_id){
	
	$.ajax({
		url:"index.php?acl=area&method=cityData&pid="+province_id+"&selectedId="+city_id,
		dataType:'json',
		success:function(arr){
			if(typeof arr !='object')//将得到的数据转换成json对象	
				arr = eval('('+ arr +')');
		
			var obj=document.getElementById("city_id");
			obj.options.length=1;
			for(i=0;i<arr.length;i++){
				if(arr[i]["selected"]!=null)
					obj.options[i+1]=new Option(arr[i]["text"],arr[i]["id"],true,true);
				else
					obj.options[i+1]=new Option(arr[i]["text"],arr[i]["id"]);
			}
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
<div class="mem-toptits">基本信息</div>
<div class="mems-wraps">
<form id="memberinfo_form">
<div class="adjust-frm">

<!--<div class="frm-cell">
<div class="frm-tit">邮箱:</div>
<div class="frm-text">testvip</div>
</div>-->
<!--<div class="frm-cell">
<div class="frm-tit">头像:</div>
<div class="frm-uploads"><div class="myheads"><img src="images/mempic.jpg" width="100" height="100"></div>
<div class="uploads-logos"><a href="#">上传头像</a></div>
</div>
</div>-->


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>昵称:</div>
<div class="frm-inputs"><input id="content_name" name="frm[content_name]" type="text" value="<?=$member["content_name"]?>"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>性别:</div>
<div class="frm-select">
<?
$DictionaryVars=new DictionaryVars();
if(is_array($enumVars["sexVars"]))
foreach($enumVars["sexVars"] as $key=>$vl){
?>
<input type="radio" name="frm[content_sex]" value="<?=$vl["id"]?>" <? if($member["content_sex"]==$vl["id"]) echo 'checked'; ?>/><?=$vl["text"]?>
<?
}
?>
</div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<!--<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>邮箱:</div>
<div class="frm-inputs"><input id="content_email" name="frm[content_email]" type="text" value="<?=$member["content_email"]?>" /></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>-->


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>地址:</div>
<div class="frm-inputs"><input id="content_address" name="frm[content_address]" type="text" value="<?=$member["content_address"]?>"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>验证码:</div>
<div class="frm-inputs"><input class="comtexts" id="validateNUM" name="validateNUM" type="text"></div><div class="codes-css"><img id="regValidateImg" width="86" height="30" style="display:none; cursor:pointer;"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>
<div class="frm-cell"><div class="frm-tit">&nbsp;</div>
<div class="frms-btns"><a href="javascript:" onClick="$('#memberinfo_form').submit();return false;" class="mem-com-btns">提交</a></div>

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
