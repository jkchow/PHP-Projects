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
						 
				{ display: "选择会员", name: "member_id", newline: true, type: "select", 
					validate: {required:true,minlength:1}, 
					group: "发送短信", groupicon: groupicon,
					comboboxName: "member_mobile", options: { 
						width: 250,
						slide: false,
						selectBoxWidth: 505,
						selectBoxHeight: 340,
						valueField: 'auto_id',
						textField: 'content_mobile',
						grid: {
							columns: [
							{ display: 'ID', name: 'auto_id', align: 'center', width: 50 },
							{ display: '手机号', name: 'content_mobile', minWidth: 140 },
							{ display: '姓名', name: 'content_name', width: 140,align:'center'},
							{ display: '邮箱', name: 'content_email', minWidth: 170 }
							], switchPageSizeApplyComboBox: false,
							url:"?acl=member&method=listsData",
							width: '100%',height:'100%',rownumbers:false,
							pageSize: 10,
							checkbox: true
						},
						condition: { fields: [{ name: 'content_mobile', label: '手机号', width: 90, type: 'text' },
											  { name: 'content_name', label: '姓名', width: 90, type: 'text' },
											  { name: 'content_email', label: '邮箱', width: 90, type: 'text' }
											  ] }
					} 
				},

				{ display: "选择短信模板", name: "templet_id", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:<? $tplList=$dao->get_datalist("select auto_id as id,content_name as text from {$dao->tables->mobile_msg_templet} "); echo json_encode($tplList); ?>,
				cancelable: false,
				emptyText:null,
				valueFieldID: "templet_id"
				
				} }
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
					var formData=$("#dataform").serialize();//将表单数据转换成序列化的字符串
					$.ajax({
					  type: "POST",
					  url: "index.php?acl="+acl+"&method=sendMsg",
					  processData:true,//提交时注意必须有这个属性
					  data:formData,
					  dataType:'json',
					  success: function(data){
					  		if(data.result==1){
								$.ligerDialog.open({ 
									 title: '提示',
									 type: 'success',
									 content:data.msg,
									 buttons: [
										{ 	
											text: '返回列表页', 
											onclick: function (item, dialog){ 
												CmsTools.jumpBack();
											} 
										}, 
										{
											text: '留在当前页', 
											onclick: function (item, dialog){
												dialog.close();
											}
										}
									] 
								});	
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
    <form id="dataform">
    
    
    <input type="button" value="发送" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="返回" id="btnCancel" class="l-button l-button-reset"/>
    </form>
</body> 
</html>