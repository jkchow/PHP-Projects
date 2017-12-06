<?php
/**
* 	配置账号信息
*/
//$tmp_success_url=base64_encode($order["success_url"]);
//$tmp_fail_url=base64_encode($order["fail_url"]);

//define("WEIXINPAY_JS_API_CALL_URL", urlencode($global->requestUrlPath."/js_api_call.php?order_sn={$order["order_sn"]}&success_url={$tmp_success_url}&fail_url={$tmp_fail_url}"));

//define("WEIXINPAY_JS_API_CALL_URL", $global->requestUrlPath."/js_api_call.php?order_sn={$order["order_sn"]}&success_url={$tmp_success_url}&fail_url={$tmp_fail_url}");


define("WEIXINPAY_SSLCERT_PATH", $global->absolutePath."/api/pay/weixin/WxPayPubHelper/cacert/apiclient_cert.pem");
define("WEIXINPAY_SSLKEY_PATH", $global->absolutePath."/api/pay/weixin/WxPayPubHelper/cacert/apiclient_key.pem");
//define("WEIXINPAY_NOTIFY_URL", $global->requestUrlPath.'/notify_url.php');

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wx974362e4aa998d11';
	//受理商ID，身份标识
	const MCHID = '1391306802';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'WangyujunWangpenQichejiuyuan9999';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = 'abe18da30116c23f6e5a829d90a64609';
	
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = WEIXINPAY_JS_API_CALL_URL;
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = WEIXINPAY_SSLCERT_PATH;
	const SSLKEY_PATH = WEIXINPAY_SSLKEY_PATH;
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = WEIXINPAY_NOTIFY_URL;

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}

?>