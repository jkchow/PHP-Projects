<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>接口参数测试</title>
</head>

<body>
<?



$serverUrl="http://127.0.0.1/qqwm/app/index.php?param=";



/*$arr=array();
$arr["acl"]="comment";
$arr["method"]="memberReviewLists";
$arr["timestamp"]="1469081550099";
$arr["mid"]=28;
$arr["validate"]=md5("9699".$arr["timestamp"]);
$arr["device_id"]="354782064441566";
$arr["app_type"]="1";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
$result= file_get_contents($url);
echo $result;
echo "<pre>";
print_r(json_decode($result));
exit;*/



//$serverUrl="http://123.57.6.54/ysfs/app/index.php?param=";
//$serverUrl="http://192.168.1.185/ysfs/app/echoParam.php?param="



//获取app的订单支付信息
$arr=array();
$arr["acl"]="pay";
$arr["method"]="getWeixinOrderInfo";
$arr["timestamp"]="1469081550099";
$arr["mid"]=28;
$arr["validate"]=md5("9699".$arr["timestamp"]);
$arr["device_id"]="354782064441566";
$arr["app_type"]="1";
//$arr["order_sn"]="1609111754139050";
$arr["order_id"]="291";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
$result= file_get_contents($url);
echo $result;
echo "<pre>";
print_r(json_decode($result));
exit;



/*$arr=array();
$arr["acl"]="member";
$arr["method"]="updateUserName";
$arr["app_type"]="2";
$arr["device_id"]="37f70516f6bb7a82430f25f78c013806";
$arr["timestamp"]="1469081550099";
$arr["content_user"]="louslwo";
$arr["validate"]="b95da1c1a0a8a4a12f9003ab64961e03";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);
exit;*/

/*//商品列表
$arr=array();
$arr["acl"]="goods";
$arr["method"]="lists";
$arr["categoryid"]=56;
$arr["page"]=1;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);
exit;*/

//定位到当前位置
/*$arr=array();
$arr["acl"]="index";
$arr["method"]="appinit";
$arr["app_type"]="1";
$arr["device_id"]="7EE65D62-6F02-4598-9DBD-8DA5880F9E36";
$arr["push_id"]="171976fa8a886f98099";
$arr["lat"]="39.906500";
$arr["lng"]="116.599578";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
$result= file_get_contents($url);
echo $result;
echo "<pre>";
print_r(json_decode($result));
exit;*/

 

/*//获取注册的短信验证码
$arr=array();
$arr["acl"]="member";
$arr["method"]="getRegMobileMsg";
$arr["content_mobile"]="15101022452";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

/*//会员注册操作
$arr=array();
$arr["acl"]="member";
$arr["method"]="saveRegister";
$arr["content_mobile"]="15101022452";
$arr["content_pass"]="123456";
$arr["device_id"]="123456";
$arr["mobile_randnum"]="45562";
$arr["app_type"]="1";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

//会员登录操作
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="doLogin";
$arr["mobile"]="15101022452";
$arr["pass"]="123456";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["app_type"]="1";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
$result= file_get_contents($url);
echo "<pre>";
print_r(json_decode($result));
exit;*/

/*//会员注销操作（退出登录状态）
$arr=array();
$arr["acl"]="member";
$arr["method"]="logout";
$arr["timestamp"]=time();
$arr["validate"]=md5("3195892".$arr["timestamp"]);
$arr["device_id"]="123456";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/


/*//上报位置
$arr=array();
$arr["acl"]="address";
$arr["method"]="localInfo";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["app_type"]="1";
$arr["push_id"]="";
$arr["lat"]="39.983424";
$arr["lng"]="116.322987";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

/*//定位到当前位置
$arr=array();
$arr["acl"]="address";
$arr["method"]="locationByGps";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["app_type"]="1";
$arr["push_id"]="";
$arr["lat"]="39.983424";
$arr["lng"]="116.322987";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;
*/

/*//获取首页banner广告
$arr=array();
$arr["acl"]="ad";
$arr["method"]="indexBanner";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

/*//获取活动列表
$arr=array();
$arr["acl"]="news";
$arr["method"]="activeLists";
$arr["page"]=2;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

/*//修改会员昵称
$arr=array();
$arr["acl"]="member";
$arr["method"]="saveNickName";
$arr["timestamp"]=time();
$arr["validate"]=md5("2947875".$arr["timestamp"]);
$arr["device_id"]="123456";
$arr["content_name"]="路人甲";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/


//修改密码
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="changePassword";
$arr["timestamp"]=time();
$arr["validate"]=md5("2947875".$arr["timestamp"]);
$arr["device_id"]="123456";
$arr["old_pass"]="123456";
$arr["new_pass"]="111111";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/


//获取会员信息
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="getMemberInfo";
$arr["timestamp"]=time();
$arr["validate"]=md5("2205749".$arr["timestamp"]);
$arr["device_id"]="123456";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

/*//城市选择时的省份选择列表
$arr=array();
$arr["acl"]="address";
$arr["method"]="provinceList";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

/*//城市选择时的省份选择列表
$arr=array();
$arr["acl"]="address";
$arr["method"]="cityList";
$arr["province_id"]=13;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/

/*//申请成为手艺人
$arr=array();
$arr["acl"]="joinApply";
$arr["method"]="saveApply";
$arr["city_id"]=14;
$arr["linkman_name"]="薛新峰";
$arr["content_sex"]=2;
$arr["content_mobile"]="15101022452";
$arr["content_address"]="测试地址";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo file_get_contents($url);*/


//位置搜索
/*$arr=array();
$arr["acl"]="address";
$arr["method"]="placeSuggestion";
$arr["city_id"]=1;
$arr["query"]="圆明园东门";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/


/*//添加常用地址(未登录)
$arr=array();
$arr["acl"]="address";
$arr["method"]="addAddress";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["city_id"]=14;
$arr["street"]="星河皓月-北门";
$arr["lat"]="39.989312";
$arr["lng"]="116.781594";
$arr["address"]="星河皓月Q1栋";
$arr["content_name"]="薛新峰";
$arr["content_mobile"]="15101022452";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//添加常用地址(已登录)
/*$arr=array();
$arr["acl"]="address";
$arr["method"]="addAddress";
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
$arr["city_id"]=14;
$arr["street"]="星河皓月-北门";
$arr["lat"]="39.989312";
$arr["lng"]="116.781594";
$arr["address"]="星河皓月Q1栋";
$arr["content_name"]="薛新峰";
$arr["content_mobile"]="15101022452";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

/*//会员中心修改常用地址(已登录)
$arr=array();
$arr["acl"]="address";
$arr["method"]="addAddress";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
$arr["id"]=18;
$arr["city_id"]=14;
$arr["street"]="星河皓月-北门";
$arr["lat"]="39.989312";
$arr["lng"]="116.781594";
$arr["address"]="星河皓月Q3栋";
$arr["content_name"]="薛新峰";
$arr["content_mobile"]="15101022452";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/


/*//获取常用地址(未登录及已登录两种情况)
$arr=array();
$arr["acl"]="address";
$arr["method"]="getAddressList";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//获取会员中心常用地址列表(登录后可用)
/*$arr=array();
$arr["acl"]="address";
$arr["method"]="getMemberAddressList";
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
$arr["page"]=1;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//会员中心设置默认地址(登录后可用)
/*$arr=array();
$arr["acl"]="address";
$arr["method"]="setDefaultAddress";
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
$arr["id"]=20;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//会员中心删除常用地址(登录后可用)
/*$arr=array();
$arr["acl"]="address";
$arr["method"]="deleteAddress";
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
$arr["id"]=19;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/



/*//查看附近的作品列表
$arr=array();
$arr["acl"]="service";
$arr["method"]="productLists";
$arr["city_id"]=1;
$arr["street"]="圆明园东门";
$arr["lat"]="40.018559";
$arr["lng"]="116.324646";
$arr["serviceCategory"]="1";
$arr["orderField"]="visit";
$arr["page"]="1";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));*/


/*//查看作品明细
$arr=array();
$arr["acl"]="service";
$arr["method"]="productDetail";
$arr["auto_id"]=7;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));*/

//查看附近的手艺人列表
/*$arr=array();
$arr["acl"]="service";
$arr["method"]="salesmanLists";
$arr["city_id"]=1;
$arr["street"]="圆明园东门";
$arr["lat"]="40.018559";
$arr["lng"]="116.324646";
$arr["serviceCategory"]="1";
$arr["orderField"]="visit";
$arr["page"]="1";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));*/

/*//查看手艺人明细
$arr=array();
$arr["acl"]="service";
$arr["method"]="salesmanDetail";
$arr["auto_id"]=31;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));*/

/*//查看附近的店铺列表
$arr=array();
$arr["acl"]="service";
$arr["method"]="shopLists";
$arr["city_id"]=1;
$arr["lat"]="39.982451";
$arr["lng"]="116.376472";
$arr["serviceCategory"]="1";
$arr["orderField"]="distance";
$arr["page"]="1";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

/*//查看店铺明细
$arr=array();
$arr["acl"]="service";
$arr["method"]="shopDetail";
$arr["auto_id"]=1;
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//查看附近可预约的服务项
/*$arr=array();
$arr["acl"]="service";
$arr["method"]="standardProductLists";
$arr["city_id"]=1;
$arr["lat"]="40.059117";
$arr["lng"]="116.311004";
$arr["serviceCategory"]="2";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/



//作品预约确认
/*$arr=array();
$arr["acl"]="service";
$arr["method"]="productOrderConfirm";
//$arr["city_id"]=1;
$arr["lat"]="40.059117";
$arr["lng"]="116.311004";
$arr["product_id"]="3";
//$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
//$arr["timestamp"]=time();
//$arr["validate"]=md5("7056488".$arr["timestamp"]);
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/


//作品预约提交
/*$arr=array();
$arr["acl"]="service";
$arr["method"]="productOrderSubmit";
//$arr["city_id"]=1;
$arr["lat"]="40.059117";
$arr["lng"]="116.311004";
$arr["product_id"]=6;
$arr["address_id"]=18;
$arr["order_date"]="2015-10-15 10:00:00";
$arr["pay_type"]=2;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//订单列表
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="orderList";
$arr["page"]=1;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//订单明细
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="orderDetail";
$arr["order_sn"]="1510082339295439";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

/*//取消订单
$arr=array();
$arr["acl"]="member";
$arr["method"]="cancelOrder";
$arr["order_sn"]="1510111810028149";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//获取重置密码的短信验证码
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="getResetPasswordMobileMsg";
$arr["content_mobile"]="15101022452";
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

/*//执行重置密码的操作
$arr=array();
$arr["acl"]="member";
$arr["method"]="resetPassword";
$arr["content_mobile"]="15101022452";
$arr["mobile_randnum"]="25507";
$arr["content_pass"]="123456";

echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//查看作品评论
/*$arr=array();
$arr["acl"]="service";
$arr["method"]="productCommentLists";
$arr["product_id"]=6;
$arr["page"]=1;

echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/






//商家会员接口部分=========================================================

/*//手艺人查看自己的作品列表
$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="myProductList";
$arr["page"]=1;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

/*//手艺人查看作品明细
$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="myProductDetail";
$arr["product_id"]=8;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//手艺人发布作品的图片
/*{"result":1,"msg":"\u64cd\u4f5c\u6210\u529f","data":{"fileName":"\u5929\u5730\u7384\u9ec4\u9879\u76ee\u5de5\u671f\u5b89\u6392 20151015.jpg","absolutePath":"D:\/WWW\/ysfs\/file\/upload\/2015\/10\/18\/1445679131_s.jpg","savePath":"2015\/10\/18\/1445679131_s.jpg","urlPath":"http:\/\/localhost\/ysfs\/file\/upload\/2015\/10\/18\/1445679131_s.jpg"}}*/



/*//获取作品分类选项数据（用于发布作品时的分类选择）
$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="getProductCategoryList";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/


//手艺人发布作品
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="addProduct";

$arr["category_id"]="2";
$arr["content_name"]="高级韩国美容套装";
$arr["content_price"]="180";
$arr["content_img"]="http://123.57.6.54/ysfs/file/upload/2015/10/24/1446363952_s.jpg";
$arr["content_desc"]="服务内容";
$arr["publish"]=1;
$arr["during_time"]="1小时";
$arr["effect_time"]="1个月";
$arr["content_notes"]="注意事项";
$arr["content_product"]="使用产品";

$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/



/*//手艺人修改作品
$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="editProduct";

$arr["product_id"]="8";
$arr["category_id"]="2";
$arr["content_name"]="韩国美容套装";
$arr["content_price"]="150";
$arr["content_img"]="http://192.168.1.185/ysfs/file/upload/2015/10/24/1446363952_s.jpg";
$arr["content_desc"]="服务内容";
$arr["publish"]=1;
$arr["during_time"]="1小时";
$arr["effect_time"]="1个月";
$arr["content_notes"]="注意事项";
$arr["content_product"]="使用产品";

$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//手艺人删除作品
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="deleteProduct";

$arr["product_id"]="9";

$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/



//订单列表
$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="orderList";

$arr["page"]="1";

$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;

/*//用来测试下单的
$arr=array();
$arr["acl"]="service";
$arr["method"]="productOrderSubmit";
$arr["lat"]="40.059117";
$arr["lng"]="116.311004";
$arr["product_id"]=3;
$arr["address_id"]=17;
$arr["order_date"]="2015-10-28 17:00:00";
$arr["pay_type"]=2;
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/



//订单明细
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="orderDetail";
$arr["order_sn"]="1510242336463785";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//响应订单
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="responseOrder";
$arr["order_sn"]="1510250845555163";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/


//拒绝订单
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="refuseOrder";
$arr["order_sn"]="1510250843244255";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//订单取消
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="cancelOrder";
$arr["order_sn"]="1510242336032978";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//手艺人完成订单
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="finishOrder";
$arr["order_sn"]="1510242335446578";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//手艺人照片列表
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="myPhotoList";
$arr["page"]=1;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//手艺人添加照片

//手艺人删除照片
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="deletePhoto";
$arr["photo_id"]=3;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//待完善================================================================

//会员中心待评价的产品列表
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="toCommentLists";
$arr["page"]=1;
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//发表评论
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="addComment";
$arr["order_sn"]="1510242335446578";
$arr["product_id"]="8";
$arr["device_id"]="864587028272400";
$arr["content_level"]=3;
$arr["content_comment"]="评价测试";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//会员中心已评价的评论列表
/*$arr=array();
$arr["acl"]="member";
$arr["method"]="myCommentLists";
$arr["page"]=1;
$arr["device_id"]="864587028272400";
$arr["timestamp"]=time();
$arr["validate"]=md5("6618408".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//服务人员会员中心统计信息
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="getServiceMemberInfo";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/

//服务人员会员中心查看评论列表
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="myCommentList";
$arr["page"]=1;
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/


//服务人员会员中心修改服务状态
/*$arr=array();
$arr["acl"]="serviceMember";
$arr["method"]="setServiceStatus";
$arr["publish"]="1";
$arr["device_id"]="2ACD10F8-1AF2-49FF-A953-8EDEA9E75779";
$arr["timestamp"]=time();
$arr["validate"]=md5("7056488".$arr["timestamp"]);
echo $json_str=json_encode($arr);
echo "<br/>";
$param=urlencode($json_str);
echo $url="{$serverUrl}{$param}";
echo "<br/>";
echo $returnStr= file_get_contents($url);
echo "<br/>";
echo "<pre>";
print_r(json_decode($returnStr));
exit;*/



?>
</body>
</html>