<?

class acl_vars extends acl_base{
	var $default_method="jsEnumVars";
	//��js�����ķ�ʽ���ϵͳ�����������������������ݿ�������ֵ䣩
	function jsEnumVars(){
		global $enumVars;
		echo "var enumVars=".json_encode($enumVars).";";
	}
	//��json��ʽ��ȡ
	function getDictionaryVars(){
		global $dao;
		$varName=$_GET["var"];
		$dictionary=$dao->get_row_by_where($dao->tables->dictionary,"where content_name='{$varName}'");
		$dictionaryVar=$dao->get_datalist("select content_value as id,content_text as text from {$dao->tables->dictionary_item} where dictionary_id='{$dictionary["auto_id"]}' and publish='1'  order by position asc,auto_id asc");
		echo json_encode($dictionaryVar);
	}
}

?>