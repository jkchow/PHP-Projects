<?
class menuService{
	
	static $menuCache=array();
	
	function getData($id){
		global $dao,$global;
		$data=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$id}'");
		if($data["content_link"]==""){
			$data["content_link"]=$this->getMenuLink($data);
			//$data["content_link"]=$global->siteUrlPath."/index.php?menu={$data["auto_id"]}";
		}
		return $data;
	}
	
	//根据id获取当前应聚焦的栏目（若当前为空则自动取下一级）
	function getLocalMenu($menuId){
		global $dao;
		$tmpMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$menuId}'",array("auto_id","pid","action_method","detail_method","content_module","content_name","content_link","link_target","seo_keywords","seo_description"));
		
		if(is_array($tmpMenu)){
			if($tmpMenu["action_method"]!="" || $tmpMenu["content_module"]!="" || $tmpMenu["content_link"]!=""){
				return $tmpMenu;
			}else{
				$sub=$this->getFirstSubMenu($tmpMenu["auto_id"]);	
				if($sub!=false)
					return $sub;
				else
					return $tmpMenu;
			}
		}else{
			return NULL;
		}	
	}
	
	private function getFirstSubMenu($pid){
		global $dao;
		$tmpMenu=$dao->get_row_by_where($dao->tables->menu,"where pid='{$pid}' and publish='1' order by auto_position asc,auto_id asc",array("auto_id","pid","action_method","detail_method","content_module","content_link","link_target","content_name","seo_keywords","seo_description"));
		
		if(!is_array($tmpMenu)) return false;
		
		if($tmpMenu["action_method"]=="" && $tmpMenu["content_module"]=="" && $tmpMenu["content_link"]==""){
			return $this->getFirstSubMenu($tmpMenu["auto_id"]);
			
		}else{
			return $tmpMenu;
		}
		
	}
	
	//获取面包屑导航数据 
	function getLocationBarMenuList($localMenuId){
		global $dao,$global;
		$localMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$localMenuId}'",array("auto_id","pid","content_link","link_target","content_name"));
		$menu_arr=array();
		$menu_arr[]=$localMenu;
		$pid=$localMenu["pid"];
		while($pid!='' && $pid!="0"){
			$tmpMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$pid}'",array("auto_id","pid","content_link","content_name","link_target","url_path"));
			if(is_array($tmpMenu)){
				$menu_arr[]=$tmpMenu;
				$pid=$tmpMenu["pid"];
			}else{
				break;
			}
			
		}
		
		
		if(is_array($menu_arr))
		foreach($menu_arr as $key=>$vl){
			if($vl["content_link"]==""){	
				$menu_arr[$key]["content_link"]=$this->getMenuLink($vl);
			}
		}
		
		return array_reverse($menu_arr);
		
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
		$list_sql="select auto_id,auto_code,content_name as text,content_module from {$dao->tables->menu} where auto_code like '{$pCode}____' {$whereStr} and publish='1' order by position asc,auto_code asc,auto_id asc ";
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
		
		//$tmpMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$pId}'",array("auto_id","auto_code"));
		//$pCode=$tmpMenu["auto_code"];
		$list_sql="select auto_id,pid,content_link,link_target,content_name,content_desc,content_module,url_path,show_submenu from {$dao->tables->menu} where pid='{$pId}' {$whereStr} and publish='1' order by auto_position asc,auto_id asc limit 0,{$num}";
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			/*if($vl["content_link"]==""){
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?menu={$vl["auto_id"]}";
			}*/
			$list[$key]["content_link"]=$this->getMenuLink($vl);
		}
		return $list;
	}
	
	
	function updateMenuPath($pid=0,$basePath=""){
		global $dao,$global;
		$menuList=$dao->get_datalist("select auto_id,url_path,pid from {$dao->tables->menu} where pid='{$pid}' and (url_path!='' and url_path is not null) and publish='1' limit 0,500");

		
		if(is_array($menuList))
		foreach($menuList as $key=>$vl){
			
			$dirpath=($basePath!=""?($basePath."/"):"").$vl["url_path"];
			
			//创建目录
			$menuPath=$global->absolutePath."/".$dirpath;
			if(!@file_exists($menuPath))
			{
				@mkdir($menuPath);
				@chmod($menuPath,0777);
			}
			//创建入口文件
			if ($fp = @fopen($menuPath."/index.php", "w+")) { 
			
				$tmpStr='<? if(empty($_REQUEST["menu"])) $_REQUEST["menu"]=$_GET["menu"]='.$vl["auto_id"].'; require("'.$global->absolutePath.'/index.php");?>';
			
				//利用读写锁实现单例模式
				flock($fp, LOCK_EX); 	
				//将新的统计数据写入文本文件
				fputs($fp,$tmpStr);//写文件时不会有冲突
				//关闭文件
				flock($fp, LOCK_UN); 
				fclose($fp);
			}
			
			//执行子目录操作
			$this->updateMenuPath($vl["auto_id"],$dirpath);
			
		}
	}
	
	private function getMenuPath($menuRecord){

		global $dao;
		menuService::$menuCache[$menuRecord["auto_id"]]=$menuRecord;
		$menuPath="";
		if($menuRecord["url_path"]!=""){
			$menuPath=$menuRecord["url_path"];
		}
		$tmpMenu=$menuRecord;
		
		
		
		
		while($tmpMenu["pid"]!="" && $tmpMenu["pid"]!="0"){
			$pid=$tmpMenu["pid"];
			$tmpMenu=menuService::$menuCache[$pid];
			if(!is_array($tmpMenu)){
				$tmpMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$pid}'",array("auto_id","pid","content_name","content_link","url_path"));
				menuService::$menuCache[$tmpMenu["auto_id"]]=$tmpMenu;
				
			}
			if($tmpMenu["url_path"]!=""){
				$menuPath=$tmpMenu["url_path"].($menuPath!=""?("/".$menuPath):"");
			}
		}
		
		return $menuPath;
	}
	
	function getMenuLink($menuRecord){
		global $global,$dao;
		
		$link=$global->siteUrlPath."/index.php?menu={$menuRecord["auto_id"]}";
		
		if($menuRecord["content_link"]!=""){//如果存在外链
			if(preg_match('/^http(s)?:\/\//i',$menuRecord["content_link"]) || preg_match('/^javascript:/i',$menuRecord["content_link"]) || preg_match('/^#/i',$menuRecord["content_link"])){
				$link=$menuRecord["content_link"];
			}else{
				$link=$global->siteUrlPath."/".$menuRecord["content_link"];
			}
		}else{//没有采用外链的情况
			
			//如果采用静态化
			if(CONFIG_STATIC_HTML){
				$pathRecord=$dao->get_row_by_where($dao->tables->define_url,"where menu_id='{$menuRecord["auto_id"]}' and acl='menu' and url_path!=''");
				if(is_array($pathRecord)){
					$link=$global->siteUrlPath.$pathRecord["url_path"];
				}
				
			}
			
		}
		
		
		
		return $link;
		
	}
	
	//获取主导航菜单
	function getMainMenuData($params=array()){
		global $dao,$local_menu;
		if($params["num"]=="")
			$params["num"]=5;
		if($params["focus"]=="")
			$params["focus"]=true;
		
		//获取菜单数据
		$menuList_sql="select auto_id,pid,show_submenu,content_name,content_module,action_method,content_link,link_target,url_path from {$dao->tables->menu} where pid='0' and publish='1' order by auto_position asc,auto_id asc limit 0,{$params["num"]}";
		$menuList=$dao->get_datalist($menuList_sql);
		
		if(is_array($menuList))
		foreach($menuList as $key=>$vl){
			$menuList[$key]["content_link"]=$this->getMenuLink($vl);
			if($vl["show_submenu"]=="1"){
			
				$list_sql="select auto_id,pid,show_submenu,content_link,link_target,content_name,content_desc,content_module,url_path from {$dao->tables->menu} where pid='{$vl["auto_id"]}' and publish='1' order by auto_position asc,auto_id asc limit 0,10";
				$tmplist=$dao->get_datalist($list_sql);
				if(is_array($tmplist))
				foreach($tmplist as $k=>$v){
					/*if($v["content_link"]==""){
						$tmplist[$k]["content_link"]=$global->siteUrlPath."/index.php?menu={$v["auto_id"]}";
					}*/
					$tmplist[$k]["content_link"]=$this->getMenuLink($v);
				}
				$menuList[$key]["sub"]=$tmplist;		
			}	
		}
		
		//设置菜单聚焦标识
		$pMenu=$local_menu;
		$pidArr=array();
		$pidArr[]=$pMenu["auto_id"];
		//获取顶级栏目
		while($local_menu["auto_id"]!="" && $pMenu["pid"]!="0" && $pMenu["pid"]!=""){
			$pMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$pMenu["pid"]}'");
			$pidArr[]=$pMenu["auto_id"];
		}
				
		
		if(is_array($menuList))
		foreach($menuList as $key=>$vl){
			
			if($params["focus"])
				if($local_menu["auto_id"]!=""){
					if($vl["auto_id"]==$pMenu["auto_id"])
						$menuList[$key]["menu_focus"]=true;
				}else{
					/*if($vl["action_method"]=="index" || $vl["action_method"]=="index.php")
						$menuList[$key]["menu_focus"]=true;*/
					if($_REQUEST["acl"]=="index" && $_REQUEST["method"]=="index" && ($vl["action_method"]=="index" || $vl["action_method"]=="index.php")){
						$menuList[$key]["menu_focus"]=true;
					}
				}
			
		}
		
		
		return $menuList;
	}
	
	//获取二级导航菜单(用于显示左侧导航菜单)
	function getSubMenuData(){
		global $dao,$local_menu;
		
		$pMenu=$local_menu;

		$pidArr=array();
		$pidArr[]=$pMenu["auto_id"];
		//获取顶级栏目
		while($local_menu["auto_id"]!="" && $pMenu["pid"]!="0"){
			$pMenu=$this->getData($pMenu["pid"]);
			$pidArr[]=$pMenu["auto_id"];
		}
		
		
		
		//获取下级栏目(用于显示左侧菜单)
		if(is_array($pMenu)){
			if($pMenu["content_link"]=="")
				$pMenu["content_link"]=$this->getMenuLink($pMenu);
			
			
			$subMenuList=$this->listsByPid($pMenu["auto_id"],20);
			if(is_array($subMenuList)){
				foreach($subMenuList as $key=>$vl){
					if(in_array($vl["auto_id"],$pidArr)){
						$subMenuList[$key]["menu_focus"]=true;
						if($vl["show_submenu"]==1){
							$subsubList=$this->listsByPid($vl["auto_id"],20);
							if(is_array($subsubList)){
								foreach($subsubList as $k=>$v){
									if(in_array($v["auto_id"],$pidArr))
										$subsubList[$k]["menu_focus"]=true;
								}
								$subMenuList[$key]["sub"]=$subsubList;
							}		
						}
						
					}		
				}
			}else{
				$subMenuList[0]=$pMenu;
				$subMenuList[0]["menu_focus"]=true;
			
			}
		}
		$result=array();
		$result["pMenu"]=$pMenu;
		$result["list"]=$subMenuList;
		
		return $result;
		
	}
	
}
?>