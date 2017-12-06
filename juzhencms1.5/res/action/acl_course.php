<?
class acl_course extends base_acl{
	var $default_method="course";
	
	function course(){
		global $top_menu_focus;
		$top_menu_focus=false;
		
		$this->tpl_file="course.php";
		$record=array();
		return $record;
	}

	function getSchoolSelectData(){
		global $dao;
		
		if($_GET["city_id"]!=""){
			$list=$dao->get_datalist("select auto_id as value,content_name as label from {$dao->tables->topic} where city_id='{$_GET["city_id"]}'");
		}elseif($_GET["province_id"]!=""){
			$list=$dao->get_datalist("select auto_id as value,content_name as label from {$dao->tables->topic} where province_id='{$_GET["province_id"]}'");
		}
		$list=array_merge(array(array("value"=>"","label"=>"选择校区")),$list);
		$record=json_encode($list);
		echo $record;
	}
	
	function applyForm(){
		global $top_menu_focus;
		$top_menu_focus=false;
		$this->tpl_file="course_apply.php";
		$record=array();
		return $record;
	}
	
	function saveApply(){
		global $dao;
		$record=$_POST["frm"];
		$record["content_status"]="0";
		$record["create_time"]=date("Y-m-d H:i:s");
		
		$school=$dao->get_row_by_where($dao->tables->topic,"where auto_id='{$record["school_id"]}'",array("content_name"));
		$record["school_name"]=$school["content_name"];
		
		//保存报名记录
		$dao->insert($dao->tables->course_apply,$record);
		//$this->redirectBack("信息提交成功，我们会尽快与您联系，请耐心等待");
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功，我们会尽快与您联系，请耐心等待"));	
	}
	
	
	
}
?>