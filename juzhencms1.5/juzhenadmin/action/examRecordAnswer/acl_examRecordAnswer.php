<?

class acl_examRecordAnswer extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	function form(){
		global $dao;
		$this->tpl_file="form.php";
		$record=array();
		
		if($_REQUEST["auto_id"]!=""){
			$recordData=$dao->get_row_by_where($dao->tables->exam_record_answer,"where auto_id='{$_REQUEST["auto_id"]}'");	
			
			
			/*if($recordData["content_type"]=="1"){
				$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$recordData["member_id"]}'",array("content_name"));
				$recordData["content_name"]=$member["content_name"]." (用户)";
			}elseif($recordData["content_type"]=="2"){
				$doctor=$dao->get_row_by_where($dao->tables->doctor,"where auto_id='{$recordData["doctor_id"]}'",array("content_name"));
				$recordData["content_name"]=$doctor["content_name"]." (医生)";
			}*/
			
			
			
		}else{
			$recordData=array();
			$recordData["publish"]='1';
			$recordData["pid"]=$_REQUEST["pid"];
			$recordData["create_time"]=date("Y-m-d H:i:s");
		}

		$formData=array();
		if(is_array($recordData))
		foreach($recordData as $key=>$vl){
			if($vl==NULL)
				continue;
			if($key!="auto_id")
				$formData["frm[{$key}]"]=$vl;
			else
				$formData["{$key}"]=$vl;
		}
		
		$record["formData"]=$formData;
		
		
		return $record;
	}
	function listsData(){

		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->exam_record_answer} where 1=1 ";
		
		if($_REQUEST["pid"]!="")
			$where.=" and pid='{$_REQUEST["pid"]}'";
			
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
			
		if($_REQUEST["searchKeyword"]!="")
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,auto_id desc";
		}else{
			$orderby.=" order by create_time desc";
		}
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,pid,question_id,answer_id,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
	
			$question=$dao->get_row_by_where($dao->tables->exam_question,"where auto_id='{$vl["question_id"]}'",array("content_name"));
			$list[$key]["question_id"]=$question["content_name"];	
			$answer=$dao->get_row_by_where($dao->tables->exam_question_answer,"where auto_id='{$vl["answer_id"]}'",array("content_name"));
			$list[$key]["answer_id"]=$answer["content_name"];
	
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);

	}
	
	function save(){
		global $dao;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		if($_POST["auto_id"]==""){
			//$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->exam_record_answer,$dataArray);			
		}else{
			$dao->update($dao->tables->exam_record_answer,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
		
		//$backUrl=base64_decode($_REQUEST["backUrl"]);	
		//$this->redirect($backUrl);
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->exam_record_answer,"where auto_id='{$_REQUEST["auto_id"]}'");	
		//$backUrl=base64_decode($_REQUEST["backUrl"]);	
		//$this->redirect($backUrl);
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
}

?>