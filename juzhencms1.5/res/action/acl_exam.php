<?
class acl_exam extends base_acl{
	var $default_method="lists";
	
	function __construct(){
		global $global;
    	$global->tplAbsolutePath=$global->absolutePath."/res/tpl/system/exam/";
		$global->tplUrlPath=$global->siteUrlPath."/res/tpl/system/exam/";
    }

	function question(){
		$this->tpl_file="form.php";
		$record=array();
		return $record;
	}
	
	function saveAnswer(){
		global $dao,$global;
		
		$pid="";
		$answer=array();
		
		if(is_array($_POST))
		foreach($_POST as $key=>$vl){
			if($key=="pid"){
				$pid=$vl;
			}else{
				$question_id=str_replace("question_","",$key);
				$answer[$question_id]=$vl;
			}
		}
		
		if($pid!=""){
			//存入数据库
			$record=array();
			//获取ip地址
			$record["pid"]=$pid;
			$record["content_ip"]=GetIP();
			$memberService=new memberService();
			$member_id=$memberService->getLoginMemberInfo("auto_id");
			if($member_id!="")
				$record["member_id"]=$member_id;
			$record["create_time"]=date("Y-m-d H:i:s");
			
			$record_id=$dao->insert($dao->tables->exam_record,$record);
			
			if(is_array($answer))
			foreach($answer as $key=>$vl){
				$answer_record=array();
				$answer_record["pid"]=$record_id;
				$answer_record["question_id"]=$key;
				$answer_record["answer_id"]=$vl;
				$answer_record["create_time"]=$record["create_time"];
				$dao->insert($dao->tables->exam_record_answer,$answer_record);
			}
			
			//查询出总分值
			$tmpstr=implode(',',$answer);
			if($tmpstr=="")
				$tmpstr="0";
			$result_score=$dao->get_datalist("select sum(content_score) as sum_score from {$dao->tables->exam_question_answer} where auto_id in({$tmpstr})");
			
			if(is_array($result_score) && count($result_score)>0){
				$total_score=$result_score[0]["sum_score"];
			}else{
				$total_score=0;
			}
			
			//获取相匹配的结果
			$result_list=$dao->get_datalist("select * from {$dao->tables->exam_result} where pid='{$pid}' order by content_score desc");
			
			if(is_array($result_list))
			foreach($result_list as $key=>$vl){
				if($total_score>=$vl["content_score"]){
					$result=$vl;
					break;
				}
			}
			
			//更新到答题记录表
			$newRecord=array();
			$newRecord["content_score"]=$total_score;
			$newRecord["result_id"]=$result["auto_id"];
			$newRecord["content_result"]=$result["content_title"];
			$dao->update($dao->tables->exam_record,$newRecord,"where auto_id='{$record_id}'");
			$result_url=$global->siteUrlPath."/index.php?acl=exam&method=result&id={$record_id}";
			
			echo json_encode(array("result"=>1,"msg"=>"","url"=>$result_url));
		}else{
			echo json_encode(array("result"=>0,"msg"=>"系统出错，请重试"));	
		}
		
	}
	
	function result(){
		$this->tpl_file="result.php";
		$record=array();
		return $record;
	}
	
}
?>