<?
class articleService{
	function getArticle($menuId){
		global $dao,$global;
		$article=$dao->get_row_by_where($dao->tables->article,"where menu_id='{$menuId}' ");

		if($article["content_img"]=="")
			$article["content_img"]="nophoto.jpg";
		if($article["content_img"]!="")	
			$article["content_img"]=$global->uploadUrlPath.$article["content_img"];
		if($article["content_video"]!="")	
			$article["content_video"]=$global->uploadUrlPath.$article["content_video"];
		if($article["content_link"]=="")
			$article["content_link"]="index.php?menu={$menuId}";
		return $article;
	}
}
?>