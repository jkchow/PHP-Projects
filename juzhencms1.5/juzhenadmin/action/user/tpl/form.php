<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
	   var acl="<?=$_REQUEST["acl"]?>";
	   var formData=<?=json_encode($_record["formData"])?>;
	
       var groupicon = "res/js/LigerUI/lib/ligerUI/skins/icons/communication.gif";
       var manager;
	   $(function ()
        {
            //创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
                { display: "用户名", name: "frm[content_user]", newline: true, type: "text", 
					validate: {required:true,minlength:2}, group: "用户信息", groupicon: groupicon
				}, 
				{ display: "密码", name: "frm[content_pass]", newline: true, type: "password", validate: {required:false,pwd:true},attr:{"id":"content_pass"}},
				{ display: "确认密码", name: "content_pass", newline: true, type: "password", validate: {required:false,equalTo:'#content_pass'}},
				
				{ display: "姓名", name: "frm[content_name]", newline: true, type: "text", validate: {required:true,minlength:2}},
				
				{ display: "职位", name: "frm[org_id]", newline: true, type: "select", comboboxName: "orgIdSelect", options: { 
				cancelable: true,
				emptyText:"(无)",
				width: 180, 
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'auto_id', 
				treeLeafOnly: false,
				tree: { 
					url: '?acl=userLevel&method=orgFormJsonData',
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'auto_id',
					isExpand:true
					},
				valueFieldID: "frm[org_id]"
				
				}},
                
				/*{ display: "角色", name: "frm[content_role]", newline: true, type: "select", comboboxName: "contentRoleSelect", options: { 
				//isShowCheckBox: true,
				isMultiSelect: true,
				emptyText:null,
				data:<?=json_encode($_record["roleVars"])?>,
				valueFieldID: "frm[content_role]"
				
				} },*/
				{ name: "frm[content_role]", type: "hidden"},
				
				{ display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:enumVars.publishVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[publish]"
				
				} },
				{ display: "创建时间", name: "frm[create_time]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } }
                ]
            });


			
			var form = liger.get("dataform");
			/*form.setData({
				"frm[publish]": '1',
				"frm[create_time]": new Date()
            });*/
			form.setData(formData);
			
			$("#role_tree").ligerTree({ 
					  data:<?=json_encode($_record["roleVars"])?>,
					  autoCheckboxEven: false //设置为不进行关联选择(自动选中父节点) 
			});
			manager = $("#role_tree").ligerGetTreeManager();

			
			$("#btnSave").click(function(){
		
				
				var roleValue=getChecked();
				if(roleValue==""){
					alert("请选择用户的角色");
					return;
				}
				
				$("#frm\\[content_role\\]").val(roleValue);
				//$("#dataform").submit();		
				//采用ajax提交表单
				if($("#dataform").valid()){
					var ele_pass=liger.get("dataform").getEditor("frm[content_pass]").element;
					var ele_pass2=liger.get("dataform").getEditor("content_pass").element;
					if(ele_pass.value!=""){
						ele_pass.value=md5(ele_pass.value);
						ele_pass2.value=md5(ele_pass2.value);
					}
					
					var formData=$("#dataform").serialize();//将表单数据转换成序列化的字符串
					$.ajax({
					  type: "POST",
					  url: "index.php?acl="+acl+"&method=save",
					  processData:true,//提交时注意必须有这个属性
					  data:formData,
					  dataType:'json',
					  success: function(data){
					  		liger.get("dataform").getEditor("frm[content_pass]").element.value="";
						  	liger.get("dataform").getEditor("content_pass").element.value="";
							
							if(data.result==1){
								var url="?acl=user&method=lists";
								CmsTools.pageJump(url);
							}else{
								alert(data.msg);
							}
					  }
					});
				}						 
			});
			
			$("#btnCancel").click(function(){					   	
				var url="?acl=user&method=lists";
				CmsTools.pageJump(url);
			});
		
        });
		
		function getChecked()
		{
			var notes = manager.getChecked();
			var text = "";
			for (var i = 0; i < notes.length; i++)
			{
				text += notes[i].data.value + ",";
			}
			return text;
		}
		
		
    </script> 

</head>
<body style="padding:10px"> 
    <form id="dataform" method="post" action="?acl=user&method=save">
    
    
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    </form> 
    
    <span style=" float:left; padding-left:7px;">选择角色：</span>
    <div style="width:278px; position:relative; height:180px; display:block; margin:10px; background:white;   border:1px solid #ccc; overflow:auto; float:left; margin-top:-2px; margin-left:30px; ">
    <ul id="role_tree">
     
    </ul>
    </div>
</body>
</html>