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
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
                { display: '产品名称', name: 'content_name', minWidth: 140,align:'left' }, 
				{ display: '发行机构', name: 'content_org', minWidth: 120 },
				{ display: '销售状态', name: 'content_status', width: 80},
				{ display: '发布状态', name: 'publish', width: 80,type:"enumVars",enumVars:enumVars.publishVars },
				{ display: '推荐', name: 'recommend', width: 50,type:"enumVars",enumVars:enumVars.boolVars },
				{ display: '排序位置', name: 'position', width: 80 ,align: 'center',
					type: 'int', editor: { type: 'int'}
				},
				/*{ display: '创建人', name: 'create_user', minWidth: 100 },*/
                { display: '创建时间', name: 'create_time' },
				{ display: '操作',isSort: false, width: 120, render: function (rowdata, rowindex, value)
                {
                    var h = "";
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
				},
				onChangeSort:function(columnName, sortOrder){}

            });
            $("#pageloading").hide();
			
			//设定字典变量的筛选条件
			CmsTools.setSelectOptions({selectId:"publishSelect",vars:enumVars.publishVars,emptyText:"不限"});
			CmsTools.setSelectOptions({selectId:"recommendSelect",vars:enumVars.boolVars,emptyText:"不限"});
			
			//发行单位
			$("#org_name").ligerComboBox({
                width: 150,
				slide: false,
				selectBoxWidth: 445,
				selectBoxHeight: 240,
				valueField: 'auto_id',
				textField: 'content_name',
				valueFieldID: "member_id",
				grid: {
					columns: [
					{ display: 'ID', name: 'auto_id', align: 'center', width: 50 },
					{ display: '用户名', name: 'content_user', minWidth: 130 },
					{ display: '名称', name: 'content_name', width: 130,align:'center' },
					{ display: '类型', name: 'content_type', minWidth: 130,type:"enumVars",enumVars:enumVars.memberTypeVars }
					], switchPageSizeApplyComboBox: false,
					url:"?acl=member&method=listsData&use=bankSelect",
					width: '100%',height:'100%',rownumbers:false,
					pageSize: 10, 
					checkbox: false
				},
				condition: { fields: [{ name: 'content_name', label: '名称', width: 90, type: 'text' }
									  //,{ name: 'course_sn', label: '编号', width: 90, type: 'text' }
									  ] }
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
					window.open("../index.php?acl=product&method=detail&id="+rowdata.auto_id);
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
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
    &nbsp;
	发行单位：
    <div style="width:150px; display:inline-block;*display:inline; position:relative; top:5px; *zoom:1">
    <input type="text" id="org_name"/>
    </div>
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:80px;">
        <option value="content_name">产品名称</option>
    </select>
    <input name="searchKeyword" type="text" style="width:150px;"/>
    <br/>
    &nbsp;
	产品分类：
	<select name="content_type" style="width:80px;">
    	<option value="">不限</option>
    	<?
		//案例分类
		$DictionaryVars=new DictionaryVars();
		$caseTypeVars=$DictionaryVars->getVars("productTypeVars");
		if(is_array($caseTypeVars))
		foreach($caseTypeVars as $key=>$vl){
			?>
            <option value="<?=$vl["id"]?>"><?=$vl["text"]?></option>
            <?
		}
		?>
    </select>
    
    &nbsp;
	销售状态：
	<select name="content_status" style="width:80px;">
    	<option value="">不限</option>
    	<?
		//案例分类
		$DictionaryVars=new DictionaryVars();
		$caseTypeVars=$DictionaryVars->getVars("sellStatusVars ");
		if(is_array($caseTypeVars))
		foreach($caseTypeVars as $key=>$vl){
			?>
            <option value="<?=$vl["id"]?>"><?=$vl["text"]?></option>
            <?
		}
		?>
    </select>
    
    &nbsp;
	收益类型：
	<select name="earnings_type" style="width:80px;">
    	<option value="">不限</option>
    	<?
		//案例分类
		$DictionaryVars=new DictionaryVars();
		$caseTypeVars=$DictionaryVars->getVars("earningsTypeVars");
		if(is_array($caseTypeVars))
		foreach($caseTypeVars as $key=>$vl){
			?>
            <option value="<?=$vl["id"]?>"><?=$vl["text"]?></option>
            <?
		}
		?>
    </select>
    
    &nbsp;
	发布状态：
	<select id="publishSelect" name="publish" style="width:80px;">
    	<option value="">不限</option>
    </select>
    &nbsp;
	是否推荐：
	<select id="recommendSelect" name="recommend" style="width:80px;">
    	<option value="">不限</option>
    </select>
     
    &nbsp;
    <input type="button" value="搜索" id="btnSearch" class="l-button l-button-submit" onclick="f_search()" /> 
    
    
</form>    
</div>
<div id="maingrid" style="margin:0; padding:0"></div>
<div style="display:none;">
<!-- g data total ttt -->

  
</div>
 
</body>
</html>
