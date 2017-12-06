<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript">
        var acl="<?=$_REQUEST["acl"]?>";
		var grid = null;
		var dataUrl="?acl="+acl+"&method=listsData";
		
        $(function () {			
            grid = $("#maingrid").ligerGrid({
                checkbox: true,
				columns: [
                { display: 'ID', name: 'auto_id', align: 'center', width: 65 },
                { display: '用户ID', name: 'user_id', minWidth: 100,align:'center' }, 
                { display: '用户名', name: 'content_user', minWidth: 100 },
				{ display: '姓名', name: 'content_name', minWidth: 100 },
				{ display: 'acl', name: 'acl', minWidth: 100 },
				{ display: 'method', name: 'method', minWidth: 100 },
				{ display: 'IP地址', name: 'ip', minWidth: 100},
                { display: '时间', name: 'create_time', width: 165 },
				{ display: '操作', isSort: false, minWidth: 60, render: function (rowdata, rowindex, value)
                {
                    var h = "";
					//h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>编辑</a> ";
					h += "<a href='javascript:view_record(" + rowdata.auto_id + ")'>查看</a> ";
                    //h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
                    return h;
                }
                }

                ],  pageSize:20,
				url:dataUrl,
				enabledSort:false,
				clickToEdit: true,
				enabledEdit: true,
                width: '100%',height:'100%',rownumbers:true,
				onBeforeSubmitEdit:function(param){
					var row = param.record;
					$.ajax({
					   type: "get",
					   url: "?acl="+acl+"&method=savePosition&auto_id="+row.auto_id+"&position="+param.value,
					   success:function(){
					   		grid.loadData();
					   }
					});
				}

            });
            $("#pageloading").hide();
			
			//设定字典变量的筛选条件
			CmsTools.setSelectOptions({selectId:"resultSelect",vars:enumVars.successVars,emptyText:"不限"});
        });
        function f_search()
        {
         	var formData=$("#searchForm").serialize();	
			grid.options.url = dataUrl+"&"+formData;
            grid.loadData();
        }
		
		
		
		function view_record(recordID){
			if(recordID!=null){
				var url="?acl="+acl+"&method=view&auto_id="+recordID;
				//CmsTools.pageJump(url);
				window.open(url,"userLogView"+recordID);
			}
		}
		
		
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:100px;">
    	<option value="content_user">用户名</option>
        <option value="content_user">姓名</option>
        <option value="ip">IP地址</option>
        <option value="acl">acl</option>
        <option value="method">method</option>
    </select>
    <input name="searchKeyword" type="text" /> 
    &nbsp;
    <input type="button" value="搜索" id="btnSearch" class="l-button l-button-submit" onclick="f_search()" /> 
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
 
</body>
</html>
