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
                { name: "auto_id", type: "hidden"},
                { display: "角色名称", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:3}, group: "角色信息", groupicon: groupicon
				}, 
				{ name: "frm[content_value]", type: "hidden"},
				/*{ display: "权限设定", name: "frm[content_value]", newline: true, type: "select", comboboxName: "roleValueSelect", options: { 
						data: enumVars.publishVars,
						cancelable: false,
						emptyText:null,
						valueFieldID: "frm[content_value]",
						
						width : 180, 
						selectBoxWidth: 250,
						selectBoxHeight: 300, valueField: 'text', treeLeafOnly: false,
						tree: { url: '?acl=role&method=permissionJsonData',ajaxType:'get'}
					} 
				},*/
				
                { display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data: enumVars.publishVars,
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
					  url: '?acl=role&method=permissionJsonData&auto_id='+$("#auto_id").val(), 
					  ajaxType: 'get',
					  autoCheckboxEven: false //设置为不进行关联选择(自动选中父节点) 
			});
			manager = $("#role_tree").ligerGetTreeManager();
			
			$("#btnSave").click(function(){	
				//alert(getChecked());	
				$("#frm\\[content_value\\]").val(getChecked());
				//$("#dataform").submit();		
				//采用ajax提交表单
				if($("#dataform").valid()){
					var formData=$("#dataform").serialize();//将表单数据转换成序列化的字符串
					$.ajax({
					  type: "POST",
					  url: "index.php?acl="+acl+"&method=save",
					  processData:true,//提交时注意必须有这个属性
					  data:formData,
					  dataType:'json',
					  success: function(data){
					  		if(data.result==1){
								var url="?acl=role&method=lists";	
								CmsTools.pageJump(url);	
							}else{
								alert(data.msg);
							}
					  }
					});
				}					 
			});
			
			$("#btnCancel").click(function(){
				var url="?acl=role&method=lists";	
				CmsTools.pageJump(url);				   
			});
			
			$("#btnRole").click(function(){
						   
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
    <form id="dataform" method="post" action="?acl=role&method=save">
    
    
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    </form> 
  
    <span style=" float:left; padding-left:7px;">操作权限：</span>
    <div style="width:278px; position:relative; height:400px; display:block; margin:10px; background:white;   border:1px solid #ccc; overflow:auto; float:left; margin-top:-2px; margin-left:30px; ">
    <ul id="role_tree">
     
    </ul>
    </div>
</body>    
</html>