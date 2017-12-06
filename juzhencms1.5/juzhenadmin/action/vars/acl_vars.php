<?

class acl_vars extends acl_base{
	var $default_method="jsEnumVars";
	//以js变量的方式输出系统环境变量（不包含存在数据库的数据字典）
	function jsEnumVars(){
		global $enumVars;
		echo "var enumVars=".json_encode($enumVars).";";
	}
	//以json方式获取
	function getDictionaryVars(){
		global $dao;
		$varName=$_GET["var"];
		$dictionary=$dao->get_row_by_where($dao->tables->dictionary,"where content_name='{$varName}'");
		$dictionaryVar=$dao->get_datalist("select content_value as id,content_text as text from {$dao->tables->dictionary_item} where dictionary_id='{$dictionary["auto_id"]}' and publish='1'  order by position asc,auto_id asc");
		echo json_encode($dictionaryVar);
	}
}

?>