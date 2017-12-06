<?
class acl_error extends base_acl{
	var $default_method="error404";
	function error404(){
		global $global;
		$this->tpl_file="404.php";
		if(!file_exists($global->tplAbsolutePath.$this->tpl_file)){
			echo "你按所访问的页面不存在";
			exit;
		}
		$record=array();
		$record["title"]="页面不存在";
		return $record;
	}
}
?>