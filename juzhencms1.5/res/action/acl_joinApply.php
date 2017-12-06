<?
class acl_joinApply extends base_acl{
	var $default_method="";
	
	function saveApply(){
		global $dao;
		$record=$_POST["frm"];
		$record["content_status"]="0";
		$record["create_time"]=date("Y-m-d H:i:s");
		
		//保存报名记录
		$dao->insert($dao->tables->join_apply,$record);
		//$this->redirectBack("信息提交成功，我们会尽快与您联系，请耐心等待");
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功，我们会尽快与您联系，请耐心等待"));	
	}
	
	
	
}
?>