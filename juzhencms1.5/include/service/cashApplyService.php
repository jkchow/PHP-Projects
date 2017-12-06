<?
class cashApplyService{

	
	function listsPage($pagesize=16){
		global $dao,$global;
		
		$memberService=new memberService();
		$member_id=$memberService->getLoginMemberInfo("auto_id");
		
		
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;

		$where=" from {$dao->tables->cash_apply} where member_id='{$member_id}' ";
		
		$orderby=" order by auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=member&method=cashApplyDetail&id={$vl["auto_id"]}";
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		
		
		$page_class=new page_class();
		$page_class->page_size=$pagesize;
		$page_class->init($total);
		$pageBar=$page_class->getPageBar();
		
		$record=array();
		$record["list"]=$list;
		$record["page"]=$pageBar;
		return $record;
	}
	
	
	
}
?>