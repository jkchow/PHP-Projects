<?

class acl_subject extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->subject,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
		
		
		$where=" from {$dao->tables->subject} where 1=1 ";
		if($_REQUEST["content_status"]!='')
			$where.=" and content_status = '{$_REQUEST["content_status"]}' ";
		if($_REQUEST["recommend"]!='')
			$where.=" and recommend = '{$_REQUEST["recommend"]}' ";
			
		if($_REQUEST["category_id"]!=''){
			
			//查询出所有下级的分类id，拼接成字符串，然后查询话题
			$category_list=$this->getSubCategoryId($_REQUEST["category_id"]);	
			$category_id_str=$_REQUEST["category_id"];
			$tmpStr=implode(',',$category_list);
			if($tmpStr!="")
				$category_id_str.=",{$tmpStr}";	
			$where.=" and category_id in ({$category_id_str})  ";	
		}	
			
			
			
		if($_REQUEST["searchKeyword"]!=""){
			if($_REQUEST["searchFieldName"]=="content_author"){
				$member=$dao->get_row_by_where($dao->tables->member,"where content_name='{$_REQUEST["searchKeyword"]}'",array("auto_id"));
				$where.=" and member_id= '{$member["auto_id"]}' ";
			
			}else{
				$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
			}
			
		}
			
		
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
		
		$list_sql="select auto_id,content_title,member_id,category_id,recommend,content_status,position,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$vl["member_id"]}'",array("content_name"));
			$list[$key]["member_id"]=$member["content_name"];
			
			$category=$dao->get_row_by_where($dao->tables->subject_category,"where auto_id='{$vl["category_id"]}'",array("content_name"));
			$list[$key]["category_id"]=$category["content_name"];
			
			$tmp=$dao->get_datalist("select count(auto_id) as count_num from {$dao->tables->subject_reply} where subject_id='{$vl["auto_id"]}'");
			
			$list[$key]["reply_num"]=$tmp[0]["count_num"]!=''?$tmp[0]["count_num"]:"0";
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);
	}
	
	//查询出所有下级分类
	private function getSubCategoryId($category_id="0"){
		global $dao;
		$category_list=$dao->get_datalist("select auto_id from {$dao->tables->subject_category} where pid='{$category_id}'");
		$result_arr=array();
		if(is_array($category_list)){
			foreach($category_list as $key=>$vl){
				$result_arr[]=$vl["auto_id"];
			}
		}
		
		if(is_array($category_list))
		foreach($category_list as $key=>$vl){
			$result_arr=array_merge($result_arr,$this->getSubCategoryId($vl["auto_id"]));
		}
		
		return $result_arr;
		
	}
	
	function save(){
		global $dao;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		if($_POST["auto_id"]==""){
			//$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->subject,$dataArray);			
		}else{
			$dao->update($dao->tables->subject,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");	
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
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
				$dao->delete($dao->tables->subject,"where auto_id in({$idStr})");
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
			$dao->update($dao->tables->subject,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
}

?>