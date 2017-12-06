<?
class mobileMsgService{
	
	
	//发送短信
	function sendMsg($mobile,$text,$paramsArr=array()){
		//获取短信发送接口
		$paramsService=new paramsService();
		$msgApiUrl=$paramsService->getParamValue("mobile_msg_api");
		
		$msgApiUrl=str_replace("{mobile}",$mobile,$msgApiUrl);
		$msgApiUrl=str_replace("{text}",urlencode($text),$msgApiUrl);
		
		$api_return=file_get_contents($msgApiUrl);
		if($api_return<=0)
			$result="0";
		else
			$result="1";
		
		$msgRecord=array();
		$msgRecord["content_mobile"]=$mobile;
		$msgRecord["content_text"]=$text;
		$msgRecord["content_result"]=$result;
		$msgRecord["api_return"]=$api_return;
		$msgRecord["create_time"]=date("Y-m-d H:i:s");
		
		if(is_array($paramsArr))
			$msgRecord=array_merge($msgRecord,$paramsArr);
		
		$this->addMsgRecord($msgRecord);
	}
	
	//写短信发送日志
	private function addMsgRecord($record){
		global $dao;
		$dao->insert($dao->tables->mobile_msg_record,$record,true);
	}

	
}
?>