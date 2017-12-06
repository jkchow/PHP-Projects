<?
class acl_pay extends base_acl{
	//获取支付宝待支付订单信息
	function getAlipayOrderInfo($requestData){
		global $global,$dao;
		$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
			$order_id=$requestData["order_id"];
			$orderService=new orderService();
			
			//$order=$orderService->getOrderBySn($order_sn);
			$order=$dao->get_row_by_where($dao->tables->order,"where auto_id='{$order_id}'");
			
			if($order["member_id"]!=$loginInfo["mid"]){
				return  array('result'=>"0",'msg'=>"没有权限支付此订单");
			}
			
			if($order["pay_type"]!="1"){
				return  array('result'=>"0",'msg'=>"此订单不允许在线支付");
			}
			
			if($order["pay_status"]=="1"){
				return  array('result'=>"0",'msg'=>"此订单已支付");
			}
			
			$onlinePayService=new onlinePayService();
			$param=array();
			$param["order_sn"]=$order["order_sn"];
			$param["paytype_code"]="alipay_app";
			$order=$onlinePayService->getAppPayOrder($param);
			
			
			include($global->sysAbsolutePath."/api/pay/alipay_app/alipay-sdk-PHP/AopSdk.php");
			
			$c = new AopClient;
			$c->gatewayUrl = "https://openapi.alipay.com/gateway.do";
			$c->appId = "2016083001821869";
			
			
			$c->rsaPrivateKeyFilePath=$global->sysAbsolutePath."/api/pay/alipay_app/cert/pkcs8_rsa_private_key.pem";
			
			
			$c->format = "json";
			$c->charset= "GBK";
			
			
			$biz_content=array(
					"body"=>"商城订单",
					"subject"=>"商城订单",
					"out_trade_no"=>$order["order_sn"],
					"total_amount"=>$order["pay_money"],
					"product_code"=>"QUICK_MSECURITY_PAY",
				);
			
			
			$param=array(
					"app_id"=>"2016083001821869",
					"method"=>"alipay.trade.app.pay",
					"format"=>"json",
					"charset"=>"utf-8",
					"sign_type"=>"RSA",
					
					"timestamp"=>date("Y-m-d H:i:s"),
					"version"=>"1.0",
					"notify_url"=>$global->sysSiteUrlPath."/api/pay/alipay_app/notify_url.php",
					"method"=>"alipay.trade.app.pay",
					"biz_content"=>json_encode($biz_content),
				);
			

			$signStr=$c->generateSign($param);
			
			ksort($param);
			$param["sign"]=$signStr;
			
			$paramStr="";
			foreach($param as $key=>$vl){
				if($vl=="")
					continue;
				if($paramStr==""){
					$paramStr.="{$key}=".urlencode($vl);
				}else{
					$paramStr.="&{$key}=".urlencode($vl);
				}
			}
			
			
     		
     		return array('result'=>'1','msg'=>'',"data"=>array("orderInfo"=>"{$paramStr}"));
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
	}
	
	//获取微信支付的订单信息
	function getWeixinOrderInfo($requestData){
		global $global,$dao;
		$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
			$order_id=$requestData["order_id"];
			$orderService=new orderService();
			
			//$order=$orderService->getOrderBySn($order_sn);
			$order=$dao->get_row_by_where($dao->tables->order,"where auto_id='{$order_id}'");
			if($order["member_id"]!=$loginInfo["mid"]){
				return  array('result'=>"0",'msg'=>"没有权限支付此订单");
			}
			
			if($order["pay_type"]!="1"){
				return  array('result'=>"0",'msg'=>"此订单不允许在线支付");
			}
			
			if($order["pay_status"]=="1"){
				return  array('result'=>"0",'msg'=>"此订单已支付");
			}
			
			$onlinePayService=new onlinePayService();
			$param=array();
			$param["order_sn"]=$order["order_sn"];
			$param["paytype_code"]="weixin_app";
			$order=$onlinePayService->getAppPayOrder($param);
			
			
			include($global->sysAbsolutePath."/api/pay/weixin_app/WxPayPubHelper/WxPayPubHelper.php");
			
			
			//================================
			/*$returnParams=array(
					"appid"=>"wx4cc15a442ec7d9ea",
					"partnerid"=>"1383676302",
					"prepayid"=>"WX1217752501201407033233368018",
					"package"=>"Sign=WXPay",
					"noncestr"=>substr(md5(time()),0,20),
					"timestamp"=>time(),
				);
			$Common_util_pub=new Common_util_pub();
			$returnParams["sign"]=$Common_util_pub->getSign($returnParams);
			return array('result'=>'1','msg'=>'',"data"=>array("orderInfo"=>$returnParams));*/
			
			//=================================
			
			
			//使用统一支付接口
			$unifiedOrder = new UnifiedOrder_pub();
			
			//设置统一支付接口参数
			//设置必填参数
			//appid已填,商户无需重复填写
			//mch_id已填,商户无需重复填写
			//noncestr已填,商户无需重复填写
			//spbill_create_ip已填,商户无需重复填写
			//sign已填,商户无需重复填写
		
			$unifiedOrder->setParameter("body","商城订单");//商品描述
			//自定义订单号，此处仅作举例
			$timeStamp = time();
			
			$unifiedOrder->setParameter("out_trade_no",$order["order_sn"]);//商户订单号 
			$unifiedOrder->setParameter("total_fee",round($order["pay_money"]*100));//总金额
			//$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
			$unifiedOrder->setParameter("notify_url",$global->sysSiteUrlPath."/api/pay/weixin_app/notify_url.php");//通知地址 
			
			
			$unifiedOrder->setParameter("trade_type","APP");//交易类型
			$unifiedOrder->setParameter("attach",$param["paytype_code"]);//附加数据 
			
			
			/*echo WxPayConf_pub::NOTIFY_URL;
			exit;*/
			
			//获取统一支付接口结果
			$unifiedOrderResult = $unifiedOrder->getResult();
			
			
			
			//商户根据实际情况设置相应的处理流程
			if ($unifiedOrderResult["return_code"] == "FAIL") 
			{
				//商户自行增加处理流程
				//echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
				return  array('result'=>"0",'msg'=>"通信出错：".$unifiedOrderResult['return_msg']);
				//header("Location: {$global->siteUrlPath}/index.php?acl=member&method=orderLists");
				//exit;
			}
			elseif($unifiedOrderResult["result_code"] == "FAIL")
			{
				//商户自行增加处理流程
				return  array('result'=>"0",'msg'=>"错误代码：".$unifiedOrderResult['err_code']." "."错误代码描述：".$unifiedOrderResult['err_code_des']);
				//echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
				//echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
				
				//header("Location: {$global->siteUrlPath}/index.php?acl=member&method=orderLists");
				//exit;
			}
			elseif($unifiedOrderResult["return_code"] == "SUCCESS" && $unifiedOrderResult["result_code"] == "SUCCESS")
			{
				//从统一支付接口获取到code_url
				$prepay_id = $unifiedOrderResult["prepay_id"];
				//商户自行增加处理流程
				//......
				
				$returnParams=array(
						"appid"=>$unifiedOrderResult["appid"],
						"partnerid"=>$unifiedOrderResult["mch_id"],
						"prepayid"=>$unifiedOrderResult["prepay_id"],
						"package"=>"Sign=WXPay",
						"noncestr"=>substr(md5(time()),0,20),
						"timestamp"=>time(),
					);
				
				$Common_util_pub=new Common_util_pub();
				$returnParams["sign"]=$Common_util_pub->getSign($returnParams);
				return array('result'=>'1','msg'=>'',"data"=>array("orderInfo"=>$returnParams));
				
			}else{
				return  array('result'=>"0",'msg'=>"接口出错");
			}
			
			
     		
     		
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
		
	}
	
	
	
}
?>