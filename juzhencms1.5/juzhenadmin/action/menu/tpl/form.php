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
            
			$("#panelBase").ligerPanel({
                title: '基础信息',
                width: '100%',
                height : 700
            });
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				{ name: "frm[content_img]", type: "hidden" },
                { display: "栏目名称", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:2}, group: "栏目信息", groupicon: groupicon
				},
				{ display: "栏目简介", name: "frm[content_desc]", newline: true, type: "textarea"},
				{ display: "链接地址", name: "frm[content_link]", newline: true, type: "text"},
				
				{ display: "打开方式", name: "frm[link_target]", newline: true, type: "select", comboboxName: "link_targetSelect", options: { 
				data:[{"id":"_self","text":"当前页面"},{"id":"_blank","text":"新窗口打开"}],
				cancelable: true,
				emptyText:"当前页面",
				valueFieldID: "frm[link_target]"
				
				} },
				
				
				{ display: "上级栏目", name: "frm[pid]", newline: true, type: "select", comboboxName: "pidSelect", options: { 
				cancelable: true,
				emptyText:"(无)",
				width: 180, 
				selectBoxWidth: 280,
				selectBoxHeight: 200, 
				//absolute:false,
				valueField: 'auto_id', 
				treeLeafOnly: false,
				tree: { 
					url: '?acl='+acl+'&method=pidFormJsonData&editId='+(formData.auto_id!=null?formData.auto_id:""),
					ajaxType:'get',
					autoCheckboxEven: false,
					single: true,
					idFieldName: 'auto_id',
					isExpand:false
					},
				valueFieldID: "frm[pid]"
				
				}},
				

				{ display: "栏目功能", name: "frm[content_module]", newline: true, type: "select", comboboxName: "contentModuleSelect", options: { 
				data:enumVars.menuModuleVars,
				cancelable: true,
				emptyText:"(空)",
				valueFieldID: "frm[content_module]"
				
				} },
				{ display: "显示下级菜单", name: "frm[show_submenu]", newline: true, type: "select", comboboxName: "show_submenuSelect", options: { 
				data:enumVars.boolVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[show_submenu]"
				
				} },
				{ display: "模板文件", name: "frm[action_method]", newline: true, type: "text"},
				{ display: "明细页模板", name: "frm[detail_method]", newline: true, type: "text",afterContent: '<div style="margin-right:10px;margin-left:6px;float:left;">用于资讯频道，可不填写</div>'},
				//{ display: "目录名称", name: "frm[url_path]", newline: true, type: "text"},
                <?
				if(CONFIG_STATIC_HTML){
				?>
				{ display: "目录名称", name: "frm[url_path]", newline: true, type: "text",afterContent: '<div style="margin-right:10px;margin-left:6px;float:left;">用于网站静态化,以 / 开头,如/news/hot,结尾不加/</div>'},
				<?
				}
				?>
				
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