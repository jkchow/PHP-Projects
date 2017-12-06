<?php defined ('ALLOW_ACCESS' ) or die();?>
<?
$Passport=new Passport();
$passport_arr=$Passport->get_passport();
$passport_id=$passport_arr["ID"];
$token=$Passport->getToken($passport_id);
$timestamp=time();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件上传</title>
<script src="res/js/jquery-1.11.1.min.js"></script>
<script>
var uploadUrlPath="<?=$global->uploadUrlPath?>";
var valueField="<?=$_GET["valueField"]?>";
$( document ).ready( function() {
	var fileUrl=window.parent.window.document.getElementById(valueField).value;							
	if(fileUrl!=""){
		showImg(fileUrl);
	}
	
	$("#deleteFileLink").click(function(){
		document.getElementById("imgShow").src="";
		document.getElementById("imgShow").style.display="none";
		document.getElementById("deleteFileLink").style.display="none";
		//将数据写入到父窗口表单
		window.parent.window.document.getElementById(valueField).value="";
	});
	
});


function uploadCallback(resultParam){
	//alert(resultParam);
	var data = eval('(' + resultParam + ')');	
	if(data.error!=null){
		alert(data.msg);
		return;
	}
	if(data.savePath!=null){
		showImg(data.urlPath);
		//将数据写入到父窗口表单
		window.parent.window.document.getElementById(valueField).value=data.savePath;
	}
}

function showImg(fileUrl){
	var url_reg = /^http(s)?:\/\/.+/ig;
	if(!url_reg.test(fileUrl)){
		document.getElementById("imgShow").src=uploadUrlPath+fileUrl;
	}else{
		document.getElementById("imgShow").src=fileUrl;
	}
	document.getElementById("imgShow").style.display="block";
	document.getElementById("deleteFileLink").style.display="block";
}

function setLinkImg(obj){
	var imgSrc=$(obj).find("img").eq(0).attr("src");
	if(imgSrc==null || imgSrc==""){
		return false;
	}else{	
		$(obj).attr("href",imgSrc);
		return true;
	}
}


</script>

</head>

<body>



<div id="flashContent" style="float:left;">
		<embed id="uploadswf" src="res/swf/file_upload.swf" FlashVars="submitUrl=<?=urlencode("{$global->admin_siteUrlPath}/index.php?acl=upload&method=uploadFile&fieldName=Filedata&passport_id={$passport_id}&timestamp={$timestamp}&validate=".md5($token.$timestamp))?>&fileType=<?=urlencode("*.jpg;*.gif;*.png;*.bmp")?>&maxFileSize=1&callBackFunction=uploadCallback" quality=high pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash" width="375" height="85" wmode="transparent">
		</embed>
</div>

<div style="float:left; padding-left:20px;">
<a href="" target="_blank" onclick="setLinkImg(this)"><img id="imgShow" src=""  height="85" style="display:none"/></a>

</div>&nbsp;<a id="deleteFileLink" href="javascript:" style=" display:none; margin-top:45px;">删除</a>

</body>
</html>