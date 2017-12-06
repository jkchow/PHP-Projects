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
 
				{ display: "网站标题", name: "frm[content_title]", newline: true, type: "text",
				group: "网站设置", 
				groupicon: groupicon,
				afterContent: '<div style="margin-right:10px;margin-left:6px;color:red;float:left;">显示在浏览器标题标签中的网站名称</div>'
				},
				
				{ display: "版权信息", name: "frm[content_copyright]", newline: true, type: "textarea"},
				{ display: "客服电话", name: "frm[service_tel]", newline: true, type: "text"},
				{ display: "客服邮箱", name: "frm[service_email]", newline: true, type: "text"},
				{ display: "公司地址", name: "frm[company_address]", newline: true, type: "text"},
				
				{ display: "流量统计代码", name: "frm[count_code]", newline: true, type: "textarea"},
				{ display: "SEO关键词", name: "frm[seo_keywords]", newline: true, type: "textarea",group: "SEO设置", groupicon: groupicon},
				{ display: "SEO描述", name: "frm[seo_description]", newline: true, type: "textarea"},
				
				
				{ display: "网站简短名称", name: "frm[content_name]", newline: true, type: "text",
					afterContent: '<div style="margin-right:10px;margin-left:6px;color:red;float:left;">用于短信及邮件通知中显示的网站名称</div>',
					group: "邮件及短信设置", groupicon: groupicon
				},
				{ display: "短信接口", name: "frm[mobile_msg_api]", newline: true, type: "textarea"},
				{ display: "邮件服务器", name: "frm[email_host]", newline: true, type: "text"},
				{ display: "端口号", name: "frm[email_port]", newline: true, type: "text"},
				{ display: "发信邮箱", name: "frm[email_email]", newline: true, type: "text"},
				{ display: "邮箱用户名", name: "frm[email_user]", newline: true, type: "text"},
				{ display: "邮箱密码", name: "frm[email_pass]", newline: true, type: "password"}
				
                
                ]
            });


			
			var form = liger.get("dataform");
			/*form.setData({
				"frm[publish]": '1',
				"frm[create_time]": new Date()
            });*/
			form.setData(formData);

			
			$("#btnSave").click(function(){
				//$("textarea[name='frm\\[count_code\\]']").val((new Base64()).Encode64($("textarea[name='frm\\[count_code\\]']").val()));						 
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
								location.reload();
							}else{
								alert(data.msg);
							}
					  }
					});
				}							 
			});
			
			$("#btnCancel").click(function(){					   	
				location.reload();
			});
			
			
			$("#btnCleanCache").click(function(){
				//清空缓存
				$.ajax({
					url:"index.php?acl="+acl+"&method=cleanCache",
					dataType:"json",
					success:function(data){
						alert(data.msg);
					}
				});
			});
			
		
        });
		
		
		
		
    </script> 

</head>
<body style="padding:10px"> 
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save&backUrl=<?=$_REQUEST["backUrl"]?>">
    
    
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    <input type="button" value="更新缓存" id="btnCleanCache" class="l-button l-button-reset"/>
    </form> 
    
    
</body>    
</html>