<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
		var acl="<?=$_REQUEST["acl"]?>";
	    var formData=<?=json_encode($_record["formData"])?>;
	
        //var groupicon = "res/js/LigerUI/lib/ligerUI/skins/icons/communication.gif";
        $(function ()
        {
            
			$("#panelBase").ligerPanel({
                title: '职位信息',
                width: '100%',
                height : 500
            });
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "auto_code", type: "hidden" },
                { display: "职位名称", name: "frm[name]", newline: true, type: "text", 
					validate: {required:true,minlength:2}
				},
				
				{ display: "所属部门", name: "frm[department_id]", newline: true, type: "select", comboboxName: "departmentSelect", options: { 
				cancelable: true,
				emptyText:"(无)",
				width: 180, 
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'auto_id', 
				treeLeafOnly: false,
				tree: { 
					url: '?acl=userDepartment&method=departmentFormJsonData',
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'auto_id',
					isExpand:true
					},
				valueFieldID: "frm[department_id]"
				
				}},
				
				{ display: "简介", name: "frm[content_desc]", newline: true, type: "textarea"},
				
				{ display: "上级职位", name: "p_code", newline: true, type: "select", comboboxName: "autoCodeSelect", options: { 
				cancelable: true,
				emptyText:"(无)",
				width: 180, 
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'auto_code', 
				treeLeafOnly: false,
				tree: { 
					url: '?acl='+acl+'&method=pcodeFormJsonData&editCode='+(formData.auto_code!=null?formData.auto_code:""),
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'auto_code',
					isExpand:true
					},
				valueFieldID: "p_code"
				
				}},
				{ display: "创建时间", name: "frm[create_time]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } }
				
                ]
            });


			
			var form = liger.get("dataform");

			form.setData(formData);

			
			$("#btnSave").click(function(){
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
								var url="?acl="+acl+"&method=lists";
								CmsTools.pageJump(url);
							}else{
								alert(data.msg);
							}
					  }
					});
				}						 
			});
			
			$("#btnCancel").click(function(){					   	
				var url="?acl="+acl+"&method=lists";
				CmsTools.pageJump(url);
			});
			
			
			
		
        });
    </script> 

</head>
<body style="padding:10px"> 
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    
    
    <div id="panelBase" style=" margin-top:10px; clear:both;">
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save">
    
    </form>
    </div>
    
</body>
</html>