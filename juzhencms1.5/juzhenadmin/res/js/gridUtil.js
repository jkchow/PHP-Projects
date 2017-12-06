// JavaScript Document
$.ligerDefaults.Grid.formatters['publishVars'] = function (value, column) {		
	//value 当前的值
	//column 列信息
	if(value=='1')
		return "已发布";
	else
		return "未发布";
};

$.ligerDefaults.Grid.formatters['enumVars'] = function (value, column) {		
	//value 当前的值
	//column 列信息
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