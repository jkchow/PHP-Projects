<?

class acl_emailTemplet extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->email_templet,"where auto_id='{$_REQUEST["auto_id"]}'");	
		}else{
			$recordData=array();
			$recordData["publish"]='1';
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
		
		
		$where=" from {$dao->tables->email_templet} where 1=1 ";
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
			
		if($_REQUEST["searchKeyword"]!="")
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,auto_id desc";
		}else{
			$orderby.=" order by position asc,auto_id desc";
		}
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,content_title,content_event,publish,position,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["create_user"]}'",array("content_name"));
			$list[$key]["create_user"]=$user["content_name"];
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
			$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->email_templet,$dataArray);			
		}else{
			$dao->update($dao->tables->email_templet,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->email_templet,"where auto_id='{$_REQUEST["auto_id"]}'");	
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");	
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	
	//保存排序操作
	function savePosition(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["position"]=$_REQUEST["position"];	
			
			if($dataArray["position"]=="")
				$dataArray["position"]="0";
			$dao->update($dao->tables->email_templet,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}

	//发送短信表单
	function sendForm(){
		global $dao;
		$this->tpl_file="sendForm.php";
		$record=array();
		return $record;
	}
	//执行发送操作
	function sendMsg(){
		global $dao;
		
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		if($_POST["member_email"]=="" || $_POST["templet_id"]==""){
			echo json_encode(array("result"=>0,"msg"=>"请选择会员及模板"));
		}else{
			$email_arr=explode(';',$_POST["member_email"]);
			$emailTemplet=$dao->get_row_by_where($dao->tables->email_templet,"where auto_id='{$_POST["templet_id"]}'");
			$emailService=new emailService();
			if(is_array($emailTemplet) && is_array($email_arr))
			foreach($email_arr as $key=>$vl){
				$emailService->sendEmail($vl,$emailTemplet["content_title"],$emailTemplet["content_body"]);
			}
			
			echo json_encode(array("result"=>1,"msg"=>"发送成功"));
		}
		
	}
	
}

?>