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
                title: '产品信息',
                width: '100%',
                height : 1050
            });
			
			//创建表单结构
            var mainform = $("#dataform");
            mainform.ligerForm({
                inputWidth: 280, labelWidth: 90, space: 40,validate: true,
                fields: [
                { name: "auto_id", type: "hidden" },
				/*{ name: "frm[content_img]", type: "hidden" },
				{ name: "frm[content_file]", type: "hidden" },
				{ name: "frm[content_body]", type: "hidden" },*/
                { display: "产品名称", name: "frm[content_name]", newline: true, type: "text", 
					validate: {required:true,minlength:2}
				},
				
				{ display: "发行单位", name: "frm[member_id]", newline: true, type: "select", 
					//validate: {required:true,minlength:1}, 
					comboboxName: "frm[content_org]", options: { 
						width: 250,
						slide: false,
						selectBoxWidth: 445,
						selectBoxHeight: 240,
						valueField: 'auto_id',
						textField: 'content_name',
						grid: {
							columns: [
							{ display: 'ID', name: 'auto_id', align: 'center', width: 50 },
							{ display: '用户名', name: 'content_user', minWidth: 130 },
							{ display: '名称', name: 'content_name', width: 130,align:'center' },
							{ display: '类型', name: 'content_type', minWidth: 130,type:"enumVars",enumVars:enumVars.memberTypeVars }
							], switchPageSizeApplyComboBox: false,
							url:"?acl=member&method=listsData&use=bankSelect",
							width: '100%',height:'100%',rownumbers:false,
							pageSize: 10, 
							checkbox: false
						},
						condition: { fields: [{ name: 'content_name', label: '名称', width: 90, type: 'text' }
											  //,{ name: 'course_sn', label: '编号', width: 90, type: 'text' }
											  ] }
					} 
				},
				
				{ display: "产品类型", name: "frm[content_type]", newline: true, type: "select",comboboxName: "content_typeSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=productTypeVars",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[content_type]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_type]"
				}},
				
				{ display: "认购币种", name: "frm[content_moneytype]", newline: true, type: "select",comboboxName: "content_typeSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=moneyTypeVars",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[content_moneytype]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_moneytype]"
				}},
				
				{ display: "销售状态", name: "frm[content_status]", newline: true, type: "select",comboboxName: "content_typeSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=sellStatusVars",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[content_status]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[content_status]"
				}},
				
				{ display: "销售开始日期", name: "frm[sell_begindate]", newline: true, type: "date",options: { format: "yyyy-MM-dd",showTime: false } },
				{ display: "销售结束日期", name: "frm[sell_enddate]", newline: true, type: "date",options: { format: "yyyy-MM-dd",showTime: false } },
				
				
				{ display: "起购金额分类", name: "frm[buy_minmoney_type]", newline: true, type: "select",comboboxName: "buy_minmoney_typeSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=buyMinMoneyVars",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[buy_minmoney_type]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[buy_minmoney_type]"
				}},
				{ display: "起购金额(万)", name: "frm[buy_minmoney]", newline: true, type: "text"},			
				{ display: "递增金额(万)", name: "frm[buy_increasemoney]", newline: true, type: "text"},			
				{ display: "投资周期分类", name: "frm[during_days_type]", newline: true, type: "select",comboboxName: "during_days_typeSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=investmentCycle",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[during_days_type]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[during_days_type]"
				}},
				{ display: "投资周期(天)", name: "frm[during_days]", newline: true, type: "text"},
				
				{ display: "年化收益分类", name: "frm[year_earnings_type]", newline: true, type: "select",comboboxName: "year_earnings_typeSelect", options: { 
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=expectedEarnings",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[year_earnings_type]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[year_earnings_type]"
				}},
				{ display: "年化收益", name: "frm[year_earnings]", newline: true, type: "text"},
				
				{ display: "收益开始日期", name: "frm[earnings_begindate]", newline: true, type: "date",options: { format: "yyyy-MM-dd",showTime: false } },
				
				{ display: "收益类型", name: "frm[earnings_type]", newline: true, type: "select",comboboxName: "content_typeSelect", options: {
				//data:enumVars.publishVars,
				url:"index.php?acl=vars&method=getDictionaryVars&var=earningsTypeVars ",
				onSuccess: function(){//ajax加载选项成功后设置聚焦
						this.selectValue($(formData).attr("frm[earnings_type]"));
				},
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[earnings_type]"
				}},
				
				{ display: "发行地区", name: "frm[sell_area]", newline: true, type: "text"},
				{ display: "发行对象", name: "frm[sell_object]", newline: true, type: "text"},
				
				
				
				{ display: "发布状态", name: "frm[publish]", newline: true, type: "select", comboboxName: "publishSelect", options: { 
				data:enumVars.publishVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[publish]"
				} },
				{ display: "是否推荐", name: "frm[recommend]", newline: true, type: "select", comboboxName: "recommendSelect", options: { 
				data:enumVars.boolVars,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[recommend]"
				} },
				
				{ display: "收益率说明", name: "frm[earnings_desc]", newline: true, type: "textarea"},
				{ display: "投资范围", name: "frm[investment_desc]", newline: true, type: "textarea"},
				{ display: "提前终止条件", name: "frm[stop_desc]", newline: true, type: "textarea"},
				{ display: "募集规划条件", name: "frm[collect_desc]", newline: true, type: "textarea"},
				{ display: "申购条件", name: "frm[buy_desc]", newline: true, type: "textarea"},
				//{ display: "关键词", name: "frm[content_keywords]", newline: true, type: "text"},
				
				
				
				
				
				
				{ display: "创建时间", name: "frm[create_time]", newline: true, type: "date",options: { format: "yyyy-MM-dd hh:mm",showTime: true } }
                ]
            });

			var form = liger.get("dataform");
			/*form.setData({
				"frm[publish]": '1',
				"frm[create_time]": new Date()
            });*/
			form.setData(formData);
			$("input[name='frm\\[content_org\\]']").val(formData["frm[content_org]"]);

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
                title: '图片附件',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formImgUpload&valueField=frm[content_img]"
            });
			$("#panelFileUpload").ligerPanel({
				frameName:"formFileUpload",							 
                title: '文件下载',
                width: '100%',
                height : 130,
				url: "?acl=upload&method=formFileUpload&valueField=frm[content_file]"
            });
			$("#panelCkeditor").ligerPanel({
                frameName:"formCkeditor",
				title: '正文内容',
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
    <!--<div id="panelImgUpload" style=" margin-top:10px; clear:both;">
    </div>
	<div id="panelFileUpload" style=" margin-top:10px; clear:both;">
    </div>
    <div id="panelCkeditor" style=" margin-top:10px; clear:both;">
    </div>-->
</body>    
</html>