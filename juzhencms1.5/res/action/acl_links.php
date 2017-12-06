<?
class acl_links extends base_acl{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="links.php";
		$record=array();
		return $record;
	}
}
?>