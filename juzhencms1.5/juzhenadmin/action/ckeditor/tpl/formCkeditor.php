<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ckeditor编辑器</title>
<script src="res/js/jquery-1.11.1.min.js"></script>
<script src="res/js/ckeditor/ckeditor.js"></script>
<script src="res/js/ckeditor/adapters/jquery.js"></script>
<script>
$( document ).ready( function() {
	$('#content_value').val(window.parent.window.document.getElementById("<?=$_GET["valueField"]?>").value);											
	$('#content_value').ckeditor();
});

function getCkeditorValue(){
	var editor=CKEDITOR.instances.content_value;
	//return editor.document.getBody().getHtml();//获取html
	//return editor.document.getBody().getText();//获取纯文本
	return editor.getData();
}

</script>

</head>

<body>
<textarea id="content_value"></textarea>
</body>
</html>