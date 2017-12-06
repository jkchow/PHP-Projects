<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>
</title>
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
                //{ name: "auto_id", type: "hidden" },
                { display: "ID", name: "auto_id", newline: true, type: "text", 
					//validate: {required:true,minlength:5}, 
					group: "接口数据日志", groupicon: groupicon
				},
				
				{ display: "设备号", name: "frm[device_id]", newline: true, type: "text"},
				{ display: "会员ID", name: "frm[member_id]", newline: true, type: "text"},
				{ display: "IP地址", name: "frm[ip_address]", newline: true, type: "text"},
				
				{ display: "请求参数", name: "frm[request_data]", newline: true, type: "textarea"},
				{ display: "解析后", name: "frm[request_data_arr]", newline: true, type: "textarea",attr:{"rows":"100"}},
				{ display: "返回数据", name: "frm[return_data]", newline: true, type: "textarea"},
				{ display: "解析后", name: "frm[return_data_arr]", newline: true, type: "textarea",attr:{"rows":"100"}},
				
                
				/*{ display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:enumVars.publishVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[publish]"
				
				} },*/
				{ display: "时间", name: "frm[create_time]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } }
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
    
    
    <!--<input type="button" value="保存" id="btnSave" class="l-button l-button-submit" />--> 
	<input type="button" value="返回" id="btnCancel" class="l-button l-button-reset"/>
    </form> 
</body>
</html>