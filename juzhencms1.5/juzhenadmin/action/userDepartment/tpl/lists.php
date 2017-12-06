<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    
    <script type="text/javascript">
		var acl="<?=$_REQUEST["acl"]?>";
		var grid;
		var dataUrl="?acl="+acl+"&method=treeGridJsonData";
		var collapseFlag=false;//是否叶子节点在关闭状态
        $(function () {	
            grid = $("#maingrid").ligerGrid({
                //checkbox: true,//有树形结构存在，复选框无法使用
				enabledSort:false,
				columns: [
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
                { display: '部门名称', name: 'name', minWidth: 100,align:'left' },
				//{ display: '创建人', name: 'create_user' },
                { display: '创建时间', name: 'create_time' },
				{ display: '操作', isSort: false, width: 120, render: function (rowdata, rowindex, value)
					{
						var h = "";
						h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>修改</a> ";
						h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
						return h;
					}
                }

                ],  pageSize:15,pageSizeOptions: [5, 10, 15, 20],
				url:dataUrl,
                width: '100%',height:'100%',rownumbers:true,						   
											   
											   
                
                onSelectRow: function (rowdata, rowindex)
                {
					//alert(rowindex);
                },
                alternatingRow: false, tree: { columnName: 'name'}, checkbox: false,
                autoCheckChildren: false,
				onAfterShowData:function(){
					if(collapseFlag)
						grid.collapseAll();
				}

            });
			
            $("#pageloading").hide();
        });
        
		
		function add_record(){
			var url="?acl="+acl+"&method=form";
			CmsTools.pageJump(url);
		}
		function edit_record(recordID){
			if(recordID!=null){
				var url="?acl="+acl+"&method=form&auto_id="+recordID;
				CmsTools.pageJump(url);
			}else{
				var rows=grid.getSelectedRows();
				if(rows!=null){
					if(rows.length==0){
						alert("请先选择要编辑的行");
						return;
					}else if(rows.length>1){
						alert("只能选择一行进行编辑");
						return;
					}else{
						var rowdata = grid.getSelectedRow();
						var url="?acl="+acl+"&method=form&auto_id="+rowdata.auto_id;
						CmsTools.pageJump(url);
					}		
				}else{
					alert("请先选择要编辑的行");
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
		
		function up()
        {
            var rows=grid.getSelectedRows();
			if(rows!=null){
				if(rows.length==0){
					alert("请先选择要排序的行");
					return;
				}else if(rows.length>1){
					alert("只能选择一行进行排序");
					return;
				}	
			}
			var row = grid.getSelected();
			$.ajax({
			   type: "get",
			   url: "?acl="+acl+"&method=position_up&auto_id="+row.auto_id
			});
			collapseFlag=false;
            grid.up(row);
			collapseFlag=true;
        }
		
        function down()
        {
            var rows=grid.getSelectedRows();
			if(rows!=null){
				if(rows.length==0){
					alert("请先选择要排序的行");
					return;
				}else if(rows.length>1){
					alert("只能选择一行进行排序");
					return;
				}	
			}
			var row = grid.getSelected();
			$.ajax({
			   type: "get",
			   url: "?acl="+acl+"&method=position_down&auto_id="+row.auto_id
			});
			collapseFlag=false;
            grid.down(row);
			collapseFlag=true;
        }
		function collapseAll()
        {
            grid.collapseAll();
        }
        function expandAll()
        {
            grid.expandAll();
        }
		
		
		//返回
		function goBack(){
			location.href="index.php?acl=userLevel";
		}
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="修改" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    <input type="button" value="上移" class="l-button l-button-submit" onclick="up()"/>
    <input type="button" value="下移" class="l-button l-button-submit" onclick="down()"/>
    <input type="button" value="展开" class="l-button l-button-submit" onclick="expandAll()"/>
    <input type="button" value="收缩" class="l-button l-button-submit" onclick="collapseAll()"/> 
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
    <input type="button" value="返回" id="btnAdd" class="l-button l-button-submit" onclick="goBack()"/>
    
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
 
</body>
</html>
