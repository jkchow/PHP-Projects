<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
*/
	include("../../../global.php");
	
	include_once("./log_.php");
	include_once("./WxPayPubHelper/WxPayPubHelper.php");

    //使用通用通知接口
	$notify = new Notify_pub();

	//存储微信的回调
    $xml = $GLOBALS['HTTP_RAW_POST_DATA'];//这里在php7下不能获取数据，使用 php://input 代替
    if(!$xml){
        $xml = file_get_contents("php://input");
    }
	$notify->saveData($xml);
	
	//验证签名，并回应微信。
	//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
	//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
	//尽可能提高通知的成功率，但微信不保证通知最终能成功。
	if($notify->checkSign() == FALSE){
		$notify->setReturnParameter("return_code","FAIL");//返回状态码
		$notify->setReturnParameter("return_msg","签名失败");//返回信息
	}else{
		$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
	}
	$returnXml = $notify->returnXml();
	//echo $returnXml;
	
	//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
	
	//以log文件形式记录回调信息
	$log_ = new Log_();
	$log_name="./notify_url.log";//log文件路径
	$log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");

	if($notify->checkSign() == TRUE)
	{
		if ($notify->data["return_code"] == "FAIL") {
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
		}
		elseif($notify->data["result_code"] == "FAIL"){
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
		}
		else{
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【支付成功】:\n".$xml."\n");
			$out_trade_no=$notify->data["out_trade_no"];
			$total_fee=$notify->data["total_fee"];
			$transaction_id=$notify->data["transaction_id"];//微信支付订单号
			
			$attach=$notify->data["attach"];//附加数据，用于区分使用的支付方式(微信js支付或微信扫码支付)
			
			
			$onlinePayService=new onlinePayService();
			$onlinePayService->payOrder($out_trade_no,$total_fee/100,$transaction_id,$attach);	
			
			
		}
		
		//商户自行增加处理流程,
		//例如：更新订单状态
		//例如：数据库操作
		//例如：推送支付完成信息
	}
?>