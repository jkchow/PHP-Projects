<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta charset="utf-8">
<?
//替换网站标题
$title=$global_params["content_title"];
if($_record["title"]!=""){
	$title="{$_record["title"]}-{$title}";
}elseif($local_menu["content_name"]!=""){
	$title="{$local_menu["content_name"]}-{$title}";
}
?>
<title><?=$title?></title>
<meta name="keywords" content="<?=$global_params["seo_keywords"]?>" />
<meta name="description" CONTENT="<?=$global_params["seo_description"]?>" />
<link rel="stylesheet" type="text/css" href="<?=$global->sysTplUrlPath?>skin/system.css">
<script  type="text/javascript" src="<?=$global->sysTplUrlPath?>js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$global->sysTplUrlPath?>js/jquery-impromptu/jquery-impromptu.css"/>
<script type="text/javascript" src="<?=$global->sysTplUrlPath?>js/jquery-impromptu/jquery-impromptu.js"></script>
<script>
var siteUrlPath="<?=$global->siteUrlPath?>";
var tplUrlPath="<?=$global->tplUrlPath?>";
</script>
<script type="text/javascript" src="<?=$global->sysTplUrlPath?>js/WebTools.js"></script>
<script type="text/javascript" src="<?=$global->tplUrlPath?>js/member_init.js"></script>
<script type="text/javascript" src="<?=$global->sysTplUrlPath?>js/init.js"></script>