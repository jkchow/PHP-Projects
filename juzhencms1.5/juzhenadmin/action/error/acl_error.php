<?

class acl_error extends acl_base{
	var $default_method="error404";
	function error404(){
		$this->tpl_file="404.php";
		$record=array();
		return $record;
	}
	function noPermission(){
		$this->tpl_file="noPermission.php";
	}
}

?>