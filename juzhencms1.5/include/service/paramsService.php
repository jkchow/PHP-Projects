<?
class paramsService{
	static $params;
	function getParamValue($name,$moduleName="global"){
		if($name=="") return;
		if($moduleName==""){
			$moduleName="global";
		}
		if(!isset(paramsService::$params[$moduleName][$name])){
			global $dao;
			$record=$dao->get_row_by_where($dao->tables->params,"where content_name='{$name}' and content_module='{$moduleName}'");
			paramsService::$params[$moduleName][$name]=$record["content_value"];
		}
		return paramsService::$params[$moduleName][$name];
	}
	
	function getParams($fields=array(),$moduleName="global"){
		if($fields==NULL || $fields=="") return;
		if($moduleName==""){
			$moduleName="global";
		}
		if(is_string($fields)){
			return $this->getParamValue($fields,$moduleName);
		}elseif(is_array($fields)){
			if(count($fields)==0) return;
			$tmpFields=array();
			$record=array();
			foreach($fields as $key=>$vl){
				if(isset(paramsService::$params[$moduleName][$vl])){
					$record[$vl]=paramsService::$params[$moduleName][$vl];
				}else{
					$tmpFields[]=$vl;
				}
			}
			
			if(count($tmpFields)>0){
				global $dao;
				$tmpArr=array();
				foreach($tmpFields as $key=>$vl){
					$tmpArr[]="'{$vl}'";
				}
				$tmpWhere=" and content_name in (".implode(',',$tmpArr).") and content_module='{$moduleName}' ";
				$dataList=$dao->get_datalist("select * from {$dao->tables->params} where 1 {$tmpWhere}");
				if(is_array($dataList))
				foreach($dataList as $key=>$vl){
					$record[$vl["content_name"]]=$vl["content_value"];
					paramsService::$params[$moduleName][$vl["content_name"]]=$vl["content_value"];
				}
			}
			return $record;	
		}
		
		
	}
	
	
	
	
}
?>