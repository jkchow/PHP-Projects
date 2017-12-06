<?
header("Content-type: text/html; charset=utf-8");

if($_GET["alias"]==""){
	exit;
}
//读取开发模板 *.dev.html
$devTplFile=dirname(__FILE__).$_GET["alias"].".dev.html";
if(!file_exists($devTplFile)){
	echo "模板文件{$devTplFile}不存在，请检查代码";
	exit;
}
$devTplHtml=file_get_contents($devTplFile);

//获取标签内容
preg_match_all('/#\(([^#]+)\)#/',$devTplHtml,$preg_result);
if(is_array($preg_result[1]) && count($preg_result[1])>0){
	$tagArr=array();
	foreach($preg_result[1] as $key=>$vl){
		if(preg_match('/\s/',$vl)){
			echo "标签{$preg_result[0][$key]}写法有误,标记中不能包含空格";
			exit;
		}
		$tagKey=str_replace("/",".",$vl);//将路径中的/替换为.然后保存在键值中
		$tagArr[$tagKey]=$vl;//保存的标签数组中将会过滤掉重复的标签
	}
	
	//替换标签内容
	foreach($tagArr as $key=>$vl){
		//读取分块的html内容
		$blockFile=dirname(__FILE__)."/".$vl.".html";
		if(!file_exists($blockFile)){
			echo "模板文件{$blockFile}不存在，请检查代码";
			exit;
		}
		
		$blockHtml=file_get_contents($blockFile);
		preg_match('/#\(([^#]+)\)#/',$blockHtml,$tmp_result);
		if(count($tmp_result)>0){
			echo "被引用的模板{$blockFile}中不应当存在模板标签#(...)#";
			exit;
		}	
		$devTplHtml=preg_replace('/#\(\s*'.str_replace('/','\/',$vl).'\s*\)#/',$blockHtml,$devTplHtml);	
	}
}

//生成html文件 *.pub.html
$pubTplFile=dirname(__FILE__).$_GET["alias"].".pub.html";
$fp=fopen($pubTplFile,"w+");
fwrite($fp,$devTplHtml);
fclose($fp);

echo $devTplHtml;

?>