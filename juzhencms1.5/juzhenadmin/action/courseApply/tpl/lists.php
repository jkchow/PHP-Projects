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
                //checkbox: true,
				columns: [
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
                { display: '家长姓名', name: 'parent_name', minWidth: 100,align:'left' }, 
				//{ display: '负责人姓名', name: 'content_name', minWidth: 100,align:'center' },
                { display: '联系电话', name: 'content_tel', minWidth: 100 },
				{ display: '孩子生日', name: 'content_birthday', minWidth: 100 },
				//{ display: '孩子年龄', name: 'content_age', minWidth: 100 },
				{ display: '校区', name: 'school_name', minWidth: 100 },
				{ display: '状态', name: 'content_status', minWidth: 100,type:"enumVars",enumVars:enumVars.dealStatusVars },
				//{ display: '创建人', name: 'create_user', minWidth: 100 },
                { display: '创建时间', name: 'create_time' },
				{ display: '操作', isSort: false, width: 120, render: function (rowdata, rowindex, value)
                {
                    var h = "";
					h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>查看</a> ";
                    h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
                    return h;
                }
                }

                ],  pageSize:20,
				url:dataUrl,
                width: '100%',height:'100%',rownumbers:true

            });
            $("#pageloading").hide();
			
			//设定字典变量的筛选条件
			CmsTools.setSelectOptions({selectId:"contentStatusSelect",vars:enumVars.dealStatusVars,emptyText:"不限"});
			
			
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
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="查看" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    <input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    <!--&nbsp;
	孩子年龄：
	<select name="content_age" style="width:80px;">
    	<option value="">不限</option>
    	<?
		//案例分类
		$DictionaryVars=new DictionaryVars();
		$caseTypeVars=$DictionaryVars->getVars("childAgeVars");
		if(is_array($caseTypeVars))
		foreach($caseTypeVars as $key=>$vl){
			?>
            <option value="<?=$vl["id"]?>"><?=$vl["text"]?></option>
            <?
		}
		?>
    </select>-->
    &nbsp;
	处理状态：
	<select id="contentStatusSelect" name="content_status" style="width:100px;">
    	<option value="">不限</option>
    </select>
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:100px;">
    	<option value="parent_name">家长姓名</option>
        <option value="content_tel">联系电话</option>
        <option value="content_email">联系邮箱</option>
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
