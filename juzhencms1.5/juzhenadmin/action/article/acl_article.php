<?

class acl_article extends acl_base{
	var $default_method="form";

	function form(){
		global $dao;
		$this->tpl_file="form.php";
		$record=array();
		
		$recordData=$dao->get_row_by_where($dao->tables->article,"where menu_id='{$_REQUEST["menu"]}'");	
		$record["formData"]=$recordData;
		
		/*echo "<pre>";
		print_r($record);
		exit;*/
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
	
	
	function save(){
		global $dao;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		if($_POST["auto_id"]==""){
			$dataArray["menu_id"]=$_REQUEST["menu"];
			$dataArray["create_time"]=date("Y-m-d H:i:s");
			$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->article,$dataArray);			
		}else{
			$dao->update($dao->tables->article,$dataArray,"where menu_id='{$_REQUEST["menu"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=form");	
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	
	
	
}

?>