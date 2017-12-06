<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎界面</title>
    
    <style type="text/css">
        p.l-log-content
        {
            margin: 0;
            padding: 0;
            padding-left: 20px;
            line-height: 22px;
            font-size: 12px;
        }
        span.l-log-content-tag
        {
            color: #008000;
            margin-right: 2px;
            font-weight: bold;
        }
        h2.l-title
        {
            margin: 7px;
            padding: 0;
            font-size: 17px;
            font-weight: bold;
        }
        h3.l-title
        {
            margin: 4px;
            padding: 0;
            font-size: 15px;
            font-weight: bold;
        }
        a {
            color:#1870A9;
        }
        a.hover {
            color: #BC2A4D;
        }
    </style>
</head>
<body style="background: white; font-size: 12px;"> 
 
    <h2>当前站点：<?=$_record["topic"]["content_name"]?></h2>
    <!--<h2>尊敬的 <?=$_record["user"]["NAME"]?>，您好</h2>-->
    <p class="l-log-content">当前登录用户：<?=$_record["user"]["USER"]?></p>
    <p class="l-log-content">登录时间：<?=$_record["user"]["LOGINTIME"]?></p>

    
</body>
</html>
