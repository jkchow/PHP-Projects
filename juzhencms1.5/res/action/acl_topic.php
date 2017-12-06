<?
class acl_topic extends base_acl{
	var $default_method="lists";
	
	/*//专题列表
	function lists(){	
		global $top_menu_focus;
		$top_menu_focus=false;
		$this->tpl_file="meetinglist.php";
		$record=array();
		return $record;
	}*/
	
	//ajax载入地区分站信息
	function getMapTopicList(){
		global $dao;
		if($_GET["province_id"]!=""){
			//查询下属的分站信息
			$topicList=$dao->get_datalist("select auto_id,content_name,content_tel,content_address from {$dao->tables->topic} where province_id='{$_GET["province_id"]}' order by position asc limit 0,20");
			echo json_encode($topicList);
			
			
		}
		
		
	}
	
	
	
	//首页
	function index(){	
	
		global $dao,$topicId;
		//增加点击量
		
		$i=0;
		$r=rand(0,3);
		if($r==3)
			$i=rand(0,5);
		
		$dao->query("update {$dao->tables->topic} set content_hit=content_hit+{$i} where auto_id='{$_GET["id"]}'");
		
		$topicId=$_GET["id"];
	
		$this->tpl_file="topicindex.php";
		$record=array();
		return $record;
	}
	//报名页面
	function apply(){
		global $dao,$topicId;
		$topicId=$_GET["id"];
		$this->tpl_file="topic/meeting_apply.php";
		
		
		/*$meetingService=new meetingService();
		$meetingInfo=$meetingService->getData($_GET["id"]);
		//如果当前不能报名，跳转回明细页面
		if($meetingInfo["apply_enddate"]<date("Y-m-d")){
			$this->redirect($meetingInfo["content_link"]);
		}*/
		
		$topicService=new topicService();
		$topic=$topicService->getData($_GET["id"]);
		if($topic["apply_endtime"]<date("Y-m-d H:i:s")){
			$this->redirectBack("报名时间已过，当前无法报名");
		}
		
		
		
		
		
		$record=array();
		$record["meetingInfo"]=$topic;
		return $record;
	}
	//保存报名信息
	function saveApply(){
		$meetingService=new meetingService();
		//$meetingInfo=$meetingService->getData($_GET["id"]);	
		
		$topicService=new topicService();
		$topic=$topicService->getData($_GET["id"]);
		
		$record=$_POST["frm"];
		
		//如果当前不能报名，跳转回明细页面
		if($topic["apply_endtime"]<date("Y-m-d H:i:s")){
			$this->redirectBack("报名时间已过，当前无法报名");
		}
		
		//如果提交的手机号已经报过名
		if(!$meetingService->checkApplyMobile($topic["auto_id"],$record["content_mobile"])){
			$this->redirectBack("您已经报过名，不能重复报名");
		}
		
		$meetingService->saveApply($record);
		
		$this->redirect("index.php?acl=topic&method=index&id={$_GET["id"]}","报名信息提交成功，我们会尽快处理您的请求，请耐心等待");
		//$this->redirectBack("报名信息提交成功，我们会尽快处理您的请求，请耐心等待");
	}
	
	
	
	
	
	
}
?>