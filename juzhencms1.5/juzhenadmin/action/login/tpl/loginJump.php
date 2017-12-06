<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录跳转</title>
</head>

<body>
<script>
if(window.parent){
	window.parent.window.location.href="?acl=login&method=loginform";
}else{
	location.href="?acl=login&method=loginform";
}
</script>
</body>
</html>