<?
class linksService{
	function lists($menuId,$num=10){
		global $dao,$global;
		
		$cacheId="links_lists_{$menuId}_{$num}";
		
		$newsList=cache::getData($cacheId);
			
		if(!$newsList){
		
			$query_sql="select auto_id,menu_id,content_name,content_link,content_img from {$dao->tables->links} where menu_id='{$menuId}' and publish='1' order by position asc,auto_id asc limit 0,{$num}";
	
			
			$newsList=$dao->get_datalist($query_sql);
			
			if(is_array($newsList))
			foreach($newsList as $key=>$vl){
				if($vl["content_img"]=="")
					$vl["content_img"]="nophoto.jpg";
				if($vl["content_img"]!="")	
					$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			}
			cache::setData($cacheId,$newsList);
			
		}
		return $newsList;
	}
	
	function listsPage($menuId,$pagesize=16){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->links} where menu_id='{$menuId}' and publish='1' ";
		
		$orderby=" order by position asc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?menu={$vl["menu_id"]}&id={$vl["auto_id"]}";
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$list[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			
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
	
	
}
?>