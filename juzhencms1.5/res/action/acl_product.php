<?
class acl_product extends base_acl{
	var $default_method="lists";

	function lists(){
		global $top_menu_focus;
		$top_menu_focus=false;
		$this->tpl_file="prolist.php";
		$record=array();
		return $record;
	}
	
	function detail(){
		global $top_menu_focus;
		$top_menu_focus=false;
		//增加点击量
		
		global $dao;
		$dao->query("update {$dao->tables->product} set content_hit=content_hit+1 where auto_id='{$_GET["id"]}'");
		$this->tpl_file="proinfo.php";
		$record=array();
		return $record;
	}
	
	//ajax载入推荐产品的html
	function ajaxRecommendProductlists(){
		global $global,$dao;
		$productService=new productService();
		$param=array();
		$param["num"]=8;
		
		if($_GET["org_letter"]!=""){
			$param["org_letter"]=$_GET["org_letter"];
		}
		if($_GET["during_days_type"]!=""){
			$param["during_days_type"]=$_GET["during_days_type"];
		}
		if($_GET["earnings_type"]!=""){
			$param["earnings_type"]=$_GET["earnings_type"];
		}
		
		$list=$productService->lists($param);
		
		$DictionaryVars=new DictionaryVars();
		//认购币种
		//$moneyTypeVars=$DictionaryVars->getVars("moneyTypeVars");
		//收益类型
		$earningsTypeVars=$DictionaryVars->getVars("earningsTypeVars");
		
		?>
        
<table width="100%" border="0">
  <?
  if(is_array($list))
  foreach($list as $key=>$vl){
	  $tmpMember=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$vl["member_id"]}'",array("content_img"));
	  if($tmpMember["content_img"]=="")
	  	$tmpMember["content_img"]="nophoto.jpg";
	  $tmpMember["content_img"]=$global->uploadUrlPath.$tmpMember["content_img"];
	  
	  
  ?>
  <tr>
    <td class="wd50"><span class="<?=$key<=2?"cr":"ranks"?>"><?=$key+1?></span></td>
    <td class="wd140"><span class="pro-imgs"><img src="<?=$tmpMember["content_img"]?>" width="100" height="50" /></span></td>
    <td><span class="remmed-tit"><a href="<?=$vl["content_link"]?>"><?=mb_substr($vl["content_name"],0,30,"utf-8")?></a></span>
       <div class="param-css"><em><?=$vl["buy_minmoney"]?>万起投</em><em><?=$vl["during_days"]?>天</em><em><?=$DictionaryVars->getText($earningsTypeVars,$vl["earnings_type"])?></em></div>
</td>
    <td class="wd130">预计年化收益
    <div class="percent"><?=$vl["year_earnings"]?>%</div>
    </td>
  </tr>
  <?
  }
  ?> 
</table>
        
        <?
		
		
	}
	
}
?>