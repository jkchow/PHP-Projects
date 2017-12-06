<?
class searchService{
	

	
	function listsPage($keywords,$type=NULL,$pagesize=16){//type可选参数:news,video,magazine,meeting
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$begin_count=($page-1)*$pagesize;
		
		
		$querySql="";
		$querySql_arr=array();
		$countSql="";
		$countSql_arr=array();
		
		if($type==NULL ||$type=="" || $type=="news"){
			$querySql_arr[]=" select auto_id,menu_id,content_name,create_time from {$dao->tables->news} where content_name like '%{$keywords}%' and publish='1' ";
			$countSql_arr[]=" select count(auto_id) as total from {$dao->tables->news} where content_name like '%{$keywords}%' and publish='1' ";
		}
		
		if($type==NULL||$type=="" || $type=="video"){
			$querySql_arr[]=" select auto_id,menu_id,content_name,create_time from {$dao->tables->video} where content_name like '%{$keywords}%' and publish='1' ";
			
			$countSql_arr[]=" select count(auto_id) as total from {$dao->tables->video} where content_name like '%{$keywords}%' and publish='1' ";
		}
		
		if($type==NULL ||$type==""|| $type=="magazine"){
			$querySql_arr[]=" select auto_id,menu_id,content_name,create_time from {$dao->tables->magazine} where content_name like '%{$keywords}%' and publish='1' ";
			$countSql_arr[]=" select count(auto_id) as total from {$dao->tables->magazine} where content_name like '%{$keywords}%' and publish='1' ";
		}
		
		if($type==NULL ||$type==""|| $type=="meeting"){
			$querySql_arr[]=" select auto_id,menu_id,content_name,create_time from {$dao->tables->meeting} where content_name like '%{$keywords}%' and publish='1' ";
			$countSql_arr[]=" select count(auto_id) as total from {$dao->tables->meeting} where content_name like '%{$keywords}%' and publish='1' ";
		}
		
		$querySql=implode(' union ',$querySql_arr)." order by create_time desc limit {$begin_count},{$pagesize}";
		$countSql=implode(' union ',$countSql_arr);
		

		
		$list=$dao->get_datalist($querySql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]="?menu={$vl["menu_id"]}&id={$vl["auto_id"]}";
		}
		
		$R=$dao->query($count_sql);
		if($R)
		while($v=mysql_fetch_assoc($R)){
			print_r($v);
		} 
		
		
		$list_count=$dao->get_datalist($countSql);
		
		
		$total=0;
		if(is_array($list_count))
		foreach($list_count as $key=>$vl){
			$total+=$vl["total"];
		}

		
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