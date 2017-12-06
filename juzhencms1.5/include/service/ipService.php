<?
class ipService{
	//获取客户端IP地址
	static function getClientIP(){
		$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]; 
		$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
		return $user_IP;
		
	}
	
	//校验IP地址格式
	static function validateIpFormat($ip){
		if(preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',$ip)){
			$tmpArr=explode('.',$ip);
			foreach($tmpArr as $key=>$vl){
				if($vl<0 || $vl>255)
					return false;
			}
			return true;
		}else{
			return false;
		}
	}
	
	//将IP地址转换为数字
	static function getIpIntValue($ip){
		$tmpArr=explode('.',$ip);
		$value=0;
		$ratio=1000000000;
		if(is_array($tmpArr))
		foreach($tmpArr as $key=>$vl){
			$value+=$vl*$ratio;
			$ratio=$ratio/1000;
		}
		return $value;
	}
	
	//检测是否允许当前客户端IP地址访问
	static function checkClientIP(){
		global $dao;
		$ip_address= self::getClientIP();
		if(self::validateIpFormat($ip_address)){
			$ip_address_value=self::getIpIntValue($ip_address);
			
			
			$where.="where begin_ip_value<='{$ip_address_value}' and end_ip_value>='{$ip_address_value}' and publish=1 ";
			$tmp=$dao->get_row_by_where($dao->tables->forbidden_ip,$where);
			if(is_array($tmp) && count($tmp)>0){
				echo "禁止访问";
				exit;
			}
		}
		
		
		
		
		
		
	}
	
}
?>