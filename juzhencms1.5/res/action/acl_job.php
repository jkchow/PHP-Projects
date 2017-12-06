<?
class acl_job extends base_acl{
	var $default_method="lists";

	function lists(){
		$this->tpl_file="joblist.php";
		$record=array();
		return $record;
	}
	
	function apply(){
		$this->tpl_file="jobsubmit.php";
		$record=array();
		return $record;
	}
	
	function saveApply(){
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
		$dao->insert($dao->tables->job_apply,$record);
		$this->redirectBack("简历信息提交成功，我们会尽快与您联系，请耐心等待");
	}
	
}
?>