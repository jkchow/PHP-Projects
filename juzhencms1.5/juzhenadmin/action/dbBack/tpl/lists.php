<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript">
        var acl="<?=$_REQUEST["acl"]?>";
		var grid = null;
		var dataUrl="?acl="+acl+"&method=listsData";
		
		var grid;
        $(function () {		
            grid = $("#maingrid").ligerGrid({
                checkbox: true,
				columns: [
                { display: '文件名', name: 'file_name', minWidth: 100,align:'center' }, 
                { display: '文件大小', name: 'file_size', minWidth: 100 },
                { display: '创建时间', name: 'modify_time' },
				{ display: '操作', isSort: false, width: 160, render: function (rowdata, rowindex, value){
						var h = "";
						h += "<a href='javascript:restore_record(\"" + rowdata.file_name + "\")'>数据恢复</a> ";
						
						var file=rowdata.file_name;
						var base64=new Base64();
						var en=base64.Encode64(file);
						h += "<a href='index.php?acl="+acl+"&method=downloadDbFile&file="+en+"'>下载</a> "; 
						//h += "<a href='../file/db_back/"+file+"' target='download_frame'>下载</a> "; 
						h += "<a href='javascript:delete_record(\"" + rowdata.file_name + "\")'>删除</a> "; 	
						return h;
					}
                }
                ],  pageSize:20,
				url:dataUrl,
				enabledSort:false,
				clickToEdit: false,
				enabledEdit: false,
                width: '100%',height:'100%',rownumbers:true

            });
            $("#pageloading").hide();
				
        });
		//创建数据库备份
		function add_record(){
			var url="?acl="+acl+"&method=dbBack";
			if(confirm("确认要进行数据库备份操作")){
				$("#pageLoading").show();
				CmsTools.pageJump(url);	
			}
				
		}
		//查看操作日志
		function view_log(){
			var url="?acl="+acl+"&method=logLists";
			CmsTools.pageJump(url,true);	
		}
        
		function restore_record(recordID){
			if(recordID!=null){
				var url="?acl="+acl+"&method=dbRestore&auto_id="+encodeURI(recordID);
				if(confirm("确认要使用此备份覆盖当前数据库？当前的操作不可撤销")){
					$("#pageLoading").show();
					CmsTools.pageJump(url);
				}
					
			}else{
				var rows=grid.getSelectedRows();
				if(rows!=null){
					if(rows.length==0){
						alert("请先选择要恢复的数据备份");
						return;
					}else if(rows.length>1){
						alert("只能选择一行进行操作");
						return;
					}else{
						var rowdata = grid.getSelectedRow();
						var url="?acl="+acl+"&method=dbRestore&auto_id="+encodeURI(rowdata.file_name);
						if(confirm("确认要使用此备份覆盖当前数据库？当前的操作不可撤销")){
							$("#pageLoading").show();
							CmsTools.pageJump(url);
						}
							
					}
				}else{
					alert("请先选择要恢复的数据库备份");
					return;
				}
			}
		}
		function delete_record(recordID){
			if(recordID==null){
				var rows=grid.getSelectedRows();
				if(rows!=null){
					if(rows.length==0){
						alert("请先选择要删除的行");
						return;
					}else{
						var idStr="";
						for(var i=0;i<rows.length;i++){
							idStr+=rows[i].auto_id+",";
						}
						recordID=idStr;	
					}		
				}else{
					alert("请先选择要删除的行");
					return;
				}	
			}
			if(recordID!=null){
				if(confirm("确认要删除所选数据？")){
					$.ajax({
					  	url: "?acl="+acl+"&method=delete&auto_id="+recordID,
					  	dataType:'json',
					  	success: function(data){
							grid.loadData();
						}
					});
				}	
			}
		}
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="创建备份" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="数据恢复" id="btnEdit" class="l-button l-button-submit" onclick="restore_record()"/>
    <input type="button" value="操作日志" id="btnEdit" class="l-button l-button-submit" onclick="view_log()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
<iframe name="download_frame" id="download_frame" src="about:_blank" frameborder="0" scrolling="no" marginwidth="0"  width="0px" height="0px" allowtransparency="true"></iframe>
<div id="pageLoading" class='l-panel-loading' style='display:none;'></div>
</body>
</html>
