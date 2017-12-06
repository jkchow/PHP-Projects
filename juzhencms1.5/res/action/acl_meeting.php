<?
class acl_meeting extends base_acl{
	var $default_method="lists";

	function lists(){
		$this->tpl_file="confer.php";
		$record=array();
		return $record;
	}
	
	function apply(){
		$this->tpl_file="meeting_apply.php";
		$meetingService=new meetingService();
		$meetingInfo=$meetingService->getData($_GET["id"]);

		
		
		//如果当前不能报名，跳转回明细页面
		if($meetingInfo["apply_enddate"]<date("Y-m-d")){
			$this->redirect($meetingInfo["content_link"]);
		}
		
		
		$record=array();
		$record["meetingInfo"]=$meetingInfo;
		return $record;
	}
	
	function saveApply(){
		$meetingService=new meetingService();
		$meetingInfo=$meetingService->getData($_GET["id"]);	
		
		$record=$_POST["frm"];
		
		//如果当前不能报名，跳转回明细页面
		if($meetingInfo["apply_enddate"]<date("Y-m-d")){
			$this->redirect($meetingInfo["content_link"],"此活动当前无法报名");
		}
		
		//如果提交的手机号已经报过名
		if(!$meetingService->checkApplyMobile($meetingInfo["auto_id"],$record["content_mobile"])){
			$this->redirect($meetingInfo["content_link"],"您已经报过名，不能重复报名");
		}
		
		$meetingService->saveApply($record);
		
		$this->redirect($meetingInfo["content_link"],"报名信息提交成功，我们会尽快处理您的请求，请耐心等待");
	}
	
	
	function detail(){
		global $dao,$global;
		//增加点击量
		$i=0;
		$r=rand(0,3);
		if($r==3)
			$i=rand(0,5);
		$dao->query("update {$dao->tables->meeting} set content_hit=content_hit+{$i} where auto_id='{$_GET["id"]}'");
		$record=array();
		//查询会议信息，如果已经上传专题广告图，则会以专题页面形式展示		
		$meetingService=new meetingService();
		$meetingInfo=$meetingService->getData($_GET["id"]);
		
		
		
		if($meetingInfo["topic_img"]!="" && $_GET["type"]!="detail"){
			$this->tpl_file="meeting_topic.php";	
			$meetingInfo["topic_img"]=$global->uploadUrlPath.$meetingInfo["topic_img"];
		}else{
			$this->tpl_file="meeting_detail.php";
		}
		
		
		$record["meetingInfo"]=$meetingInfo;
		
		return $record;
	}
	
	
}
?>