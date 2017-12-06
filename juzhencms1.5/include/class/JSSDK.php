<?

/*//调用方式
global $weixin_appid, $weixin_secret;
$jssdk = new JSSDK($weixin_appid, $weixin_secret);
$signPackage = $jssdk->GetSignPackage();*/

class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();
	
	
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
	global $global;
	  
	$jsapi_ticket_file=$global->fileAbsolutePath."/tmp/weixin/jsapi_ticket.json";
	
    $data = json_decode(@file_get_contents($jsapi_ticket_file));
    if ($data->expire_time < time()) {
      $accessToken = $this->getAccessToken();
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7200;
        $data->jsapi_ticket = $ticket;
        $fp = fopen($jsapi_ticket_file, "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

  private function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
	global $global;
	  
	$access_token_file=$global->fileAbsolutePath."/tmp/weixin/access_token.json";
	
    $data = json_decode(@file_get_contents($access_token_file));
    if ($data->expire_time < time()) {
	  
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
	  
      $res = json_decode($this->httpGet($url));
	  
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7200;
        $data->access_token = $access_token;
        $fp = fopen($access_token_file, "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  private function httpGet($url) {
	//若没有开启openssl，使用file_get_contents无法获取https内容，比如在云虚拟主机中就不可用
	//return file_get_contents($url);  
	
    $curl = curl_init();
	/*//按这个配置在阿里云虚拟主机中无法获取结果
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_URL, $url);*/
	
	//改成这个配置就可以了
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

    $res = curl_exec($curl);
    curl_close($curl);
	
    return $res;
  }
}

?>