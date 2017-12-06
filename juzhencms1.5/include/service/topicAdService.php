<?
class topicAdService{
	function getAdData($spaceId,$num=1){
		global $dao,$global,$topicId;
		$adList=$dao->get_datalist("select * from {$dao->tables->topic_ad} where space_id='{$spaceId}' and topic_id='{$topicId}' and publish='1' order by position asc,auto_id asc limit 0,{$num}");
		
		if(is_array($adList))
		foreach($adList as $key=>$vl){
			$adList[$key]["content_file"]=$global->uploadUrlPath.$vl["content_file"];
		}
		return $adList;
	}
	
	function getImgAd($spaceId){
		global $dao,$global,$topicId;
		
		$space=$dao->get_row_by_where($dao->tables->topic_ad_space,"where auto_id='{$spaceId}'");
		
		$adList=$dao->get_datalist("select * from {$dao->tables->topic_ad} where space_id='{$spaceId}' and topic_id='{$topicId}' and publish='1' order by position asc,auto_id asc limit 0,1");
		
		$ad=$adList[0];
		
		if(is_array($ad)){
			$ad["content_file"]=$global->uploadUrlPath.$ad["content_file"];
			$ad_html="<img src=\"{$ad["content_file"]}\" width=\"{$space["content_width"]}\" height=\"{$space["content_height"]}\" />";
			
			if($ad["content_link"]!=""){
				$ad_html="<a href=\"{$ad["content_link"]}\" target=\"_blank\">{$ad_html}</a>";
			}
			
		return $ad_html;	
			
		}
		
        
	}
	
	function getTextAd($spaceId){
		global $dao,$global;
		
		$space=$dao->get_row_by_where($dao->tables->topic_ad_space,"where auto_id='{$spaceId}'");
		
		$adList=$dao->get_datalist("select * from {$dao->tables->topic_ad} where space_id='{$spaceId}' and publish='1' order by position asc,auto_id asc limit 0,1");
		
		$ad=$adList[0];
		
		if(is_array($ad)){
			if($ad["content_link"]!=""){
				$link_html=" href=\"{$ad["content_link"]}\" target=\"_blank\" ";
			}
			$ad_html="<a {$link_html}>{$ad["content_name"]}</a>";
			
			return $ad_html;	
		} 
	}
	
}
?>