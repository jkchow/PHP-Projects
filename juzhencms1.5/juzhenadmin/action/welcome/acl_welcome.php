<?

class acl_welcome extends acl_base{
	var $default_method="welcome";
	function welcome(){
		$record=array();
		$record["user"]=$this->getLoginUser();
		
		$this->tpl_file="welcome.php";
		return $record;
	}
	
	function about(){
		$this->tpl_file="about.php";
	}
	function environmentTest(){
		$this->tpl_file="environmentTest.php";
	}
}

?>