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
                height : 195
            });
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "frm[content_img]", type: "hidden" },
                { display: "链接标题", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:2}
				}, 
				{ display: "链接地址", name: "frm[content_link]", newline: true, type: "text"},
				
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
			
			
			$("#panelImgUpload").ligerPanel({
				frameName:"formImgUpload",							 
                title: '图片附件',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img]"
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
	
</body>    
</html>