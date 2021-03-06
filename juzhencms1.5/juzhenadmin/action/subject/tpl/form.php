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
                { display: "标题", name: "frm[content_title]", newline: true, type: "text", 
					validate: {required:true,minlength:5}, group: "话题信息", groupicon: groupicon
				},
				
				{ display: "作者", name: "frm[member_id]", newline: true, type: "select", 
					validate: {required:true,minlength:1}, 
					comboboxName: "frm[content_author]", options: { 
						width: 250,
						slide: false,
						selectBoxWidth: 445,
						selectBoxHeight: 240,
						valueField: 'auto_id',
						textField: 'content_name',
						grid: {
							columns: [
							{ display: 'ID', name: 'auto_id', align: 'center', width: 50 },
							{ display: '用户名', name: 'content_user', minWidth: 130 },
							{ display: '名称', name: 'content_name', width: 130,align:'center' },
							{ display: '类型', name: 'content_type', minWidth: 130,type:"enumVars",enumVars:enumVars.memberTypeVars }
							], switchPageSizeApplyComboBox: false,
							url:"?acl=member&method=listsData",
							width: '100%',height:'100%',rownumbers:false,
							pageSize: 10, 
							checkbox: false
						},
						condition: { fields: [{ name: 'content_name', label: '名称', width: 90, type: 'text' }
											  //,{ name: 'course_sn', label: '编号', width: 90, type: 'text' }
											  ] }
					} 
				},
				
				{ display: "所属分类", name: "frm[category_id]", newline: true, 
				type: "select", comboboxName: "categoryIdSelect", options: { 
				cancelable: false,
				emptyText:null,
				width: 180,
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'id',
				treeLeafOnly: false,
				tree: { 
					url: '?acl=subjectCategory&method=categoryFormJsonData',
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'id',
					isExpand:false
					},
				valueFieldID: "frm[category_id]"
				
				}},
				
				{ display: "内容", name: "frm[content_body]", newline: true, type: "textarea", validate: {required:true,minlength:6}},
				
                
				{ display: "状态", name: "frm[content_status]", newline: true, type: "select", comboboxName: "statusSelect", options: { 
				data:enumVars.subjectStatus,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_status]"
				
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
			$("input[name='frm\\[content_author\\]']").val(formData["frm[content_author]"]);
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
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save">
    
    
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    </form> 
</body>
</html>