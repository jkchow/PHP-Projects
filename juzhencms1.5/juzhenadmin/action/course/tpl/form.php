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
                title: '基础信息',
                width: '100%',
                height : 300
            });
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "frm[content_img]", type: "hidden" },
				{ name: "frm[content_img2]", type: "hidden" },
				{ name: "frm[content_img3]", type: "hidden" },
				{ name: "frm[recommend_img]", type: "hidden" },
				{ name: "frm[content_body]", type: "hidden" },
                { display: "课程名称", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:1}
				},
				{ display: "副标题", name: "frm[sub_title]", newline: true, type: "text"},
				{ display: "所属分类", name: "frm[category_id]", newline: true, type: "select", comboboxName: "category_codeSelect", options: { 
				cancelable: true,
				emptyText:"(无)",
				width: 180, 
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'auto_id',
				treeLeafOnly: false,
				tree: { 
					url: '?acl=courseCategory&method=categoryFormJsonData',
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'auto_id',
					isExpand:false
					},
				valueFieldID: "frm[category_id]"
				
				}},
				
				{ display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:enumVars.publishVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[publish]"
				} },
				/*{ display: "是否推荐", name: "frm[recommend]", newline: true, type: "select", comboboxName: "recommendSelect", options: { 
				data:enumVars.boolVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[recommend]"
				} },*/
				
				{ display: "课程简介", name: "frm[content_desc]", newline: true, type: "textarea"},
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
				//$("#frm\\[content_img\\]").val(getIframeDocument("formImgUpload").getElementById("content_value").value);
				//$("#frm\\[content_file\\]").val(getIframeDocument("formFileUpload").getElementById("content_value").value);
				var ckeditorValue=document.getElementsByTagName("iframe")["formCkeditor"].contentWindow.getCkeditorValue();
				
				$("#frm\\[content_body\\]").val(ckeditorValue);						 
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
			
			
			$("#panelImgUpload").ligerPanel({
				frameName:"formImgUpload",							 
                title: '图片',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img]"
            });
			
			
			
			$("#panelCkeditor").ligerPanel({
                frameName:"formCkeditor",
				title: '详细描述',
                width: '100%',
                height : 550,
				url: "?acl=ckeditor&method=formCkeditor&valueField=frm[content_body]"
            });
			
			$("#panelImgUpload2").ligerPanel({
				frameName:"formImgUpload2",							 
                title: '教学目标图片',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img2]"
            });
			
			$("#panelImgUpload3").ligerPanel({
				frameName:"formImgUpload3",							 
                title: '课程表图片',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img3]"
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
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save">
    
    </form>
    </div>
    <div id="panelImgUpload" style=" margin-top:10px; clear:both;">
    </div>
    
    <div id="panelCkeditor" style=" margin-top:10px; clear:both;">
    </div>
    <div id="panelImgUpload2" style=" margin-top:10px; clear:both;">
    </div>
    <div id="panelImgUpload3" style=" margin-top:10px; clear:both;">
    </div>
</body>    
</html>