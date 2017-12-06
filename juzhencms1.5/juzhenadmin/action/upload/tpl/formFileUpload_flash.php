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
<script src="res/js/Base64.js"></script>
<script>
var uploadUrlPath="<?=$global->uploadUrlPath?>";
var valueField="<?=$_GET["valueField"]?>";
$( document ).ready( function() {					  
	var fileUrl=window.parent.window.document.getElementById(valueField).value;	
	
	$('#content_value').val(window.parent.window.document.getElementById(valueField).value);
	
	if(fileUrl!=""){
		document.getElementById("uploadFileName").innerHTML=fileUrl;
		makeDownloadLink();
		
	}
	
	$("#deleteFileLink").click(function(){
		document.getElementById("uploadFileName").innerHTML="";
		document.getElementById("downloadDiv").style.display="none";
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
		document.getElementById("uploadFileName").innerHTML=data.savePath;
		makeDownloadLink();
		
		//将数据写入到父窗口表单
		window.parent.window.document.getElementById(valueField).value=data.savePath;
	}
}

function makeDownloadLink(){
	
	var file=document.getElementById("uploadFileName").innerHTML;
	var url_reg = /^(http:\/\/)|(https:\/\/)/i;
	if(!url_reg.test(file)){
		var base64=new Base64();
		var en=base64.Encode64(file);
		document.getElementById("downloadLink").href="index.php?acl=download&method=downloadFile&file="+en;
	}else{
		document.getElementById("downloadLink").href=file;
	}
	document.getElementById("downloadDiv").style.display="block";
	document.getElementById("deleteFileLink").style.display="block";
}


</script>

</head>

<body>



<div id="flashContent" style="float:left;">
		<embed id="uploadswf" src="res/swf/file_upload.swf" FlashVars="submitUrl=<?=urlencode("{$global->admin_siteUrlPath}/index.php?acl=upload&method=uploadFile&fieldName=Filedata&passport_id={$passport_id}&timestamp={$timestamp}&validate=".md5($token.$timestamp))?>&fileType=<?=urlencode("*.doc;*.docx;*.pdf;*.apk")?>&maxFileSize=20&callBackFunction=uploadCallback" quality=high pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash" width="375" height="85" wmode="transparent">
		</embed>
</div>

<div id="downloadDiv" style="float:left; padding-left:20px; line-height:25px; display:none;">
<a id="downloadLink" href="javascript:" target="download_frame"><span id="uploadFileName" ></span><span><br/>点击下载</span></a><a id="deleteFileLink" href="javascript:" style="display:block; float:right;">删除</a>
</div>

<iframe name="download_frame" id="download_frame" src="about:_blank" frameborder="0" scrolling="no" marginwidth="0"  width="0px" height="0px" allowtransparency="true"></iframe>


</body>
</html>