<?
class DictionaryVars{
	function getVars($dictionaryName){
		global $dao,$global;
		$sql="select i.content_value as id,i.content_text as text,i.content_desc as content_desc from {$dao->tables->dictionary_item} i join {$dao->tables->dictionary} d on d.content_name='{$dictionaryName}' and i.dictionary_id=d.auto_id where i.publish='1' order by i.position asc,i.auto_id asc";
		$list=$dao->get_datalist($sql);
		return $list;
	}
	
	function getVar($dictionaryName,$id){
		global $dao,$global;
		$sql="select i.content_value as id,i.content_text as text,i.content_desc as content_desc from {$dao->tables->dictionary_item} i join {$dao->tables->dictionary} d on d.content_name='{$dictionaryName}' and i.content_value='{$id}' and i.dictionary_id=d.auto_id where i.publish='1' order by i.position asc,i.auto_id asc";
		$list=$dao->get_datalist($sql);
		return $list[0];
	}
	
	function getText($varsArray,$id){
		/*if(is_array($varsArray))
		foreach($varsArray as $key=>$vl){
			if($vl["id"]==$id)
				return $vl["text"];
		}*/
		$var=$this->getItem($varsArray,$id);
		return $var["text"];
	}
	
	function getItem($varsArray,$id){
		if(is_array($varsArray))
		foreach($varsArray as $key=>$vl){
			if($vl["id"]==$id)
				return $vl;
		}
	}
	
	/*function getJsonVars($dictionaryName){
		return json_encode($this->getVars($dictionaryName));
	}*/
}
?>