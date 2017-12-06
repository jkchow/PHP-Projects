<?
class commentService{
	function lists($type,$objId,$num=10,$page=1){
		global $dao,$global;
		$begin=($page-1)*$num;
		
		$query_sql="select * from {$dao->tables->comment} where object_id='{$objId}' and content_type='{$type}' and publish='1' order by auto_id desc limit {$begin},{$num}";
		$newsList=$dao->get_datalist($query_sql);
		
		if(is_array($newsList))
		foreach($newsList as $key=>$vl){
			$tmpMember=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$vl["member_id"]}'",array("content_user","content_name","content_head"));
			if($tmpMember["content_head"]==""){
				$tmpMember["content_head"]="default_head.jpg";
			}
			$newsList[$key]["member_head"]=$global->uploadUrlPath.$tmpMember["content_head"];
		}
		return $newsList;
	}
	
	function getCommentNum($type,$objId){
		global $dao,$global;
		$query_sql="select count(auto_id) as total_num from {$dao->tables->comment} where object_id='{$objId}' and content_type='{$type}' and publish='1'";
		$tmp=$dao->get_datalist($query_sql);
		if($tmp[0]["total_num"]!="")
			return $tmp[0]["total_num"];
		else
			return "0";
		
		
	}
	
	
	
	
	
	
}
?>