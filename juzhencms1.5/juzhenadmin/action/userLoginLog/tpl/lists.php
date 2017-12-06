<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    
    <script type="text/javascript">
        var grid = null;
		var dataUrl="?acl=userLoginLog&method=listsData";

		var grid;
        $(function () {
					
					
            grid = $("#maingrid").ligerGrid({
                //checkbox: true,
				columns: [
                { display: "用户ID", name: 'user_id',width: 120  }, 
                { display: '用户名', name: 'content_user',align: 'center', minWidth: 120 }, 
				{ display: '姓名', name: 'content_name', minWidth: 100 },
                { display: '登录时间', name: 'create_time' }

                ],  pageSize:20,url:dataUrl,rownumbers:true,
                width: '100%',height:'100%'

            });
            $("#pageloading").hide();
        });

		
		
        function f_search()
        {
            var formData=$("#searchForm").serialize();	
			grid.options.url = dataUrl+"&"+formData;
            grid.loadData();
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
        <option value="content_name">姓名</option>
        <option value="user_id">用户ID</option>
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
