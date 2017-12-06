<?
class acl_magazine extends base_acl{
	var $default_method="lists";

	function lists(){
		$this->tpl_file="magazine_list.php";
		$record=array();
		return $record;
	}
	
	function detail(){
		$this->tpl_file="magazine_info.php";
		$record=array();
		return $record;
	}
	
	function itemDetail(){
		global $dao;
		//增加点击量
		$i=0;
		$r=rand(0,3);
		if($r==3)
			$i=rand(0,5);
		$dao->query("update {$dao->tables->magazine_item} set content_hit=content_hit+{$i} where auto_id='{$_GET["id"]}'");
		$this->tpl_file="magazineItem_info.php";
		$record=array();
		return $record;
	}
	
	function itemNewsDetail(){
		global $dao;
		//增加点击量
		$i=0;
		$r=rand(0,3);
		if($r==3)
			$i=rand(0,5);
		$dao->query("update {$dao->tables->magazine_item_news} set content_hit=content_hit+{$i} where auto_id='{$_GET["id"]}'");
		$this->tpl_file="magazineItemNews_info.php";
		$record=array();
		return $record;
	}
	
}
?>