<?
class acl_comment extends base_acl{
	var $default_method="lists";
	
	//ajax载入评论内容，用于静态化时使用 
	function ajaxCommentLists(){
		$record=array();
		$pagesize=10;
		$commentService=new commentService();
		$commentList=$commentService->lists($_GET["commentType"],$_GET["id"],$pagesize,$_GET["page"]);	
		
		ob_start();
		if(is_array($commentList)){
			foreach($commentList as $key=>$vl){
		?>
		<div class="review-cell">
        <div class="review-pic"><img src="<?=$vl["member_head"]?>" width="50" height="50" /></div>
        <div class="review-cnt">
        <h5><?=$vl["member_name"]?></h5><span class="timecss"><?=$vl["create_time"]?></span>
        <div class="review-txt"><?=$vl["content_comment"]?></div>
        </div>
        </div>
		<?
			}
		}else{
			$record["msg"]="没有更多评论了";
		}
		
		if(count($commentList)==$pagesize){
			$record["result"]="1";
		}
		
		$record["html"] =  ob_get_contents();
		ob_end_clean();
		echo json_encode($record);
	}
	
	
	
	function saveComment(){
		global $dao,$global;
		$memberService=new memberService();
		$member=$memberService->getLoginMemberInfo();
		$mid=$member["auto_id"];
		if($mid==""){ 
			//$this->redirect($global_link["register"],"已经存在相同邮箱，注册失败");
			echo json_encode(array("result"=>0,"msg"=>"请先登录后再进行操作"));
			exit;
		}
		
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   strtolower($_POST["validateNUM"])!=strtolower($_SESSION["validateNUM"])
		){
			//$this->redirect($global_link["register"],"验证码输入错误");
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		
		
		
		
		$record=array();
		$record["content_type"]=$_POST["content_type"];
		$record["object_id"]=$_POST["object_id"];
		$record["member_id"]=$member["auto_id"];
		$record["member_name"]=$member["content_name"];
		$record["content_comment"]=$_POST["content_comment"];
		$record["create_time"]=date("Y-m-d H:i:s");
		
		if($record["content_comment"]==""){
			echo json_encode(array("result"=>0,"msg"=>"评论内容不能为空"));
			exit;
		}
		
		//根据分类和id查询被评论的内容
		if($record["content_type"]=="1"){
			$tmpObject=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$record["object_id"]}'",array("content_name"));	
		}elseif($record["content_type"]=="2"){
			$tmpObject=$dao->get_row_by_where($dao->tables->product,"where auto_id='{$record["object_id"]}'",array("content_name"));
			
		}elseif($record["content_type"]=="3"){
			$tmpObject=$dao->get_row_by_where($dao->tables->invest_product,"where auto_id='{$record["object_id"]}'",array("content_name"));
			
		}else{
			echo json_encode(array("result"=>0,"msg"=>"系统出错，请刷新后重试"));
			exit;
		}
		
		if(!is_array($tmpObject)){
			echo json_encode(array("result"=>0,"msg"=>"被评论的内容不存在，请刷新后重试"));
			exit;
		}
		
		//限定每个会员对每个内容只能评论一次
		$tmpComment=$dao->get_row_by_where($dao->tables->comment,"where member_id='{$record["member_id"]}' and object_id='{$record["object_id"]}' and content_type='{$record["content_type"]}'",array("auto_id"));
		
		if(is_array($tmpComment)){
			echo json_encode(array("result"=>0,"msg"=>"您已经评论过此内容了,不能重复评论"));
			exit;
		}
		
		$record["object_name"]=$tmpObject["content_name"];
		$dao->insert($dao->tables->comment,$record,true);
		
		echo json_encode(array("result"=>1,"msg"=>"评论成功"));
		
	}

	
}
?>