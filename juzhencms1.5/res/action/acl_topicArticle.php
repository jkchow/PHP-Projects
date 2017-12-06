<?
class acl_topicArticle extends base_acl{
	var $default_method="detail";
	function detail(){
		$this->tpl_file="topicArticle.php";
		$record=array();
		return $record;
	}
}
?>