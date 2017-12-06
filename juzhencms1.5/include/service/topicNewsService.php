<?
class topicNewsService{

	
	function lists($menuId,$num=10){
		global $dao,$global,$topicId;
		$newsList=$dao->get_datalist("select auto_id,menu_id,content_name,content_subname,content_link,content_desc,content_img,content_file,create_time from {$dao->tables->topic_news} where menu_id='{$menuId}' and publish='1' order by auto_position desc,create_time desc,auto_id desc limit 0,{$num}");
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			if($vl["content_link"]=="")
				$newsList[$key]["content_link"]="?topicMenu={$vl["menu_id"]}&id={$vl["auto_id"]}";
			if($vl["content_img"]!="")	
				$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
		}
		return $newsList;
	}
	
	
	
	function listsPage($menuId,$pagesize=16){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		

		
		$where=" from {$dao->tables->topic_news} where menu_id='{$menuId}' and publish='1' ";
		
		$orderby=" order by recommend desc,auto_position desc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,content_name,content_subname,menu_id,content_img,content_file,content_desc,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]="?topicMenu={$vl["menu_id"]}&id={$vl["auto_id"]}";
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$list[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			if($vl["content_file"]!="")
				$list[$key]["download_link"]=$global->siteUrlPath."/index.php?acl=download&method=memberDownloadFile&file=".base64_encode($vl["content_file"]);
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
	
	function getData($id){
		global $dao;
		$data=$dao->get_row_by_where($dao->tables->topic_news,"where auto_id='{$id}'");
		return $data;
	}
	
	
}
?>