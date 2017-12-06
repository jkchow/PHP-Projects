<?

class acl_main extends acl_base{
	var $default_method="main";
	//后台主界面
	function main(){
		$this->tpl_file="main.php";
		$record=array();
		$record["welcome"]="欢迎光临";
		return $record;
	}
	//左侧栏目树的数据
	function menuTreeData(){
		$return_arr=$this->getMenuTreeData();
		
/*		$passport=new Passport();
		$rolePermissionsArr=$passport->get_permissions();
		echo "<pre>";
		print_r($rolePermissionsArr);
		echo "<br/>";
		echo "<pre>";
		print_r($return_arr);
		exit;
		*/
		

		
		if(is_array($return_arr))			
			echo json_encode($return_arr); 
		else
			echo "[]";
	}
	
	private function getMenuTreeData($where="",$pid=""){
		
		//没有权限判断，显示全部栏目
		/*if(trim($where)!="")
			$whereStr=" and ".$where;

		global $dao;
		$list_sql="select auto_id,auto_code,content_name as text,content_module from {$dao->tables->menu} where  auto_code like '{$pCode}____' {$whereStr} order by auto_position asc,auto_code asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);

		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){

			if($vl["content_module"]!="")
				$list[$key]["url"]="?acl={$vl["auto_id"]}";
			$subList=$this->getMenuTreeData($where,$vl["auto_code"]);
			if(is_array($subList) && count($subList)>0)
				$list[$key]["children"]=$subList;
		}
		return $list;*/
		
		
		//获取当前角色的权限，无权限的栏目不显示
		$passport=new Passport();
		$rolePermissionsArr=$passport->get_permissions();
		
		$whereStr=" 1 ";
		if(strlen($pid)>0)
			$whereStr.=" and pid='{$pid}' ";
		else
			$whereStr.=" and pid='0' ";
		if(trim($where)!="")
			$whereStr.=" and {$where} ";

		global $dao;
		$list_sql="select auto_id,pid,content_name as text,content_module from {$dao->tables->menu} where {$whereStr} order by auto_position asc,auto_id asc ";
		
		$list=$dao->get_datalist($list_sql);
		
		$newList=array();
		
		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){
			
			//判断是否有权限
			if(is_array($rolePermissionsArr)){
				$k=$vl["auto_id"];
				if($vl["content_module"]!="")
					$k.=".".$vl["content_module"];
				if(!is_array($rolePermissionsArr[$k])){
					unset($list[$key]);
					continue;
				}
			}
			
			if($vl["content_module"]!="" && $vl["content_module"]!="null")
				$list[$key]["url"]="index.php?acl={$vl["auto_id"]}";
			$subList=$this->getMenuTreeData($where,$vl["auto_id"]);
			if(is_array($subList) && count($subList)>0)
				$list[$key]["children"]=$subList;
			
			$newList[]=	$list[$key];
			
		}
		
		return $newList;
		
		
	}
	
	
}

?>