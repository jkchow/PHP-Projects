<?
//查询问卷概要内容
$exam=$dao->get_row_by_where($dao->tables->exam,"where auto_id='{$_GET["id"]}'");

if(!is_array($exam)){
	echo "您所访问的内容不存在";
	exit;
}

//查询问卷问题列表
$questons=$dao->get_datalist("select * from {$dao->tables->exam_question} where pid='{$exam["auto_id"]}' order by position asc,auto_id asc");

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


<script>
var submitflag=true;
function submit_form(){
	submitflag=true;
	//表单验证
	$("input[name^='question_']").each(function(index,element){
		if(!submitflag)	return;									
		var input_name=$(this).attr("name");
		if($("input[name='"+input_name+"']:checked").size()==0){
			submitflag=false;
			alert("所有问题都填写后才可以提交");
		}
	});
	
	//ajax提交表单
	if(submitflag){
		var formData=$("#question_form").serialize();//将表单数据转换成序列化的字符串
		$.ajax({
		  type: "POST",
		  url: siteUrlPath+"/index.php?acl=exam&method=saveAnswer",
		  processData:true,//提交时注意必须有这个属性
		  data:formData,
		  dataType:'json',
		  success: function(data){
			if(data.result=="1"){
				location.href=data.url;
			}else{
				alert(data.msg);
			}
			//alert(data);  
		  	//$("#result").html("保存成功");
		  }
		});
	}
	
	
}
</script>
</head>

<body>
<div class="mems-header">
  <div class="header"><a href="<?=$global->sysTplUrlPath?>"><img src="<?=$global->sysTplUrlPath?>skin/images/logo.png" width="185" height="65"><span>返回首页></span></a>
    <div class="head-icons"><a class="search-mobile"></a><a class="members"></a><a class="menus-mobiles"></a></div>
  </div>
</div>


<!--问卷调查开始-->
<div class="sur-wrap">
<div class="inner-sur-wrap">
<div class="sur-top">
<div class="sur-tit"><?=$exam["content_title"]?></div>
<div class="sur-txt"><?=$form_class->get_textarea_string($exam["content_desc"])?></div>
</div>
<form id="question_form" method="post">
<input type="hidden" name="pid" value="<?=$exam["auto_id"]?>"/>
<div class="sur-content">

<?
if(is_array($questons))
foreach($questons as $key=>$vl){
?>
<div class="asksur-tit"><?=$key+1?>、<?=$vl["content_name"]?></div>
<ul>
<?
$answerList=$dao->get_datalist("select * from {$dao->tables->exam_question_answer} where pid='{$vl["auto_id"]}'");
if(is_array($answerList))
foreach($answerList as $k=>$v){
	$i=ord('A')+$k;
?>
<li><span><input name="question_<?=$vl["auto_id"]?>" type="radio" value="<?=$v["auto_id"]?>" /></span><a href="javascript:" onclick="$(this).parent().find('input').eq(0).click()"><?=chr($i)?>. <?=$v["content_name"]?></a></li>
<?
}
?>
</ul>
<?
}
?>


<div class="comonbtn-wrap">
<a class="comonbtn" href="javascript:" onclick="submit_form()">提交问卷，并查看结果</a></div>
</div>
</form>


</div>
</div>
<!--问卷调查结束-->
<div class="footer mem-footer">
	<div class="clear"></div>
	<div class="copy-rights"><?=$global_params["content_copyright"]?></div>
</div>

</body>
</html>