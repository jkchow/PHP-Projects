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
				{ display: "姓名", name: "frm[linkman_name]", newline: true, type: "text", group: "加盟申请", groupicon: groupicon},
				{ display: "性别", name: "frm[content_sex]", newline: true, type: "select", comboboxName: "content_sexSelect", options: { 
				data:enumVars.sexVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_sex]"
				} },
				
				{ display: "省份", name: "frm[province_id]", newline: true, type: "select", 
					comboboxName: "province_idSelect",options: { 
						url:"index.php?acl=area&method=provinceData",
						onSuccess: function(){//ajax加载选项成功后设置聚焦
								this.selectValue($(formData).attr("frm[province_id]"));
								//新定义的标志位，用于触发联动，不是ligerUI的标准字段
								this.isChangeSub=true;		
						},
						onSelected:function(newvalue)
						{	
							if(newvalue && this.isChangeSub){
								$.ajax({
									url:"index.php?acl=area&method=cityData&pid="+newvalue,
									dataType:'json',
									success:function(data){
										liger.get("city_idSelect").setData(data);
									}
								});
							}		
						},
						cancelable: false,
						emptyText:null,
						valueFieldID: "frm[province_id]"
					}
				},
				{ display: "城市", name: "frm[city_id]", newline: true, type: "select",
					comboboxName: "city_idSelect", options: { 
						url:"index.php?acl=area&method=cityData&pid="+$(formData).attr("frm[province_id]"),
						onSuccess: function(){//ajax加载选项成功后设置聚焦
								this.selectValue($(formData).attr("frm[city_id]"));
						},
						cancelable: false,
						emptyText:null,
						valueFieldID: "frm[city_id]"
					}
				},
				
				{ display: "手机", name: "frm[content_mobile]", newline: true, type: "text"},
				//{ display: "联系邮箱", name: "frm[content_email]", newline: true, type: "text"},
				
				
				{ display: "备注", name: "frm[content_desc]", newline: true, type: "textarea"},
				{ display: "处理状态", name: "frm[content_status]", newline: true, type: "select", comboboxName: "content_statusSelect", options: { 
				data:enumVars.dealStatusVars,
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