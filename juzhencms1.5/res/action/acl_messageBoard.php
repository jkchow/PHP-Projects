<?
class acl_messageBoard extends base_acl{
	var $default_method="message";
	function message(){
		$this->tpl_file="guest.php";
		$record=array();
		return $record;
	}
	
	function saveMessage(){
		global $dao;
		
		//检查验证码
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			$this->redirectBack("验证码输入错误");
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		$record=$_POST["frm"];
		$record["publish"]="0";
		$record["create_time"]=date("Y-m-d H:i:s");
		//保存报名记录
		$dao->insert($dao->tables->message_board,$record);
		$this->redirectBack("信息提交成功，我们会尽快与您联系，请耐心等待");
	}
	
	
}
?>