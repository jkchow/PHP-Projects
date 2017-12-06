<?

class acl_params extends acl_base{
	var $default_method="form";

	function form(){
		global $dao;
		$this->tpl_file="form.php";
		$record=array();
		$formData=array();
		$dataList=$dao->get_datalist("select * from {$dao->tables->params}");
		if(is_array($dataList))
		foreach($dataList as $key=>$vl){
			$formData["frm[{$vl["content_name"]}]"]=$vl["content_value"];
		}

			
		$record["formData"]=$formData;
	
		return $record;
	}
	
	
	function save(){
		global $dao;

		
		$dataArray=$_POST["frm"];
		/*if($dataArray["count_code"]!=""){
			$dataArray["count_code"]=base64_decode($dataArray["count_code"]);
		}*/
		
		
		
		
		if(is_array($dataArray))
		foreach($dataArray as $key=>$vl){
			$dao->update($dao->tables->params,array("content_value"=>$vl),"where content_name='{$key}' and content_module='global'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=form");	
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function cleanCache(){	
		cache::flush();
		echo json_encode(array("result"=>1,"msg"=>"缓存已清除"));
	}
	
	
}

?>