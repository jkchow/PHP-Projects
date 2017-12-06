<?
class topicMenuService{
	
	function getDataByKey($key){
		global $dao,$global,$topicId;
		$data=$dao->get_row_by_where($dao->tables->topic_menu,"where menu_key='{$key}' and topic_id='{$topicId}'");
		if($data["content_link"]==""){
			$data["content_link"]=$global->siteUrlPath."/index.php?topicMenu={$data["auto_id"]}";
		}
		return $data;
	}
	
	
	function getData($id){
		global $dao,$global;
		$data=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$id}'");
		if($data["content_link"]==""){
			$data["content_link"]=$global->siteUrlPath."/index.php?topicMenu={$data["auto_id"]}";
		}
		return $data;
	}
	
	function getDataByCode($code){
		global $dao,$global,$topicId;
		$data=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_code='{$code}' and topic_id='{$topicId}'");
		if($data["content_link"]==""){
			$data["content_link"]=$global->siteUrlPath."/index.php?topicMenu={$data["auto_id"]}";
		}
		return $data;
	}
	
	
	//根据id获取当前应聚焦的栏目（若当前为空则自动取下一级）
	function getLocalMenu($menuId){
		global $dao;
		$tmpMenu=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$menuId}'",array("auto_id","topic_id","auto_code","action_method","content_module","content_name","seo_keywords","seo_description"));
		
		if($tmpMenu["action_method"]=="" && ($tmpMenu["content_module"]=="" || $tmpMenu["content_module"]=="null")){
			return $this->getFirstSubMenu($tmpMenu);		
		}else{
			return $tmpMenu;
		}	
	}
	
	private function getFirstSubMenu($pMenu){
		global $dao;
		$tmpMenu=$dao->get_row_by_where($dao->tables->topic_menu,"where topic_id='{$pMenu["topic_id"]}' and auto_code like '{$pMenu["auto_code"]}____' and publish='1' order by auto_position asc,auto_id asc",array("auto_id","topic_id","auto_code","action_method","content_module","content_name","seo_keywords","seo_description"));
		
		if(!is_array($tmpMenu)) return false;
		
		if($tmpMenu["action_method"]=="" && ($tmpMenu["content_module"]=="" || $tmpMenu["content_module"]=="null")){
			return $this->getFirstSubMenu($tmpMenu);
			
		}else{
			return $tmpMenu;
		}
		
	}
	
	function getLocationBarMenuList($localMenuId){
		global $dao,$global;
		$localMenu=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$localMenuId}'",array("auto_id","topic_id","auto_code","content_link","content_name"));
		$code_arr=array();
		$code=$localMenu["auto_code"];
		$code=substr($code,0,strlen($code)-4);
		while($code!=""){
			$code_arr[]="'{$code}'";
			$code=substr($code,0,strlen($code)-4);
		}
		$list=array();
		if(count($code_arr)>0){
			$code_str=implode(',',$code_arr);
			
			$list_sql="select auto_id,topic_id,auto_code,content_name,content_link from {$dao->tables->topic_menu} where topic_id='{$localMenu["topic_id"]}' and auto_code in({$code_str}) and menu_key!='1' order by auto_code asc,auto_id asc ";
			$list=$dao->get_datalist($list_sql);
		}
		$list[]=$localMenu;
		
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?topicMenu={$vl["auto_id"]}";
		}
		return $list;
		
	}
	
	/*//获取栏目树形结构的数据(暂时没有用到)
	function getTreeData(){
		$return_arr=$this->getSubTreeData();
		return $return_arr;
	}
	
	private function getSubTreeData($where="",$pCode=""){
		
		if(trim($where)!="")
			$whereStr=" and ".$where;
		
		global $dao;
		$list_sql="select auto_id,auto_code,content_name as text,content_module from {$dao->tables->topic_menu} where auto_code like '{$pCode}____' {$whereStr} and publish='1' order by position asc,auto_code asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);
		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){
			$subList=$this->getSubTreeData($where,$vl["auto_code"]);
			if(is_array($subList) && count($subList)>0)
				$list[$key]["children"]=$subList;
		}
		return $list;
	}*/
	
	
	function listsByPid($pId,$num=10){
		global $dao,$global;
		
		$tmpMenu=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$pId}'",array("auto_id","topic_id","auto_code"));
		$pCode=$tmpMenu["auto_code"];
		$list_sql="select auto_id,topic_id,auto_code,content_link,content_name,content_desc,content_module from {$dao->tables->topic_menu} where topic_id='{$tmpMenu["topic_id"]}' and auto_code like '{$pCode}____' {$whereStr} and publish='1' order by auto_position asc,auto_code asc,auto_id asc limit 0,{$num}";
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]==""){
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?topicMenu={$vl["auto_id"]}";
			}
		}
		return $list;
	}
	
	
}
?>