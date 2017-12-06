<?
class acl_article extends base_acl{
	var $default_method="detail";
	function detail(){
		$this->tpl_file="article.php";
		$record=array();
		return $record;
	}
	
}
?>