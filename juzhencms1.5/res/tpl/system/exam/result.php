<?
$resultRecord=$dao->get_row_by_where($dao->tables->exam_record,"where auto_id='{$_GET["id"]}'");
$exam=$dao->get_row_by_where($dao->tables->exam,"where auto_id='{$resultRecord["pid"]}'");
$exam_result_list=$dao->get_datalist("select * from {$dao->tables->exam_result} where pid='{$exam["auto_id"]}'");
$form_class=new form_class();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$exam["content_title"]?></title>
<link rel="stylesheet" type="text/css" href="<?=$global->sysTplUrlPath?>skin/system.css">
<script>
var siteUrlPath="<?=$global->siteUrlPath?>";
var tplUrlPath="<?=$global->tplUrlPath?>";
</script>
<script type="text/javascript" src="<?=$global->sysTplUrlPath?>js/jquery-1.9.1.min.js"></script>
</head>

<body>
<div class="mems-header">
  <div class="header"><a href="<?=$global->sysTplUrlPath?>"><img src="<?=$global->sysTplUrlPath?>skin/images/logo.png" width="185" height="65"><span>返回首页></span></a>
    <div class="head-icons"><a class="search-mobile"></a><a class="members"></a><a class="menus-mobiles"></a></div>
  </div>
</div>
<div class="sur-wrap">
<div class="inner-sur-wrap">
<div class="sur-top">
<div class="sur-tit"><?=$exam["content_title"]?></div>
<div class="sur-txt"><?=$form_class->get_textarea_string($exam["content_desc"])?></div>
</div>

<div class="sur-result">
<div class="sur-tips">亲爱的用户，根据您的<?=$exam["content_title"]?>调查问卷，您的测试结果如下：</div>
<div class="sur-resshow">
<div class="result-inner">
<div class="result-cnt">
<?
if(is_array($exam_result_list))
foreach($exam_result_list as $key=>$vl){
	if($vl["auto_id"]==$resultRecord["result_id"])
		$result_desc=$vl["content_desc"];
?>
<span <?=$vl["auto_id"]==$resultRecord["result_id"]?'class="cr"':""?>><?=$vl["content_title"]?></span>
<?
}
?>
</div>
<div class="rec-tips">
<?=$result_desc?>
</div>
</div>
</div>


</div>



</div>
</div>
<div class="footer mem-footer">
	<div class="clear"></div>
	<div class="copy-rights"><?=$global_params["content_copyright"]?></div>
</div>
</body>
</html>