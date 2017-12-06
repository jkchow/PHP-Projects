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
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
                { display: '标题', name: 'content_title', minWidth: 100,align:'left' }, 
				{ display: '发布状态', name: 'publish', width: 80,type:"enumVars",enumVars:enumVars.publishVars },
				{ display: '排序位置', name: 'position', width: 80 ,align: 'center',
					type: 'int', editor: { type: 'int'}
				},
				{ display: '创建人', name: 'create_user', minWidth: 100 },
                { display: '创建时间', name: 'create_time' },
				{ display: '操作', isSort: false, width: 270, render: function (rowdata, rowindex, value)
                {
                    var h = "";
					
					h += "<a href='javascript:view_question(" + rowdata.auto_id + ")'>题目管理</a> ";
					h += "<a href='javascript:view_result(" + rowdata.auto_id + ")'>结果设定</a> ";
					h += "<a href='javascript:view_record(" + rowdata.auto_id + ")'>答题记录("+rowdata.record_num+")</a> ";
					h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>修改</a> ";
                    h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
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
			CmsTools.setSelectOptions({selectId:"publishSelect",vars:enumVars.publishVars,emptyText:"不限"});
        });
        function f_search()
        {
         	var formData=$("#searchForm").serialize();	
			grid.options.url = dataUrl+"&"+formData;
            grid.loadData();
        }
		
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
		
		//问题管理
		function view_question(recordID){
			var url="?acl=examQuestion&method=lists&pid="+recordID;
			CmsTools.pageJump(url,true);
		}
		
		//结果管理
		function view_result(recordID){
			var url="?acl=examResult&method=lists&pid="+recordID;
			CmsTools.pageJump(url,true);
		}
		
		//查看答题记录
		function view_record(recordID){
			var url="?acl=examRecord&method=lists&pid="+recordID;
			CmsTools.pageJump(url,true);
		}
		
		//预览
		function preview_record(){
			var rows=grid.getSelectedRows();
			if(rows!=null){
				if(rows.length==0){
					alert("请先选择要预览的行");
					return;
				}else if(rows.length>1){
					alert("只能选择一行进行预览");
					return;
				}else{
					var rowdata = grid.getSelectedRow();
					window.open("../index.php?acl=exam&method=question&id="+rowdata.auto_id);
				}		
			}else{
				alert("请先选择要预览的行");
				return;
			}
		}
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="修改" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    <input type="button" value="预览" id="btnPreview" class="l-button l-button-submit" onclick="preview_record()"/>
    &nbsp;
	发布状态：
	<select id="publishSelect" name="publish" style="width:100px;">
    	<option value="">不限</option>
    	<!--<option value="0">未发布</option>
        <option value="1">已发布</option>-->
    </select>
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:100px;">
    	<option value="content_name">名称</option>
        <option value="content_desc">简介</option>
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
