<?
//获取系统设定的最低提现金额
$paramsService=new paramsService();
$min_apply_money=$paramsService->getParamValue("min_cash_apply");
if($min_apply_money==""){
	$min_apply_money=100;
}
?>
<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script>

function submit_cash_apply(){
	$("#content_money").val($.trim($("#content_money").val()));
	
	var content_money=$("#content_money").val();
	var numReg=/^\d+(\.\d+)?$/;
	if(!numReg.test(content_money)){
		alert("请输入正确的提现金额");
		$("#content_money").val("");
		$("#content_money").focus();
		return;
	}
	
	content_money=parseFloat(content_money);
	
	if(content_money<<?=$min_apply_money?>){
		alert("提现金额最低为<?=$min_apply_money?>元");
		$("#content_money").val("");
		$("#content_money").focus();
		return;
	}
	
	var accountBalance=parseFloat($("#accountBalance").val());
	if(content_money>accountBalance){
		alert("输入的提现金额不能超出账户余额");
		$("#content_money").val(accountBalance);
		$("#content_money").focus();
		return;
	}
	
	if($("#content_name").val()==""){
		alert("请输入真实姓名");
		$("#content_name").focus();
		return;
	}
	
	if($("#account_info").val()==""){
		alert("请输入收款账户信息");
		$("#account_info").focus();
		return;
	}
	
	var formData=$("#cashApplyForm").serialize();
	$.ajax({
		type: "POST",
		url:"index.php?acl=member&method=saveCashApply",
		processData:true,//提交时注意必须有这个属性
  		data:formData,
		dataType:'json',
		success:function(data){
			if(data.result){
				alert(data.msg);
				location.reload();
			}else{
				alert(data.msg);
				location.reload();
				
			}
		}
	});
}

</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<div class="mem-inners-r">
<div class="mem-toptits">提现申请</div>
<div class="mems-wraps">


<form id="cashApplyForm">
<input type="hidden" id="accountBalance" value="<?=accountBalance?>"/>
<div class="adjust-frm">

<div class="frm-cell">
<div class="frm-tit">账户余额:</div>
<div class="frm-text">￥<?=$member["account_balance"]?></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>提现金额:</div>
<div class="frm-inputs"><input id="content_money" name="frm[content_money]" type="text" value="" placeholder="请输入提现金额,最低<?=$min_apply_money?>元"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>提现方式:</div>
<div class="frm-select">
<?
$DictionaryVars=new DictionaryVars();
$cashApplyTypeVars=$DictionaryVars->getVars("cashApplyTypeVars");
if(is_array($cashApplyTypeVars))
foreach($cashApplyTypeVars as $key=>$vl){
?>
<input type="radio" name="frm[trans_type]" value="<?=$vl["id"]?>" <? if($key=="0") echo 'checked'; ?>/><?=$vl["text"]?>
<?
}
?>
</div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>真实姓名:</div>
<div class="frm-inputs"><input id="content_name" name="frm[content_name]" type="text" value="" placeholder="请输入姓名,需与提现账户匹配"/></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell">
<div class="frm-tit"><font class="redclass">*</font>收款账户:</div>
<div class="frm-inputs"><input id="account_info" name="frm[account_info]" type="text" value="" placeholder="请输入收款账户信息"></div>
<div class="frm-tips"><em class="onShow"></em></div>
</div>


<div class="frm-cell"><div class="frm-tit">&nbsp;</div>
<div class="frms-btns"><a href="javascript:" onClick="submit_cash_apply()" class="mem-com-btns">提交</a></div>

</div>


</div>
</form>




<div class="system-account">

<div class="system-acctit2">提现申请记录</div>

<div class="system-table">
<table width="100%" border="0">
<thead>
  <tr>
    <th>日期</th>
    <th>金额</th>
    <th>处理状态</th>

  </tr>
</thead>
  
<tbody>
<?
$cashApplyService=new cashApplyService();
$DictionaryVars=new DictionaryVars();
$record=$cashApplyService->listsPage(16);
if(is_array($record["list"])){
	foreach($record["list"] as $key=>$vl){
?>
  <tr>
    <td><?=substr($vl["create_time"],0,10)?></td>
    <td>￥<?=$vl["content_money"]?></td>
    <td><?=$DictionaryVars->getText($enumVars["agreeVars"],$vl["content_status"])?></td> 
  </tr>
<?
	}
}else{
?>
  <tr>
    <td colspan="3">暂时没有相关记录</td>
  </tr>
<?
}
?>
</tbody>
</table>

</div>

<div class="clear"></div>
<div class="page">
<?=$record["page"]?>       
</div>


</div>





</div>


</div>

</div>


</div>

<div class="clear"></div>
<div class="item-height"></div>
<div class="clear"></div>

<!--公共底部-->
<? include($global->tplAbsolutePath."common/member_footer.php"); ?>

</body>
</html>
