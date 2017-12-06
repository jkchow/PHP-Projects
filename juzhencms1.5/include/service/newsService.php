<?
class newsService{
	//资讯列表
	function lists($menuId,$num=10,$orderStr="order by position asc,create_time desc,auto_id desc"){
		global $dao,$global;
		
		$cacheId="news_lists_{$menuId}_{$num}_".md5($orderStr);
		$newsList=cache::getData($cacheId);
		if(!$newsList){
			$newsList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,recommend,content_author,content_source,create_time from {$dao->tables->news} where menu_id='{$menuId}' and publish='1' {$orderStr} limit 0,{$num}");
			
			if(is_array($newsList))
			foreach($newsList as $key=>$vl){
				$newsList[$key]["content_link"]=$this->getNewsLink($vl);
				if($vl["content_img"]=="")
					$vl["content_img"]="nophoto.jpg";
				if($vl["content_img"]!="")	
					$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			}
			cache::setData($cacheId,$newsList);
			
		}
		return $newsList;
	}
	
	function listsByPid($pMenuId,$num=10){
		global $dao,$global;
		$menuService=new menuService();
		$menuList=$menuService->listsByPid($pMenuId,20);
		$menuId="0";
		$menuArr=array();
		if(is_array($menuList))
		foreach($menuList as $key=>$vl){
			$menuArr[]=$vl["auto_id"];
		}
		
		if(count($menuArr)>0)
			$menuId=implode(',',$menuArr);
		
		
		$newsList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,recommend,create_time from {$dao->tables->news} where menu_id in({$menuId}) and publish='1' order by position asc,create_time desc,auto_id desc limit 0,{$num}");
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			$newsList[$key]["content_link"]=$this->getNewsLink($vl);
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
		}
		return $newsList;
	}
	
	
	
	function getData($id){
		global $dao;
		$data=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$id}'");
		return $data;
	}
	
	
	
	function listsPage($menuId,$pagesize=16){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->news} where menu_id='{$menuId}' and publish='1' ";
		
		$orderby=" order by position asc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,content_name,content_author,content_source,content_subname,menu_id,content_link,content_img,content_file,content_desc,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$list[$key]["content_link"]=$this->getNewsLink($vl);
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$list[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			if($vl["content_file"]!="")
				$list[$key]["download_link"]=$global->siteUrlPath."/index.php?acl=download&file&file=".base64_encode($vl["content_file"]);
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		
		
		$page_class=new page_class();
		$page_class->page_size=$pagesize;
		$page_class->init($total);
		$pageBar=$page_class->getPageBar();
		
		$record=array();
		$record["list"]=$list;
		$record["page"]=$pageBar;
		return $record;
	}
	
	function searchListsPage($keywords,$pagesize=16){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->news} where  publish='1' ";
		
		$keywords=trim($keywords);
		if($keywords!=""){
			$where.=" and content_name like '%{$keywords}%' ";
		}
		
		$orderby=" order by recommend desc,position asc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,content_name,content_subname,menu_id,content_link,content_img,content_file,content_desc,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$list[$key]["content_link"]=$this->getNewsLink($vl);
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$list[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			if($vl["content_file"]!="")
				$list[$key]["download_link"]=$global->siteUrlPath."/index.php?acl=download&file&file=".base64_encode($vl["content_file"]);
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		
		
		$page_class=new page_class();
		$page_class->page_size=$pagesize;
		$page_class->init($total);
		$pageBar=$page_class->getPageBar();
		
		$record=array();
		$record["list"]=$list;
		$record["page"]=$pageBar;
		return $record;
	}
	
	//带有栏目链接的新闻列表
	function menuLinklists($menu_id_str,$num=10){
		global $dao,$global;
		
		$newsList=$dao->get_datalist("select t.auto_id as auto_id,t.menu_id as menu_id,t.content_name as content_name,t.content_link as content_link,t.content_desc as content_desc,t.content_img as content_img,t.create_time as create_time,m.content_name as menu_name,m.content_link as menu_link from {$dao->tables->news} t join {$dao->tables->menu} m on m.auto_id in({$menu_id_str}) and  m.content_module='news' and t.menu_id=m.auto_id and m.publish='1' where t.publish='1' order by t.recommend desc,t.position asc,t.create_time desc,t.auto_id desc limit 0,{$num}");
		
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			$newsList[$key]["content_link"]=$this->getNewsLink($vl);
			if($vl["content_img"]!="")	
				$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			if($vl["menu_link"]=="")	
				$newsList[$key]["menu_link"]=$global->siteUrlPath."/index.php?menu={$vl["menu_id"]}";
		}
		
		
		
		return $newsList;
	}
	
	function getRelationNewsLists($keywordsArray,$num,$ignoreIdArray=array()){
		global $dao,$global;
		if(is_array($keywordsArray)){
			$sqlItemArr=array();
			if(is_array($ignoreIdArray) && count($ignoreIdArray)>0){
				$ignoreIdStr=implode(',',$ignoreIdArray);
				$tmpStr=" and auto_id not in({$ignoreIdStr}) ";
			}
			foreach($keywordsArray as $key=>$vl){
				$vl=trim($vl);
				if($vl!=""){
					
					$sqlItemArr[]="select auto_id,content_name,menu_id,content_link,content_img,content_desc,content_keywords,create_time,recommend,position from {$dao->tables->news} where (content_name like '%{$vl}%' or content_keywords like '%{$vl}%') {$tmpStr}";
				}	
				
			}
			
			$sql=implode(' union ',$sqlItemArr);
			
			$sql.=" order by recommend desc,position asc,create_time desc,auto_id desc limit 0,{$num}";
				
				
				
			$list=$dao->get_datalist($sql);
			if(is_array($list))
			foreach($list as $key=>$vl){
				$list[$key]["content_link"]=$this->getNewsLink($vl);
				if($vl["content_img"]=="")
					$vl["content_img"]="nophoto.jpg";
				if($vl["content_img"]!="")	
					$list[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
				if($vl["content_file"]!="")
					$list[$key]["download_link"]=$global->siteUrlPath."/index.php?acl=download&file&file=".base64_encode($vl["content_file"]);
			}
			
			return $list;	
			
		}
		
	}
	
	//获取上一条及下一条新闻
	function getPrevAndNextRecord($menuId,$newsId,$orderByStr="order by position asc,create_time desc,auto_id desc"){
		global $dao,$global;
		
		/*$tmpList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,create_time from {$dao->tables->news} where menu_id='{$menuId}' and publish='1' and auto_id>'{$newsId}' order by auto_id asc limit 0,1");
		$newsList["prev"]=$tmpList[0];
		
		$tmpList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,create_time from {$dao->tables->news} where menu_id='{$menuId}' and publish='1' and auto_id<'{$newsId}' order by auto_id desc limit 0,1");
		
		$newsList["next"]=$tmpList[0];*/
		
		
		$newsList=array();
		$tmp=$dao->get_datalist("select auto_id from {$dao->tables->news} where menu_id='{$menuId}' and publish='1' {$orderByStr} limit 0,10000");
		
		if(is_array($tmp))
		foreach($tmp as $key=>$vl){
			if($vl["auto_id"]==$newsId){	
				if($key>0){
					$prevId=$tmp[$key-1]["auto_id"];
					$tmpList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,create_time from {$dao->tables->news} where auto_id='{$prevId}'");
					$newsList["prev"]=$tmpList[0];	
				}
				if($key<count($tmp)-1){
					$nextId=$tmp[$key+1]["auto_id"];
					$tmpList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,create_time from {$dao->tables->news} where auto_id='{$nextId}'");
					$newsList["next"]=$tmpList[0];
				}	
			}
		}	
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			if(!is_array($vl)) continue;
			$newsList[$key]["content_link"]=$this->getNewsLink($vl);
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
			$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
		}
		
		return $newsList;
	}
	
	function getNewsLink($newsRecord){
		global $global,$dao;
		
		$link=$global->siteUrlPath."/index.php?menu={$newsRecord["menu_id"]}&id={$newsRecord["auto_id"]}";
		
		if($newsRecord["content_link"]!=""){//如果存在外链
			if(preg_match('/^http(s)?:\/\//i',$newsRecord["content_link"]) || preg_match('/^javascript:/i',$newsRecord["content_link"]) || preg_match('/^#/i',$newsRecord["content_link"])){
				$link=$newsRecord["content_link"];
			}else{
				$link=$global->siteUrlPath."/".$newsRecord["content_link"];
			}
		}else{//没有采用外链的情况
			
			//如果采用静态化
			if(CONFIG_STATIC_HTML){
				$pathRecord=$dao->get_row_by_where($dao->tables->define_url,"where data_id='{$newsRecord["auto_id"]}' and acl='news' and file_name!=''");
				if(is_array($pathRecord)){
					$link=$global->siteUrlPath.$pathRecord["url_path"]."/".$pathRecord["file_name"];
				}
			}
		}
		
		return $link;
		
	}
	
	
}
?>