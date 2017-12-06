<?
class topicLinksService{
	function lists($menuId,$num=10){
		global $dao,$global;
		$query_sql="select auto_id,menu_id,content_name,content_link,content_img from {$dao->tables->topic_links} where menu_id='{$menuId}' and publish='1' order by position asc,create_time desc,auto_id desc limit 0,{$num}";

		
		$newsList=$dao->get_datalist($query_sql);
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			if($vl["content_img"]!="")	
				$newsList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
		}
		return $newsList;
	}
	
	
	
	
}
?>