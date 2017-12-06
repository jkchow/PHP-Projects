<?
class AppPush{
	function push($param){
		global $global;
		
		/*$param["msg"]="hello world";
		$param["RegistrationId"]=array('121c83f76025e32a47b');
		$app_key="9711be5b41a980ce979b7e3a";
		$master_secret="51dbdac3da44a625457a65a7";*/
		
		if($param["msg"]=="" || $param["RegistrationId"]=="" || (is_array($param["RegistrationId"]) && count($param["RegistrationId"])==0 )){
			return 0;
		}
		
		$app_key="9711be5b41a980ce979b7e3a";
		$master_secret="51dbdac3da44a625457a65a7";
		
		
		//require 'path_to_sdk/autoload.php';
		import("lib/jpush-api-php-client-3.5.5/autoload");
		$client = new \JPush\Client($app_key, $master_secret,$global->fileAbsolutePath."/log/jpush.log");
		
		$pusher = $client->push();
		$pusher->setPlatform('all');
		$pusher->addRegistrationId($param["RegistrationId"]);
		//$pusher->addAllAudience();
		$pusher->setNotificationAlert($param["msg"]);
		try {
			$result=$pusher->send();
		} catch (\JPush\Exceptions\JPushException $e) {
			// try something else here
			return 0;
		}
		
		
		
		return $result["body"]["msg_id"];

		
		
	}
}
?>