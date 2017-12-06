<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
		var acl="<?=$_REQUEST["acl"]?>";
	    var formData=<?=json_encode($_record["formData"])?>;
	
        $(function ()
        {
            $("#panelBase").ligerPanel({
                title: '常用地址',
                width: '100%',
                height : 350
            });
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "frm[member_id]", type: "hidden" },
				{ name: "frm[lat]", type: "hidden" },
				{ name: "frm[lng]", type: "hidden" },
                { display: "联系人", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:2}
				},
				
				{ display: "手机号", name: "frm[content_mobile]", newline: true, type: "text", 
					validate: {required:true,minlength:1}
				},
				
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
				
				{ display: "街道名称", name: "frm[street_name]", newline: true, type: "text", validate: {required:true,minlength:1}},
				{ display: "详细地址", name: "frm[content_address]", newline: true, type: "textarea", validate: {required:true,minlength:1}},
				
				{ display: "默认地址", name: "frm[is_default]", newline: true, type: "select", comboboxName: "is_defaultSelect", options: { 
				data:enumVars.boolVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[is_default]"
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
				//获取图片附件及编辑器的内容
				
				//var ckeditorValue=document.getElementsByTagName("iframe")["formCkeditor"].contentWindow.getCkeditorValue();
				
				//$("#frm\\[content_body\\]").val(ckeditorValue);						 
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
				//var url="?acl="+acl+"&method=lists";
				//CmsTools.pageJump(url);
				history.back();
			});
			
			$("#panelMap").ligerPanel({
				frameName:"formMap",							 
                title: '地图标注',
                width: '100%',
                height : 500,
				url: "?acl="+acl+"&method=showMap&latField=frm[lat]&lngField=frm[lng]"
            });
			
        });
		//根据iframe的id获取iframe的document对象
		function getIframeDocument(frameId){
			var win;
			if(document.getElementById(frameId).contentDocument){//火狐下
					win=document.getElementById(frameId).contentDocument;//获取iframe中的document对象,通过此对象可以获取其中的表单等	
			}else{ //IE下
					win=document.frames[frameId].document;//获取iframe中的document对象,通过此对象可以获取其中的表单等		
			}
			return win;
		}
		
		
    </script> 

</head>
<body style="padding:10px"> 
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    
    
    <div id="panelBase" style=" margin-top:10px; clear:both;">
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save&backUrl=<?=$_REQUEST["backUrl"]?>">
    
    </form>
    </div>
    <div id="panelMap" style=" margin-top:10px; clear:both;">
    </div>
	
</body>    
</html>