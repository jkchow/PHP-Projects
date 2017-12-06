<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^E_NOTICE);
header("Content-type: text/html; charset=utf-8");
ini_set('date_default_timezone_set', 'Asia/Shanghai');
date_default_timezone_set("Asia/Shanghai");
$serverUrl="http://123.57.6.54/ysfs";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>app接口说明</title>
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
.info tr{ display:none}
.info .theader{display:block; cursor:pointer;}


.info tr td {
	border: 1px solid #000000;
	padding: 3px 10px 3px 10px;
}
.info th {
	border: 1px solid #000000;
	font-weight: bold;
	height: 16px;
	padding: 3px 10px 3px 10px;
	background-color: #9acd32;
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
	width:200px;
}
-->
</style>
<script src="jquery-1.11.1.min.js"></script>
<script>
$(function(){

	$(".theader").click(function(){
		if($(this).parent().children().eq(1).is(":hidden")){
			$(this).parent().children().show();
		}else{
			$(this).parent().children().hide();
			$(this).show();
		}
	});

});
</script>
</head>

<body>

<hr/>接口规范<hr/>
<br />

<table width="100%" class="info">
	<tr class="theader">
		<th colspan="3" align="left">接口规范</th>
	</tr>
    <tr>
		<td class="item">接口地址</td>
		<td>
         <?=$serverUrl?>
        </td>
        <td>
        说明：此地址在app中需要设置为全局配置，当前为测试地址，当项目上线后此地址需要改为正式地址
        </td>
	</tr>
    <tr>
		<td class="item">接口请求路径</td>
		<td>
         {接口地址}/app/index.php
        </td>
        <td>
        说明：此路径是所有数据请求接口的入口目录，不包含webview载入的页面，webview页面有其他的入口
        </td>
	</tr>
    <tr>
		<td class="item">接口参数(必填)</td>
		<td>
		param
        </td>
        <td>
		说明：此参数为json字符串格式，建议采用post方式提交此参数，提交时需要把数据采用urlencode编码转义，不同的接口json内容不同，例如注册获取短信验证码的接口，原始参数为<?=$paramJson='{"acl":"member","method":"getRegMobileMsg","content_mobile":"15101022452"}'?>
        <br/>urlencode编码后为<br/><?=urlencode($paramJson)?><br/>注意ios的urlencode编码操作时要注意+、&等字符的转义
        </td>
	</tr>
    <tr>
		<td class="item">接口示例</td>
		<td colspan="2">{接口地址}/app/index.php?param=<?=urlencode($paramJson)?>
        </td>
	</tr>
    <tr>
		<td class="item">返回数据示例</td>
		<td>	{"result":1,"msg":"\u6ce8\u518c\u6210\u529f","data":{"token":9104339,"member_id":"19","content_mobile":"15101022452"}}
        </td>
        <td>说明：返回数据为json格式，其中各字段说明如下<br/>
        result:接口状态，1(成功)、0(失败)、-1(需要登录，跳转到登录界面)<br/>
        msg:提示信息，部分接口需要将此信息提示给用户<br/>
        data:返回的数据，不同接口此字段将返回不同的数据
        </td>
	</tr>
</table>

<br/>
<hr/>定位及地址选择<hr/>

<br />

<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取位置信息（每次app程序重新打开后需要自动调用，如果只是从后台唤醒则不需要重新调用）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"localInfo","device_id":"123457","app_type":"2","push_id":"004","lat":"39.983424","lng":"116.322987"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 localInfo</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td class="item">app_type</td>
		<td>必填参数，设备类型，1:ios、2:android</td>
	</tr> 
    <tr>
		<td class="item">lat</td>
		<td>GPS坐标的北纬度数，可以是字符串类型或是浮点数类型</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>GPS坐标的东经度数，可以是字符串类型或是浮点数类型</td>
	</tr>
    <tr>
		<td class="item">push_id</td>
		<td>从极光推送接口返回的ID，用于消息推送，对于每个客户端每次获取到的此参数都应当是一样的，可选参数（当客户手机禁用推送时此参数可能无法获取推送ID）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22localInfo%22%2C%22device_id%22%3A%22123457%22%2C%22app_type%22%3A%222%22%2C%22push_id%22%3A%22004%22%2C%22lat%22%3A%2239.983424%22%2C%22lng%22%3A%22116.322987%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22localInfo%22%2C%22device_id%22%3A%22123457%22%2C%22app_type%22%3A%222%22%2C%22push_id%22%3A%22004%22%2C%22lat%22%3A%2239.983424%22%2C%22lng%22%3A%22116.322987%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"address":"\u5317\u4eac\u5e02\u6d77\u6dc0\u533a\u4e2d\u5173\u6751\u5927\u885727\u53f71101-08\u5ba4\u5317\u4eac\u8fdc\u666f\u56fd\u9645\u516c\u5bd3(\u4e2d\u5173\u6751\u5e97)\u51850\u7c73","street":"\u4e2d\u5173\u6751\u5927\u8857","city":"\u5317\u4eac\u5e02","cityId":"1"}} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败，当返回0时需要提示用户“获取位置信息失败”</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>位置相关信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data字段数据结构说明</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>当前街道名称，需要显示在首页左上角位置，数据太长的话需要客户端做截字处理</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>当前详细地址，暂时没有用到</td>
	</tr>
    <tr>
		<td class="item">city</td>
		<td>当前城市名称，在城市选择按钮上要默认显示此名称</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>当前城市ID，在选择城市的操作中，若用户未选择而使用当前城市，需要用此ID作为默认的城市ID参数提交</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>坐标北纬度数，客户端存储此数据，用来作为获取商品及店铺数据的参数</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>坐标东经度数，客户端存储此数据，用来作为获取商品及店铺数据的参数</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取常用地址列表（首页左上角的地址链接点击进入后调用显示）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"getAddressList","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1441417307,"validate":"fc9840f381512e82917f385239d9deee"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getAddressList</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22getAddressList%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1441417307%2C%22validate%22%3A%22fc9840f381512e82917f385239d9deee%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22getAddressList%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1441417307%2C%22validate%22%3A%22fc9840f381512e82917f385239d9deee%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"id":"18","address":"\u661f\u6cb3\u7693\u6708Q3\u680b","street":"\u661f\u6cb3\u7693\u6708-\u5317\u95e8","content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452","lat":"39.989312","lng":"116.781594","city_id":"14","city":"\u5eca\u574a\u5e02","is_default":"0"},{"id":"13","address":"\u534e\u8d38\u5199\u5b57\u697c","street":"\u56fd\u8d38","content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452","lat":"39.914112","lng":"116.487719","city_id":"1","city":"\u5317\u4eac\u5e02","is_default":"1"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>常用地址列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>地址ID，此接口中此字段未用到</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>城市ID，选择地址后需要将此字段存储在客户端，地址搜索及某些接口中会用到此参数</td>
	</tr>
    <tr>
		<td class="item">city</td>
		<td>城市名称，选择地址后需要将此字段存储在客户端，在显示当前城市时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>街道名称，选择此地址后需要将此字段存储在客户端，并显示在首页左上角当前位置，注意字数太长时客户端显示时要根据情况做截字处理</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>北纬度数，选择地址后需要将此字段存储在客户端，在显示周边信息时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>东经度数，选择地址后需要将此字段存储在客户端，在显示周边信息时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>详细地址，选择地址后需要将此字段存储在客户端，在下单时默认显示在联系人详细地址表单中</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>联系人姓名，选择地址后需要将此字段存储在客户端，在下单时默认显示在联系人姓名表单中</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>联系人手机，选择地址后需要将此字段存储在客户端，在下单时默认显示在联系人手机号码表单中</td>
	</tr>
    <tr>
		<td class="item">is_default</td>
		<td>是否是默认地址，若返回1，则客户端应把此地址显示为默认地址，前面的复选框设置为选中状态</td>
	</tr> 
</table>



<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">使用GPS定位到当前位置(与获取位置信息的接口基本相同)</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"locationByGps","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","app_type":"1","push_id":"","lat":"39.983424","lng":"116.322987"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 locationByGps</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td class="item">app_type</td>
		<td>必填参数，设备类型，1:ios、2:android</td>
	</tr> 
    <tr>
		<td class="item">lat</td>
		<td>GPS坐标的北纬度数，可以是字符串类型或是浮点数类型</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>GPS坐标的东经度数，可以是字符串类型或是浮点数类型</td>
	</tr>
    <tr>
		<td class="item">push_id</td>
		<td>从极光推送接口返回的ID，用于消息推送，对于每个客户端每次获取到的此参数都应当是一样的，可选参数（当客户手机禁用推送时此参数可能无法获取推送ID）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22locationByGps%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22app_type%22%3A%221%22%2C%22push_id%22%3A%22%22%2C%22lat%22%3A%2239.983424%22%2C%22lng%22%3A%22116.322987%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22locationByGps%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22app_type%22%3A%221%22%2C%22push_id%22%3A%22%22%2C%22lat%22%3A%2239.983424%22%2C%22lng%22%3A%22116.322987%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"address":"\u5317\u4eac\u5e02\u6d77\u6dc0\u533a\u4e2d\u5173\u6751\u5927\u885727\u53f71101-08\u5ba4\u5317\u4eac\u8fdc\u666f\u56fd\u9645\u516c\u5bd3(\u4e2d\u5173\u6751\u5e97)\u51850\u7c73","street":"\u4e2d\u5173\u6751\u5927\u8857","city":"\u5317\u4eac\u5e02","city_id":"1","lat":"39.983424","lng":"116.322987"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败，当返回0时需要提示用户“获取位置信息失败”</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>位置相关信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data字段数据结构说明</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>当前街道名称，需要显示在首页左上角位置，数据太长的话需要客户端做截字处理</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>当前详细地址，暂时没有用到</td>
	</tr>
    <tr>
		<td class="item" >city</td>
		<td>当前城市名称，在城市选择按钮上要默认显示此名称</td>
	</tr>
    <tr>
		<td class="item" >city_id</td>
		<td>当前城市ID，在选择城市的操作中，若用户未选择而使用当前城市，需要用此ID作为默认的城市ID参数提交</td>
	</tr>
    <tr>
		<td class="item" >lat</td>
		<td>坐标北纬度数，客户端存储此数据，用来作为获取商品及店铺数据的参数</td>
	</tr>
    <tr>
		<td class="item" >lng</td>
		<td>坐标东经度数，客户端存储此数据，用来作为获取商品及店铺数据的参数</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">新增地址选择城市时需要显示的省份选择列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"provinceList"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 provinceList</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22provinceList%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22provinceList%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"id":"1","name":"\u5317\u4eac"},{"id":"2","name":"\u5929\u6d25"},{"id":"3","name":"\u4e0a\u6d77"},{"id":"4","name":"\u91cd\u5e86"},{"id":"5","name":"\u6cb3\u5317"},{"id":"6","name":"\u5c71\u897f"},{"id":"7","name":"\u53f0\u6e7e"},{"id":"8","name":"\u8fbd\u5b81"},{"id":"9","name":"\u5409\u6797"},{"id":"10","name":"\u9ed1\u9f99\u6c5f"},{"id":"11","name":"\u6c5f\u82cf"},{"id":"12","name":"\u6d59\u6c5f"},{"id":"13","name":"\u5b89\u5fbd"},{"id":"14","name":"\u798f\u5efa"},{"id":"15","name":"\u6c5f\u897f"},{"id":"16","name":"\u5c71\u4e1c"},{"id":"17","name":"\u6cb3\u5357"},{"id":"18","name":"\u6e56\u5317"},{"id":"19","name":"\u6e56\u5357"},{"id":"20","name":"\u5e7f\u4e1c"},{"id":"21","name":"\u7518\u8083"},{"id":"22","name":"\u56db\u5ddd"},{"id":"23","name":"\u8d35\u5dde"},{"id":"24","name":"\u6d77\u5357"},{"id":"25","name":"\u4e91\u5357"},{"id":"26","name":"\u9752\u6d77"},{"id":"27","name":"\u9655\u897f"},{"id":"28","name":"\u5e7f\u897f"},{"id":"29","name":"\u897f\u85cf"},{"id":"30","name":"\u5b81\u590f"},{"id":"31","name":"\u65b0\u7586"},{"id":"32","name":"\u5185\u8499\u53e4"},{"id":"33","name":"\u6fb3\u95e8"},{"id":"34","name":"\u9999\u6e2f"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>省份列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中的省份字段说明</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>省份ID，用于请求下级城市时作为参数使用</td>
	</tr>
    <tr>
		<td class="item">name</td>
		<td>省份名称，需要显示在省份选择列表上</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">新增地址选择城市时需要显示的城市选择列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"cityList","province_id":13}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 cityList</td>
	</tr>
    <tr>
		<td class="item">province_id</td>
		<td>必填参数，省份ID，从省份选择列表的接口获取</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22cityList%22%2C%22province_id%22%3A13%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22cityList%22%2C%22province_id%22%3A13%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"id":"110","name":"\u5408\u80a5\u5e02"},{"id":"111","name":"\u829c\u6e56\u5e02"},{"id":"112","name":"\u868c\u57e0\u5e02"},{"id":"113","name":"\u6dee\u5357\u5e02"},{"id":"114","name":"\u9a6c\u978d\u5c71\u5e02"},{"id":"115","name":"\u6dee\u5317\u5e02"},{"id":"116","name":"\u94dc\u9675\u5e02"},{"id":"117","name":"\u5b89\u5e86\u5e02"},{"id":"118","name":"\u9ec4\u5c71\u5e02"},{"id":"119","name":"\u6ec1\u5dde\u5e02"},{"id":"120","name":"\u961c\u9633\u5e02"},{"id":"121","name":"\u5bbf\u5dde\u5e02"},{"id":"122","name":"\u5de2\u6e56\u5e02"},{"id":"123","name":"\u516d\u5b89\u5e02"},{"id":"124","name":"\u4eb3\u5dde\u5e02"},{"id":"125","name":"\u6c60\u5dde\u5e02"},{"id":"126","name":"\u5ba3\u57ce\u5e02"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>城市列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中的省份字段说明</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>城市ID，用于选择城市后作为提交的参数</td>
	</tr>
    <tr>
		<td class="item">name</td>
		<td>城市名称，选择后显示在城市选择按钮上</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">地址搜索，用于添加新地址时的区域选择</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"placeSuggestion","city_id":14,"query":"\u71d5\u90ca"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 placeSuggestion</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，用户在创建新地址时选择的城市ID，若用户未选择，则使用当前城市ID（获取位置接口所返回数据中的city_id字段）</td>
	</tr>
    <tr>
		<td class="item">query</td>
		<td>必填参数，地址关键词，用户在输入框内输入的位置关键词，当输入发生变化时调用此接口获取位置提示信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22placeSuggestion%22%2C%22city_id%22%3A14%2C%22query%22%3A%22%5Cu71d5%5Cu90ca%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22placeSuggestion%22%2C%22city_id%22%3A14%2C%22query%22%3A%22%5Cu71d5%5Cu90ca%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"name":"\u71d5\u90ca\u9547","lat":39.950035,"lng":116.816229},{"name":"\u71d5\u90ca\u516c\u56ed","lat":39.956553,"lng":116.819142},{"name":"\u71d5\u90ca\u4eba\u6c11\u533b\u9662","lat":39.94969,"lng":116.81136},{"name":"\u71d5\u90ca\u5f00\u53d1\u533a","lat":39.956101,"lng":116.859986},{"name":"\u71d5\u90ca\u690d\u7269\u56ed","lat":39.993924,"lng":116.822616},{"name":"\u71d5\u90ca\u6b65\u884c\u8857","lat":39.958424,"lng":116.815463},{"name":"\u4e09\u6cb3\u71d5\u90ca\u7ad9","lat":39.9474,"lng":116.832362},{"name":"\u71d5\u90ca\u56fd\u9645\u6c7d\u914d\u57ce","lat":39.955039,"lng":116.863528},{"name":"\u71d5\u90ca\u521b\u4e1a\u5927\u53a6","lat":39.971684,"lng":116.821561},{"name":"\u4e0a\u4e0a\u57ce\u7b2c\u4e09\u5b63","lat":39.988038,"lng":116.785067}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>位置列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中的位置列表字段说明</td>
	</tr>
    <tr>
		<td class="item">name</td>
		<td>位置名称，提交时需要提交此字段</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>北纬坐标数，提交时需要提交此字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>东经坐标数，提交时需要提交此字段</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">添加\修改常用地址（修改地址的接口仅登录后在会员中心常用地址列表编辑时可用）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"addAddress","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1441415288,"validate":"e3dba4252ed1d2546ee4b553ceeff477","id":18,"city_id":14,"street":"\u661f\u6cb3\u7693\u6708-\u5317\u95e8","lat":"39.989312","lng":"116.781594","address":"\u661f\u6cb3\u7693\u6708Q3\u680b","content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 addAddress</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>选填参数，地址ID，由返回的地址列表字段获取，当保存修改后的地址时需要此参数</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，用户在创建新地址时选择的城市ID，若用户未选择，则使用当前城市ID（获取位置接口所返回数据中的city_id字段）</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>必填参数，街道名称，来源于位置搜索接口返回的数据的name字段（用户在区域选择界面输入位置关键词，调用位置搜索接口获取相关的地址列表，选择地址后需要提取所选地址的街道名name称及坐标数据lat,lng）</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，北纬度数，同上来源于位置搜索接口返回的数据的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，东经度数，同上来源于位置搜索接口返回的数据的lng字段</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>必填参数，详细地址</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>必填参数，联系人姓名</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>必填参数，联系人手机号</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22addAddress%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1441415288%2C%22validate%22%3A%22e3dba4252ed1d2546ee4b553ceeff477%22%2C%22id%22%3A18%2C%22city_id%22%3A14%2C%22street%22%3A%22%5Cu661f%5Cu6cb3%5Cu7693%5Cu6708-%5Cu5317%5Cu95e8%22%2C%22lat%22%3A%2239.989312%22%2C%22lng%22%3A%22116.781594%22%2C%22address%22%3A%22%5Cu661f%5Cu6cb3%5Cu7693%5Cu6708Q3%5Cu680b%22%2C%22content_name%22%3A%22%5Cu859b%5Cu65b0%5Cu5cf0%22%2C%22content_mobile%22%3A%2215101022452%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22addAddress%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1441415288%2C%22validate%22%3A%22e3dba4252ed1d2546ee4b553ceeff477%22%2C%22id%22%3A18%2C%22city_id%22%3A14%2C%22street%22%3A%22%5Cu661f%5Cu6cb3%5Cu7693%5Cu6708-%5Cu5317%5Cu95e8%22%2C%22lat%22%3A%2239.989312%22%2C%22lng%22%3A%22116.781594%22%2C%22address%22%3A%22%5Cu661f%5Cu6cb3%5Cu7693%5Cu6708Q3%5Cu680b%22%2C%22content_name%22%3A%22%5Cu859b%5Cu65b0%5Cu5cf0%22%2C%22content_mobile%22%3A%2215101022452%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":""}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当返回的result为0时需要将此信息提示给用户</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">设置默认地址（登录后在会员中心常用地址列表界面操作，设置后刷新界面数据并显示提示信息）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"setDefaultAddress","device_id":"864587028272400","timestamp":1449972919,"validate":"d95a2af7bb1a91b42f2699d4a699a44e","id":20}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 setDefaultAddress</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>选填参数，地址ID，由返回的地址列表字段获取</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22setDefaultAddress%22%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1449972919%2C%22validate%22%3A%22d95a2af7bb1a91b42f2699d4a699a44e%22%2C%22id%22%3A20%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22setDefaultAddress%22%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1449972919%2C%22validate%22%3A%22d95a2af7bb1a91b42f2699d4a699a44e%22%2C%22id%22%3A20%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u9ed8\u8ba4\u5730\u5740\u8bbe\u7f6e\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败，-1需要登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当返回的result为1时需要将此信息提示给用户</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">删除常用地址（登录后在会员中心常用地址列表界面操作，设置后刷新界面数据并显示提示信息）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"deleteAddress","device_id":"864587028272400","timestamp":1449973082,"validate":"4e10957eaebac990ab68681ff62f0f13","id":19}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 deleteAddress</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>选填参数（当客户端会员在登录状态下需要添加此参数，以便地址数据与会员关联），校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>选填参数，地址ID，由返回的地址列表字段获取</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22deleteAddress%22%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1449973082%2C%22validate%22%3A%224e10957eaebac990ab68681ff62f0f13%22%2C%22id%22%3A19%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22deleteAddress%22%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1449973082%2C%22validate%22%3A%224e10957eaebac990ab68681ff62f0f13%22%2C%22id%22%3A19%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u5730\u5740\u5220\u9664\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败，-1需要登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当返回的result为1时需要将此信息提示给用户</td>
	</tr>
</table>

<br/>


<hr/>会员基础功能<hr/>
<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取注册短信验证码</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"getRegMobileMsg","content_mobile":"15101022452"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getRegMobileMsg</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>必填参数，手机号，字符串类型</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22getRegMobileMsg%22%2C%22content_mobile%22%3A%2215101022452%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22getRegMobileMsg%22%2C%22content_mobile%22%3A%2215101022452%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u9a8c\u8bc1\u7801\u5df2\u7ecf\u53d1\u9001\u5230\u60a8\u7684\u624b\u673a\uff0c\u6709\u6548\u671f20\u5206\u949f\uff0c\u8bf7\u6ce8\u610f\u67e5\u6536"} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result字段为0时需要将此字段的信息提示给用户</td>
	</tr>
</table>
<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员注册接口（注册后自动登录）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"saveRegister","content_mobile":"15101022452","content_pass":"123456","device_id":"123456","mobile_randnum":"45562","app_type":"1"}</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 saveRegister</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>必填参数，手机号，字符串类型</td>
	</tr>
    <tr>
		<td class="item">content_pass</td>
		<td>必填参数，密码，字符串类型</td>
	</tr>
    <tr>
		<td class="item">app_type</td>
		<td>必填参数，设备类型，1:ios、2:android</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td class="item">mobile_randnum</td>
		<td>必填参数，短信验证码，字符串类型，使用用户输入的短信验证码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22saveRegister%22%2C%22content_mobile%22%3A%2215101022452%22%2C%22content_pass%22%3A%22123456%22%2C%22device_id%22%3A%22123456%22%2C%22mobile_randnum%22%3A%2245562%22%2C%22app_type%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22saveRegister%22%2C%22content_mobile%22%3A%2215101022452%22%2C%22content_pass%22%3A%22123456%22%2C%22device_id%22%3A%22123456%22%2C%22mobile_randnum%22%3A%2245562%22%2C%22app_type%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u6ce8\u518c\u6210\u529f","data":{"token":5392608,"member_id":"21","member_type":"1","content_mobile":"15101022452","content_name":"\u8def\u4eba\u7532","content_head":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/2015\/08\/23\/1440985527.jpg"}} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result字段为0时需要将此字段的信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>注册后的会员相关信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data字段数据结构说明</td>
	</tr>
    <tr>
		<td class="item">token</td>
		<td>会员接口秘钥，客户端需要将此数据持久化保存，用作会员登录状态的判断标识，当客户端token存在时，客户端便可认为用户是在登录状态</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>会员用户名，即为注册手机号，客户端也需要将此数据作为用户登录名持久化保存，当调用部分数据接口时需要将此字段结合token字段一起使用</td>
	</tr>
    <tr>
		<td class="item">member_type</td>
		<td>会员类型，1个人会员、2商家会员，客户端需要将此数据持久化保存，根据此字段的不同来判断进入个人会员主界面或商家会员主界面</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>会员昵称，用于显示在会员中心头像下方的昵称位置，如果此字段返回NULL，则不需要显示昵称</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>会员头像图片URL，需要将此图片显示在会员中心的头像图片位置</td>
	</tr>
    <tr>
		<td class="item">member_id</td>
		<td>会员id，客户端暂时不需要此字段</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员登录接口</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"doLogin","content_user":"15101022452","content_pass":"123456","device_id":"123456","app_type":"1"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 doLogin</td>
	</tr>
    <tr>
		<td class="item">content_user</td>
		<td>必填参数，手机号，字符串类型</td>
	</tr>
    <tr>
		<td class="item">content_pass</td>
		<td>必填参数，密码，字符串类型</td>
	</tr>
    <tr>
		<td class="item">app_type</td>
		<td>必填参数，设备类型，1:ios、2:android</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22doLogin%22%2C%22content_user%22%3A%2215101022452%22%2C%22content_pass%22%3A%22123456%22%2C%22device_id%22%3A%22123456%22%2C%22app_type%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22doLogin%22%2C%22content_user%22%3A%2215101022452%22%2C%22content_pass%22%3A%22123456%22%2C%22device_id%22%3A%22123456%22%2C%22app_type%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u767b\u5f55\u6210\u529f","data":{"token":7552795,"member_id":"21","member_type":"1","content_mobile":"15101022452","content_name":"\u8def\u4eba\u7532","content_head":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/2015\/08\/23\/1440985527.jpg"}} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result字段为0时需要将此字段的信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>登录成功的会员相关信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data字段数据结构说明</td>
	</tr>
    <tr>
		<td class="item">token</td>
		<td>会员接口秘钥，客户端需要将此数据持久化保存，用作会员登录状态的判断标识，当客户端token存在时，客户端便可认为用户是在登录状态</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>会员用户名，即为注册手机号，客户端也需要将此数据作为用户登录名持久化保存，当调用部分数据接口时需要将此字段结合token字段一起使用</td>
	</tr>
    <tr>
		<td class="item">member_type</td>
		<td>会员类型，1个人会员、2商家会员，客户端需要将此数据持久化保存，根据此字段的不同来判断进入个人会员主界面或商家会员主界面</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>会员昵称，用于显示在会员中心头像下方的昵称位置，如果此字段返回NULL，则不需要显示昵称</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>会员头像图片URL，需要将此图片显示在会员中心的头像图片位置</td>
	</tr>
    <tr>
		<td class="item">member_id</td>
		<td>会员id，客户端暂时不需要此字段</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员注销接口</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"logout","timestamp":1439652627,"validate":"08932d99cdda4a07b7537753fb34335b","device_id":"123456"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 logout</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22logout%22%2C%22timestamp%22%3A1439652627%2C%22validate%22%3A%2208932d99cdda4a07b7537753fb34335b%22%2C%22device_id%22%3A%22123456%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22logout%22%2C%22timestamp%22%3A1439652627%2C%22validate%22%3A%2208932d99cdda4a07b7537753fb34335b%22%2C%22device_id%22%3A%22123456%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":""}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败，客户端处理时此处数据不论成功或失败都需要清除客户端存储的token数据</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
</table>








<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取会员信息(每次app重新启动时，若客户端会员token存在则需要调用此接口获取会员信息以便显示在会员中心界面)</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"getMemberInfo","timestamp":1440342905,"validate":"877935589c82908b41eea12364d80525","device_id":"123456"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getMemberInfo</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22getMemberInfo%22%2C%22timestamp%22%3A1440342905%2C%22validate%22%3A%22877935589c82908b41eea12364d80525%22%2C%22device_id%22%3A%22123456%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22getMemberInfo%22%2C%22timestamp%22%3A1440342905%2C%22validate%22%3A%22877935589c82908b41eea12364d80525%22%2C%22device_id%22%3A%22123456%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"member_id":"21","member_type":"1","content_mobile":"15101022452","content_name":"\u8def\u4eba\u7532","content_head":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/2015\/08\/23\/1440985527.jpg"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败，当此字段返回0时客户端需要清除客户端的会员信息，将客户端设置为未登录状态</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，在此接口中此字段未用到</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>会员数据</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>会员用户名，即为注册手机号，客户端也需要将此数据作为用户登录名持久化保存，当调用部分数据接口时需要将此字段结合token字段一起使用</td>
	</tr>
    <tr>
		<td class="item">member_type</td>
		<td>会员类型，1个人会员、2商家会员，客户端需要将此数据持久化保存，根据此字段的不同来判断进入个人会员主界面或商家会员主界面</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>会员昵称，用于显示在会员中心头像下方的昵称位置，如果此字段返回NULL，则不需要显示昵称</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>会员头像图片URL，需要将此图片显示在会员中心的头像图片位置</td>
	</tr>
    <tr>
		<td class="item">member_id</td>
		<td>会员id，客户端暂时不需要此字段</td>
	</tr>
</table>




<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取找回密码的短信验证码</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"getResetPasswordMobileMsg","content_mobile":"15101022452"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getResetPasswordMobileMsg</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>必填参数，用户输入的注册手机号</td>
	</tr> 
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22getResetPasswordMobileMsg%22%2C%22content_mobile%22%3A%2215101022452%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22getResetPasswordMobileMsg%22%2C%22content_mobile%22%3A%2215101022452%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u9a8c\u8bc1\u7801\u5df2\u7ecf\u53d1\u9001\u5230\u60a8\u7684\u624b\u673a\uff0c\u6709\u6548\u671f20\u5206\u949f\uff0c\u8bf7\u6ce8\u610f\u67e5\u6536"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要将此字段信息提示给用户</td>
	</tr> 
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">重置密码（找回密码）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"resetPassword","content_mobile":"15101022452","mobile_randnum":"25507","content_pass":"123456"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 resetPassword</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>必填参数，用户输入的注册手机号</td>
	</tr>
    <tr>
		<td class="item">mobile_randnum</td>
		<td>必填参数，用户输入的短信验证码</td>
	</tr>
    <tr>
		<td class="item">content_pass</td>
		<td>必填参数，用户输入的新密码</td>
	</tr> 
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22resetPassword%22%2C%22content_mobile%22%3A%2215101022452%22%2C%22mobile_randnum%22%3A%2225507%22%2C%22content_pass%22%3A%22123456%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22resetPassword%22%2C%22content_mobile%22%3A%2215101022452%22%2C%22mobile_randnum%22%3A%2225507%22%2C%22content_pass%22%3A%22123456%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u5bc6\u7801\u91cd\u7f6e\u6210\u529f\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败，若result为1则提示用户密码重置成功后再跳转到登录界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要将此字段信息提示给用户</td>
	</tr> 
</table>

<br/>
<hr/>浏览商品及预约<hr/>
<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取首页banner广告</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"ad","method":"indexBanner"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 ad</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 indexBanner</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22ad%22%2C%22method%22%3A%22indexBanner%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22ad%22%2C%22method%22%3A%22indexBanner%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"content_name":"\u5e7f\u544a01","content_link":"http:\/\/www.baidu.com","content_file":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/2015\/08\/21\/1441062140.jpg","content_width":"320","content_height":"293"},{"content_name":"\u5e7f\u544a02","content_link":"http:\/\/www.baidu.com","content_file":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/2015\/08\/21\/1440412473.jpg","content_width":"320","content_height":"293"},{"content_name":"\u5e7f\u544a03","content_link":"","content_file":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/2015\/08\/21\/1440477611.jpg","content_width":"320","content_height":"293"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，无需处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>广告图片数组</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">content_file</td>
		<td>图片文件url地址，需要根据此url地址载入图片</td>
	</tr>
    <tr>
		<td class="item">content_link</td>
		<td>点击广告后需要使用webview载入此链接对应的页面<br/>广告界面说明：<br/>标题栏左侧是返回按钮，点击返回主页，标题栏文字采用下面的广告标题字段，标题栏下方使用webview载入广告链接对应的页面</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>广告标题，当点击广告进入新界面时此字段需要显示在标题栏</td>
	</tr>
    <tr>
		<td class="item">content_width</td>
		<td>广告位宽度，暂时不需要</td>
	</tr>
    <tr>
		<td class="item">content_height</td>
		<td>广告位高度，暂时不需要</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看附近的作品（点击首页的美容、烫染、购买等进入后的作品列表）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"productLists","city_id":1,"street":"\u5706\u660e\u56ed\u4e1c\u95e8","lat":"40.018559","lng":"116.324646","serviceCategory":"1","orderField":"visit","page":"1"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 productLists</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，来源于定位接口或常用地址选择接口返回的city_id字段</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>不再需要此参数</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，GPS坐标的北纬度数，通过地址定位或使用常用地址接口的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，GPS坐标的东经度数，通过地址定位或使用常用地址接口的lng字段</td>
	</tr>
    <tr>
		<td class="item">serviceCategory</td>
		<td>必填参数，服务分类(1美发/烫染,2美容,3美甲,4化妆,5购买),直接在客户端将各分类的ID设置好即可</td>
	</tr>
    <tr>
		<td class="item">orderField</td>
		<td>可选参数，排序类型，默认为visit,取值范围：visit按人气排序，sales按销量排序，price按价格排序，priceDesc按价格降序排序</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>可选参数，代表当前分页数，默认为1，列表上拉加载更多数据时要根据下一页的页数进行赋值（页数从1开始，当执行上拉加载有数据更新时数值加1，若下一页无数据时则在下次上拉加载更多数据时此参数不需要增加）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productLists%22%2C%22city_id%22%3A1%2C%22street%22%3A%22%5Cu5706%5Cu660e%5Cu56ed%5Cu4e1c%5Cu95e8%22%2C%22lat%22%3A%2240.018559%22%2C%22lng%22%3A%22116.324646%22%2C%22serviceCategory%22%3A%221%22%2C%22orderField%22%3A%22visit%22%2C%22page%22%3A%221%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productLists%22%2C%22city_id%22%3A1%2C%22street%22%3A%22%5Cu5706%5Cu660e%5Cu56ed%5Cu4e1c%5Cu95e8%22%2C%22lat%22%3A%2240.018559%22%2C%22lng%22%3A%22116.324646%22%2C%22serviceCategory%22%3A%221%22%2C%22orderField%22%3A%22visit%22%2C%22page%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"7","content_name":"\u7117\u6cb9","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1441888532.jpg","content_price":"40.00","sales_num":"3"},{"auto_id":"4","content_name":"\u9ad8\u7ea7\u70eb\u67d3","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/03\/1441613887.jpg","content_price":"20.00","sales_num":"3"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>作品列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作品ID，查看作品明细时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>作品图片url,需要根据此URL载入作品图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>销量</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>价格</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看作品明细（由产品列表点击进入）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"productDetail","auto_id":7}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 productDetail</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>必填参数，作品ID，来源于作品列表的auto_id字段</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productDetail%22%2C%22auto_id%22%3A7%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productDetail%22%2C%22auto_id%22%3A7%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"auto_id":"7","content_name":"\u7117\u6cb9","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1441888532.jpg","content_price":"40.00","sales_num":"3","content_desc":"\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9\u7117\u6cb9","content_notes":"\u6ce8\u610f\u4e8b\u9879\u6ce8\u610f\u4e8b\u9879","content_product":"\u6240\u7528\u7684\u4ea7\u54c1\u6240\u7528\u7684\u4ea7\u54c1","during_time":"30\u5206\u949f","effect_time":"20\u5929","saler":{"auto_id":"28","content_name":"\u5218\u6842\u8d24","content_level":"1","sales_num":"20","avg_price":"80.00","content_head":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1442341713.jpg"},"comment_num":"10","can_buy":1}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>作品明细</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作品ID，购买或收藏作品时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>作品图片url,需要根据此URL载入作品图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>销量</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>价格</td>
	</tr>
    <tr>
		<td class="item">during_time</td>
		<td>耗时</td>
	</tr>
    <tr>
		<td class="item">effect_time</td>
		<td>有效期</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>简介，显示在耗时和有效期的下方</td>
	</tr>
    <tr>
		<td class="item">content_product</td>
		<td>使用产品</td>
	</tr>
    <tr>
		<td class="item">content_notes</td>
		<td>注意事项</td>
	</tr>
    <tr>
		<td class="item">comment_num</td>
		<td>顾客评价数</td>
	</tr>
    <tr>
		<td class="item">can_buy</td>
		<td>是否可预约，若为0则不显示预约按钮</td>
	</tr>
    <tr>
		<td class="item">saler</td>
		<td>作者信息（具体字段说明见下方的作者字段说明部分）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">作者信息字段说明（saler）</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作者ID，查看作者（手艺人）信息的接口需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作者姓名</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>作者的评价等级（取值范围：1至5）</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>作者接单数</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>作者头像图片URL</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看作品的评论</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"productCommentLists","product_id":6,"page":1}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 productCommentLists</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>必填参数，作品ID</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productCommentLists%22%2C%22product_id%22%3A6%2C%22page%22%3A1%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productCommentLists%22%2C%22product_id%22%3A6%2C%22page%22%3A1%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"2","member_id":"21","member_name":"\u859b\u65b0\u5cf0","content_level":"3","content_comment":"\u771f\u7684\u4e0d\u9519","create_time":"2015-10-17 11:15:07","member_head":"http:\/\/192.168.1.152\/test\/ysfs\/file\/upload\/2015\/08\/29\/1441640725.png"},{"auto_id":"1","member_id":"21","member_name":"\u859b\u65b0\u5cf0","content_level":"4","content_comment":"\u8fd8\u4e0d\u9519\u5440","create_time":"2015-10-17 09:58:55","member_head":"http:\/\/192.168.1.152\/test\/ysfs\/file\/upload\/2015\/08\/29\/1441640725.png"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1有数据，0没有数据</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result值为0时需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>评论列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组中的评论字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>评论ID,暂时未用到</td>
	</tr>
    <tr>
		<td class="item">member_id</td>
		<td>会员ID，暂时未用到</td>
	</tr>
    <tr>
		<td class="item">member_name</td>
		<td>评论人姓名</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>评论星级，取值范围0-5</td>
	</tr>
    <tr>
		<td class="item">content_comment</td>
		<td>评论内容</td>
	</tr>
    <tr>
		<td class="item">create_time</td>
		<td>评论时间</td>
	</tr>
    <tr>
		<td class="item">member_head</td>
		<td>评论人头像图片url</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">作品预约确认（由作品界面点击预约进入）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"productOrderConfirm","lat":"40.059117","lng":"116.311004","product_id":"4","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1444319025,"validate":"30a5f53e1f72bed493363d03cf5612d6"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 productOrderConfirm</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，GPS坐标的北纬度数，通过地址定位或使用常用地址接口的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，GPS坐标的东经度数，通过地址定位或使用常用地址接口的lng字段</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>必填参数，预约作品的ID，由作品明细界面获取</td>
	</tr>
     <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productOrderConfirm%22%2C%22lat%22%3A%2240.059117%22%2C%22lng%22%3A%22116.311004%22%2C%22product_id%22%3A%224%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444319025%2C%22validate%22%3A%2230a5f53e1f72bed493363d03cf5612d6%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productOrderConfirm%22%2C%22lat%22%3A%2240.059117%22%2C%22lng%22%3A%22116.311004%22%2C%22product_id%22%3A%224%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444319025%2C%22validate%22%3A%2230a5f53e1f72bed493363d03cf5612d6%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"product":{"auto_id":"4","content_name":"\u9ad8\u7ea7\u70eb\u67d3","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/03\/1441613887.jpg","content_price":"20.00","author":"\u859b\u65b0\u5cf0"},"defaultAddress":{"auto_id":"13","content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452","address":"\u56fd\u8d38\u534e\u8d38\u5199\u5b57\u697c"},"orderDate":{"minDate":"2015-10-12 09:00:00","maxDate":"2015-10-16 18:00:00"},"payTypeList":[{"id":"1","text":"\u5728\u7ebf\u652f\u4ed8"},{"id":"2","text":"\u73b0\u91d1\u652f\u4ed8"}]}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>作品预约提交界面所需要显示的信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">product</td>
		<td>作品信息，具体字段后面详细说明</td>
	</tr>
    <tr>
		<td class="item">defaultAddress</td>
		<td>默认地址信息，若没有则不显示，具体字段后面详细说明</td>
	</tr>
    <tr>
		<td class="item">orderDate</td>
		<td>预定时间的选择范围，具体字段后面说明</td>
	</tr>
    <tr>
		<td class="item">payTypeList</td>
		<td>可选择的支付方式列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">作品product字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作品ID，预约提交时需要此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>作品图片url</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>作品价格</td>
	</tr>
    <tr>
		<td class="item">author</td>
		<td>作者姓名，即发布此作品的手艺人姓名</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">默认地址defaultAddress字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>地址ID，预约提交时需要此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>姓名</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>手机号</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>地址</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">预约时间选择范围orderDate字段说明，建议在要求用户选择预约时间时日期和时间控件分开，先让用户选择日期,选完日期后再选择时间，以便进行日期时间范围的输入限制</td>
	</tr>
    <tr>
		<td class="item">minDate</td>
		<td>预约的最早时间，使用时需要拆成日期和时间两部分使用</td>
	</tr>
    <tr>
		<td class="item">maxDate</td>
		<td>预约的最晚时间,使用时需要拆成日期和时间两部分使用</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">payTypeList可选支付方式列表字段说明</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>支付方式ID，选择后需要提交此字段作为参数</td>
	</tr>
    <tr>
		<td class="item">text</td>
		<td>支付方式名称</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">作品预约订单提交（作品预约界面点击提交执行）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"productOrderSubmit","lat":"40.059117","lng":"116.311004","product_id":6,"address_id":18,"order_date":"2015-10-15 10:00:00","pay_type":2,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1444558202,"validate":"b83e0cd903b0e2d487a97637e77bf50f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 productOrderSubmit</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，GPS坐标的北纬度数，通过地址定位或使用常用地址接口的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，GPS坐标的东经度数，通过地址定位或使用常用地址接口的lng字段</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>必填参数，预约作品的ID，由作品明细界面获取</td>
	</tr>
    <tr>
		<td class="item">address_id</td>
		<td>必填参数，联系地址ID，从默认地址获取或从地址选择页面选择获取</td>
	</tr>
    <tr>
		<td class="item">order_date</td>
		<td>必填参数，预约时间，格式例如2015-11-06 12:00:00</td>
	</tr>
    <tr>
		<td class="item">pay_type</td>
		<td>必填参数，支付方式，有由订单确认接口的付方式列表字段获取</td>
	</tr>
     <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productOrderSubmit%22%2C%22lat%22%3A%2240.059117%22%2C%22lng%22%3A%22116.311004%22%2C%22product_id%22%3A6%2C%22address_id%22%3A18%2C%22order_date%22%3A%222015-10-15+10%3A00%3A00%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444320083%2C%22validate%22%3A%22172b54b890ccae75f69d45d1d12c15cf%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22productOrderSubmit%22%2C%22lat%22%3A%2240.059117%22%2C%22lng%22%3A%22116.311004%22%2C%22product_id%22%3A6%2C%22address_id%22%3A18%2C%22order_date%22%3A%222015-10-15+10%3A00%3A00%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444320083%2C%22validate%22%3A%22172b54b890ccae75f69d45d1d12c15cf%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u606d\u559c\u60a8\u4e0b\u5355\u6210\u529f","data":{"order_sn":"1510090001236479"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录，若返回1则需要根据返回的订单号进入相应的订单明细界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result返回1时需要把此字段提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>订单信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单号,需要根据此字段进入相应的订单明细界面</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看附近的手艺人（点击首页的美容、烫染、购买等进入后的手艺人列表）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"salesmanLists","city_id":1,"street":"\u5706\u660e\u56ed\u4e1c\u95e8","lat":"40.018559","lng":"116.324646","serviceCategory":"1","orderField":"visit","page":"1"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 salesmanLists</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，来源于定位接口或常用地址选择接口返回的city_id字段</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>不再需要此参数</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，GPS坐标的北纬度数，通过地址定位或使用常用地址接口的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，GPS坐标的东经度数，通过地址定位或使用常用地址接口的lng字段</td>
	</tr>
    <tr>
		<td class="item">serviceCategory</td>
		<td>必填参数，服务分类(1美发/烫染,2美容,3美甲,4化妆,5购买),直接在客户端将各分类的ID设置好即可</td>
	</tr>
    <tr>
		<td class="item">orderField</td>
		<td>可选参数，排序类型，默认为visit,取值范围：visit按人气排序，sales按销量排序，price按价格排序，priceDesc按价格降序排序</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>可选参数，代表当前分页数，默认为1，列表上拉加载更多数据时要根据下一页的页数进行赋值（页数从1开始，当执行上拉加载有数据更新时数值加1，若下一页无数据时则在下次上拉加载更多数据时此参数不需要增加）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22salesmanLists%22%2C%22city_id%22%3A1%2C%22street%22%3A%22%5Cu5706%5Cu660e%5Cu56ed%5Cu4e1c%5Cu95e8%22%2C%22lat%22%3A%2240.018559%22%2C%22lng%22%3A%22116.324646%22%2C%22serviceCategory%22%3A%221%22%2C%22orderField%22%3A%22visit%22%2C%22page%22%3A%221%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22salesmanLists%22%2C%22city_id%22%3A1%2C%22street%22%3A%22%5Cu5706%5Cu660e%5Cu56ed%5Cu4e1c%5Cu95e8%22%2C%22lat%22%3A%2240.018559%22%2C%22lng%22%3A%22116.324646%22%2C%22serviceCategory%22%3A%221%22%2C%22orderField%22%3A%22visit%22%2C%22page%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"21","content_name":"\u859b\u65b0\u5cf0","content_level":"1","content_head":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/","sales_num":"1","avg_price":"50.00"},{"auto_id":"28","content_name":"\u5218\u6842\u8d24","content_level":"1","content_head":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/","sales_num":"20","avg_price":"80.00"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>手艺人列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>手艺人ID，查看手艺人明细时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>手艺人姓名</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>手艺人头像url,需要根据此URL载入头像图片</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>手艺人的评价等级（取值范围：1至5）</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>接单数（销量）</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看手艺人明细（由手艺人列表或作品的作者介绍点击进入）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"salesmanDetail","auto_id":21}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 salesmanDetail</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>必填参数，手艺人ID，来源于手艺人列表的auto_id字段或作品的手艺人ID字段</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22salesmanDetail%22%2C%22auto_id%22%3A21%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22salesmanDetail%22%2C%22auto_id%22%3A21%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"auto_id":"21","content_name":"\u859b\u65b0\u5cf0","content_head":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/08\/29\/1441640725.png","content_level":"1","sales_num":"1","avg_price":"50.00","content_desc":"454747457","service_district":"\u4e2d\u5173\u6751,\u4e0a\u5730","productList":[{"auto_id":"5","content_name":"\u7f8e\u5bb9\u62a4\u80a4","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1441897015.jpg","content_price":"250.00","sales_num":"5"},{"auto_id":"4","content_name":"\u9ad8\u7ea7\u70eb\u67d3","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/03\/1441613887.jpg","content_price":"20.00","sales_num":"3"}],"photoList":[{"auto_id":"4","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1442172422.jpg"},{"auto_id":"3","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1442172422.jpg"}]}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>手艺人明细</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>手艺人ID，收藏手艺人时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>手艺人姓名</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>手艺人头像url,需要根据此URL载入头像图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>接单数</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>手艺人的评价等级（取值范围：1至5）</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>个人介绍</td>
	</tr>
    <tr>
		<td class="item">service_district</td>
		<td>服务商圈</td>
	</tr>
    <tr>
		<td class="item">productList</td>
		<td>作品列表（具体字段说明见下方的作品字段说明部分）</td>
	</tr>
    <tr>
		<td class="item">photoList</td>
		<td>照片列表(用于展示手艺人相册，具体字段说明见下方的作品字段说明部分)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">作品列表字段说明（productList）</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作品ID，查看作品明细信息的接口需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>作品图片url,需要根据此url加载作品的图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>购买数</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>价格</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">相册列表字段说明（photoList）</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>照片ID，暂时未用到</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>照片url,需要根据此url加载照片</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看附近的店铺（点击首页的美容、烫染、购买等进入后的店铺列表）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"shopLists","city_id":1,"lat":"39.982451","lng":"116.376472","serviceCategory":"1","orderField":"distance","page":"1"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 shopLists</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，来源于定位接口或常用地址选择接口返回的city_id字段</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，GPS坐标的北纬度数，通过地址定位或使用常用地址接口的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，GPS坐标的东经度数，通过地址定位或使用常用地址接口的lng字段</td>
	</tr>
    <tr>
		<td class="item">serviceCategory</td>
		<td>必填参数，服务分类(1美发/烫染,2美容,3美甲,4化妆,5购买),直接在客户端将各分类的ID设置好即可</td>
	</tr>
    <tr>
		<td class="item">orderField</td>
		<td>可选参数，排序类型，默认为distance,取值范围：distance按距离排序，sales按销量排序，price按价格排序，priceDesc按价格降序排序</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>可选参数，代表当前分页数，默认为1，列表上拉加载更多数据时要根据下一页的页数进行赋值（页数从1开始，当执行上拉加载有数据更新时数值加1，若下一页无数据时则在下次上拉加载更多数据时此参数不需要增加）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22shopLists%22%2C%22city_id%22%3A1%2C%22lat%22%3A%2239.982451%22%2C%22lng%22%3A%22116.376472%22%2C%22serviceCategory%22%3A%221%22%2C%22orderField%22%3A%22distance%22%2C%22page%22%3A%221%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22shopLists%22%2C%22city_id%22%3A1%2C%22lat%22%3A%2239.982451%22%2C%22lng%22%3A%22116.376472%22%2C%22serviceCategory%22%3A%221%22%2C%22orderField%22%3A%22distance%22%2C%22page%22%3A%221%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"1","shop_name":"\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/03\/1441812504.jpg","sales_num":"20","avg_price":"80.00","distance":"4.4"},{"auto_id":"2","shop_name":"\u9038\u4e1d\u98ce\u5c1a\u4e0a\u5730\u5e97","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1441635380.jpg","sales_num":"35","avg_price":"50.00","distance":"7.0"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>店铺列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>店铺ID，查看店铺明细时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">shop_name</td>
		<td>店铺名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>店铺图片url,需要根据此URL载入店铺图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>接单数（销量）</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
    <tr>
		<td class="item">distance</td>
		<td>距离，单位为km</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">

		<th colspan="2" align="left">查看店铺明细（由店铺列表点击进入）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"shopDetail","auto_id":1}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 shopDetail</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>必填参数，店铺ID，来源于店铺列表接口的auto_id字段</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22shopDetail%22%2C%22auto_id%22%3A1%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22shopDetail%22%2C%22auto_id%22%3A1%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"auto_id":"1","shop_name":"\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97","content_desc":"\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97\u9038\u4e1d\u98ce\u5c1a\u4e2d\u5173\u6751\u5e97","content_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/03\/1441812504.jpg","avg_price":"80.00","sales_num":"20","salesmanList":[{"auto_id":"21","content_name":"\u859b\u65b0\u5cf0","content_level":"1","content_head":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/08\/29\/1441640725.png","sales_num":"1","avg_price":"50.00"}]}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>店铺明细</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>店铺ID</td>
	</tr>
    <tr>
		<td class="item">shop_name</td>
		<td>店铺名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>店铺图片url,需要根据此URL载入店铺图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>接单数</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>店铺介绍</td>
	</tr>
    <tr>
		<td class="item">salesmanList</td>
		<td>手艺人列表（具体字段说明见下方的作品字段说明部分）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">手艺人列表字段说明（salesmanList）</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>手艺人ID，点击查看手艺人明细信息时需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>手艺人姓名</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>手艺人的评价等级（取值范围：1至5）</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>头像图片url,需要根据此url加载手艺人的头像图片</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>接单数</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看可预约的服务项（点击首页预约频道，在预约分类界面点击分类进入）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"service","method":"standardProductLists","city_id":1,"lat":"40.059117","lng":"116.311004","serviceCategory":"2"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 service</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 standardProductLists</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，来源于定位接口或常用地址选择接口返回的city_id字段</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>必填参数，GPS坐标的北纬度数，通过地址定位或使用常用地址接口的lat字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>必填参数，GPS坐标的东经度数，通过地址定位或使用常用地址接口的lng字段</td>
	</tr>
    <tr>
		<td class="item">serviceCategory</td>
		<td>必填参数，服务分类(1美发/烫染,2美容,3美甲,4化妆,5购买),直接在客户端将各分类的ID设置好即可</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22standardProductLists%22%2C%22city_id%22%3A1%2C%22lat%22%3A%2240.059117%22%2C%22lng%22%3A%22116.311004%22%2C%22serviceCategory%22%3A%222%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22service%22%2C%22method%22%3A%22standardProductLists%22%2C%22city_id%22%3A1%2C%22lat%22%3A%2240.059117%22%2C%22lng%22%3A%22116.311004%22%2C%22serviceCategory%22%3A%222%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"2","content_name":"\u56fd\u4ea7\u5957\u88c5","content_desc":"\u4f7f\u7528\u56fd\u4ea7\u4f18\u8d28\u5957\u88c5\u4e3a\u60a8\u670d\u52a1","content_price":"50.00"},{"auto_id":"3","content_name":"\u8fdb\u53e3\u5957\u88c5","content_desc":"\u4f7f\u7528\u8fdb\u53e3\u54c1\u724c\u7684\u4ea7\u54c1\u4e3a\u60a8\u670d\u52a1","content_price":"100.00"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>服务项列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>服务ID，提交预约时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>服务名称</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>服务简介</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>服务价格</td>
	</tr>
</table>


<br/>
<hr/>
活动及设置
<hr/>
<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">活动列表数据（主页底部导航的活动菜单）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"news","method":"activeLists","page":1}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 news</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 activeLists</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>可选参数，代表当前分页数，默认为1，列表上拉加载更多数据时要根据下一页的页数进行赋值（页数从1开始，当执行上拉加载有数据更新时数值加1，若下一页无数据时则在下次上拉加载更多数据时此参数不需要增加）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22news%22%2C%22method%22%3A%22activeLists%22%2C%22page%22%3A2%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22news%22%2C%22method%22%3A%22activeLists%22%2C%22page%22%3A2%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"2174","content_name":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u6807\u98985","content_desc":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb.5","content_link":"http:\/\/127.0.0.1\/yisifengshang\/index.php?acl=news&method=detail&id=2174","content_img":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/nophoto.jpg"},{"auto_id":"2173","content_name":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u6807\u98984","content_desc":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb.4","content_link":"http:\/\/127.0.0.1\/yisifengshang\/index.php?acl=news&method=detail&id=2173","content_img":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/nophoto.jpg"},{"auto_id":"2172","content_name":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u6807\u98983","content_desc":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb.3","content_link":"http:\/\/127.0.0.1\/yisifengshang\/index.php?acl=news&method=detail&id=2172","content_img":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/nophoto.jpg"},{"auto_id":"2171","content_name":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u6807\u98982","content_desc":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb.2","content_link":"http:\/\/127.0.0.1\/yisifengshang\/index.php?acl=news&method=detail&id=2171","content_img":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/nophoto.jpg"},{"auto_id":"2170","content_name":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u6807\u98981","content_desc":"\u6d3b\u52a8-\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb,\u6d4b\u8bd5\u8d44\u8baf\u6570\u636e\u7b80\u4ecb.1","content_link":"http:\/\/www.baidu.com","content_img":"http:\/\/127.0.0.1\/yisifengshang\/file\/upload\/nophoto.jpg"}]} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0没有更多数据了</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当返回的result值为0时需要将此提示信息显示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>活动资讯列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>资讯ID，接口保留字段，暂时未用到</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>资讯标题，若字数过长客户端要根据情况隐藏多余的文字</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>资讯简介，若字数过长客户端要根据情况隐藏多余的文字</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>图片url</td>
	</tr>
    <tr>
		<td class="item">content_link</td>
		<td>详情url,当点击列表中的资讯条目时需要在新界面中使用webview载入此URL内容<br/>资讯明细界面可以和上面的广告明细采用相同的界面形式:<br/>标题栏文字放置“活动”即可，左上角带有返回按钮，点击返回主页，正文部分使用webview载入网页内容</td>
	</tr> 
</table>
<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">申请成为手艺人</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"joinApply","method":"saveApply","city_id":14,"linkman_name":"\u859b\u65b0\u5cf0","content_sex":2,"content_mobile":"15101022452","content_address":"\u6d4b\u8bd5\u5730\u5740"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 joinApply</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 saveApply</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>必填参数，城市ID，在城市选择列表选择的城市的ID，若不选择则使用默认的当前所在地的城市ID（使用从获取当前位置的接口返回的city_id字段）</td>
	</tr>
    <tr>
		<td class="item">linkman_name</td>
		<td>必填参数，姓名</td>
	</tr>
    <tr>
		<td class="item">content_sex</td>
		<td>必填参数，性别：1男、2女，需要将男女选项对应的数字提交即可，此字典变量直接定义在客户端即可</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>必填参数，手机号，字符串类型，客户端需要校验手机号格式（以1开头的11位数字即可）</td>
	</tr>
    <tr>
		<td class="item">content_address</td>
		<td>必填参数，联系地址，字符串类型</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22joinApply%22%2C%22method%22%3A%22saveApply%22%2C%22city_id%22%3A14%2C%22linkman_name%22%3A%22%5Cu859b%5Cu65b0%5Cu5cf0%22%2C%22content_sex%22%3A2%2C%22content_mobile%22%3A%2215101022452%22%2C%22content_address%22%3A%22%5Cu6d4b%5Cu8bd5%5Cu5730%5Cu5740%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param==%7B%22acl%22%3A%22joinApply%22%2C%22method%22%3A%22saveApply%22%2C%22city_id%22%3A14%2C%22linkman_name%22%3A%22%5Cu859b%5Cu65b0%5Cu5cf0%22%2C%22content_sex%22%3A2%2C%22content_mobile%22%3A%2215101022452%22%2C%22content_address%22%3A%22%5Cu6d4b%5Cu8bd5%5Cu5730%5Cu5740%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u4fe1\u606f\u63d0\u4ea4\u6210\u529f\uff0c\u6211\u4eec\u4f1a\u5c3d\u5feb\u5904\u7406\u60a8\u7684\u7533\u8bf7"} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，提交后需要将此信息提交给用户，提示后需要返回到上一级设置界面</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">设置--服务范围（webview载入url链接）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">页面url地址，使用webview界面载入</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}<?="/index.php?acl=article&method=detail&menu=2"?></td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">设置--关于我们（webview载入url链接）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">页面url地址，使用webview界面载入</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}<?="/index.php?acl=article&method=detail&menu=17"?></td>
	</tr>
</table>

<br/>
<hr/>会员中心功能<hr/>
<br />

<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">修改会员昵称</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"saveNickName","timestamp":1440324453,"validate":"a810cd504c56d34c53af565c54576495","device_id":"123456","content_name":"\u8def\u4eba\u7532"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 saveNickName</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>必填参数，昵称，字符串类型，UTF-8编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22saveNickName%22%2C%22timestamp%22%3A1440324453%2C%22validate%22%3A%22a810cd504c56d34c53af565c54576495%22%2C%22device_id%22%3A%22123456%22%2C%22content_name%22%3A%22%5Cu8def%5Cu4eba%5Cu7532%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22saveNickName%22%2C%22timestamp%22%3A1440324453%2C%22validate%22%3A%22a810cd504c56d34c53af565c54576495%22%2C%22device_id%22%3A%22123456%22%2C%22content_name%22%3A%22%5Cu8def%5Cu4eba%5Cu7532%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u64cd\u4f5c\u6210\u529f"} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，-1登录校验失败，若返回-1需要跳转至会员登录界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，若返回-1需要将此信息提示给用户</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">修改会员头像</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">参数说明</td>
	</tr>
    <tr>
		<td colspan="2" align="left">此接口参数与其他接口不同，除param参数外还有一个content_head_file参数，content_head_file参数是存放上传图片文件的参数，此参数只能使用post方式提交</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"uploadHeadImg","timestamp":1440324453,"validate":"a810cd504c56d34c53af565c54576495","device_id":"123456"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数各字段说明</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 uploadHeadImg</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22saveNickName%22%2C%22timestamp%22%3A1440324453%2C%22validate%22%3A%22a810cd504c56d34c53af565c54576495%22%2C%22device_id%22%3A%22123456%22%2C%22content_name%22%3A%22%5Cu8def%5Cu4eba%5Cu7532%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">content_head_file参数说明</td>
	</tr>
    <tr>
		<td colspan="2" align="left">存放上传的图片文件，字段名为content_head_file</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u64cd\u4f5c\u6210\u529f","data":{"headImg":"http:\/\/localhost\/yisifengshang\/file\/upload\/2015\/08\/23\/1440985527.jpg"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面，</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，若result返回0需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>上传后的图片信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">headImg</td>
		<td>上传成功后获得的头像图片url，需要用此图片路径替换掉当前的头像图片路径</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">修改密码</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>

		<td colspan="2" align="left">{"acl":"member","method":"changePassword","timestamp":1440340040,"validate":"d5e7ca8ef3c70c849db1685f80d487fc","device_id":"123456","old_pass":"123456","new_pass":"111111"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 changePassword</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td class="item">old_pass</td>
		<td>必填参数，原密码</td>
	</tr>
    <tr>
		<td class="item">new_pass</td>
		<td>必填参数，新密码，要求至少输入6位</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22changePassword%22%2C%22timestamp%22%3A1440340040%2C%22validate%22%3A%22d5e7ca8ef3c70c849db1685f80d487fc%22%2C%22device_id%22%3A%22123456%22%2C%22old_pass%22%3A%22123456%22%2C%22new_pass%22%3A%22111111%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22changePassword%22%2C%22timestamp%22%3A1440340040%2C%22validate%22%3A%22d5e7ca8ef3c70c849db1685f80d487fc%22%2C%22device_id%22%3A%22123456%22%2C%22old_pass%22%3A%22123456%22%2C%22new_pass%22%3A%22111111%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u60a8\u5df2\u7ecf\u6210\u529f\u4fee\u6539\u4e86\u5bc6\u7801","data":{"token":2205749}} </td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不管结果如何，都需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>会员数据</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">token</td>
		<td>修改密码后服务端会更新此用户的token，此处返回token后客户端需要使用此token替换之前存储在客户端的toekn，否则会员的登录验证会失效</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取会员中心常用地址列表（登录后可用）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"address","method":"getMemberAddressList","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1441419686,"validate":"650ac600cba0e00db3dd1d9e5886483b","page":1}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 address</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getMemberAddressList</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>可选参数，代表当前分页数，默认为1，列表上拉加载更多数据时要根据下一页的页数进行赋值（页数从1开始，当执行上拉加载有数据更新时数值加1，若下一页无数据时则在下次上拉加载更多数据时此参数不需要增加）</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22getMemberAddressList%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1441419686%2C%22validate%22%3A%22650ac600cba0e00db3dd1d9e5886483b%22%2C%22page%22%3A1%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22address%22%2C%22method%22%3A%22getMemberAddressList%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1441419686%2C%22validate%22%3A%22650ac600cba0e00db3dd1d9e5886483b%22%2C%22page%22%3A1%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"id":"18","address":"\u661f\u6cb3\u7693\u6708Q3\u680b","street":"\u661f\u6cb3\u7693\u6708-\u5317\u95e8","content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452","lat":"39.989312","lng":"116.781594","city_id":"14","city":"\u5eca\u574a\u5e02","is_default":"0"},{"id":"13","address":"\u534e\u8d38\u5199\u5b57\u697c","street":"\u56fd\u8d38","content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452","lat":"39.914112","lng":"116.487719","city_id":"1","city":"\u5317\u4eac\u5e02","is_default":"1"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，此接口可忽略此字段</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>常用地址列表</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">id</td>
		<td>地址ID，修改常用地址的接口中会用到此字段的值</td>
	</tr>
    <tr>
		<td class="item">city_id</td>
		<td>城市ID，选择地址后需要将此字段存储在客户端，地址搜索及某些接口中会用到此参数</td>
	</tr>
    <tr>
		<td class="item">city</td>
		<td>城市名称，选择地址后需要将此字段存储在客户端，在显示当前城市时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">street</td>
		<td>街道名称，选择此地址后需要将此字段存储在客户端，并显示在首页左上角当前位置，注意字数太长时客户端显示时要根据情况做截字处理</td>
	</tr>
    <tr>
		<td class="item">lat</td>
		<td>北纬度数，选择地址后需要将此字段存储在客户端，在显示周边信息时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">lng</td>
		<td>东经度数，选择地址后需要将此字段存储在客户端，在显示周边信息时会用到此字段</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>详细地址，选择地址后需要将此字段存储在客户端，在下单时默认显示在联系人详细地址表单中</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>联系人姓名，选择地址后需要将此字段存储在客户端，在下单时默认显示在联系人姓名表单中</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>联系人手机，选择地址后需要将此字段存储在客户端，在下单时默认显示在联系人手机号码表单中</td>
	</tr>
    <tr>
		<td class="item">is_default</td>
		<td>是否是默认地址，若返回1，则客户端应把此地址显示为默认地址，前面的复选框设置为选中状态</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心订单列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"orderList","page":1,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1444555460,"validate":"21c7dde3e1fb47ed4e266d61700f028b"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 orderList</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22orderList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444555460%2C%22validate%22%3A%2221c7dde3e1fb47ed4e266d61700f028b%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22orderList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444555460%2C%22validate%22%3A%2221c7dde3e1fb47ed4e266d61700f028b%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"3","order_sn":"1510090001236479","service_member_name":"\u5218\u6842\u8d24","order_status":"0","product_name":"\u7f8e\u5bb9\u6c34\u7597\u6cd5","product_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1442178767.jpg","product_money":"160.00","order_time":"2015-10-15 10:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q3\u680b","pay_money":"160.00","pay_type":"1","pay_status":"0","status_text":"\u5f85\u786e\u8ba4","paybtn":1,"cancelbtn":1},{"auto_id":"2","order_sn":"1510082339295439","service_member_name":"\u5218\u6842\u8d24","order_status":"0","product_name":"\u7f8e\u5bb9\u6c34\u7597\u6cd5","product_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1442178767.jpg","product_money":"160.00","order_time":"2015-10-15 10:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q3\u680b","pay_money":"160.00","pay_type":"1","pay_status":"0","status_text":"\u5f85\u786e\u8ba4","paybtn":1,"cancelbtn":1}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1有数据，0没有数据,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>订单列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>订单ID,暂时未用到</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单号,查看订单明细的界面需要此字段作为参数调用接口,另外支付或取消订单的接口也需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">service_member_name</td>
		<td>服务人员姓名</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>预定的产品名称</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>产品图片url</td>
	</tr>
    <tr>
		<td class="item">product_money</td>
		<td>产品价格</td>
	</tr>
    <tr>
		<td class="item">order_time</td>
		<td>预定时间</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>联系地址</td>
	</tr>
    <tr>
		<td class="item">pay_money</td>
		<td>订单金额（需支付金额）</td>
	</tr>
    <tr>
		<td class="item">status_text</td>
		<td>订单状态文字说明</td>
	</tr>
    <tr>
		<td class="item">paybtn</td>
		<td>是否显示支付按钮，为1时显示按钮，为0时不显示按钮</td>
	</tr>
    <tr>
		<td class="item">cancelbtn</td>
		<td>是否显示取消按钮，为1时显示按钮，为0时不显示按钮</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心订单明细</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"orderDetail","order_sn":"1510082339295439","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1444556560,"validate":"ed3a5d3b9cabe6d7a1e6aaaba910cb48"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 orderDetail</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>必填参数，订单号，可由订单列表获取或预定下单后返回获得</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22orderDetail%22%2C%22order_sn%22%3A%221510082339295439%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444556560%2C%22validate%22%3A%22ed3a5d3b9cabe6d7a1e6aaaba910cb48%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22orderDetail%22%2C%22order_sn%22%3A%221510082339295439%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444556560%2C%22validate%22%3A%22ed3a5d3b9cabe6d7a1e6aaaba910cb48%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"auto_id":"2","order_sn":"1510082339295439","service_member_name":"\u5218\u6842\u8d24","product_name":"\u7f8e\u5bb9\u6c34\u7597\u6cd5","product_img":"http:\/\/192.168.1.185\/yisifengshang\/file\/upload\/2015\/09\/05\/1442178767.jpg","product_money":"160.00","order_time":"2015-10-15 10:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q3\u680b","pay_money":"160.00","customer_name":"\u859b\u65b0\u5cf0","customer_mobile":"15101022452","status_text":"\u5f85\u786e\u8ba4","paybtn":1,"cancelbtn":1}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result为0时需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>订单信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>订单ID</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单号，支付或取消订单的接口需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">service_member_name</td>
		<td>服务人员姓名</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>预定的产品名称</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>产品图片url</td>
	</tr>
    <tr>
		<td class="item">product_money</td>
		<td>产品价格</td>
	</tr>
    <tr>
		<td class="item">order_time</td>
		<td>预定时间</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>联系地址</td>
	</tr>
    <tr>
		<td class="item">pay_money</td>
		<td>订单金额（需支付金额）</td>
	</tr>
    <tr>
		<td class="item">status_text</td>
		<td>订单状态文字说明</td>
	</tr>
    <tr>
		<td class="item">customer_name</td>
		<td>顾客姓名</td>
	</tr>
    <tr>
		<td class="item">customer_mobile</td>
		<td>顾客电话</td>
	</tr>
    <tr>
		<td class="item">paybtn</td>
		<td>是否显示支付按钮，为1时显示按钮，为0时不显示按钮</td>
	</tr>
    <tr>
		<td class="item">cancelbtn</td>
		<td>是否显示取消按钮，为1时显示按钮，为0时不显示按钮</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">取消订单</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"cancelOrder","order_sn":"1510111810028149","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1444558787,"validate":"03861ab74599779866d93837c456dc47"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 cancelOrder</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>必填参数，订单号，可由订单列表或订单明细接口获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22cancelOrder%22%2C%22order_sn%22%3A%221510111810028149%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444558787%2C%22validate%22%3A%2203861ab74599779866d93837c456dc47%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22cancelOrder%22%2C%22order_sn%22%3A%221510111810028149%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1444558787%2C%22validate%22%3A%2203861ab74599779866d93837c456dc47%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u8ba2\u5355\u53d6\u6d88\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要将此字段信息提示给用户</td>
	</tr> 
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心待评论的产品列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"toCommentLists","page":1,"device_id":"864587028272400","timestamp":1446045612,"validate":"5012f52d7ea7c8f743068f74017c5c53"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 toCommentLists</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22toCommentLists%22%2C%22page%22%3A1%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1446045612%2C%22validate%22%3A%225012f52d7ea7c8f743068f74017c5c53%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22toCommentLists%22%2C%22page%22%3A1%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1446045612%2C%22validate%22%3A%225012f52d7ea7c8f743068f74017c5c53%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"5","order_sn":"1510242335446578","service_member_name":"\u859b\u65b0\u5cf0","product_id":"8","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","product_money":"120.00","order_time":"2015-10-25 10:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"120.00","status_text":"\u5df2\u5b8c\u6210"},{"auto_id":"1","order_sn":"345435","service_member_name":"\u859b\u65b0\u5cf0","product_id":"3","product_name":"\u8fdb\u53e3\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/nophoto.jpg","product_money":"100.00","order_time":"2015-10-13 12:00:00","address":"\u5317\u4eac\u5e02\u4e2d\u5173\u6751\u4e2d\u5173\u6751\u79d1\u8d38","pay_money":"100.00","status_text":"\u5df2\u5b8c\u6210"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1有数据，0没有数据,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>待评论的产品列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组中的产品字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>订单ID,暂时未用到</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单号，发表评论的接口需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">service_member_name</td>
		<td>服务人员姓名</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>产品ID，发表评论的接口需要用到此字段</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>预定的产品名称</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>产品图片url</td>
	</tr>
    <tr>
		<td class="item">product_money</td>
		<td>产品价格</td>
	</tr>
    <tr>
		<td class="item">order_time</td>
		<td>预定时间</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>联系地址</td>
	</tr>
    <tr>
		<td class="item">pay_money</td>
		<td>订单金额（需支付金额）</td>
	</tr>
    <tr>
		<td class="item">status_text</td>
		<td>订单状态文字说明</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心发表评论</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"addComment","order_sn":"1510242335446578","product_id":"8","device_id":"864587028272400","content_level":3,"content_comment":"\u8bc4\u4ef7\u6d4b\u8bd5","timestamp":1446047022,"validate":"19740be44ee9d512366a96080e6cf701"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 addComment</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>选填参数，订单号</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>选填参数，评论的产品ID</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>选填参数，打分星级，取值范围1-5</td>
	</tr>
    <tr>
		<td class="item">content_comment</td>
		<td>选填参数，评论文字内容</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22addComment%22%2C%22order_sn%22%3A%221510242335446578%22%2C%22product_id%22%3A%228%22%2C%22device_id%22%3A%22864587028272400%22%2C%22content_level%22%3A3%2C%22content_comment%22%3A%22%5Cu8bc4%5Cu4ef7%5Cu6d4b%5Cu8bd5%22%2C%22timestamp%22%3A1446047022%2C%22validate%22%3A%2219740be44ee9d512366a96080e6cf701%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22addComment%22%2C%22order_sn%22%3A%221510242335446578%22%2C%22product_id%22%3A%228%22%2C%22device_id%22%3A%22864587028272400%22%2C%22content_level%22%3A3%2C%22content_comment%22%3A%22%5Cu8bc4%5Cu4ef7%5Cu6d4b%5Cu8bd5%22%2C%22timestamp%22%3A1446047022%2C%22validate%22%3A%2219740be44ee9d512366a96080e6cf701%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u8bc4\u8bba\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1评论成功，0评论失败,若返回-1则返回登录界面要求用户登录，评论成功后跳转到“我的评论”列表</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要提示给用户</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心我的评论列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"member","method":"myCommentLists","page":1,"device_id":"864587028272400","timestamp":1446047471,"validate":"cf26781602247a06a4c901744e79c30b"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 member</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 myCommentLists</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22myCommentLists%22%2C%22page%22%3A1%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1446047471%2C%22validate%22%3A%22cf26781602247a06a4c901744e79c30b%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22member%22%2C%22method%22%3A%22myCommentLists%22%2C%22page%22%3A1%2C%22device_id%22%3A%22864587028272400%22%2C%22timestamp%22%3A1446047471%2C%22validate%22%3A%22cf26781602247a06a4c901744e79c30b%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"order_sn":"1510242335446578","product_id":"8","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","content_level":"3","content_comment":"\u8bc4\u4ef7\u6d4b\u8bd5","create_time":"2015-10-28 23:43:42","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1有数据，0没有数据,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>我的评论列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组中的评论字段说明</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单编号,暂时未用到</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>产品ID</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>产品名称</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>产品图片url</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>评价等级，取值范围1-5</td>
	</tr>
    <tr>
		<td class="item">content_comment</td>
		<td>评价内容</td>
	</tr>
    <tr>
		<td class="item">create_time</td>
		<td>评论时间</td>
	</tr>
</table>


<br />
<hr/>
手艺人会员功能
<hr/>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心首页信息（进入服务人员会员中心首页时调用，当用户每次重新进入此界面时都需要调用接口刷新截面数据，当用户停留在此界面时需要每隔30秒调用此接口刷新界面数据）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"getServiceMemberInfo","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1446372751,"validate":"9595b79bdf62cd9be823d8afb1fda754"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getServiceMemberInfo</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22getServiceMemberInfo%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446372751%2C%22validate%22%3A%229595b79bdf62cd9be823d8afb1fda754%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22getServiceMemberInfo%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446372751%2C%22validate%22%3A%229595b79bdf62cd9be823d8afb1fda754%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"content_name":"\u859b\u65b0\u5cf0","content_mobile":"15101022452","content_head":"2015\/10\/24\/1445839203_s.jpg","content_level":"1","sales_num":"1","avg_price":"50.00","order_num":"5","product_num":"4","comment_num":"1","photos_num":"3","is_agree":"\u5df2\u5ba1\u6838","publish":"\u6b63\u5e38"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，当result返回0时需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>会员中心首页需要显示的信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data的字段说明</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>手艺人姓名</td>
	</tr>
    <tr>
		<td class="item">content_mobile</td>
		<td>手艺人注册手机号</td>
	</tr>
    <tr>
		<td class="item">content_head</td>
		<td>头像图片</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>评价星级（取值范围1-5）</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>接单数</td>
	</tr>
    <tr>
		<td class="item">avg_price</td>
		<td>均价</td>
	</tr>
    <tr>
		<td class="item">order_num</td>
		<td>订单数量</td>
	</tr>
    <tr>
		<td class="item">product_num</td>
		<td>作品数量</td>
	</tr>
    <tr>
		<td class="item">comment_num</td>
		<td>评论数量</td>
	</tr>
    <tr>
		<td class="item">photos_num</td>
		<td>照片数量</td>
	</tr>
    <tr>
		<td class="item">is_agree</td>
		<td>审核状态</td>
	</tr>
    <tr>
		<td class="item">publish</td>
		<td>营业状态</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">我的作品列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"myProductList","page":1,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445681363,"validate":"5e51e4be8e89b462b2a975d067cf52f2"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 myProductList</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myProductList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445681363%2C%22validate%22%3A%225e51e4be8e89b462b2a975d067cf52f2%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myProductList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445681363%2C%22validate%22%3A%225e51e4be8e89b462b2a975d067cf52f2%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"5","content_name":"\u7f8e\u5bb9\u62a4\u80a4","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/09\/05\/1441897015.jpg","publish":"1","content_price":"250.00","publish_status_text":"\u5df2\u53d1\u5e03","sales_count":"0"},{"auto_id":"4","content_name":"\u9ad8\u7ea7\u70eb\u67d3","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/09\/03\/1441613887.jpg","publish":"1","content_price":"20.00","publish_status_text":"\u5df2\u53d1\u5e03","sales_count":"0"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>作品列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作品ID，编辑作品时需要用到此参数</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>作品图片</td>
	</tr>
    <tr>
		<td class="item">publish</td>
		<td>发布状态：0未发布，1已发布</td>
	</tr>
    <tr>
		<td class="item">publish_status_text</td>
		<td>发布状态显示的文字</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>价格</td>
	</tr>
    <tr>
		<td class="item">sales_num</td>
		<td>销售数量</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">上传作品图片</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">参数说明</td>
	</tr>
    <tr>
		<td colspan="2" align="left">此接口参数与其他接口不同，除param参数外还有一个content_img参数，content_img参数是存放上传图片文件的参数，此参数只能使用post方式提交</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">
{"acl":"serviceMember","method":"uploadProductPicture","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445681363,"validate":"5e51e4be8e89b462b2a975d067cf52f2"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数各字段说明</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 uploadProductPicture</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22uploadProductPicture%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445681363%2C%22validate%22%3A%225e51e4be8e89b462b2a975d067cf52f2%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">content_img参数说明</td>
	</tr>
    <tr>
		<td colspan="2" align="left">存放上传的图片文件，字段名为content_img</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u64cd\u4f5c\u6210\u529f","data":{"content_img":"http:\/\/localhost\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面，</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，若result返回0需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>上传后的图片信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>上传成功后获得的图片url，在提交作品信息时需要提交此字段内容作为图片路径</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">获取作品分类选项数据（用于发布作品时的分类选择）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"getProductCategoryList","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445692778,"validate":"83d9f951dca653baaf35ec3afb78ddf2"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 getProductCategoryList</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22getProductCategoryList%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445692778%2C%22validate%22%3A%2283d9f951dca653baaf35ec3afb78ddf2%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22getProductCategoryList%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445692778%2C%22validate%22%3A%2283d9f951dca653baaf35ec3afb78ddf2%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"2","content_name":"\u7f8e\u5bb9"},{"auto_id":"1","content_name":"\u70eb\u67d3"},{"auto_id":"5","content_name":"\u8d2d\u4e70"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>作品分类数据</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>分类ID，发布作品时需要提交此字段作为作品分类数据</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>分类名称，用于显示所选分类</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">发布新作品</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">
{"acl":"serviceMember","method":"addProduct","category_id":"2","content_name":"\u9ad8\u7ea7\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","content_price":"120","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","content_desc":"\u670d\u52a1\u5185\u5bb9","content_notes":"\u6ce8\u610f\u4e8b\u9879","content_product":"\u4f7f\u7528\u4ea7\u54c1","during_time":"1\u5c0f\u65f6","effect_time":"1\u4e2a\u6708","publish":1,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445690413,"validate":"d071364702699257cf483cedbf0c9cec"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数各字段说明</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 addProduct</td>
	</tr>
    <tr>
		<td class="item">category_id</td>
		<td>必填参数，作品分类，所需的值由获取作品分类接口获取</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>必填参数，作品名称</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>必填参数，作品价格，只能输入数字</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>必填参数，图片url，由上传作品图片的接口返回</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>必填参数，服务内容</td>
	</tr>
    <tr>
		<td class="item">publish</td>
		<td>必填参数，发布状态，0未发布，1已发布</td>
	</tr>
    <tr>
		<td class="item">during_time</td>
		<td>选填参数，所需时间</td>
	</tr>
    <tr>
		<td class="item">effect_time</td>
		<td>选填参数，有效期</td>
	</tr>
    <tr>
		<td class="item">content_notes</td>
		<td>选填参数，注意事项</td>
	</tr>
    <tr>
		<td class="item">content_product</td>
		<td>选填参数，所使用的产品</td>
	</tr>
    
    
    
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22addProduct%22%2C%22category_id%22%3A%222%22%2C%22content_name%22%3A%22%5Cu9ad8%5Cu7ea7%5Cu97e9%5Cu56fd%5Cu7f8e%5Cu5bb9%5Cu5957%5Cu88c5%22%2C%22content_price%22%3A%22120%22%2C%22content_img%22%3A%22http%3A%5C%2F%5C%2F192.168.1.185%5C%2Fysfs%5C%2Ffile%5C%2Fupload%5C%2F2015%5C%2F10%5C%2F24%5C%2F1446363952_s.jpg%22%2C%22content_desc%22%3A%22%5Cu670d%5Cu52a1%5Cu5185%5Cu5bb9%22%2C%22content_notes%22%3A%22%5Cu6ce8%5Cu610f%5Cu4e8b%5Cu9879%22%2C%22content_product%22%3A%22%5Cu4f7f%5Cu7528%5Cu4ea7%5Cu54c1%22%2C%22during_time%22%3A%221%5Cu5c0f%5Cu65f6%22%2C%22effect_time%22%3A%221%5Cu4e2a%5Cu6708%22%2C%22publish%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445690413%2C%22validate%22%3A%22d071364702699257cf483cedbf0c9cec%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22addProduct%22%2C%22category_id%22%3A%222%22%2C%22content_name%22%3A%22%5Cu9ad8%5Cu7ea7%5Cu97e9%5Cu56fd%5Cu7f8e%5Cu5bb9%5Cu5957%5Cu88c5%22%2C%22content_price%22%3A%22120%22%2C%22content_img%22%3A%22http%3A%5C%2F%5C%2F192.168.1.185%5C%2Fysfs%5C%2Ffile%5C%2Fupload%5C%2F2015%5C%2F10%5C%2F24%5C%2F1446363952_s.jpg%22%2C%22content_desc%22%3A%22%5Cu670d%5Cu52a1%5Cu5185%5Cu5bb9%22%2C%22content_notes%22%3A%22%5Cu6ce8%5Cu610f%5Cu4e8b%5Cu9879%22%2C%22content_product%22%3A%22%5Cu4f7f%5Cu7528%5Cu4ea7%5Cu54c1%22%2C%22during_time%22%3A%221%5Cu5c0f%5Cu65f6%22%2C%22effect_time%22%3A%221%5Cu4e2a%5Cu6708%22%2C%22publish%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445690413%2C%22validate%22%3A%22d071364702699257cf483cedbf0c9cec%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u53d1\u5e03\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面，</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，若result返回0需要将此信息提示给用户</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">查看作品明细（用于作品编辑时显示作品的信息）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"myProductDetail","product_id":8,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445693302,"validate":"0c7138942fe0caf17bd9365eef89d85d"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 myProductDetail</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>选填参数，作品ID，由作品列表接口数据的auto_id字段获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myProductDetail%22%2C%22product_id%22%3A8%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445693302%2C%22validate%22%3A%220c7138942fe0caf17bd9365eef89d85d%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myProductDetail%22%2C%22product_id%22%3A8%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445693302%2C%22validate%22%3A%220c7138942fe0caf17bd9365eef89d85d%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"auto_id":"8","category_id":"2","content_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","content_price":"120.00","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","content_desc":"\u670d\u52a1\u5185\u5bb9","content_notes":"\u6ce8\u610f\u4e8b\u9879","content_product":"\u4f7f\u7528\u4ea7\u54c1","publish":"1","during_time":"1\u5c0f\u65f6","effect_time":"1\u4e2a\u6708","publish_status_text":"\u5df2\u53d1\u5e03"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>作品详细信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>作品ID，提交编辑后的作品时需要用到此参数</td>
	</tr>
    <tr>
		<td class="item">category_id</td>
		<td>作品分类ID</td>
	</tr>
    <tr>
		<td class="item">category_name</td>
		<td>作品分类名称（用于显示已选择的分类）</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>作品价格</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>作品图片</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>服务内容</td>
	</tr>
    <tr>
		<td class="item">content_notes</td>
		<td>注意事项</td>
	</tr>
    <tr>
		<td class="item">content_product</td>
		<td>使用的产品</td>
	</tr>
    <tr>
		<td class="item">publish</td>
		<td>发布状态：0未发布、1已发布</td>
	</tr>
    <tr>
		<td class="item">publish_status_text</td>
		<td>发布状态文字说明，用于显示</td>
	</tr>
    <tr>
		<td class="item">during_time</td>
		<td>所需时间</td>
	</tr>
    <tr>
		<td class="item">effect_time</td>
		<td>有效期</td>
	</tr> 
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">保存修改后的作品</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">
{"acl":"serviceMember","method":"editProduct","product_id":"8","category_id":"2","content_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","content_price":"120","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","content_desc":"\u670d\u52a1\u5185\u5bb9","publish":1,"during_time":"1\u5c0f\u65f6","effect_time":"1\u4e2a\u6708","content_notes":"\u6ce8\u610f\u4e8b\u9879","content_product":"\u4f7f\u7528\u4ea7\u54c1","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445698212,"validate":"b1875969702c961d683fc873c1b82b43"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数各字段说明</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 editProduct</td>
	</tr>
    
    <tr>
		<td class="item">product_id</td>
		<td>必填参数，需要修改的作品ID，所需的值由作品明细信息接口的auto_id字段获取</td>
	</tr>
    
    <tr>
		<td class="item">category_id</td>
		<td>必填参数，作品分类，所需的值由获取作品分类接口获取</td>
	</tr>
    <tr>
		<td class="item">content_name</td>
		<td>必填参数，作品名称</td>
	</tr>
    <tr>
		<td class="item">content_price</td>
		<td>必填参数，作品价格，只能输入数字</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>必填参数，图片url，由上传作品图片的接口返回</td>
	</tr>
    <tr>
		<td class="item">content_desc</td>
		<td>必填参数，服务内容</td>
	</tr>
    <tr>
		<td class="item">publish</td>
		<td>必填参数，发布状态，0未发布，1已发布</td>
	</tr>
    <tr>
		<td class="item">during_time</td>
		<td>选填参数，所需时间</td>
	</tr>
    <tr>
		<td class="item">effect_time</td>
		<td>选填参数，有效期</td>
	</tr>
    <tr>
		<td class="item">content_notes</td>
		<td>选填参数，注意事项</td>
	</tr>
    <tr>
		<td class="item">content_product</td>
		<td>选填参数，所使用的产品</td>
	</tr>
    
    
    
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22editProduct%22%2C%22product_id%22%3A%228%22%2C%22category_id%22%3A%222%22%2C%22content_name%22%3A%22%5Cu97e9%5Cu56fd%5Cu7f8e%5Cu5bb9%5Cu5957%5Cu88c5%22%2C%22content_price%22%3A%22120%22%2C%22content_img%22%3A%22http%3A%5C%2F%5C%2F192.168.1.185%5C%2Fysfs%5C%2Ffile%5C%2Fupload%5C%2F2015%5C%2F10%5C%2F24%5C%2F1446363952_s.jpg%22%2C%22content_desc%22%3A%22%5Cu670d%5Cu52a1%5Cu5185%5Cu5bb9%22%2C%22publish%22%3A1%2C%22during_time%22%3A%221%5Cu5c0f%5Cu65f6%22%2C%22effect_time%22%3A%221%5Cu4e2a%5Cu6708%22%2C%22content_notes%22%3A%22%5Cu6ce8%5Cu610f%5Cu4e8b%5Cu9879%22%2C%22content_product%22%3A%22%5Cu4f7f%5Cu7528%5Cu4ea7%5Cu54c1%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445698212%2C%22validate%22%3A%22b1875969702c961d683fc873c1b82b43%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22editProduct%22%2C%22product_id%22%3A%228%22%2C%22category_id%22%3A%222%22%2C%22content_name%22%3A%22%5Cu97e9%5Cu56fd%5Cu7f8e%5Cu5bb9%5Cu5957%5Cu88c5%22%2C%22content_price%22%3A%22120%22%2C%22content_img%22%3A%22http%3A%5C%2F%5C%2F192.168.1.185%5C%2Fysfs%5C%2Ffile%5C%2Fupload%5C%2F2015%5C%2F10%5C%2F24%5C%2F1446363952_s.jpg%22%2C%22content_desc%22%3A%22%5Cu670d%5Cu52a1%5Cu5185%5Cu5bb9%22%2C%22publish%22%3A1%2C%22during_time%22%3A%221%5Cu5c0f%5Cu65f6%22%2C%22effect_time%22%3A%221%5Cu4e2a%5Cu6708%22%2C%22content_notes%22%3A%22%5Cu6ce8%5Cu610f%5Cu4e8b%5Cu9879%22%2C%22content_product%22%3A%22%5Cu4f7f%5Cu7528%5Cu4ea7%5Cu54c1%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445698212%2C%22validate%22%3A%22b1875969702c961d683fc873c1b82b43%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u4fdd\u5b58\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面，</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要将此信息提示给用户</td>
	</tr>
</table>


<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">删除作品</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">
{"acl":"serviceMember","method":"deleteProduct","product_id":"9","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445698719,"validate":"e5e7636e0fd72b5b04dd959ebe59da9f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数各字段说明</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 deleteProduct</td>
	</tr>
    
    <tr>
		<td class="item">product_id</td>
		<td>必填参数，需要删除的作品ID，所需的值由作品明细信息接口的auto_id字段获取</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22deleteProduct%22%2C%22product_id%22%3A%229%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445698719%2C%22validate%22%3A%22e5e7636e0fd72b5b04dd959ebe59da9f%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22deleteProduct%22%2C%22product_id%22%3A%229%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445698719%2C%22validate%22%3A%22e5e7636e0fd72b5b04dd959ebe59da9f%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u4f5c\u54c1\u5220\u9664\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面，</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要将此信息提示给用户</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">我的订单列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"orderList","page":"1","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445701091,"validate":"c2e8a7c414cd3c894063d782634b54d0"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 orderList</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22orderList%22%2C%22page%22%3A%221%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445701091%2C%22validate%22%3A%22c2e8a7c414cd3c894063d782634b54d0%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22orderList%22%2C%22page%22%3A%221%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445701091%2C%22validate%22%3A%22c2e8a7c414cd3c894063d782634b54d0%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"9","order_sn":"1511081301329069","customer_name":"\u859b\u65b0\u5cf0","product_name":"\u8fdb\u53e3\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/09\/03\/1441557481.jpg","service_member_name":"\u859b\u65b0\u5cf0","product_money":"100.00","order_time":"2015-10-28 17:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"100.00","status_text":"\u5f85\u786e\u8ba4","responseBtn":1,"refuseBtn":1,"finishBtn":0,"cancelBtn":0},{"auto_id":"8","order_sn":"1510242336542846","customer_name":"\u859b\u65b0\u5cf0","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","service_member_name":"\u859b\u65b0\u5cf0","product_money":"120.00","order_time":"2015-10-26 16:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"120.00","status_text":"\u5df2\u786e\u8ba4","responseBtn":0,"refuseBtn":0,"finishBtn":1,"cancelBtn":1},{"auto_id":"7","order_sn":"1510242336463785","customer_name":"\u859b\u65b0\u5cf0","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","service_member_name":"\u859b\u65b0\u5cf0","product_money":"120.00","order_time":"2015-10-26 14:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"120.00","status_text":"\u5df2\u53d6\u6d88","responseBtn":0,"refuseBtn":0,"finishBtn":0,"cancelBtn":0},{"auto_id":"6","order_sn":"1510242336032978","customer_name":"\u859b\u65b0\u5cf0","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","service_member_name":"\u859b\u65b0\u5cf0","product_money":"120.00","order_time":"2015-10-26 10:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"120.00","status_text":"\u5df2\u53d6\u6d88","responseBtn":0,"refuseBtn":0,"finishBtn":0,"cancelBtn":0},{"auto_id":"5","order_sn":"1510242335446578","customer_name":"\u859b\u65b0\u5cf0","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","service_member_name":"\u859b\u65b0\u5cf0","product_money":"120.00","order_time":"2015-10-25 10:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"120.00","status_text":"\u5df2\u5b8c\u6210","responseBtn":0,"refuseBtn":0,"finishBtn":0,"cancelBtn":0},{"auto_id":"1","order_sn":"345435","customer_name":"\u6d4b\u8bd522","product_name":"\u8fdb\u53e3\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/nophoto.jpg","service_member_name":"\u859b\u65b0\u5cf0","product_money":"100.00","order_time":"2015-10-13 12:00:00","address":"\u5317\u4eac\u5e02\u4e2d\u5173\u6751\u4e2d\u5173\u6751\u79d1\u8d38","pay_money":"100.00","status_text":"\u5df2\u5b8c\u6210","responseBtn":0,"refuseBtn":0,"finishBtn":0,"cancelBtn":0}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>订单列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>订单ID</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单编号</td>
	</tr>
    <tr>
		<td class="item">customer_name</td>
		<td>顾客姓名</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>产品名称</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>产品图片</td>
	</tr>
    <tr>
		<td class="item">product_money</td>
		<td>产品价格</td>
	</tr>
    <tr>
		<td class="item">service_member_name</td>
		<td>手艺人姓名</td>
	</tr>
    <tr>
		<td class="item">order_time</td>
		<td>预约时间</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>地址</td>
	</tr>
    <tr>
		<td class="item">pay_money</td>
		<td>订单总金额</td>
	</tr>
    <tr>
		<td class="item">status_text</td>
		<td>订单状态</td>
	</tr>
    <!--<tr>
		<td class="item">responseBtn</td>
		<td>是否显示"接单"按钮</td>
	</tr>
    <tr>
		<td class="item">refuseBtn</td>
		<td>是否显示"拒绝"按钮</td>
	</tr>
    <tr>
		<td class="item">finishBtn</td>
		<td>是否显示"完成"按钮</td>
	</tr>
    <tr>
		<td class="item">cancelBtn</td>
		<td>是否显示"取消"按钮</td>
	</tr>-->
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">我的订单明细</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"orderDetail","order_sn":"1510242336463785","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445702100,"validate":"19e02c533c6ee0adeef790ef24902f24"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 orderDetail</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>选填参数，订单编号，由订单列表的order_sn字段获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22orderDetail%22%2C%22order_sn%22%3A%221510242336463785%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445702100%2C%22validate%22%3A%2219e02c533c6ee0adeef790ef24902f24%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22orderDetail%22%2C%22order_sn%22%3A%221510242336463785%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445702100%2C%22validate%22%3A%2219e02c533c6ee0adeef790ef24902f24%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":{"auto_id":"7","order_sn":"1510242336463785","service_member_name":"\u859b\u65b0\u5cf0","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg","product_money":"120.00","order_time":"2015-10-26 14:00:00","address":"\u5eca\u574a\u5e02\u661f\u6cb3\u7693\u6708-\u5317\u95e8\u661f\u6cb3\u7693\u6708Q1\u680b","pay_money":"120.00","customer_name":"\u859b\u65b0\u5cf0","customer_mobile":"15101022452","status_text":"\u5f85\u786e\u8ba4","responseBtn":1,"refuseBtn":1,"finishBtn":0,"cancelBtn":0}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>订单信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的订单字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>订单ID</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单编号</td>
	</tr>
    <tr>
		<td class="item">customer_name</td>
		<td>顾客姓名</td>
	</tr>
    <tr>
		<td class="item">customer_mobile</td>
		<td>顾客手机号</td>
	</tr>
    <tr>
		<td class="item">service_member_name</td>
		<td>服务人员姓名</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>产品名称</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>产品图片</td>
	</tr>
    <tr>
		<td class="item">product_money</td>
		<td>产品价格</td>
	</tr>
    <tr>
		<td class="item">order_time</td>
		<td>预约时间</td>
	</tr>
    <tr>
		<td class="item">address</td>
		<td>地址</td>
	</tr>
    <tr>
		<td class="item">pay_money</td>
		<td>订单总金额</td>
	</tr>
    <tr>
		<td class="item">status_text</td>
		<td>订单状态</td>
	</tr>
    <tr>
		<td class="item">responseBtn</td>
		<td>是否显示"接单"按钮</td>
	</tr>
    <tr>
		<td class="item">refuseBtn</td>
		<td>是否显示"拒绝"按钮</td>
	</tr>
    <tr>
		<td class="item">finishBtn</td>
		<td>是否显示"完成"按钮</td>
	</tr>
    <tr>
		<td class="item">cancelBtn</td>
		<td>是否显示"取消"按钮</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">响应订单（在订单明细界面点击"接单"按钮）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"responseOrder","order_sn":"1510242336542846","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445705372,"validate":"a37714fa7829f8619d9036c665e86582"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 responseOrder</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>选填参数，订单编号，由订单列表的order_sn字段获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22responseOrder%22%2C%22order_sn%22%3A%221510242336542846%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445705372%2C%22validate%22%3A%22a37714fa7829f8619d9036c665e86582%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22responseOrder%22%2C%22order_sn%22%3A%221510242336542846%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445705372%2C%22validate%22%3A%22a37714fa7829f8619d9036c665e86582%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u63a5\u5355\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录，若是其他状态则调用订单明细接口刷新当前订单明细的界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要提示给用户</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">拒绝订单（在订单明细界面点击"拒绝"按钮）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"refuseOrder","order_sn":"1510242336463785","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445705678,"validate":"aa630c4cffb5a8aa4c68596ddc50f601"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 refuseOrder</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>选填参数，订单编号，由订单列表的order_sn字段获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22refuseOrder%22%2C%22order_sn%22%3A%221510242336463785%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445705678%2C%22validate%22%3A%22aa630c4cffb5a8aa4c68596ddc50f601%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22refuseOrder%22%2C%22order_sn%22%3A%221510242336463785%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445705678%2C%22validate%22%3A%22aa630c4cffb5a8aa4c68596ddc50f601%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u8ba2\u5355\u53d6\u6d88\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录，若是其他状态则调用订单明细接口刷新当前订单明细的界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要提示给用户</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">取消订单（在订单明细界面点击"取消"按钮）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"cancelOrder","order_sn":"1510242336032978","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445705924,"validate":"0abceaf65d81c949efba3d0e9ef7b97d"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 cancelOrder</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>选填参数，订单编号，由订单列表的order_sn字段获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22cancelOrder%22%2C%22order_sn%22%3A%221510242336032978%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445705924%2C%22validate%22%3A%220abceaf65d81c949efba3d0e9ef7b97d%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22cancelOrder%22%2C%22order_sn%22%3A%221510242336032978%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445705924%2C%22validate%22%3A%220abceaf65d81c949efba3d0e9ef7b97d%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u8ba2\u5355\u53d6\u6d88\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录，若是其他状态则调用订单明细接口刷新当前订单明细的界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要提示给用户</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">订单完成（在订单明细界面点击"完成"按钮）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"finishOrder","order_sn":"1510242335446578","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1445706046,"validate":"b5f9530c7a4a2e062cb635fe617df5c8"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 finishOrder</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>选填参数，订单编号，由订单列表的order_sn字段获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22finishOrder%22%2C%22order_sn%22%3A%221510242335446578%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445706046%2C%22validate%22%3A%22b5f9530c7a4a2e062cb635fe617df5c8%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22finishOrder%22%2C%22order_sn%22%3A%221510242335446578%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445706046%2C%22validate%22%3A%22b5f9530c7a4a2e062cb635fe617df5c8%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u64cd\u4f5c\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录，若是其他状态则调用订单明细接口刷新当前订单明细的界面</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要提示给用户</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">会员中心的评论列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"myCommentList","page":1,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1446373691,"validate":"600854f46e80b455b4a53a8f37706e0b"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 myCommentList</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myCommentList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446373691%2C%22validate%22%3A%22600854f46e80b455b4a53a8f37706e0b%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myCommentList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446373691%2C%22validate%22%3A%22600854f46e80b455b4a53a8f37706e0b%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"3","order_sn":"1510242335446578","product_id":"8","product_name":"\u97e9\u56fd\u7f8e\u5bb9\u5957\u88c5","member_name":"Gavi11122211","content_level":"3","content_comment":"\u8bc4\u4ef7\u6d4b\u8bd5","create_time":"2015-10-28 23:43:42","product_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/24\/1446363952_s.jpg"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>评论列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的评论字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>评论ID，暂时未用到</td>
	</tr>
    <tr>
		<td class="item">order_sn</td>
		<td>订单号</td>
	</tr>
    <tr>
		<td class="item">product_id</td>
		<td>作品ID</td>
	</tr>
    <tr>
		<td class="item">product_name</td>
		<td>作品名称</td>
	</tr>
    <tr>
		<td class="item">member_name</td>
		<td>评论人姓名</td>
	</tr>
    <tr>
		<td class="item">content_level</td>
		<td>评价星级，取值范围1-5</td>
	</tr>
    <tr>
		<td class="item">content_comment</td>
		<td>评论内容</td>
	</tr>
    <tr>
		<td class="item">create_time</td>
		<td>评论时间</td>
	</tr>
    <tr>
		<td class="item">product_img</td>
		<td>作品图片</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">我的照片列表</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"myPhotoList","page":1,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1446043243,"validate":"23f631d243dc84aec78e16755af97173"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 myPhotoList</td>
	</tr>
    <tr>
		<td class="item">page</td>
		<td>选填参数，默认为1，分页数</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myPhotoList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446043243%2C%22validate%22%3A%2223f631d243dc84aec78e16755af97173%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22myPhotoList%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446043243%2C%22validate%22%3A%2223f631d243dc84aec78e16755af97173%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"","data":[{"auto_id":"6","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/28\/1446756477_s.jpg"},{"auto_id":"5","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/10\/28\/1446096421_s.jpg"},{"auto_id":"4","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/09\/05\/1442172422.jpg"},{"auto_id":"3","content_img":"http:\/\/192.168.1.185\/ysfs\/file\/upload\/2015\/09\/05\/1442172422.jpg"}]}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>照片列表信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data中的照片字段说明</td>
	</tr>
    <tr>
		<td class="item">auto_id</td>
		<td>照片ID，删除照片的接口需要使用此参数</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>照片URL</td>
	</tr>
</table>

<br />
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">上传手艺人相册照片</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">参数说明</td>
	</tr>
    <tr>
		<td colspan="2" align="left">此接口参数与其他接口不同，除param参数外还有一个content_img参数，content_img参数是存放上传图片文件的参数，此参数只能使用post方式提交</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">
{"acl":"serviceMember","method":"uploadPhoto","timestamp":1446043030,"validate":"59aa703d1eaf6049bb5b7e8a88611190","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数各字段说明</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 uploadPhoto</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备号（不能重复），字符串类型，android系统可获取设备编号，ios系统可以根据网卡地址生成一个唯一编码</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22uploadPhoto%22%2C%22page%22%3A1%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1445681363%2C%22validate%22%3A%225e51e4be8e89b462b2a975d067cf52f2%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">content_img参数说明</td>
	</tr>
    <tr>
		<td colspan="2" align="left">存放上传的图片文件，字段名为content_img</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u7167\u7247\u4e0a\u4f20\u6210\u529f","data":{"content_img":"http:\/\/localhost\/ysfs\/file\/upload\/2015\/10\/28\/1446756477_s.jpg"}}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功、0失败、-1登录校验失败，若返回-1需要跳转至会员登录界面，若返回1则需要重新调用照片列表接口刷新当前的照片列表以便显示新上传的照片</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要将此信息提示给用户</td>
	</tr>
    <tr>
		<td class="item">data</td>
		<td>上传后的图片信息</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据中data数组字段说明</td>
	</tr>
    <tr>
		<td class="item">content_img</td>
		<td>上传成功后获得的图片url，在提交作品信息时需要提交此字段内容作为图片路径</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">删除相册中照片（删除前需要让用户确认删除操作，点击确认后再执行，以避免误删除）</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"deletePhoto","photo_id":3,"device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1446043957,"validate":"1eae0549e39aedab034f5f225e518b6a"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 myPhotoList</td>
	</tr>
    <tr>
		<td class="item">photo_id</td>
		<td>必填参数，需要删除的照片的ID，由照片列表接口获取</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22deletePhoto%22%2C%22photo_id%22%3A3%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446043957%2C%22validate%22%3A%221eae0549e39aedab034f5f225e518b6a%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22deletePhoto%22%2C%22photo_id%22%3A3%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1446043957%2C%22validate%22%3A%221eae0549e39aedab034f5f225e518b6a%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u7167\u7247\u5220\u9664\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，不需要处理</td>
	</tr>
</table>

<br/>
<table width="100%" class="info">
	<tr class="theader">
		<th colspan="2" align="left">手艺人修改营业状态（修改为营业中或休息中），采用浮出选择框形式即可</th>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"acl":"serviceMember","method":"setServiceStatus","publish":"1","device_id":"2ACD10F8-1AF2-49FF-A953-8EDEA9E75779","timestamp":1449914224,"validate":"f455827a44e6ac6e9b5b8b652ce520c6"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">输入参数说明（都包含在param参数中），若不特殊说明都要设置为字符串类型</td>
	</tr>
    <tr>
		<td class="item">acl</td>
		<td>必填参数，固定值，值为 serviceMember</td>
	</tr>
    <tr>
		<td class="item">method</td>
		<td>必填参数，固定值，值为 setServiceStatus</td>
	</tr>
    <tr>
		<td class="item">publish</td>
		<td>必填参数，取值范围：1营业中，0休息中</td>
	</tr>
    <tr>
		<td class="item">device_id</td>
		<td>必填参数，设备ID</td>
	</tr>
    <tr>
		<td class="item">timestamp</td>
		<td>必填参数，时间戳，字符串类型，取值为当前时间戳字符串，精确到毫秒数</td>
	</tr>
    <tr>
		<td class="item">validate</td>
		<td>必填参数，校验字段，字符串类型，算法为md5(token字符串+时间戳字符串)</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">param参数使用urlencode编码示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22setServiceStatus%22%2C%22publish%22%3A%221%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1449914224%2C%22validate%22%3A%22f455827a44e6ac6e9b5b8b652ce520c6%22%7D
</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">接口请求示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{接口地址}/app/index.php?param=%7B%22acl%22%3A%22serviceMember%22%2C%22method%22%3A%22setServiceStatus%22%2C%22publish%22%3A%221%22%2C%22device_id%22%3A%222ACD10F8-1AF2-49FF-A953-8EDEA9E75779%22%2C%22timestamp%22%3A1449914224%2C%22validate%22%3A%22f455827a44e6ac6e9b5b8b652ce520c6%22%7D</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回数据示例</td>
	</tr>
    <tr>
		<td colspan="2" align="left">{"result":1,"msg":"\u72b6\u6001\u66f4\u65b0\u6210\u529f"}</td>
	</tr>
    <tr>
		<td colspan="2" align="left" style="background-color:#BDD5B9">返回字段说明</td>
	</tr>
    <tr>
		<td class="item">result</td>
		<td>执行结果，1成功，0失败,若返回-1则返回登录界面要求用户登录</td>
	</tr>
    <tr>
		<td class="item">msg</td>
		<td>提示信息，需要提示给用户</td>
	</tr>
</table>

</body>
</html>