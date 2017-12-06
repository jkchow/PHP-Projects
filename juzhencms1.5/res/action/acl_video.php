<?
class acl_video extends base_acl{
	var $default_method="videoPlayer";

	function videoPlayer(){
		global $global;
		$global->tplAbsolutePath=$global->absolutePath."/res/tpl/system/videoPlayer/";
		$global->tplUrlPath=$global->siteUrlPath."/res/tpl/system/videoPlayer/";
		$this->tpl_file="videoPlayer.php";
		$record=array();
		return $record;
	}
	
	
	
	
}
?>