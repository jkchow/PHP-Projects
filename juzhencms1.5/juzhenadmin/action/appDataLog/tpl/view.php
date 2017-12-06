<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看接口日志</title>
</head>

<body>

<?
echo "<pre>";
$recordData=$dao->get_row_by_where($dao->tables->app_datalog,"where auto_id='{$_REQUEST["auto_id"]}'");
?>
<br/>请求数据:<br/>
<?
print_r(json_decode($recordData["request_data"]));
?>
<br/>返回数据:<br/>
<?
print_r(json_decode($recordData["return_data"]));
?>
<br/>日志参数:<br/>
<?
print_r($recordData);
?>

</body>
</html>