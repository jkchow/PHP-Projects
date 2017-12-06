<?
class topicService{
	
	function lists($num=10){
		global $dao,$global;
		$dataList=$dao->get_datalist("select * from {$dao->tables->topic} where publish='1' order by position asc,create_time desc,auto_id desc limit 0,{$num}");
		$dictionaryVars=new DictionaryVars();
		$topicTypeVars=$dictionaryVars->getVars("topicTypeVars");
		
		if(is_array($dataList))
		foreach($dataList as $key=>$vl){
			if($vl["content_link"]=="")
				$dataList[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=topic&method=index&id={$vl["auto_id"]}";
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$dataList[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			$dataList[$key]["content_type"]=$dictionaryVars->getText($topicTypeVars,$vl["content_type"]);
		}
		return $dataList;
	}
	
	
	
	
	
	function getData($id){
		global $dao;
		$data=$dao->get_row_by_where($dao->tables->topic,"where auto_id='{$id}'");
		return $data;
	}
	
	
	
	function listsPage($pagesize=16){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->topic} where publish='1' ";
		
		$orderby=" order by position asc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		
		$dictionaryVars=new DictionaryVars();
		$topicTypeVars=$dictionaryVars->getVars("topicTypeVars");
		
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=topic&method=index&id={$vl["auto_id"]}";
			if($vl["content_img"]=="")
				$vl["content_img"]="nophoto.jpg";
			if($vl["content_img"]!="")	
				$list[$key]["content_img"]=$global->uploadUrlPath.$vl["content_img"];
			$list[$key]["content_type"]=$dictionaryVars->getText($topicTypeVars,$vl["content_type"]);
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