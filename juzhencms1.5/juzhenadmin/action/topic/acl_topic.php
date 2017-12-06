<?

class acl_topic extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->topic,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
		$dictionaryVars=new DictionaryVars();
		$record["topicTypeVars"]=$dictionaryVars->getVars("topicTypeVars");
		
		return $record;
	}
	function listsData(){

		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->topic} where 1=1 ";
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
		if($_REQUEST["province_id"]!='')
			$where.=" and province_id = '{$_REQUEST["province_id"]}' ";	
			
			
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
		
		$list_sql="select auto_id,content_name,province_id,publish,position,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["create_user"]}'",array("content_name"));
			$list[$key]["create_user"]=$user["content_name"];
			$province=$dao->get_row_by_where($dao->tables->address_province,"where id='{$vl["province_id"]}'",array("name"));
			$list[$key]["province_id"]=$province["name"];
			
			
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
			$dao->insert($dao->tables->topic,$dataArray);	
			
			$topic_id=$dao->get_insert_id();
			//根据模板创建频道
			
			$menuList=$dao->get_datalist("select * from {$dao->tables->topic_menu} where topic_id='0' and menu_key!='' ");
			if(is_array($menuList))
			foreach($menuList as $key=>$vl){
				unset($vl["auto_id"]);
				$vl["topic_id"]=$topic_id;
				$dao->insert($dao->tables->topic_menu,$vl);	
			}
			
			
		}else{
			$dao->update($dao->tables->topic,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");	
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->topic,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
			$dao->update($dao->tables->topic,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	
	//后台主界面
	function main(){
		global $dao;
		//根据get参数将专题标识存储在session中
		$_SESSION["topicId"]=$_REQUEST["id"];
		$topic=$dao->get_row_by_where($dao->tables->topic,"where auto_id='{$_REQUEST["id"]}'");	
		
		
		$this->tpl_file="main.php";
		$record=array();
		$record["topic"]=$topic;
		return $record;
	}
	//左侧栏目树的数据
	function menuTreeData(){
		$return_arr=$this->getMenuTreeData();
		
		if(is_array($return_arr))			
			echo json_encode($return_arr); 
		else
			echo "[]";
	}
	
	private function getMenuTreeData($where="",$pCode=""){
		
		//没有权限判断，显示全部栏目
		if(trim($where)!="")
			$whereStr=" and ".$where;

		global $dao;
		$list_sql="select auto_id,auto_code,content_name as text,content_module from {$dao->tables->topic_menu} where topic_id='{$_SESSION["topicId"]}' and auto_code like '{$pCode}____' {$whereStr} order by auto_position asc,auto_code asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);

		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){

			if($vl["content_module"]!=""){
				$list[$key]["url"]="?acl={$vl["auto_id"]}.{$vl["content_module"]}";
			}
				
			
			$subList=$this->getMenuTreeData($where,$vl["auto_code"]);
			if(is_array($subList) && count($subList)>0)
				$list[$key]["children"]=$subList;
		}
		return $list;
		
		
		
		
	}
	
	function welcome(){
		global $dao;
		$record=array();
		
		$topic=$dao->get_row_by_where($dao->tables->topic,"where auto_id='{$_SESSION["topicId"]}'");
		$record["user"]=$this->getLoginUser();
		$record["topic"]=$topic;
		
		$this->tpl_file="welcome.php";
		return $record;
	}
	
	function paramsForm(){
		global $dao;
		$this->tpl_file="paramsForm.php";
		$record=array();
		
		
		$recordData=$dao->get_row_by_where($dao->tables->topic,"where auto_id='{$_SESSION["topicId"]}'");	
		

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
	
	
	function saveParams(){
		global $dao;
		$dataArray=$_POST["frm"];
		
		if($_POST["auto_id"]==""){
			$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->topic,$dataArray);			
		}else{
			$dao->update($dao->tables->topic,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=paramsForm");	
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	
}

?>