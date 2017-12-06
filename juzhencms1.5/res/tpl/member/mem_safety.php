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
<div class="mem-inners-r">
<div class="mem-toptits">安全设置</div>
<div class="mems-wraps">

<div class="mod-safety">

<div class="safety-cells"><span>登录密码</span><em>互联网账号存在被盗风险，建议您定期更改密码以保护账户安全。</em>
<a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=passwordForm">修改</a>
</div>
<div class="safety-cells"><span>注册手机</span><em>可用于快速找回登录密码</em>
<a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=changeMobileForm_1">修改</a>
</div>
<div class="safety-cells"><span>注册邮箱</span><em>可用于快速找回登录密码</em>
<a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=changeEmailForm">修改</a>
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
