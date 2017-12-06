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
                { display: '话题', name: 'content_title', minWidth: 150,align:'left' }, 
                { display: '作者', name: 'member_id', minWidth: 100 },
				{ display: '分类', name: 'category_id', width: 90 },
				{ display: '状态', name: 'content_status', width: 80,type:"enumVars",enumVars:enumVars.subjectStatus },
				{ display: '推荐', name: 'recommend', width: 80,type:"enumVars",enumVars:enumVars.boolVars },
				{ display: '排序位置', name: 'position', width: 80 ,align: 'center',
					type: 'int', editor: { type: 'int'}
				},
                { display: '创建时间', name: 'create_time' },
				{ display: '操作', isSort: false, width: 180, render: function (rowdata, rowindex, value)
                {
                    var h = "";
					h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>查看回复("+rowdata.reply_num+")</a> ";
					h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>编辑</a> ";
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
			
			//设定分类表单
			 $("#category_select").ligerComboBox({
                width: 100,
				initText: "不限",
                selectBoxWidth: 200,
                selectBoxHeight: 400, 
				textField: 'text',
				treeLeafOnly:false,
				valueField: 'id',
				valueFieldID: "category_id",
                tree: { url: '?acl=subjectCategory&method=categoryFormJsonData', checkbox: false, ajaxType: 'get',idFieldName: 'id' }
            });
			
			
			//设定字典变量的筛选条件
			CmsTools.setSelectOptions({selectId:"statusSelect",vars:enumVars.subjectStatus,emptyText:"不限"});
			CmsTools.setSelectOptions({selectId:"recommendSelect",vars:enumVars.boolVars,emptyText:"不限"});
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
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="编辑" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    &nbsp;
	分类：
    <div style="width:120px; display:inline-block;*display:inline; position:relative; top:5px; *zoom:1">
    <input type="text" id="category_select"/>
    </div>
    &nbsp;
	状态：
	<select id="statusSelect" name="content_status" style="width:70px;">
    	<option value="">不限</option>
    	<!--<option value="0">未发布</option>
        <option value="1">已发布</option>-->
    </select>
    &nbsp;
    推荐：
	<select id="recommendSelect" name="recommend" style="width:70px;">
    	<option value="">不限</option>
    	<!--<option value="0">未发布</option>
        <option value="1">已发布</option>-->
    </select>
    
    &nbsp;
    排序：
	<select id="sortSelect" name="sort" style="width:70px;">
    	<option value="recommend">推荐</option>
        <option value="createTime">最新发布</option>
        <option value="replyTime">最新回复</option>
    </select>
    
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:70px;">
    	<option value="content_name">标题</option>
        <option value="content_author">作者</option>
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
