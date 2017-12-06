<?
class emailService{
	
	
	//发送邮件
	function sendEmail($email,$title,$body,$paramsArr=array()){
		//获取邮件参数
		$paramsService=new paramsService();
		$email_params=$paramsService->getParams(array("email_host","email_port","email_email","email_user","email_pass","content_name"));
		
		$smtpserver = $email_params['email_host'];//SMTP服务器,如smtp.126.com(123.125.50.110)
		$smtpserverport =$email_params['email_port'];//SMTP服务器端口
		$smtpusermail = $email_params['email_email'];//SMTP服务器的用户邮箱
		$smtpSenderName = $email_params['content_name'];//显示的发信人名称
		$smtpuser = $email_params['email_user'];//SMTP服务器的用户帐号
		$smtppass = $email_params['email_pass'];//SMTP服务器的用户密码
		$smtpemailto=$email;
		$mailtype="html";
		
		if(!class_exists("smtp"))
			import("lib/mail_class/mail_class");
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
		$smtp->debug = false;//是否显示发送的调试信息 
		if($smtp->sendmail($smtpemailto, $smtpusermail,$smtpSenderName, $title, $body, $mailtype))
		{
			$result=1;
		}
		else{
			$result=0;
		}
		
		$msgRecord=array();
		$msgRecord["content_email"]=$email;
		$msgRecord["content_title"]=$title;
		$msgRecord["content_body"]=$body;
		$msgRecord["content_result"]=$result;
		$msgRecord["from_email"]=$smtpusermail;
		$msgRecord["create_time"]=date("Y-m-d H:i:s");
		
		if(is_array($paramsArr))
			$msgRecord=array_merge($msgRecord,$paramsArr);
		
		$this->addEmailRecord($msgRecord);
		
		return $result;
	}
	
	//写短信发送日志
	private function addEmailRecord($record){
		global $dao;
		$dao->insert($dao->tables->email_record,$record,true);
	}

	
}
?>