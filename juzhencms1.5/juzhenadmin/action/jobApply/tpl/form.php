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
				{ name: "frm[job_id]", type: "hidden" },
                { display: "姓名", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:1},group: "简历信息", groupicon: groupicon
				}, 
				{ display: "性别", name: "frm[content_sex]", newline: true, type: "select", comboboxName: "content_sexSelect", options: { 
				data:enumVars.sexVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_sex]"
				} },
				{ display: "出生日期", name: "frm[content_birthday]", newline: true, type: "date",options: { format: "yyyy-MM-dd",showTime: false } },
				{ display: "婚姻状况", name: "frm[content_marriage]", newline: true, type: "text"},
				{ display: "学历", name: "frm[content_education]", newline: true, type: "text"},
				{ display: "毕业院校", name: "frm[content_university]", newline: true, type: "text"},
				{ display: "专业", name: "frm[content_major]", newline: true, type: "text"},
				{ display: "毕业日期", name: "frm[graduate_date]", newline: true, type: "date",options: { format: "yyyy-MM-dd",showTime: false } },
				{ display: "户籍地", name: "frm[content_hometown]", newline: true, type: "text"},
				{ display: "教育经历", name: "frm[education_desc]", newline: true, type: "textarea"},
				{ display: "工作经历", name: "frm[work_desc]", newline: true, type: "textarea"},
				{ display: "座机电话", name: "frm[content_tel]", newline: true, type: "text"},
				{ display: "邮箱", name: "frm[content_email]", newline: true, type: "text"},
				{ display: "通信地址", name: "frm[content_address]", newline: true, type: "text"},
				{ display: "邮编", name: "frm[post_code]", newline: true, type: "text"},
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
    
    
</body>    
</html>