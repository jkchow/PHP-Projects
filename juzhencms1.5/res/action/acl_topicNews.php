<?
class acl_topicNews extends base_acl{
	var $default_method="lists";

	function lists(){
		$this->tpl_file="topicNewslist.php";
		$record=array();
		return $record;
	}
	
	
	
	
	function detail(){
		global $dao;
		//增加点击量
		
		$i=0;
		$r=rand(0,3);
		if($r==3)
			$i=rand(0,5);
		
		$dao->query("update {$dao->tables->topic_news} set content_hit=content_hit+{$i} where auto_id='{$_GET["id"]}'");
		$this->tpl_file="topicNewsinfo.php";
		$record=array();
		return $record;
	}
	
	
}
?>