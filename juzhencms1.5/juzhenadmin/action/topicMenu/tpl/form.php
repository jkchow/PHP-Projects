<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
	
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
				{ name: "auto_code", type: "hidden" },
                { display: "栏目名称", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:2}, group: "栏目信息", groupicon: groupicon
				},
				//{ display: "栏目简介", name: "frm[content_desc]", newline: true, type: "text"},
				{ display: "链接地址", name: "frm[content_link]", newline: true, type: "text"},
				
				{ display: "上级栏目", name: "p_code", newline: true, type: "select", comboboxName: "autoCodeSelect", options: { 
				cancelable: true,
				emptyText:"(无)",
				width: 180, 
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'auto_code', 
				treeLeafOnly: false,
				tree: { 
					url: '?acl=topicMenu&method=pcodeFormJsonData&editCode='+(formData.auto_code!=null?formData.auto_code:""),
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'auto_code',
					isExpand:false
					},
				valueFieldID: "p_code"
				
				}},
				

				{ display: "栏目功能", name: "frm[content_module]", newline: true, type: "select", comboboxName: "contentModuleSelect", options: { 
				data:enumVars.topicMenuModuleVars,
				cancelable: true,
				emptyText:"(空)",
				valueFieldID: "frm[content_module]"
				
				} },
				{ display: "模板标识", name: "frm[action_method]", newline: true, type: "text"},
                
				{ display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: {
				data:enumVars.publishVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[publish]"
				
				} },
				{ display: "创建时间", name: "frm[create_time]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } },
				
				
				{ display: "SEO关键词", name: "frm[seo_keywords]", newline: true, type: "textarea",group: "SEO信息", groupicon: groupicon},
				{ display: "SEO描述", name: "frm[seo_description]", newline: true, type: "textarea"}
				
				
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
								var url="?acl=topicMenu&method=lists";
								CmsTools.pageJump(url);
							}else{
								alert(data.msg);
							}
					  }
					});
				}							 
			});
			
			$("#btnCancel").click(function(){					   	
				var url="?acl=topicMenu&method=lists";
				CmsTools.pageJump(url);
			});
		
        });
    </script> 

</head>
<body style="padding:10px"> 
    <form id="dataform" method="post" action="?acl=topicMenu&method=save">
    
    
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    </form> 
</html>