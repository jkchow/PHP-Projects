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
                { display: "家长姓名", name: "frm[parent_name]", newline: true, type: "text", 
					validate: {required:true,minlength:1}, group: "预约报名", groupicon: groupicon
				}, 
				//{ display: "负责人姓名", name: "frm[content_name]", newline: true, type: "text"},
				//{ display: "联系手机", name: "frm[content_mobile]", newline: true, type: "text"},
				{ display: "联系电话", name: "frm[content_tel]", newline: true, type: "text"},
				{ display: "联系邮箱", name: "frm[content_email]", newline: true, type: "text"},
				/*{ display: "孩子年龄", name: "frm[content_age]", newline: true, type: "select",comboboxName: "content_ageSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=childAgeVars",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[content_age]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_age]"
				}},*/
				{ display: "孩子生日", name: "frm[content_birthday]", newline: true, type: "date",options: { format: "yyyy-MM-dd",showTime: false } },
				
				
				{ display: "地区", name: "frm[province_id]", newline: true, type: "select", 
					comboboxName: "province_idSelect",options: { 
						url:"index.php?acl=area&method=provinceData",
						onSuccess: function(){//ajax加载选项成功后设置聚焦
								this.selectValue($(formData).attr("frm[province_id]"));
								//新定义的标志位，用于触发联动，不是ligerUI的标准字段
								//this.isChangeSub=true;		
						},
						/*onSelected:function(newvalue)
						{	
							if(newvalue && this.isChangeSub){
								$.ajax({
									url:"index.php?acl=area&method=cityData&pid="+newvalue,
									dataType:'json',
									success:function(data){
										liger.get("city_codeSelect").setData(data);
									}
								});
							}		
						},*/
						cancelable: false,
						emptyText:null,
						valueFieldID: "frm[province_id]"
					}
				},
				
				{ display: "校区", name: "frm[school_id]", newline: true, type: "select", 
					//validate: {required:true,minlength:1}, 
					comboboxName: "frm[school_name]", options: { 
						width: 250,
						slide: false,
						selectBoxWidth: 445,
						selectBoxHeight: 240,
						valueField: 'auto_id',
						textField: 'content_name',
						grid: {
							columns: [
							{ display: 'ID', name: 'auto_id', align: 'center', width: 50 },
							{ display: '校区名称', name: 'content_name', minWidth: 230 },
							{ display: '所在地区', name: 'content_area', width: 130,align:'center' }
							], switchPageSizeApplyComboBox: false,
							url:"?acl=topic&method=listsData",
							width: '100%',height:'100%',rownumbers:false,
							pageSize: 10, 
							checkbox: false
						},
						condition: { fields: [{ name: 'content_name', label: '名称', width: 90, type: 'text' }
											  //,{ name: 'goods_sn', label: '编号', width: 90, type: 'text' }
											  ] }
					} 
				},
				
				
				//{ display: "公司网址", name: "frm[content_website]", newline: true, type: "text"},
				//{ display: "广告位置", name: "frm[ad_position]", newline: true, type: "text"},  
				{ display: "处理状态", name: "frm[content_status]", newline: true, type: "select", comboboxName: "content_statusSelect", options: { 
				data:enumVars.dealStatusVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_status]"
				} },
				{ display: "创建时间", name: "frm[create_time]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } },
				{ display: "备注", name: "frm[content_desc]", newline: true, type: "textarea"}
                ]
            });
				

			
			var form = liger.get("dataform");
			/*form.setData({
				"frm[publish]": '1',
				"frm[create_time]": new Date()
            });*/
			form.setData(formData);
			$("input[name='frm\\[school_name\\]']").val(formData["frm[school_name]"]);
			
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