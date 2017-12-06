<?

class acl_example extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	function form(){
		global $dao;
		
		//定义表单模板
		//$this->tpl_file="form.php";//普通表单
		$this->tpl_file="formAdvanced.php";//高级表单，分多标签，含有图片、文件上传、视频上传、在线编辑器字段
		
		$record=array();
		
		if($_REQUEST["auto_id"]!=""){
			$recordData=$dao->get_row_by_where($dao->tables->example,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
			if($key=="auto_id"){
				$formData["{$key}"]=$vl;
			}elseif($key=="favor"){
				$formData["{$key}[]"]=$vl;
			}else{
				$formData["frm[{$key}]"]=$vl;
			}
			
		}
		
		$record["formData"]=$formData;
		
		
		return $record;
	}
	function listsData(){

		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->example} where 1=1 ";
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
		
		$list_sql="select auto_id,content_name,content_desc,publish,position,create_user,create_time "
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
		
		$dataArray=$_POST["frm"];
		if(is_array($_POST["favor"]))
			$dataArray["favor"]=";".implode(';',$_POST["favor"]).";";
		else
			$dataArray["favor"]="";
			
		$dataId=$_POST["auto_id"];
			
		if($_POST["auto_id"]==""){
			$dataArray["menu_id"]=$_REQUEST["menu"];
			$dataArray["create_user"]=$this->getLoginUserId();
			$dataId=$dao->insert($dao->tables->example,$dataArray);	
			
		}else{
			$dao->update($dao->tables->example,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");	
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功","id"=>$dataId));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$idStr=trim($_REQUEST["auto_id"],',');
			$idArr=explode(',',$idStr);
			if(is_array($idArr) && count($idArr)>0){
				foreach($idArr as $key=>$vl){
					if($vl=="")
						unset($idArr[$key]);
				}
				$idStr=implode(',',$idArr);
				$dao->delete($dao->tables->example,"where auto_id in({$idStr})");
			}
		}		
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
			$dao->update($dao->tables->example,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
}

?>