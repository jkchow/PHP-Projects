<?php defined ('ALLOW_ACCESS' ) or die();?>
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


<form id="uploadFileForm" action="index.php?acl=upload&method=uploadFileCallback" method="post" enctype="multipart/form-data" data-ajax="false" target="uploadframe">
<input type="hidden" name="fieldName" value="content_file"/>
<input type="file" name="content_file" id="content_file" value="" autocomplete="off" accept="image/*" style="width:250px;height:23px; border:#C1C1C1 solid 1px; float:left;"/>
</form>

<div id="downloadDiv" style=" display:none; float:left;">
<span id="uploadFileName" style="float:left;margin-right:10px;margin-left:10px;"></span>
<a id="downloadLink" href="javascript:" target="uploadframe" style=" margin-top:5px;width:60px;height:21px; border:#C1C1C1 solid 1px; text-decoration:none; font-size:12px; text-align:center; line-height:21px; background:#EBEBEB; float:left; color:#000;margin-top:0px; float:left;">点击下载</a>
<a id="deleteFileLink" href="javascript:" style=" margin-top:5px;width:60px;height:21px; border:#C1C1C1 solid 1px; text-decoration:none; font-size:12px; text-align:center; line-height:21px; background:#EBEBEB; float:left; color:#000;margin-top:0px;margin-left:10px;float:left;">删除</a>
</div>

<iframe name="uploadframe" id="uploadframe" src="" frameborder="0" scrolling="no" marginwidth="0"  width="0" height="0" allowtransparency="true" style="display:none;"></iframe>

</body>
</html>