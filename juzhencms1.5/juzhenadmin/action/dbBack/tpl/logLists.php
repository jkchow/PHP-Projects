<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript">
        var acl="<?=$_REQUEST["acl"]?>";
		var grid = null;
		var dataUrl="?acl="+acl+"&method=logListsData";
		
        $(function () {		
            grid = $("#maingrid").ligerGrid({
                checkbox: false,
				columns: [
                { display: '操作', name: 'c1', minWidth: 100,align:'center' }, 
                { display: '文件名', name: 'c2', minWidth: 100 },
				{ display: '操作结果', name: 'c3', minWidth: 100 },
                { display: '时间', name: 'c0' }
                ],  pageSize:20,
				url:dataUrl,
				enabledSort:false,
				clickToEdit: false,
				enabledEdit: false,
                width: '100%',height:'100%',rownumbers:true

            });
            $("#pageloading").hide();
				
        });
		
		function goBack(){
			CmsTools.jumpBack();
		}
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="返回" class="l-button l-button-submit" onclick="goBack()"/> 
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
</body>
</html>
