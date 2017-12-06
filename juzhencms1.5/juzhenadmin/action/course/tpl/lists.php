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
                //checkbox: true,
				columns: [
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
                { display: '课程名称', name: 'content_name', minWidth: 140,align:'left' }, 
				//{ display: '商品编号', name: 'course_sn', width: 110 },
				
				{ display: '发布状态', name: 'publish', width: 80,type:"enumVars",enumVars:enumVars.publishVars },
				//{ display: '推荐', name: 'recommend', width: 80,type:"enumVars",enumVars:enumVars.boolVars },
				{ display: '排序位置', name: 'position', width: 80 ,align: 'center',
					type: 'int', editor: { type: 'int'}
				},
				/*{ display: '创建人', name: 'create_user', minWidth: 100 },*/
                //{ display: '创建时间', width: 170,name: 'create_time' },
				{ display: '操作',isSort: false, width: 220, render: function (rowdata, rowindex, value)
                {
                    var h = "";
					//h += "<a href='javascript:view_imgs(" + rowdata.auto_id + ")'>图集管理</a> ";
					//h += "<a href='javascript:lookup_agent_price(" + rowdata.auto_id + ")'>区域价格</a> ";
					h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>修改</a> ";
                    h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
                    return h;
                }
                }

                ],  pageSize:20,
				url:dataUrl,enabledSort:false,clickToEdit: true,enabledEdit: true,
                width: '100%',height:'100%',rownumbers:true,
				onBeforeSubmitEdit:function(param){

					var row = grid.getSelectedRow();
					if(row==null || row.auto_id==null){
						row=param.record;	
					}
					var colName=param.column.name;
					if(colName=="position"){
						//修改排序位
						$.ajax({
						   type: "get",
						   url: "?acl="+acl+"&method=savePosition&auto_id="+row.auto_id+"&position="+param.value,
						   success:function(){
								grid.loadData();
						   }
						});
					}else if(colName=="content_num"){
						//修改库存
						$.ajax({
						   type: "get",
						   url: "?acl="+acl+"&method=saveContentNum&auto_id="+row.auto_id+"&content_num="+param.value,
						   success:function(){
								grid.loadData();
						   }
						});
					}else if(colName=="content_price"){
						//修改价格
						$.ajax({
						   type: "get",
						   url: "?acl="+acl+"&method=saveContentPrice&auto_id="+row.auto_id+"&content_price="+param.value,
						   success:function(){
								grid.loadData();
						   }
						});
					}
					
					
					
					
					
					
					
					
				},
				onChangeSort:function(columnName, sortOrder){}

            });
            $("#pageloading").hide();
			
			
			//设定分类表单
			$("#category_select").ligerComboBox({
                width: 100,
				initText: "不限",
                selectBoxWidth: 200,
                selectBoxHeight: 200, 
				textField: 'text',
				treeLeafOnly:false,
				valueField: 'auto_code',
				valueFieldID: "category_code",
                tree: { url: '?acl=courseCategory&method=categoryFormJsonData', checkbox: false, ajaxType: 'get',idFieldName: 'auto_code',isExpand:1 }
            });

			
			
        });
        function f_search()
        {
         	var formData=$("#searchForm").serialize();	
			grid.options.url = dataUrl+"&"+formData;
			/*//如果推荐选择是，则排序失效，并且显示出上移和下移按钮
			var recommend=$("#recommend").val();
			if(recommend=="1"){
				$("#btnUp").show();
				$("#btnDown").show();
				//关闭表头排序功能
				grid.options.enabledSort=false;
			}else{
				$("#btnUp").hide();
				$("#btnDown").hide();
				//打开表头排序功能
				grid.options.enabledSort=true;
			}*/
			
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
				var rowdata = grid.getSelectedRow();
				if (!rowdata)
					alert("请先选择要编辑的行");
				else{
					var url="?acl="+acl+"&method=form&auto_id="+rowdata.auto_id;
					CmsTools.pageJump(url);
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
		
		function view_imgs(recordID){
			var url="?acl=courseImg&method=lists&pid="+recordID;
			CmsTools.pageJump(url,true);
		}
		
		function lookup_agent_price(recordID){
			if(recordID!=null){
				CmsTools.pageJump("?acl=agentPrice&method=lists&pid="+recordID,true);
			}
		}
		
		/*function up()
        {
            var row = grid.getSelected();
			$.ajax({
			   type: "get",
			   url: "?acl="+acl+"&method=position_up&auto_id="+row.auto_id
			});
            grid.up(row);
        }
        function down()
        {
            var row = grid.getSelected();
			$.ajax({
			   type: "get",
			   url: "?acl="+acl+"&method=position_down&auto_id="+row.auto_id
			});
            grid.down(row);
        }*/
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="修改" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    &nbsp;
	分类：
    <div style="width:120px; display:inline-block;*display:inline; position:relative; top:5px; *zoom:1">
    <input type="text" id="category_select"/>
    </div>
    &nbsp;
	状态：
	<select name="publish" style="width:80px;">
    	<option value="">不限</option>
    	<option value="0">未发布</option>
        <option value="1">已发布</option>
    </select>
    <!--&nbsp;
	推荐：
	<select name="recommend" style="width:80px;">
    	<option value="">不限</option>
    	<option value="0">否</option>
        <option value="1">是</option>
    </select>-->
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:80px;">
        <option value="content_name">课程名称</option>
        <!--<option value="course_sn">商品编号</option>-->
    </select>
    <input name="searchKeyword" type="text" style="width:80px;"/> 
    &nbsp;
    <input type="button" value="搜索" id="btnSearch" class="l-button l-button-submit" onclick="f_search()" /> 
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
    <input type="button" value="上移" id="btnUp" class="l-button l-button-submit" onclick="up()" style="display:none"/>
    <input type="button" value="下移" id="btnDown" class="l-button l-button-submit" onclick="down()" style="display:none"/>
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
 
</body>
</html>
