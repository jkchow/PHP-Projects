<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
		var acl="<?=$_REQUEST["acl"]?>";
		var uploadUrlPath="<?=$global->uploadUrlPath?>";
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
				{ name: "frm[pid]", type: "hidden" },
                { display: "回复人", name: "frm[content_name]", newline: true, type: "text",validate: {required:true,minlength:1}, group: "回复信息", groupicon: groupicon,attr:{"disabled":"disabled"}},
				{ display: "内容", name: "frm[content_desc]", newline: true, type: "textarea", validate: {required:true,minlength:1}},
				
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
								CmsTools.jumpBack();
							}else{
								alert(data.msg);
							}
					  }
					});
				}						 
			});
			
			$("#btnCancel").click(function(){					   	
				history.back();
			});
			
			
		
        });
		
		
		
    </script> 

</head>
<body style="padding:10px"> 
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save&backUrl=<?=$_REQUEST["backUrl"]?>">
    
    
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    </form> 
    
    
    
</html>