<?
class acl_news extends base_acl{
	var $default_method="lists";
	
	function lists(){
		$this->tpl_file="newslist.php";
		$record=array();
		return $record;
	}

	
	
	function searchlists(){
		$this->tpl_file="searchlist.php";
		$record=array();
		return $record;
	}
	
	function piclists(){
		$this->tpl_file="piclist.php";
		$record=array();
		return $record;
	}
	
	function news(){
		$this->tpl_file="news.php";
		$record=array();
		return $record;
	}
	
	function topicNewsLists(){
		$this->tpl_file="topic_news_list.php";
		$record=array();
		return $record;
	}
	
	function detail(){
		global $dao,$global_params;
		//增加点击量
		
		$i=0;
		$r=rand(0,3);
		if($r==3)
			$i=rand(0,5);
		
		$dao->query("update {$dao->tables->news} set content_hit=content_hit+{$i} where auto_id='{$_GET["id"]}'");
		$this->tpl_file="newsinfo.php";
		$record=array();
		$newsService=new newsService();
		$newsInfo=$newsService->getData($_GET["id"]);
		$record["newsData"]=$newsInfo;
		$record["title"]=$newsInfo["content_name"];
		
		if($newsInfo["seo_keywords"]!="")
			$global_params["seo_keywords"]=$newsInfo["seo_keywords"];
		if($newsInfo["seo_description"]!="")	
			$global_params["seo_description"]=$newsInfo["seo_description"];
		
		return $record;
	}
	
	
}
?>