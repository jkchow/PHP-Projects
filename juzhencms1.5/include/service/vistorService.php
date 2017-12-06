<?
class vistorService{
	function addLog($siteFlag){
		global $dao;
		//记录访问日志
		$memberService=new memberService();
		$member_id=$memberService->getLoginMemberInfo("auto_id");
		
		$session_id=session_id();
		$date=date("Y-m-d");
		$datatime=date("Y-m-d H:i:s");
		$tmp_vistor_record=$dao->get_row_by_where($dao->tables->vistor_log,"where content_date='{$date}' and session_id='{$session_id}'");
		
		
		
		if(!is_array($tmp_vistor_record)){
			$vistor_record=array();
			$vistor_record["member_id"]=$member_id;
			$vistor_record["session_id"]=$session_id;
			$vistor_record["content_hit"]=1;
			$vistor_record["create_time"]=$datatime;
			$vistor_record["last_time"]=$datatime;
			$vistor_record["content_date"]=$date;
			$vistor_record["content_flag"]=$siteFlag;
			$dao->insert($dao->tables->vistor_log,$vistor_record);
		}else{
			$vistor_record=array();
			$vistor_record["content_hit"]=$tmp_vistor_record["content_hit"]+1;
			$vistor_record["member_id"]=$member_id;
			$vistor_record["last_time"]=$datatime;
			$dao->update($dao->tables->vistor_log,$vistor_record,"where content_date='{$date}' and session_id='{$session_id}'");
		}

	}
}
?>