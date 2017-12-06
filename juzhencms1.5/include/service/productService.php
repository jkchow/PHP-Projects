<?
class productService{
	
	function lists($params){
		global $dao,$global;
		
		$sql_str="";
		if($params["recommend"]=="1")
			$sql_str.=" and recommend='1' ";
		if($params["content_status"]!="")
			$sql_str.=" and content_status='{$params["content_status"]}' ";
		if($params["content_org"]!="")
			$sql_str.=" and content_org like '%{$params["content_org"]}%' ";		
		if($params["member_id"]!="")
			$sql_str.=" and member_id='{$params["member_id"]}' ";
		if($params["buy_minmoney_type"]!="")
			$sql_str.=" and buy_minmoney_type='{$params["buy_minmoney_type"]}' ";
		if($params["during_days_type"]!="")
			$sql_str.=" and during_days_type='{$params["during_days_type"]}' ";
		if($params["year_earnings_type"]!="")
			$sql_str.=" and year_earnings_type='{$params["year_earnings_type"]}' ";
		if($params["earnings_type"]!="")
			$sql_str.=" and earnings_type='{$params["earnings_type"]}' ";
		if(is_array($params["except_id"]) && count($params["except_id"])>0){
			$tmpstr=implode(',',$params["except_id"]);
			$sql_str.=" and auto_id not in({$tmpstr}) ";
		}
		if($params["org_letter"]!=""){
			$tmplist=$dao->get_datalist("select auto_id from {$dao->tables->member} where content_type in(2,3) and first_letter='{$params["org_letter"]}'");
			if(is_array($tmplist)){
				$tmparr=array();
				foreach($tmplist as $key=>$vl){
					$tmparr[]=$vl["auto_id"];
				}
				$tmpstr=implode(',',$tmparr);
				$sql_str.=" and member_id in({$tmpstr}) ";
				
			}else{
				$sql_str.=" and 1=0 ";
			}
			
		}
			
		
		
		if($params["num"]=="")
			$num=10;
		else
			$num=$params["num"];
		
		$newsList=$dao->get_datalist("select auto_id,member_id,content_org,content_name,content_type,content_moneytype,content_status,during_days,year_earnings,buy_minmoney,earnings_type,create_time from {$dao->tables->product} where publish='1' {$sql_str}  order by position asc,create_time desc,auto_id desc limit 0,{$num}");
			
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			if($vl["content_link"]=="")
				$newsList[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=product&method=detail&id={$vl["auto_id"]}";
		}
		return $newsList;
	}
	
	function getData($id){
		global $dao;
		$data=$dao->get_row_by_where($dao->tables->product,"where auto_id='{$id}'");
		return $data;
	}
	
	
	
	function listsPage($params){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		
		
		if($params["pagesize"]=="")
			$pagesize=10;
		else
			$pagesize=$params["pagesize"];
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->product} where publish='1' ";
		
		
		
		if($params["recommend"]=="1")
			$where.=" and recommend='1' ";
		if($params["content_status"]!="")
			$where.=" and content_status='{$params["content_status"]}' ";
		if($params["content_org"]!="")
			$where.=" and content_org like '%{$params["content_org"]}%' ";		
		if($params["member_id"]!="")
			$where.=" and member_id='{$params["member_id"]}' ";
		if($params["buy_minmoney_type"]!="")
			$where.=" and buy_minmoney_type='{$params["buy_minmoney_type"]}' ";
		if($params["during_days_type"]!="")
			$where.=" and during_days_type='{$params["during_days_type"]}' ";
		if($params["year_earnings_type"]!="")
			$where.=" and year_earnings_type='{$params["year_earnings_type"]}' ";
		if($params["earnings_type"]!="")
			$where.=" and earnings_type='{$params["earnings_type"]}' ";
		
		
		
		
		$orderby=" order by recommend desc,position asc,create_time desc,auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,member_id,content_org,content_name,content_type,content_moneytype,content_status,during_days,year_earnings,earnings_type,buy_minmoney,sell_begindate,sell_enddate,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			if($vl["content_link"]=="")
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=product&method=detail&id={$vl["auto_id"]}";
			
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