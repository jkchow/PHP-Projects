<?
class topicArticleService{
	function getArticle($menuId){
		global $dao,$global;
		$article=$dao->get_row_by_where($dao->tables->topic_article,"where menu_id='{$menuId}' ");
		//$article["content_desc"]=$this->get_textarea_string($article["content_desc"]);
		if($article["content_img"]=="")
			$article["content_img"]="nophoto.jpg";
		if($article["content_img"]!="")	
			$article["content_img"]=$global->uploadUrlPath.$article["content_img"];
		return $article;
	}
	
	private function get_textarea_string($str){
		$return_str="";
		$text_arr=explode("\n",trim($str,"\n"));
		$line_count=count($text_arr);
		foreach($text_arr as $key=>$vl){
			if($key<$line_count-1)
				$return_str.=str_replace(" ","&nbsp;&nbsp;",$vl)."<br/>";
			else $return_str.=str_replace(" ","&nbsp;&nbsp;",$vl);
		}
		return $return_str;
	}
}
?>