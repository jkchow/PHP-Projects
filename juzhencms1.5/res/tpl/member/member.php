<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
</head>
<body>

<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200 mem-com-index">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<div class="mem-inners-r">
<div class="mem-toptits">会员中心</div>
<div class="mems-wraps">
<div class="mems-headers">

<div class="mems-person-pic"><img src="<?=$member["content_head"]?>" width="100" height="100"></div>
<div class="mems-person-infos">
<div class="user-name"><span><?=$member["content_firstname"].$member["content_lastname"]?></span>您好,欢迎登录！</div>
<div class="edits-infobtns"><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=memberInfo">修改资料</a><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=uploadHeadImgForm">上传头像</a></div>
</div>

</div>

<div class="memheader-tit"><span>通知公告</span>
<!--<a href="#">更多</a>-->
<div class="clear"></div>
</div>
<div class="memlist">
<?
$newsService=new newsService();
$newsList=$newsService->lists(231,10);
if(!is_array($newsList)){
?>
<div class="data-emptys"><img src="<?=$global->sysTplUrlPath?>skin/images/emptys.png" width="64" height="64">暂无数据</div>
<?
}else{
?>
<ul>
	<?
	foreach($newsList as $key=>$vl){
	?>
      <li><a href="<?=$vl["content_link"]?>" title="<?=$vl["content_name"]?>" target="_blank"><?=$vl["content_name"]?></a><span class="time"><?=substr($vl["create_time"],0,10)?></span><br>
      </li>
    <?
	}
	?>
</ul>
<?
}
?>
</div>

</div>


</div>

</div>

<div class="clear"></div>
</div>

<div class="clear"></div>
<div class="item-height"></div>
<div class="clear"></div>

<!--公共底部-->
<? include($global->tplAbsolutePath."common/member_footer.php"); ?>
</body>
</html>
