// JavaScript Document
$.ligerDefaults.Grid.formatters['publishVars'] = function (value, column) {		
	//value ��ǰ��ֵ
	//column ����Ϣ
	if(value=='1')
		return "�ѷ���";
	else
		return "δ����";
};

$.ligerDefaults.Grid.formatters['enumVars'] = function (value, column) {		
	//value ��ǰ��ֵ
	//column ����Ϣ
	var vars=column.enumVars;
	if(vars){
		var varItems=vars;
		for(var i=0;i<varItems.length;i++){
			var varItem=varItems[i];
			if(varItem.id==value)
				return varItem.text;
		}
	}
};