<?
class acl_search extends base_acl{
	var $default_method="search_list";
	function search_list(){
		global $top_menu_focus;
		$top_menu_focus=false;
		$this->tpl_file="search_list.php";
		$record=array();
		//新闻，视频，期刊，会议
		$_GET["keywords"]=trim($_GET["keywords"]);
		$_GET["type"]=trim($_GET["type"]);
		
		$searchService=new searchService();
		$record["search_result"]=$searchService->listsPage($_GET["keywords"],$_GET["type"]);
		
		return $record;
	}
}
?>