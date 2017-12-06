<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript"> 
		var acl="<?=$_REQUEST["acl"]?>";
	    var formData=<?=json_encode($_record["formData"])?>;
		var groupData=<?=json_encode($_record["groupData"])?>;
	
        var groupicon = "res/js/LigerUI/lib/ligerUI/skins/icons/communication.gif";
		var treeManager;
        $(function ()
        {
            
			$("#panelBase").ligerPanel({
                title: '企业信息',
                width: '100%',
                height : 710
            });
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				//{ name: "frm[content_img]", type: "hidden" },
				{ name: "frm[content_head]", type: "hidden" },
				{ name: "frm[lat]", type: "hidden" },
				{ name: "frm[lng]", type: "hidden" },
                /*{ display: "用户名", name: "frm[content_user]", newline: true, type: "text", 
					validate: {required:true,minlength:3}, group: "帐户信息", groupicon: groupicon
				},*/ 
				{ display: "手机", name: "frm[content_mobile]", newline: true, type: "text", validate: {required:true,minlength:2},group: "帐户信息",groupicon: groupicon},
				{ display: "密码", name: "frm[content_pass]", newline: true, type: "password", validate: {required:false},attr:{"id":"content_pass"}},
				{ display: "确认密码", name: "content_pass", newline: true, type: "password", validate: {required:false,equalTo:'#content_pass'}},
				{ display: "会员类型", name: "frm[content_type]", newline: true, type: "select", comboboxName: "content_typeSelect", options: {
				data:enumVars.memberTypeVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_type]"
				
				} },
				{ display: "所在分组", name: "frm[group_id]", newline: true, type: "select", comboboxName: "group_idSelect", options: {
				data:groupData,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[group_id]"
				
				} },
				{ display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:enumVars.publishVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[publish]"
				} },
				{ display: "审核状态", name: "frm[is_agree]", newline: true, type: "select", comboboxName: "is_agreeSelect", options: { 
				data:enumVars.agreeVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[is_agree]"
				} },
				/*{ display: "UID", name: "frm[uc_id]", newline: true, type: "text",afterContent: '<div style="margin-right:10px;margin-left:6px;color:red;float:left;">论坛会员ID,请不要随意修改</div>'},*/

				
				{ display: "企业名称", name: "frm[content_name]", newline: true, type: "text",validate: {required:true,minlength:1},group: "企业资料",groupicon: groupicon},
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
				{ display: "联系人姓名", name: "frm[linkman_name]", newline: true, type: "text"},
				{ display: "联系人性别", name: "frm[content_sex]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:enumVars.sexVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_sex]"
				} },
				{ display: "公司电话", name: "frm[content_tel]", newline: true, type: "text"},
				{ display: "邮箱", name: "frm[content_email]", newline: true, type: "text"},
				
				{ display: "联系地址", name: "frm[content_address]", newline: true, type: "text"},
				
				
				{ display: "备注", name: "frm[content_desc]", newline: true, type: "textarea"},
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
				//var ckeditorValue=document.getElementsByTagName("iframe")["formCkeditor"].contentWindow.getCkeditorValue();
				
				//$("#frm\\[content_body\\]").val(ckeditorValue);							 
				
				//$("#dataform").submit();		
				//采用ajax提交表单
				if($("#dataform").valid()){
					
					var ele_pass=liger.get("dataform").getEditor("frm[content_pass]").element;
					var ele_pass2=liger.get("dataform").getEditor("content_pass").element;
					if(ele_pass.value!=""){
						ele_pass.value=md5(ele_pass.value);
						ele_pass2.value=md5(ele_pass2.value);
					}
					
					var formData=$("#dataform").serialize();//将表单数据转换成序列化的字符串
					$.ajax({
					  type: "POST",
					  url: "index.php?acl="+acl+"&method=save",
					  processData:true,//提交时注意必须有这个属性
					  data:formData,
					  dataType:'json',
					  success: function(data){
						  	liger.get("dataform").getEditor("frm[content_pass]").element.value="";
						  	liger.get("dataform").getEditor("content_pass").element.value="";
						  
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
			
			
			
			
			$("#panelHeadUpload").ligerPanel({
				frameName:"formHeadUpload",							 
                title: '头像',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_head]"
            });
			$("#panelMap").ligerPanel({
				frameName:"formMap",							 
                title: '地图标注',
                width: '100%',
                height : 500,
				url: "?acl="+acl+"&method=showMap&latField=frm[lat]&lngField=frm[lng]"
            });
			
			/*$("#panelCkeditor").ligerPanel({
                frameName:"formCkeditor",
				title: '详细介绍',
                width: '100%',
                height : 550,
				url: "?acl=ckeditor&method=formCkeditor&valueField=frm[content_body]"
            });*/
			
		
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
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save">
    
    </form>

    </div>
    <div id="panelHeadUpload" style=" margin-top:10px; clear:both;">
    </div>
    <div id="panelMap" style=" margin-top:10px; clear:both;">
    </div>
    <!--<div id="panelCkeditor" style=" margin-top:10px; clear:both;">
    </div>-->
    
</body> 
</html>