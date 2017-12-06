<?
class onlinePayService{
	
	var $payType=array(
			"pc"=>array(
					"alipay_pc"=>array(
							"text"=>"支付宝",
							"img"=>"api/pay/alipay_pc/img/alipay.gif",
							"desc"=>"请点击支付宝图标，然后在新打开的页面中进行支付",
							"payLink"=>"api/pay/alipay_pc/alipayapi.php",
						),
					"weixin_qrcode"=>array(
							"text"=>"微信支付",
							"img"=>"api/pay/weixin/weixin.jpg",
							"desc"=>"请点击微信，然后使用微信扫描新打开页面中的二维码进行支付",
							"payLink"=>"api/pay/weixin/native_dynamic_qrcode.php",
						),
				),
			"wap"=>array(
					"alipay_wap"=>array(
							"text"=>"支付宝",
							"img"=>"api/pay/alipay_wap/images/alipay.gif",
							"desc"=>"请点击支付宝图标，然后在新打开的页面中进行支付",
							"payLink"=>"api/pay/alipay_wap/alipayapi.php",
						),
				),
			"weixin"=>array(
					"weixin_js"=>array(
							"text"=>"微信支付",
							"img"=>"api/pay/weixin/weixin.jpg",
							"desc"=>"请点击微信，然后使用微信扫描新打开页面中的二维码进行支付",
							"payLink"=>"api/pay/weixin/js_api_call.php",
						),
				),
			"app"=>array(
					"weixin_app"=>array(
							"text"=>"微信支付",
						),
					"alipay_app"=>array(
							"text"=>"支付宝支付",
						),
				),
			
			
		);
	
	
	
	//获取当前可用的支付方式
	function getAllowPayTypeVars(){
		//获取可用的支付方式
		$DictionaryVars=new DictionaryVars();
		$payTypeArr=$DictionaryVars->getVars("payTypeVars");
		return $payTypeArr;
	}
	
	
	
	//获取支付参数，在支付接口的入口文件中需要调用此方法，若出错会直接跳转到相关页面
	function getPayOrder($param){
		
		global $global,$dao;
		
		$order_sn=$param["order_sn"];
		$paytype_id=$param["paytype_code"];
		$success_url=$param["success_url"];
		$fail_url=$param["fail_url"];
		
		if($param["useBalance"]!="")
			$useBalance=$param["useBalance"];
		elseif($_GET["useBalance"]!=""){
			$useBalance=$_GET["useBalance"];
		}
		
		//获取配置的支付方式
		$payTpyeParam=NULL;
		foreach($this->payType as $key=>$vl){
			if(is_array($vl[$paytype_id])){
				$payTpyeParam=$vl[$paytype_id];
				break;
			}
		}
		
		if(!is_array($payTpyeParam)){
			echo "参数错误";
			exit;
		}
		
		
		
		$order=array();
		//根据订单号判断订单类型,
		if($order_sn==""){
			$alertMsg="参数有误";
			echo "<script>alert('{$alertMsg}');location.href='{$fail_url}';</script>";
			exit;
		}else{
			//普通订单
			$tmp=$dao->get_row_by_where($dao->tables->order,"where order_sn='{$order_sn}'",array("auto_id","type","pay_money","pay_status","member_id"));
			
			
			if(!is_array($tmp)){
				header("Location: {$fail_url}");
				exit;
			}
			
			if($tmp["pay_status"]!="0"){
				header("Location: {$success_url}");
				exit;
			}

			
			$order["pay_money"]=$tmp["pay_money"];
			$order["auto_id"]=$tmp["auto_id"];
			$order["order_sn"]=$order_sn;
			//支付完成后跳转的页面
			$order["success_url"]=$success_url;
			$order["fail_url"]=$fail_url;
			
			//如果订单使用余额
			if($useBalance){
				//查询会员余额并存入订单
				$tmpMember=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$tmp["member_id"]}'",array("account_balance"));
				if($order["pay_money"]>=$tmpMember["account_balance"])
					$useBalanceMoney=$tmpMember["account_balance"];
				else
					$useBalanceMoney=$order["pay_money"];
				//$dao->update($dao->tables->order,array("use_balance_money"=>$useBalanceMoney),"where auto_id='{$order["auto_id"]}'");
				$order["pay_money"]=$order["pay_money"]-$useBalanceMoney;
				//如果使用余额后不需要再支付，则直接变为支付成功状态(这种情况不会存在，若余额足够，则之前就自动支付了)
				/*if($order["pay_money"]==0){
					//修改账户记录及会员账户余额
					
					//修改订单的支付状态
					
					$this->payOrder($_GET["order_sn"],0,"",$paytype_id);
					
					//跳转回订单明细页面
					header("Location: {$success_url}");
					exit;
				}*/
			}
			
			
		}
		
		
		//生成在线支付记录
		$record=array();
		$record["pay_sn"]=$order["order_sn"];//支付流水号使用订单号
		$record["order_id"]=$order["auto_id"];
		$record["order_sn"]=$order["order_sn"];
		$record["onlinepay_type"]=$paytype_id;
		$record["content_money"]=$order["pay_money"];//在线支付金额
		$record["account_money"]=$useBalanceMoney;//账户余额支付金额
		
		if($order["success_url"]!="")
			$record["success_url"]=$order["success_url"];
		if($order["fail_url"]!="")
			$record["fail_url"]=$order["fail_url"];
		$record["create_time"]=date("Y-m-d H:i:s");
		
		$pay_order=$dao->get_row_by_where($dao->tables->onlinepay_log,"where pay_sn='{$record["pay_sn"]}' and onlinepay_type='{$record["onlinepay_type"]}'");
		if(!is_array($pay_order)){
			$dao->insert($dao->tables->onlinepay_log,$record);
		}else{
			$dao->update($dao->tables->onlinepay_log,$record,"where auto_id='{$pay_order["auto_id"]}'");
			if($order["success_url"]=="" && $pay_order["success_url"]!="")
				$order["success_url"]=$pay_order["success_url"];
			if($order["fail_url"]=="" && $pay_order["fail_url"]!="")
				$order["fail_url"]=$pay_order["fail_url"];
			
		}
		
		return $order;	
	}
	
	//获取app支付所用的订单
	function getAppPayOrder($param){
		global $global,$dao;
		
		$order_sn=$param["order_sn"];
		$paytype_id=$param["paytype_code"];
		
		//获取配置的支付方式
		$payTpyeParam=NULL;
		foreach($this->payType as $key=>$vl){
			if(is_array($vl[$paytype_id])){
				$payTpyeParam=$vl[$paytype_id];
				break;
			}
		}
		
		if(!is_array($payTpyeParam)){
			
		}
		
		
		
		$order=array();
		//根据订单号判断订单类型,
		if($order_sn==""){
			return array("result"=>"0","msg"=>"订单号为空");
		}elseif(strpos($order_sn,"h")!==false){
			//客房订单
			
			
		}else{
			//普通订单
			$tmp=$dao->get_row_by_where($dao->tables->order,"where order_sn='{$order_sn}'",array("auto_id","pay_money","pay_status"));
			
			if(!is_array($tmp) || $tmp["pay_status"]!="0"){
				//echo "{$global->siteUrlPath}/index.php?acl=member&method=orderLists";
				return array("result"=>"0","msg"=>"订单不存在或不需要支付");
			}
		
			$order["pay_money"]=$tmp["pay_money"];
			$order["auto_id"]=$tmp["auto_id"];
			$order["order_sn"]=$order_sn;
			
			//如果订单使用余额
			if($tmp["is_use_balance"]=="1"){
				//查询会员余额并存入订单
				$tmpMember=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$tmp["member_id"]}'",array("account_balance"));
				if($order["pay_money"]>=$tmpMember["account_balance"])
					$useBalanceMoney=$tmpMember["account_balance"];
				else
					$useBalanceMoney=$order["pay_money"];
				//$dao->update($dao->tables->order,array("use_balance_money"=>$useBalanceMoney),"where auto_id='{$order["auto_id"]}'");
				$order["pay_money"]=$order["pay_money"]-$useBalanceMoney;
				//如果使用余额后不需要再支付，则直接变为支付成功状态
				if($order["pay_money"]==0){
					//修改账户记录及会员账户余额
					//修改订单的支付状态
					$this->payOrder($_GET["order_sn"],0,"",$paytype_id);
					
					//跳转回订单明细页面
					return array("result"=>"1","msg"=>"订单不需要支付");
				}	
			}
		}
		
		
		//生成在线支付记录
		$record=array();
		$record["pay_sn"]=$order["order_sn"];//支付流水号使用订单号
		//$record["pay_sn"]=date("ymdHis").substr(microtime(),2,4);//支付流水号使用时间戳
		$record["order_id"]=$order["auto_id"];
		$record["order_sn"]=$order["order_sn"];
		$record["onlinepay_type"]=$paytype_id;
		$record["content_money"]=$order["pay_money"];
		
		$record["create_time"]=date("Y-m-d H:i:s");
		$pay_order=$dao->get_row_by_where($dao->tables->onlinepay_log,"where pay_sn='{$record["pay_sn"]}' and onlinepay_type='{$record["onlinepay_type"]}'");
		if(!is_array($pay_order)){
			$dao->insert($dao->tables->onlinepay_log,$record);
		}else{
			$dao->update($dao->tables->onlinepay_log,$record,"where auto_id='{$pay_order["auto_id"]}'");
			
		}
		
		return $order;	
	}
	
	
	//获取支付成功后的跳转链接地址
	function getOrderSuccessUrl($order_sn,$onlinePaytypeId){
		global $dao;
		$tmpOrder=$dao->get_row_by_where($dao->tables->onlinepay_log,"where order_sn='{$order_sn}' and onlinepay_type='{$onlinePaytypeId}'");
		return $tmpOrder["success_url"];
	}
	
	
	//获取在线支付链接
	function getOrderPayLink($order_sn,$success_url="",$fail_url=""){
		global $global;
		//return $global->siteUrlPath."/api/pay/alipay_wap/alipayapi.php?order_sn=".$order_sn;
		//return $global->siteUrlPath."/api/pay/alipay_wap/index.php?order_sn=".$order_sn;
		if($success_url=="")
			$success_url=$global->siteUrlPath."/index.php?acl=member&method=orderInfo&order_sn={$order_sn}";
		if($fail_url=="")
			$fail_url=$global->siteUrlPath."/index.php?acl=member&method=orderInfo&order_sn={$order_sn}";
		$success_url=base64_encode($success_url);
		$fail_url=base64_encode($fail_url);
		
		if(strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")){
			return $global->sysSiteUrlPath."/api/pay/weixin/js_api_call.php?order_sn={$order_sn}&success_url={$success_url}&fail_url={$fail_url}";
		}else{
			return $global->sysSiteUrlPath."/api/pay/alipay_wap/alipayapi.php?order_sn={$order_sn}&success_url={$success_url}&fail_url={$fail_url}";
		}
	}
	
	//进行支付操作，若已经支付则忽略（不能进行报错，因为可能在跳转回网站时重复调用）
	function payOrder($order_sn,$pay_money="",$api_order_sn="",$onlinePaytypeId=''){
		global $dao;
		
		$pay_order=$dao->get_row_by_where($dao->tables->onlinepay_log,"where pay_sn='{$order_sn}' and onlinepay_type='{$onlinePaytypeId}' ");
		if(!is_array($pay_order)){
			return false;
		}
		
		$record=array();
		$record["content_status"]="1";
		$record["content_money"]=$pay_money;
		$record["api_order_sn"]=$api_order_sn;
		$record["create_time"]=date("Y-m-d H:i:s");
		$dao->update($dao->tables->onlinepay_log,$record,"where order_sn='{$order_sn}' and onlinepay_type='{$onlinePaytypeId}'");
			
		$order=$dao->get_row_by_where($dao->tables->order,"where order_sn='{$order_sn}'");
		
		//写入订单日志
		$logText="用户在线支付{$pay_money}元";
		//获取支付方式名称
		if($onlinePaytypeId!=""){
			if(is_array($this->payType))
			foreach($this->payType as $key=>$vl){
				if(is_array($vl))
				foreach($vl as $k=>$v){
					if($k==$onlinePaytypeId){
						$logText.=",支付方式:".$v["text"];
						break;
					}
				}
			}
		}
		$orderService=new orderService();
		$orderService->addOrderLog($order["auto_id"],"用户",$logText);
		
		
		if($pay_order["account_money"]>0){
			
			//查询会员账户余额
			$memberAccountService=new memberAccountService();
			$accountBalance=$memberAccountService->getAccountBalance($order["member_id"]);
			$balance_monay=$accountBalance-$pay_order["account_money"];
			
			//增加账户余额记录
			$dataArray=array();
			$dataArray["member_id"]=$order["member_id"];
			$dataArray["content_type"]=2;
			$dataArray["content_event"]="account_pay";
			$dataArray["content_desc"]="支付订单{$order["order_sn"]}";
			$dataArray["content_money"]=$pay_order["account_money"]*(-1);
			$dataArray["balance_monay"]=$balance_monay;
			$dataArray["order_id"]=$order["auto_id"];
			$dataArray["order_sn"]=$order["order_sn"];			
			$dataArray["create_time"]=date("Y-m-d H:i:s");
			$dao->insert($dao->tables->member_account,$dataArray);
			//修改账户余额字段
			$dao->update($dao->tables->member,array("account_balance"=>$dataArray["balance_monay"]),"where auto_id='{$dataArray["member_id"]}'");
			
			//写入订单日志
			$orderService->addOrderLog($order["auto_id"],"用户","账户余额支付{$pay_order["account_money"]}元");
		}
		
		
		if($pay_money+$pay_order["account_money"]>=$order["pay_money"] && $order["pay_status"]=="0"){
			//变更订单支付状态
			$record=array();
			$record["pay_status"]="1";
			$dao->update($dao->tables->order,$record,"where auto_id='{$order["auto_id"]}'");
			//调用回调函数
			$order["pay_status"]="1";
			$this->paySuccessCallback($order);
			
		}else{
			//写入订单日志
			$orderService=new orderService();
			$orderService->addOrderLog($order["auto_id"],"用户","支付过程中订单金额发生变化，支付失败");
		}
	
	}
	
	//支付成功后的调用函数，用于处理支付成功后的操作
	function paySuccessCallback($order){
		global $dao;
		if($order["type"]==4){//如果是账户充值
			//查询会员账户余额
			$memberAccountService=new memberAccountService();
			$accountBalance=$memberAccountService->getAccountBalance($order["member_id"]);
			$balance_monay=$accountBalance+$order["pay_money"];
		
			//增加账户记录
			$dataArray=array();
			$dataArray["member_id"]=$order["member_id"];
			$dataArray["content_type"]=1;
			$dataArray["content_event"]="fill_account";
			$dataArray["content_desc"]="账户充值";
			$dataArray["content_money"]=$order["pay_money"];
			$dataArray["balance_monay"]=$balance_monay;
			$dataArray["order_id"]=$order["auto_id"];
			$dataArray["order_sn"]=$order["order_sn"];
			$dataArray["create_time"]=date("Y-m-d H:i:s");
			$dao->insert($dao->tables->member_account,$dataArray);
			//修改账户余额字段
			$dao->update($dao->tables->member,array("account_balance"=>$dataArray["balance_monay"]),"where auto_id='{$dataArray["member_id"]}'");
		}
		
	}
	
}
?>