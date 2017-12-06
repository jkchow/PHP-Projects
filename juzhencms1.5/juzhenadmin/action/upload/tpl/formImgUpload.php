<?php defined ('ALLOW_ACCESS' ) or die();?>
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
		document.getElementById("uploadFileForm").reset();
	});
	
	$("#content_file").on("change",function(){
		var file_value=$("#content_file").val();
		if(file_value!=""){
			$("#uploadFileForm").submit();
		}	
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



<form id="uploadFileForm" action="index.php?acl=upload&method=uploadImgCallback" method="post" enctype="multipart/form-data" data-ajax="false" target="uploadframe">
<input type="hidden" name="fieldName" value="content_file"/>
<input type="hidden" name="imgWidth" value="<?=$_GET["imgWidth"]?>"/>
<input type="hidden" name="imgHeight" value="<?=$_GET["imgHeight"]?>"/>
<input type="hidden" name="cutType" value="<?=$_GET["cutType"]?>"/>
<input type="file" name="content_file" id="content_file" value="" autocomplete="off" accept="image/*" style="width:250px;height:23px; border:#C1C1C1 solid 1px; float:left;"/>
</form>

<div style="float:left;margin-left:10px;">
<a href="" target="_blank" onclick="setLinkImg(this)"><img id="imgShow" src=""  height="85" style="display:none"/></a>
</div>


&nbsp;<a id="deleteFileLink" href="javascript:" style=" display:none; margin-top:5px;width:60px;height:21px; border:#C1C1C1 solid 1px; text-decoration:none; font-size:12px; text-align:center; line-height:21px; background:#EBEBEB; float:left; color:#000;margin-top:0px;margin-left:10px;">删除</a>


<iframe name="uploadframe" id="uploadframe" src="" frameborder="0" scrolling="no" marginwidth="0"  width="0" height="0" allowtransparency="true" style="display:none;"></iframe>
</body>
</html>