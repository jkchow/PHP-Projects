<?
$memberService=new memberService();
$loginMember=$memberService->getLoginMemberInfo();
$member=$memberService->getMember($loginMember["auto_id"]);
//$memberGroup=$dao->get_row_by_where($dao->tables->member_group,"where auto_id='{$member["group_id"]}'");
?>
<div class="mem-left">
<div class="navs">
<div class="my-mem"><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=member">会员中心</a></div>
<div class="mems-pic2"><img src="<?=$member["content_head"]?>" width="90" height="90"><br><span><?=$member["content_name"]?></span>,您好
</div>

<?
//根据不同的会员分类显示不同的菜单
if($member["content_type"]=="1" || $member["content_type"]==""){//个人会员菜单
?>
<ul>

<li <? if(in_array($_REQUEST["method"],array("memberInfo","editInfoForm","uploadHeadImgForm","account","safe"))) echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=memberInfo"><span>会员信息</span></a>
<ul>
<li <? if(in_array($_REQUEST["method"],array("memberInfo","editInfoForm"))) echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=memberInfo"><span>个人资料</span></a></li>

<li <? if(in_array($_REQUEST["method"],array("account","accountApply"))) echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=account"><span>我的账户</span></a>
</li>

<li <? if($_REQUEST["method"]=="safe") echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=safe"><span>安全设置</span></a></li>
</ul>
</li>



<li><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=logout"><span>退出登录</span></a>
</li>

</ul>
<?
}elseif($member["content_type"]=="2"){//企业会员菜单
?>
<ul>

<li <? if(in_array($_REQUEST["method"],array("memberInfo","editInfoForm","uploadHeadImgForm","passwordForm"))) echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=memberInfo"><span>会员信息</span></a>
<ul>
<li <? if(in_array($_REQUEST["method"],array("memberInfo","editInfoForm"))) echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=memberInfo"><span>基本信息</span></a></li>
<li <? if($_REQUEST["method"]=="passwordForm") echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=passwordForm"><span>修改密码</span></a></li>
</ul>
</li>

<li <? if(in_array($_REQUEST["method"],array("account","accountApply"))) echo "class=\"cr\""; ?>><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=account"><span>我的账户</span></a>
</li>

<li><a href="<?=$global->siteUrlPath?>/index.php?acl=member&method=logout"><span>退出登录</span></a>
</li>

</ul>
<?
}
?>
</div>

</div>