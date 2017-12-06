<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
		var acl="<?=$_REQUEST["acl"]?>";
	    var formData=<?=json_encode($_record["formData"])?>;
	
        var groupicon = "res/js/LigerUI/lib/ligerUI/skins/icons/communication.gif";
        $(function ()
        {
            //创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ display: "用户名", name: "content_user", newline: true, type: "text", 
					 group: "修改密码", groupicon: groupicon,attr:{"disabled":"disabled"}
				},
				{ display: "原有密码", name: "old_pass", newline: true, type: "password", validate: {required:true},attr:{"id":"old_pass"}},
				{ display: "新密码", name: "new_pass", newline: true, type: "password", validate: {required:true,minlength:6,pwd:true},attr:{"id":"new_pass"}},
				{ display: "确认密码", name: "new_pass2", newline: true, type: "password", validate: {required:true,equalTo:'#new_pass'},attr:{"id":"new_pass2"}}
				
				
                ]
            });


			
			var form = liger.get("dataform");
			/*form.setData({
				"frm[publish]": '1',
				"frm[create_time]": new Date()
            });*/
			form.setData(formData);

			
			$("#btnSave").click(function(){
				//$("#dataform").submit();		
				//采用ajax提交表单
				if($("#dataform").valid()){
					
					var old_pass=liger.get("dataform").getEditor("old_pass").element;
					var new_pass=liger.get("dataform").getEditor("new_pass").element;
					var new_pass2=liger.get("dataform").getEditor("new_pass2").element;
					old_pass.value=md5(old_pass.value);
					new_pass.value=md5(new_pass.value);
					new_pass2.value=md5(new_pass2.value);
					
					
					var formData=$("#dataform").serialize();//将表单数据转换成序列化的字符串
					$.ajax({
					  type: "POST",
					  url: "index.php?acl="+acl+"&method=changePassword",
					  processData:true,//提交时注意必须有这个属性
					  data:formData,
					  dataType:'json',
					  success: function(data){
						  	$("#old_pass").val("");	
							$("#new_pass").val("");	
							$("#new_pass2").val("");
							
							alert(data.msg);
					  		
					  }
					});
				}						 
			});
			
			$("#btnCancel").click(function(){
				$("#old_pass").val("");	
				$("#new_pass").val("");	
				$("#new_pass2").val("");	
				//location.reload();						   
			});
		
        });
    </script> 

</head>
<body style="padding:10px"> 
    <form id="dataform" method="post" action="?acl=user&method=changePassword">
    
    
    <input type="submit" value="提交" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="清空" id="btnCancel" class="l-button l-button-reset"/>
    <!--<br/><br/>
    当前用户：<?=$_record["formData"]["content_user"]?>-->
    </form> 
</html>