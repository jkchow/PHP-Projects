<?
class StringTool{

//判断密码强度，返回密码强度级别（1弱，2中，3强）
function getPasswordLevel($password){ 
  
	$level=0;
	if(preg_match("/[0-9]/",$password)){
		$level++;
	}
	if(preg_match("/[a-z]/",$password)){
		$level++;
	}
	if(preg_match("/[A-Z]/",$password)){
		$level++;
	}
	if(preg_match("/[^a-zA-Z0-9]/",$password)){
		$level++;
	}
	return $level;
	
} 


}
?>