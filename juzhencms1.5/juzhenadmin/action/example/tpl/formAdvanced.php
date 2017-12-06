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
			//构造基础表单标签 
			$("#panelBase").ligerPanel({
                title: '基础信息',
                width: '100%',
                height : 260
            });
			
			
            //创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "frm[content_img]", type: "hidden" },//存储图片上传路径的隐藏标单
				{ name: "frm[content_file]", type: "hidden" },//存储文件上传路径的隐藏标单
				{ name: "frm[content_video]", type: "hidden" },//存储视频上传路径的隐藏标单
				{ name: "frm[content_body]", type: "hidden" },//存储html编辑器字段内容的隐藏标单
                { display: "名称字段", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:1},
					afterContent: '<div style="margin-right:10px;margin-left:6px;color:red;float:left;">请输入名称</div>'
				}, 
				{ display: "简介字段", name: "frm[content_desc]", newline: true, type: "textarea", validate: {required:true,minlength:2}},
				{ display: "多选字段", name: "favor[]", newline: true, type: "checkboxlist", editor:
					{
						data:[{"id":"1","text":"足球","checked":true},{"id":"2","text":"篮球"},{"id":"3","text":"乒乓球"}]
					}
				},
                
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
			//向表单中填充初始化数据
			form.setData(formData);

			//定义点击保存按钮的操作
			$("#btnSave").click(function(){
				 
				//如果有html编辑器字段，需要获取编辑器内容并赋值到相应的表单字段------------------
				var ckeditorValue=document.getElementsByTagName("iframe")["formCkeditor"].contentWindow.getCkeditorValue();
				$("#frm\\[content_body\\]").val(ckeditorValue);	
				//保存编辑器代码结束--------------------------------------------------------
				
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
								//设置主键ID，防止再次点击保存出现多条数据
								$("#auto_id").val(data.id);
								
								$.ligerDialog.open({ 
									 title: '提示',
									 type: 'success',
									 content:data.msg,
									 buttons: [
										{ 	
											text: '返回列表页', 
											onclick: function (item, dialog){ 
												CmsTools.jumpBack();
											} 
										}, 
										{
											text: '留在当前页', 
											onclick: function (item, dialog){
												dialog.close();
											}
										}
									] 
								});	
							}else{
								alert(data.msg);
							}
					  }
					});
				}
				
			});
			
			//定义点击取消按钮的操作
			$("#btnCancel").click(function(){					   	
				var url="?acl="+acl+"&method=lists";
				CmsTools.pageJump(url);
			});
			
			//构造图片上传表单
			$("#panelImgUpload").ligerPanel({
				frameName:"formImgUpload",							 
                title: '上传图片',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img]"
            });
			
			//构造文件上传表单
			$("#panelFileUpload").ligerPanel({
				frameName:"formFileUpload",							 
                title: '上传附件',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formFileUpload&valueField=frm[content_file]"
            });
			
			//构造html编辑器表单
			$("#panelCkeditor").ligerPanel({
                frameName:"formCkeditor",
				title: '正文内容',
                width: '100%',
                height : 550,
				url: "?acl=ckeditor&method=formCkeditor&valueField=frm[content_body]"
            });
			
			//构造视频上传表单
			$("#panelVideoUpload").ligerPanel({
                frameName:"formVideoUpload",
				title: '视频文件（需要浏览器支持flash）',
                width: '100%',
                height : 455,
				url: "?acl=upload&method=formVideoUpload&valueField=frm[content_video]"
            });
			
		
        });
    </script> 

</head> 
<body style="padding:10px"> 
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    
    
    <div id="panelBase" style=" margin-top:10px; clear:both;">
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save">
    <!-- 基础表单字段 -->
    </form>
    </div>
    <div id="panelImgUpload" style=" margin-top:10px; clear:both;">
    <!-- 图片上传表单 -->
    </div>
	<div id="panelFileUpload" style=" margin-top:10px; clear:both;">
    <!-- 文件上传表单 -->
    </div>
    <div id="panelCkeditor" style=" margin-top:10px; clear:both;">
    <!-- 在线编辑器表单 -->
    </div>
    <div id="panelVideoUpload" style=" margin-top:10px; clear:both;">
    <!-- 视频上传表单（大文件上传） -->
    </div>
</body>
</html>