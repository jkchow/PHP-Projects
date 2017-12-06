<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
</head>
<body>

<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<?
$memberService=new memberService();
$mid=$memberService->getLoginMemberInfo("auto_id");
if($mid!=""){
	//查询会员信息
	$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$mid}'");
	
	if($member["content_head"]=="")
		$member["content_head"]="default_head.jpg";
	$member["content_head"]=$global->uploadUrlPath.$member["content_head"];
	
}
?>
<div class="mem-inners-r">
<div class="mem-toptits">基本信息</div>
<div class="mems-wraps">
<div class="adjust-frm">



<div class="frm-cell">
<div class="frm-tit">头像:</div>
<div class="frm-uploads"><div class="myheads"><img src="<?=$member["content_head"]?>" width="100" height="100"></div>
<div class="uploads-logos"><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=uploadHeadImgForm">上传头像</a></div>
</div>
</div>

<!--<div class="frm-cell">
<div class="frm-tit">手机号:</div>
<div class="frm-text"><?=$member["content_mobile"]?></div>
</div>

<div class="frm-cell">
<div class="frm-tit">邮箱:</div>
<div class="frm-text"><?=$member["content_email"]?></div>
</div>-->

<div class="frm-cell">
<div class="frm-tit">昵称:</div>
<div class="frm-text"><?=$member["content_name"]!=""?$member["content_name"]:"未填写"?></div>
</div>

<div class="frm-cell">
<div class="frm-tit">性别:</div>
<div class="frm-text"><? 
	$DictionaryVars=new DictionaryVars(); 
	if($member["content_sex"]>0)
		echo $DictionaryVars->getText($enumVars["sexVars"],$member["content_sex"]); 
	else
		echo "未填写";
?></div>
</div>

<div class="frm-cell">
<div class="frm-tit">地址:</div>
<div class="frm-text"><?=$member["content_address"]!=""?$member["content_address"]:"未填写"?></div>
</div>


<div class="frm-cell"><div class="frm-tit">&nbsp;</div>
<div class="frms-btns"><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=editInfoForm">修改信息</a></div>

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
