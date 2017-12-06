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
				{ display: "会员", name: "frm[member_id]", newline: true, type: "select", 
					validate: {required:true,minlength:1}, 
					group: "提现申请", groupicon: groupicon,
					comboboxName: "member_mobile", options: { 
						width: 250,
						slide: false,
						selectBoxWidth: 505,
						selectBoxHeight: 340,
						valueField: 'auto_id',
						textField: 'content_mobile',
						grid: {
							columns: [
							{ display: 'ID', name: 'auto_id', align: 'center', width: 50 },
							{ display: '手机号', name: 'content_mobile', minWidth: 140 },
							{ display: '姓名', name: 'content_name', width: 140,align:'center'},
							{ display: '账户余额', name: 'account_balance', minWidth: 170 }
							], switchPageSizeApplyComboBox: false,
							url:"?acl=member&method=listsData",
							width: '100%',height:'100%',rownumbers:false,
							pageSize: 10, 
							checkbox: false
						},
						condition: { fields: [{ name: 'content_mobile', label: '手机号', width: 90, type: 'text' },
											  { name: 'content_name', label: '姓名', width: 90, type: 'text' },
											  { name: 'content_email', label: '邮箱', width: 90, type: 'text' }
											  ] }
					}
				},
				
				{ display: "提现金额", name: "frm[content_money]", newline: true, type: "text",validate: {required:true,minlength:1}},
				{ display: "提现方式", name: "frm[trans_type]", newline: true, type: "select", comboboxName: "trans_typeSelect", options: { 
				data:<? $DictionaryVars=new DictionaryVars(); echo json_encode($DictionaryVars->getVars("cashApplyTypeVars"))?>,
				cancelable: false,
				emptyText:null,
				valueFieldID: "frm[trans_type]"
				} },
				
				{ display: "真实姓名", name: "frm[content_name]", newline: true, type: "text", afterContent: '<div style="margin-right:10px;margin-left:6px;color:#000;float:left;">用于核实支付宝及银行信息</div>'},
				{ display: "提现账户", name: "frm[account_info]", newline: true, type: "textarea",afterContent: '<div style="margin-right:10px;margin-left:6px;color:#000;float:left;">支付宝账号或开户银行信息</div>'},
				
				{ display: "备注", name: "frm[content_desc]", newline: true, type: "textarea",validate: {required:true,minlength:1}},
				
				{ display: "处理状态", name: "frm[content_status]", newline: true, type: "select", comboboxName: "content_statusSelect", options: { 
				data:enumVars.agreeVars,
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
			$("input[name='member_mobile']").val(formData["frm[member_mobile]"]);
			
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
								CmsTools.jumpBack();
							}else{
								alert(data.msg);
							}
					  }
					});
				}						 
			});
			
			$("#btnCancel").click(function(){					   	
				history.back();
			});
			
			
		
        });
		
		
		
    </script> 

</head>
<body style="padding:10px"> 
    <form id="dataform" method="post" action="?acl=<?=$_REQUEST["acl"]?>&method=save&backUrl=<?=$_REQUEST["backUrl"]?>">
    
    <?
	if($_record["formData"]["frm[content_status]"]=="" || $_record["formData"]["frm[content_status]"]=="0"){
	?>
    <input type="button" value="保存" id="btnSave" class="l-button l-button-submit" /> 
	<?
	}
	?>
    <input type="button" value="取消" id="btnCancel" class="l-button l-button-reset"/>
    
    </form> 
    
    
</body>   
</html>