<?php defined ('ALLOW_ACCESS' ) or die();?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^E_NOTICE);
header("Content-type: text/html; charset=utf-8");
ini_set('date_default_timezone_set', 'Asia/Shanghai');
date_default_timezone_set("Asia/Shanghai");

function _SERVER($n) {
    return isset($_SERVER[$n]) ? $_SERVER[$n] : '[undefine]';
}
function get_gd_info($name) {
    $gd_info = gd_info();
    return $gd_info[$name];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>运行环境检测</title>
<style type="text/css">
<!--
body {
	font-family: verdana, tahoma;
	font-size: 12px;
	margin-top: 10px;
}
form {
	margin: 0;
}
table {
	border-collapse: collapse;
}
.info tr td {
	border: 1px solid #000000;
	padding: 3px 10px 3px 10px;
}
.info th {
	border: 1px solid #000000;
	font-weight: bold;
	height: 16px;
	padding: 3px 10px 3px 10px;
	background-color:#C2E2DA;
}
input {
	border: 1px solid #000000;
	background-color: #fafafa;
}
a {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
}
a.arrow {
	font-family: webdings, sans-serif;
	font-size: 10px;
}
a.arrow:hover {
	color: #ff0000;
	text-decoration: none;
}
.item {
	white-space: nowrap;
	text-align: right;
	width:30%;
}
-->
</style>
</head>

<body>
<table width="100%" class="info">
	<tr>
		<th colspan="2">服务器信息</th>
	</tr>
    <tr>
		<td class="item">web服务器</td>
		<td>
		<?php
		echo _SERVER('SERVER_SOFTWARE');
		?>
        </td>
	</tr>
    <tr>
		<td class="item">php.ini</td>
		<td>
		<?php
		$php_ini_file= function_exists('php_ini_loaded_file') ? php_ini_loaded_file() : '[undefine]';
        echo $php_ini_file;
		?>
        </td>
	</tr>
	<tr>
		<td class="item">网站主目录</td>
		<td>
		<?php
        echo _SERVER('DOCUMENT_ROOT');
		?>
        </td>
	</tr>
    <tr>
		<td class="item">服务器时间（是否准确？）</td>
		<td>
		<?php
		echo date("Y-m-d H:i:s");
		?>
        </td>
	</tr>
</table>
<br />

<table width="100%" class="info">
	<tr>
		<th colspan="2">目录权限</th>
	</tr>
    <tr>
		<td class="item">目录浏览</td>
		<td>
		<?php
		$tmpUrl=preg_replace('/(\/)[^\/]*$/i',"",$_SERVER["REQUEST_URI"]);
		$test_url="http://127.0.0.1".($_SERVER["SERVER_PORT"]!="80"?":{$_SERVER["SERVER_PORT"]}":"").$tmpUrl."/action";
		$result=@file_get_contents($test_url);
		if(strlen($result)>0){
			echo "<font style='color:red'>高风险，目前未关闭web服务器目录浏览功能</font>";
		}else{
			echo "<font style='color:green'>已关闭目录浏览功能</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">写入权限</td>
		<td>
		<?php
		//echo dirname(__FILE__);
		if(is_writable(dirname(__FILE__))){
			echo "<font style='color:green'>目录已设置为可写入，建议仅将文件上传目录及缓存目录设置为可写</font>";
		}else{
			echo "<font style='color:red'>目录没有可写权限，请注意将文件上传目录及缓存目录设置为可写</font>";
		}
		?>
        </td>
	</tr>
</table>
<br />

<table width="100%" class="info">
	<tr>
		<th colspan="2">PHP 环境要求（必须达到）</th>
	</tr>
    <tr>
		<td class="item">php版本</td>
		<td>
		<?php
		$phpVersion=PHP_VERSION;
		if($phpVersion!=""){
			$tmp=substr($phpVersion,0,3);
			$tmp=floatval($tmp);
			if($tmp>=5.2 && $tmp<7.2){
				echo "<font style='color:green'>php版本为{$phpVersion}</font>";
			}else{
				echo "<font style='color:red'>php版本为{$phpVersion}</font>";
			}	
		}else{
			echo "<font style='color:red'>无法获取php版本</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">short_open_tag</td>
		<td>
		<?php
		$short_open_tag=ini_get('short_open_tag');
		if($short_open_tag!=""){
			if($short_open_tag=="1"){
				echo "<font style='color:green'>支持short_open_tag</font>";
			}else{
				echo "<font style='color:red'>不支持short_open_tag</font>";
			}
		}else{
			echo "<font style='color:red'>无法获取short_open_tag配置</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">safe_mode</td>
		<td>
		<?php
		$safe_mode=ini_get('safe_mode');
		if($safe_mode!="1"){
			echo "<font style='color:green'>已关闭</font>";
		}else{
			echo "<font style='color:red'>未关闭</font>";
		}
		
		?>
        </td>
	</tr>
    <tr>
		<td class="item">register_globals</td>
		<td>
		<?php
		$register_globals=ini_get('register_globals');
		//echo $register_globals;
		if($register_globals=="" || $register_globals=="0"){
			echo "<font style='color:green'>已关闭</font>";
		}else{
			echo "<font style='color:red'>未关闭</font>";
		}
		?>
        </td>
	</tr>
    
	<tr>
		<td class="item">php_mysql</td>
		<td>
		<?php
		if(function_exists('mysql_close')){
			echo "<font style='color:green'>支持php_mysql，版本为".mysql_get_client_info()."</font>";
		}else{
			echo "<font style='color:red'>不支持php_mysql</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">php_mysqli</td>
		<td>
		<?php
		if(function_exists('mysqli_close')){
			echo "<font style='color:green'>支持php_mysqli，版本为".mysqli_get_client_info()."</font>";
		}else{
			echo "<font style='color:red'>不支持php_mysqli</font>";
		}
		?>
        </td>
	</tr>
	<tr>
		<td class="item">gd库</td>
		<td>
		<?php
		if(function_exists('gd_info')){
			echo "<font style='color:green'>支持gd库，版本为".get_gd_info('GD Version')."</font>";
		}else{
			echo "<font style='color:red'>不支持gd库</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">mbstring</td>
		<td>
		<?php
		if(function_exists('mb_substr')){
			echo "<font style='color:green'>支持mbstring</font>";
		}else{
			echo "<font style='color:red'>不支持mbstring</font>";
		}
		?>
        </td>
	</tr>
    
</table>
<br />
<table width="100%" class="info">
	<tr>
		<th colspan="2">建议的配置（可选）</th>
	</tr>
    <tr>
		<td class="item">allow_url_fopen</td>
		<td>
		<?php
		$allow_url_fopen=ini_get('allow_url_fopen');
		if($allow_url_fopen=="1"){
			echo "<font style='color:green'>已开启</font>";
		}else{
			echo "<font style='color:red'>未开启</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">curl</td>
		<td>
		<?php
		if(function_exists('curl_getinfo')){
			echo "<font style='color:green'>支持curl</font>";
		}else{
			echo "<font style='color:red'>不支持curl</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">soap(用于webservice接口)</td>
		<td>
		<?php
		if(class_exists('SoapServer') && class_exists('SoapClient')){
			echo "<font style='color:green'>支持soap</font>";
		}else{
			echo "<font style='color:red'>不支持soap</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">exif(用于缩略图)</td>
		<td>
		<?php
		if(function_exists('exif_read_data'))
			echo "<font style='color:green'>支持exif</font>";
		else
			echo "<font style='color:red'>不支持exif</font>";
		?>
        </td>
	</tr>
	<tr>
		<td class="item">magic_quotes_gpc</td>
		<td>
		<?php
		if(get_magic_quotes_gpc())
			echo "<font style='color:green'>支持magic_quotes_gpc</font>";
		else
			echo "<font style='color:red'>不支持magic_quotes_gpc</font>";
		?>
        </td>
	</tr>
    <tr>
		<td class="item">PDO</td>
		<td>
		<?php
		if(class_exists('PDO')){
			echo "<font style='color:green'>支持PDO</font>";
		}else{
			echo "<font style='color:red'>不支持PDO</font>";
		}
		?>
        </td>
	</tr>
    <tr>
		<td class="item">openssl(用于在线支付)</td>
		<td>
		<?php
		if(function_exists('openssl_get_publickey')){
			echo "<font style='color:green'>支持openssl</font>";
		}else{
			echo "<font style='color:red'>不支持openssl</font>";
		}
		?>
        </td>
	</tr>
    
    <tr>
		<td class="item">Memcache</td>
		<td>
		<?php
		if(class_exists('Memcache')){
			echo "<font style='color:green'>支持Memcache</font>";
		}else{
			echo "<font style='color:red'>不支持Memcache</font>";
		}
		?>
        </td>
	</tr>
    
    <tr>
		<td class="item">允许上传的文件大小</td>
		<td>
		<?php
		function PMA_get_real_size($size = 0) {
			 if (! $size) {
				 return 0;
			 }
		 
			 $scan['gb'] = 1073741824; //1024 * 1024 * 1024;
			 $scan['g']  = 1073741824; //1024 * 1024 * 1024;
			 $scan['mb'] = 1048576;
			 $scan['m']  = 1048576;
			 $scan['kb'] =    1024;
			 $scan['k']  =    1024;
			 $scan['b']  =       1;
		 
			foreach ($scan as $unit => $factor) {
				 if (strlen($size) > strlen($unit)
				  && strtolower(substr($size, strlen($size) - strlen($unit))) == $unit) {
					 return substr($size, 0, strlen($size) - strlen($unit)) * $factor;
				 }
			 }
		 
			return $size;
		} // end function PMA_get_real_size()
		 
		
		$upload_max_filesize = PMA_get_real_size(ini_get('upload_max_filesize'));
		$post_max_size = PMA_get_real_size(ini_get('post_max_size'));
		$min_upload_size = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;
		$upload_max_mbsize=round($min_upload_size/(1024*1024),2);
		
		
		if($upload_max_mbsize<1){
			echo "<font style='color:red'>（应大于1MB，建议设置为10MB）</font>";
		}else{
			echo $upload_max_mbsize."MB";
			if($upload_max_mbsize<10){
				echo "（建议设置为10MB）";
			}
		}
		?>
        </td>
	</tr>
    
    <tr>
		<td class="item">memory_limit</td>
		<td>
		<?php
		
		 
		
		$memory_limit = PMA_get_real_size(ini_get('memory_limit'));
		
		$memory_limit=round($memory_limit/(1024*1024),2);
		
		echo $memory_limit."MB";
		if($memory_limit<16)
			echo "<font style='color:red'>（不应低于16MB，建议64MB）</font>";
		
		?>
        </td>
	</tr>
    
    
    
     
    <tr>
		<td class="item">display_errors</td>
		<td>
		<?php
		$display_errors=ini_get('display_errors');
		if($display_errors!="1"){
			echo "<font style='color:green'>已关闭</font>";
		}else{
			echo "<font style='color:red'>未关闭</font>";
		}
		?>
        </td>
	</tr>
    
</table>
<br/>
<form method="post" action="<?php echo _SERVER('PHP_SELF')?>">
<input type="hidden" name="acl" value="<?php echo $_REQUEST["acl"] ?>" />
<input type="hidden" name="method" value="<?php echo $_REQUEST['method'] ?>" />
<table width="100%" class="info">
	<tr>
		<th colspan="4">MySQL 连接测试</th>
	</tr>
	<tr>
		<td>MySQL 服务器</td>
		<td><input type="text" name="mysqlHost" value="<?php echo $_POST['mysqlHost']!=""?$_POST['mysqlHost']:"localhost:3306" ?>" /></td>
		<td>MySQL 数据库名</td>
		<td><input type="text" name="mysqlDb" value="<?php echo $_POST['mysqlDb'] ?>" /></td>
	</tr>
	<tr>

		<td>MySQL 用户名</td>
		<td><input type="text" name="mysqlUser" value="<?php echo $_POST['mysqlUser']!=""?$_POST['mysqlUser']:"root" ?>" /></td>
		<td>MySQL 用户密码</td>
		<td><input type="text" name="mysqlPassword" value="<?php echo $_POST['mysqlPassword'] ?>" /></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><input type="submit" value="连接"
			name="mysqlact" /></td>
	</tr>
</table>
</form>   
<?php if(isset($_POST['mysqlact'])) { ?> 
<br />
<table width="100%" class="info">
	<tr>
		<th colspan="4">MySQL 测试结果</th>
	</tr>   <?php $link = @mysql_connect($_POST['mysqlHost'], $_POST['mysqlUser'], $_POST['mysqlPassword']); $errno = mysql_errno(); if ($link) $str1 = '<span style="color: #008000; font-weight: bold;">OK</span> ('.mysql_get_server_info($link).')'; else $str1 = '<span style="color: #ff0000; font-weight: bold;">Failed</span><br />'.mysql_error(); ?>  <tr>
		<td colspan="2">服务器 <?php echo $_POST['mysqlHost']?></td>
		<td colspan="2"><?php echo $str1?></td>
	</tr>
	<tr>
		<td colspan="2">数据库 <?php echo $_POST['mysqlDb']?></td>
		<td colspan="2"><?php echo (@mysql_select_db($_POST['mysqlDb'],$link))?'<span style="color: #008000; font-weight: bold;">OK</span>':'<span style="color: #ff0000; font-weight: bold;">Failed</span>'?></td>
	</tr>
</table>
<?php
}
?>
</body>
</html>