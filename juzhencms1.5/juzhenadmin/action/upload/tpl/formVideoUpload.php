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
<title>视频上传</title>
<script src="res/js/jquery-1.11.1.min.js"></script>
<script src="res/js/flowplayer-3.2.18/flowplayer-3.2.13.min.js"></script>
<script>
var uploadUrlPath="<?=$global->uploadUrlPath?>";
var valueField="<?=$_GET["valueField"]?>";
$( document ).ready( function() {					  
	var videoUrl=window.parent.window.document.getElementById(valueField).value;
	if(videoUrl!=""){
		showPlayer(videoUrl);
	}
	$("#deleteFileLink").click(function(){
		$("#player").html("");
		$("#player").hide();
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
		showPlayer(data.savePath);
		//将数据写入到父窗口表单
		window.parent.window.document.getElementById(valueField).value=data.savePath;
	}
}

function showPlayer(videoUrl){
	var url_reg = /^(http:\/\/)|(https:\/\/)/i;
	if(!url_reg.test(videoUrl)){
		videoUrl=uploadUrlPath+videoUrl;
	}
	flowplayer("player","res/js/flowplayer-3.2.18/flowplayer-3.2.18.swf",{
	   clip:{
		   url: videoUrl,
		   autoPlay: false,
		   autoBuffering: true
		   } 
	});
	$("#player").show();
	document.getElementById("deleteFileLink").style.display="block";
}


</script>

</head>

<body>



<div id="flashContent">
		<embed id="uploadswf" src="res/swf/file_upload.swf" FlashVars="submitUrl=<?=urlencode("{$global->admin_siteUrlPath}/index.php?acl=upload&method=uploadFile&fieldName=Filedata&passport_id={$passport_id}&timestamp={$timestamp}&validate=".md5($token.$timestamp))?>&fileType=<?=urlencode("*.flv;*.mp4")?>&maxFileSize=20&fieldName=Filedata&callBackFunction=uploadCallback" quality=high pluginspage="http://www.adobe.com/go/getflashplayer" type="application/x-shockwave-flash" width="375" height="85" wmode="transparent">
		</embed>
</div>

<div style="padding-top:5px; width:500px; float:left;">

<div id="player" style="width:480px; height:320px"></div>


</div>
<a id="deleteFileLink" href="javascript:" style="float:left; display:none; width:40px; margin-top:305px;">删除</a>
</body>
</html>