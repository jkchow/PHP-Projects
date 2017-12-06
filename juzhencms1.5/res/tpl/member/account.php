<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script>
function fillMoney(){
	var formData=$("#fillForm").serialize();
	$.ajax({
		type: "POST",
		url:"index.php?acl=member&method=fillMoney",
		processData:true,//提交时注意必须有这个属性
  		data:formData,
		dataType:'json',
		success:function(data){
			if(data.result){
				//alert(data.msg);
				location.href=data.url;
				
				
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
<div class="mem-toptits">账户管理</div>
<div class="mems-wraps">
<div class="system-account">
<div class="system-acctit">
<?
$memberAccountService=new memberAccountService();
?>
您目前账户余额：<em>￥<?=$member["account_balance"]?></em>
</div>
<div class="system-accsearch">
<form id="fillForm">
充值金额：<input id="fill_money" name="fill_money" type="text">
<div class="frms-btns"><a href="javascript:" onClick="fillMoney()">充值</a></div><div class="frms-btns">
<a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=accountApply">提现</a>
</div>
</form>
</div>

<div class="system-acctit2">账户记录</div>

<div class="system-table">
<table width="100%" border="0">
<thead>
  <tr>
    <th>日期</th>
    <th>事项</th>
    <th>金额</th>
    <th>账户余额</th>
  </tr>
</thead>
  
<tbody>
<?
$record=$memberAccountService->listsPage(25);
if(is_array($record["list"])){
	foreach($record["list"] as $key=>$vl){
		if($vl["content_money"]>=0){
			$vl["content_money"]="+".$vl["content_money"];
		}

?>
  <tr>
    <td><?=substr($vl["create_time"],0,10)?></td>
    <td><?=mb_substr($vl["content_desc"],0,20,"utf-8")?></td>
    <td><?=$vl["content_money"]?></td>
    <td><?=$vl["balance_monay"]?></td>
  </tr>
<?
	}
}else{
?>
  <tr>
    <td colspan="4">暂时没有相关记录</td>
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
