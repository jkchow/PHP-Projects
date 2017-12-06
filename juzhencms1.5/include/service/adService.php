<?
class adService{
	/*function getAdData($spaceId,$num=1){
		
		global $dao,$global;
		//获取广告位（宽度及高度信息）
		$space=$dao->get_row_by_where($dao->tables->ad_space,"where auto_id='{$spaceId}'");
		
		if($space["menu_case"]=="1"){//如果广告位设置显示与栏目关联,则需要查询相关栏目下的广告
			//默认使用全局变量获取当前聚焦的栏目
			global $local_menu;
			$menu_id=$local_menu["auto_id"];
			
			$menu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$menu_id}'");
			
			//获取栏目code
			if(is_array($menu)){
				$menu_code=$menu["auto_code"];
				$sql_arr=array();
				for($i=4;$i<=strlen($menu_code);$i=$i+4){
					$tmp_code=substr($menu_code,0,$i);
					$sql_arr[]="auto_code='{$tmp_code}'";
				}
				
				$whereCode=" and (".implode(' or ',$sql_arr).") ";
			
				$menuList=$dao->get_datalist("select auto_id from {$dao->tables->menu} where 1=1 {$whereCode} order by length(auto_code) asc");
				
				if(is_array($menuList)){
					foreach($menuList as $key=>$vl){
						$tmpArr[]=$vl["auto_id"];
					}
					//查询的栏目范围是当前栏目及上级（多个，直到顶级）栏目
					$whereMenu=" and menu_id in (".implode(',',$tmpArr).")";
					
					//优先显示当前栏目的广告，如果没有则显示上一级，以此类推
					$tmpSQL="select content_name,content_link,content_file from {$dao->tables->ad} where space_id='{$spaceId}' {$whereMenu} and publish='1'  order by instr(',".implode(',',$tmpArr).",',concat(',',menu_id,',')) desc,position asc,auto_id asc limit 0,{$num}";
					$adList=$dao->get_datalist($tmpSQL);
					
				}	
			}
		}
		
		if(!is_array($adList))
			$adList=$dao->get_datalist("select content_name,content_link,content_file from {$dao->tables->ad} where space_id='{$spaceId}' and publish='1' order by position asc,auto_id asc limit 0,{$num}");
		
		
		if(is_array($adList)){
			foreach($adList as $key=>$vl){
				$adList[$key]["content_file"]=$global->uploadUrlPath.$vl["content_file"];
				if($space["content_width"]!="" && $space["content_width"]!="0")
					$adList[$key]["content_width"]=$space["content_width"];
				if($space["content_height"]!="" && $space["content_height"]!="0")
					$adList[$key]["content_height"]=$space["content_height"];
			}
		}
		
		return $adList;
	}*/
	function getAdData($spaceId,$num=1){
		
		global $dao,$global;
		$cacheId="ad_getAdData_{$spaceId}_{$num}";
		$adList=cache::getData($cacheId);
		if(!$adList){
		
			//获取广告位（宽度及高度信息）
			$space=$dao->get_row_by_where($dao->tables->ad_space,"where auto_id='{$spaceId}'");
			
			if($space["menu_case"]=="1"){//如果广告位设置显示与栏目关联,则需要查询相关栏目下的广告
				//默认使用全局变量获取当前聚焦的栏目
				global $local_menu;
	
				//$menu_id=$local_menu["auto_id"];
				
				
				$tmpMenu=$local_menu;
				
				$cacheId="ad_getAdData_{$spaceId}_{$num}_{$tmpMenu["auto_id"]}";
				$adList=cache::getData($cacheId);
				if($adList){
					return $adList;
				}
				
				
				$tmpSQL="select content_name,content_link,content_file,code_str from {$dao->tables->ad} where space_id='{$spaceId}' and menu_id='{$tmpMenu["auto_id"]}' and publish='1' order by position asc,auto_id asc limit 0,{$num}";
				
				$adList=$dao->get_datalist($tmpSQL);
				
				while(!is_array($adList)){
					
					
					$tmpSQL="select content_name,content_link,content_file,code_str from {$dao->tables->ad} where space_id='{$spaceId}' and menu_id='{$tmpMenu["pid"]}' and publish='1' order by position asc,auto_id asc limit 0,{$num}";
					$adList=$dao->get_datalist($tmpSQL);
					if(is_array($adList) || $tmpMenu["pid"]=="0"){
						break;
					}else{
						$tmpMenu=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$tmpMenu["pid"]}'",array("auto_id","pid"));
					}		
				
				}
			}else{
				$adList=$dao->get_datalist("select content_name,content_link,content_file,code_str from {$dao->tables->ad} where space_id='{$spaceId}' and publish='1' order by position asc,auto_id asc limit 0,{$num}");
			}
			
			if(is_array($adList)){
				foreach($adList as $key=>$vl){
					$adList[$key]["content_file"]=$global->uploadUrlPath.$vl["content_file"];
					if($space["content_width"]!="" && $space["content_width"]!="0")
						$adList[$key]["content_width"]=$space["content_width"];
					if($space["content_height"]!="" && $space["content_height"]!="0")
						$adList[$key]["content_height"]=$space["content_height"];
				}
			}
			cache::setData($cacheId,$adList);
			
		}
		
		return $adList;
	}
	
	function getImgAd($spaceId){
		
		$adList=$this->getAdData($spaceId,1);
		
		$ad=$adList[0];
		
		if(is_array($ad)){
			if($ad["content_width"]!=""){
				$width="width=\"{$ad["content_width"]}\"";
			}
			if($ad["content_height"]!=""){
				$height="height=\"{$ad["content_height"]}\"";
			}
			$ad_html="<img src=\"{$ad["content_file"]}\" {$width} {$height}  />";
			
			if($ad["content_link"]!=""){
				$ad_html="<a href=\"{$ad["content_link"]}\" target=\"_blank\">{$ad_html}</a>";
			}
			
			return $ad_html;
			
		}
		
        
	}
	
}
?>