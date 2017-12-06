<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript">
		var acl="<?=$_REQUEST["acl"]?>";
		var pid="<?=$_REQUEST["pid"]?>";
        var grid = null;
		var dataUrl="?acl="+acl+"&method=listsData&pid="+pid;
		
		

		var grid;
        $(function () {			
            grid = $("#maingrid").ligerGrid({
                checkbox: true,
				columns: [
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
				{ display: '结果', name: 'content_title', minWidth: 100,align:'left' },
                { display: '说明', name: 'content_desc', minWidth: 100,align:'center' }, 
                { display: '达标分值', name: 'content_score', minWidth: 100,align:'center' },
				{ display: '排序位置', name: 'position', minWidth: 100 ,align: 'center',
					type: 'int', editor: { type: 'int'}
				},
				{ display: '操作', isSort: false, width: 180, render: function (rowdata, rowindex, value)
					{
						var h = "";
						//h += "<a href='javascript:view_item(" + rowdata.auto_id + ")'>相关产品</a> ";
						
						h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>修改</a> ";
						h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
						return h;
					}
                }

                ],  pageSize:20,
				url:dataUrl,enabledSort:false,clickToEdit: true,enabledEdit: true,
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
        });
        function f_search()
        {
         	var formData=$("#searchForm").serialize();	
			grid.options.url = dataUrl+"&"+formData;
            grid.loadData();
        }
		
		function add_record(){
			var url="?acl="+acl+"&method=form&pid="+pid;
			CmsTools.pageJump(url,true);
		}
		function edit_record(recordID){
			if(recordID!=null){
				var url="?acl="+acl+"&method=form&auto_id="+recordID;
				CmsTools.pageJump(url,true);
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
						CmsTools.pageJump(url,true);
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
		
		function view_item(recordID){
			//保存当前地址到url，用于返回
			
			//跳转到广告列表
			var url="?acl=examResultProduct&method=lists&pid="+recordID;
			CmsTools.pageJump(url,true);
		}
		
        function goBack(){
			CmsTools.jumpBack();
		}
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="修改" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
 	<!--&nbsp;
	发布状态：
	<select name="publish" style="width:80px;">
    	<option value="">不限</option>
    	<option value="0">未发布</option>
        <option value="1">已发布</option>
    </select>
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:100px;">
    	<option value="content_name">标题</option>
    </select>
    <input name="searchKeyword" type="text" /> 
    &nbsp;
    <input type="button" value="搜索" id="btnSearch" class="l-button l-button-submit" onclick="f_search()" />--> 
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
    <input type="button" value="返回" id="btnBack" class="l-button l-button-submit" onclick="goBack()"/>
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
 
</body>
</html>
