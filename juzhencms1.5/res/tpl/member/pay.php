<?
$order=$_record["order"];
$memberService=new memberService();
$mid=$memberService->getLoginMemberInfo("auto_id");
//查询会员账户余额
$memberAccountService=new memberAccountService();
$account_balance=$memberAccountService->getAccountBalance($mid);
?>
<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script>
function payConfirmTip(obj){
	
	linkStr=$(obj).attr("href");
	//获取余额支付的选择状态
	if($("#useBalance").size()>0 && $('#useBalance').attr('checked')){
		//在链接中添加&useBalance=1
		if(linkStr.indexOf("&useBalance=1") ==-1){
			linkStr+="&useBalance=1";
			$(obj).attr("href",linkStr);
		}
	}else{
		//在链接中去掉&useBalance=1
		if(linkStr.indexOf("&useBalance=1") >= 0){
			linkStr=linkStr.replace("&useBalance=1", "");
			$(obj).attr("href",linkStr);
		}
	}
	
	
	$.prompt("请在新打开的页面中完成支付操作，支付完成后点击根据支付结果进行相关操作", {
		title: "提示",
		buttons: { "支付成功": 1,"支付失败": 2 },
		close: function(e,v,m,f){
			if(v==1){
				location.href="<?=base64_decode($_GET["success_url"])?>";
			}else{
				location.href="<?=base64_decode($_GET["fail_url"])?>";
			}
			
		}
	});
}
</script>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">



<div class="mem-right mem-right2">
<div class="mem-inners-r">
<div class="mem-toptits">订单支付</div>
<div class="mems-wraps">
<div class="system-account">
<div class="account-id"><span>订单号：</span><?=$order["order_sn"]?>
</div>
<div class="account-id"><span>金额：</span>￥<?=$order["pay_money"]?>
</div>
<div class="account-id"><span>说明：</span><?=$order["name"]?>
</div>

<?
//如果不是账户充值并且账户余额大于0，显示余额支付选项
if($order["type"]!=4 && $account_balance>0){
?>
<div class="account-payinfos"><input type="checkbox" value="1" id="useBalance" name="useBalance" checked/>使用账户余额（余额￥<?=$account_balance?>）</div>
<?
}
?>

<div class="account-payinfos">请选择支付方式点击图标去完成支付操作</div>

<div class="pay-btn">
<?
$onlinePayService=new onlinePayService();
$onlinePayTypeList=$onlinePayService->payType["pc"];
if(is_array($onlinePayTypeList))
foreach($onlinePayTypeList as $key=>$vl){
	$vl["content_img"]=$global->sysSiteUrlPath."/".$vl["img"];
	$vl["content_link"]=$global->sysSiteUrlPath."/".$vl["payLink"]."?order_sn={$order["order_sn"]}&success_url={$_GET["success_url"]}&fail_url={$_GET["fail_url"]}";
?>
<a href="<?=$vl["content_link"]?>" onClick="payConfirmTip(this)" target="_blank">
<img src="<?=$vl["content_img"]?>" width="200" height="80" />
</a>
<?
}
?>

</div>


<div class="clear"></div>



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
