<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
		var acl="<?=$_REQUEST["acl"]?>";
	    var formData=<?=json_encode($_record["formData"])?>;
		var topicTypeVars=<?=json_encode($_record["topicTypeVars"])?>;
	
        var groupicon = "res/js/LigerUI/lib/ligerUI/skins/icons/communication.gif";
        $(function ()
        {
            $("#panelBase").ligerPanel({
                title: '分站信息',
                width: '100%',
                height : 410
            });
			
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "frm[content_img]", type: "hidden" },
                { display: "分站名称", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:1}
				},
				/*{ display: "类型", name: "frm[content_type]", newline: true, type: "select", comboboxName: "contentTypeSelect",options: { 
				data:topicTypeVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_type]"
				} },
				
				
				{ display: "报名截止日期", name: "frm[apply_endtime]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } },*/
				
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
				
				{ display: "电话", name: "frm[content_tel]", newline: true, type: "text"},
				{ display: "地址", name: "frm[content_address]", newline: true, type: "text"},
				
				
				
				{ display: "备注", name: "frm[content_desc]", newline: true, type: "textarea"},
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
			
			/*$("#panelImgUpload").ligerPanel({
				frameName:"formImgUpload",							 
                title: '图片附件(150*125)',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img]"
            });*/
		
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
	<div id="panelImgUpload" style=" margin-top:10px; clear:both;"></div>
</body> 
</html>