<?
class magazineItemService{
	
	
	function getData($id){
		global $dao,$global;
		$data=$dao->get_row_by_where($dao->tables->magazine_item,"where auto_id='{$id}'");
		if($data["content_file"]!="")	
			$data["download_link"]=$global->siteUrlPath."/index.php?acl=download&file&file=".base64_encode($data["content_file"]);

			
		return $data;
	}
	
	function listsPage($menuId,$magazineId,$pagesize=16){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->magazine_item} where magazine_id='{$magazineId}' ";
		
		$orderby=" order by position asc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,magazine_id,content_name,content_file,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?menu={$menuId}&method=itemDetail&id={$vl["auto_id"]}";
			if($vl["content_file"]!=""){
				$list[$key]["download_link"]=$global->siteUrlPath."/index.php?acl=download&file&file=".base64_encode($vl["content_file"]);
			}
				
				
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