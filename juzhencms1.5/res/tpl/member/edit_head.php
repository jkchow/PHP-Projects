<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
<script>

$(function(){

	$("#content_head_file").on("change",function(){
		var file_value=$("#content_head_file").val();
		//alert(file_value);
		if(file_value!=""){
			$("#uploadhead_form").submit();
		}
	});
	
	$("#save_btn").click(function(){
		
		var file_value=$("#content_head").val();
		if(file_value==""){
			location.href="index.php?acl=member&method=member";
			return;
		}	
								  
		$.ajax({
			type: "get",
			url: "index.php?acl=member&method=saveHeadImgValue&content_head="+file_value,
			dataType:'json',
			success:function(data){
				//alert(data.msg);
				location.href="index.php?acl=member&method=member";
			}
		});
	
	});
	
	$("#cancel_btn").click(function(){
		location.href="index.php?acl=member&method=member";
	});

});

</script>
</head>
<body>

<? include($global->tplAbsolutePath."common/member_header.php"); ?>



<div class="mem-com-1200">

<? include($global->tplAbsolutePath."common/member_leftmenu.php"); ?>

<div class="mem-right">
<?
//获取当前会员的头像
$memberService=new memberService();
$mid=$memberService->getLoginMemberInfo("auto_id");
$memberInfo=$memberService->getMember($mid);
?>
<div class="mem-inners-r">
<div class="mem-toptits">修改头像</div>
<div class="mems-wraps">

<form id="uploadhead_form" action="<?=$global->siteUrlPath?>/index.php?acl=member&method=uploadHeadImg" method="post" enctype="multipart/form-data" data-ajax="false" target="uploadframe">
<input type="hidden" name="frm[content_head]" id="content_head"/>
<div class="memtable-frm">
<table width="100%" border="0">
  <tr>
    <td width="196"><em class="font-red">*</em><span class="mems-tits">选择您要上传的头像：</span></td>
    <td width="594" ><div class="files-btns files-btns20"><a class="filebtns filebtns20">上传头像</a>
    <div class="files-css files-css20"><input name="content_head_file" id="content_head_file" value="" autocomplete="off" accept="image/*" type="file"/></div></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><em class="suby">仅支持JPG、GIF、PNG、JPEG、BMP格式，文件小于4M</em><br /></td>
  </tr>
  
</table>
</div>
</form>



<div class="clear"></div>
<div class="pic-rights"><img id="member_head_img" src="<?=$memberInfo["content_head"]?>" width="300" height="300" />
<div class="clear"></div>
<div class="com-height30"></div>
<div class="frms-btns"><a id="save_btn" href="javascript:">确定</a></div>
</div>
<div class="wlefts">
效果预览<br /><br />

你上传的图片会自动生成2种尺寸，请注意小尺寸的头像
是否清晰<br /><br /><br />
<img id="member_head_img2" src="<?=$memberInfo["content_head"]?>" width="176" height="160" /> &nbsp;&nbsp;&nbsp;76*160px<br />
<br /><br />
<img id="member_head_img3" src="<?=$memberInfo["content_head"]?>" width="116" height="105" /> &nbsp;&nbsp;&nbsp;116*105px</div>

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
