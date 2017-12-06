<?
$param=(array)json_decode(base64_decode($_GET["param"]));

if($param["video"]==""){
	echo "视频不存在";
	exit;
}

if(preg_match('/^http(s?):/i',$param["video"])){
    $videoUrl=$param["video"];
}else{
	$videoUrl=$global->uploadUrlPath."/".$param["video"];
}

if($param["img"]!=""){
	if(preg_match('/^http(s?):/i',$param["img"])){
		$imgUrl=$param["img"];
	}else{
		$imgUrl=$global->uploadUrlPath."/".$param["img"];
	}
}else{
	$imgUrl="";
}

if($param["width"]==""){
	$param["width"]="100%";
}else{
	$param["width"]=str_replace("px","",$param["width"]);
}
if($param["height"]==""){
	$param["height"]="400";
}else{
	$param["height"]=str_replace("px","",$param["height"]);
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>视频播放器</title>
<link rel="stylesheet" type="text/css" href="<?=$global->tplUrlPath?>js/CuSunPlayerMobile/images/common.css"/>
<script type="text/javascript" src="<?=$global->tplUrlPath?>js/CuSunPlayerMobile/js/jquery172.js"></script>
<script type="text/javascript" src="<?=$global->tplUrlPath?>js/CuSunPlayerMobile/js/action.js"></script>
</head>

<body>

<!--content/begin-->
<div id="content" >
<div class="close_light_bg" id="close_light_bg"></div>
<div class="video" id="CuPlayer" >
<SCRIPT LANGUAGE=JavaScript>
<!--
var vID        = "";
var vWidth     = "100%";
var vHeight    = "<?=$param["height"]?>";
var vFile      = "<?=$global->tplUrlPath?>js/CuSunPlayerMobile/CuSunV2set.xml";//参数配置文件,可以修改是否自动播放、颜色等
var vPlayer    = "<?=$global->tplUrlPath?>js/CuSunPlayerMobile/player.swf?v=2.5";
var vPic       = "<?=$imgUrl?>";
var vCssurl    = "<?=$global->tplUrlPath?>js/CuSunPlayerMobile/images/mini.css";

//PC,安卓,iOS,这个要设置绝对地址。不然手机浏览时视频文件的读取路径和PC版不一致
var vMp4url    = "<?=$videoUrl?>";

//-->
</SCRIPT> 
<script class="CuPlayerVideo" data-mce-role="CuPlayerVideo" type="text/javascript" src="<?=$global->tplUrlPath?>js/CuSunPlayerMobile/js/CuSunX1.min.js"></script>
</div>


</body>
</html>