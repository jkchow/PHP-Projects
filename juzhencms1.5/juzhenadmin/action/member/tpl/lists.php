<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include($global->admin_absolutePath."/res/tpl/common_header.php"); ?>
    <script type="text/javascript">
        var acl="<?=$_REQUEST["acl"]?>";
		var grid = null;
		var dataUrl="?acl="+acl+"&method=listsData";
		var groupData=<?=json_encode($_record["groupData"])?>;
		
        $(function () {			
            grid = $("#maingrid").ligerGrid({
                checkbox: true,
				columns: [
                { display: 'ID', name: 'auto_id', align: 'center', width: 60 },
				
				//{ display: '用户名', name: 'content_user', minWidth: 100,align:'center' },
				{ display: '手机号', name: 'content_mobile', minWidth: 100 },
				{ display: '姓名/昵称', name: 'content_name', minWidth: 100,align:'center' },
				{ display: '会员类型', name: 'content_type', minWidth: 100,align:'center',type:"enumVars",enumVars:enumVars.memberTypeVars },
                
				//{ display: '邮箱', name: 'content_email', minWidth: 100 },
                { display: '所在分组', name: 'group_id', minWidth: 100 },
				{ display: '积分', isSort: false, width: 100, render: function (rowdata, rowindex, value){
						
						var h = "";
						h += "<a href='javascript:view_credits(" + rowdata.auto_id + ")'>" + rowdata.content_credits + "</a> ";
						
						return h;
					}
                },
				{ display: '账户', isSort: false, width: 100, render: function (rowdata, rowindex, value){
						
						var h = "";
						h += "<a href='javascript:view_account(" + rowdata.auto_id + ")'>" + rowdata.account_balance + "</a> ";
						
						return h;
					}
                },
				{ display: '发布状态', name: 'publish', width: 80,type:"enumVars",enumVars:enumVars.publishVars },
				{ display: '审核状态', name: 'is_agree', width: 80,type:"enumVars",enumVars:enumVars.agreeVars },
				//{ display: '同步状态', name: 'is_synbbs', width: 80,type:"enumVars",enumVars:enumVars.boolVars },
                { display: '创建时间', name: 'create_time' },
				{ display: '操作', isSort: false, width: 90, render: function (rowdata, rowindex, value)
                {
                    var h = "";
					/*if(rowdata.content_type=="1"){
						h += "<a href='javascript:view_address(" + rowdata.auto_id + ")'>常用地址</a> ";
					}else{
						h += "<a href='javascript:view_photos(" + rowdata.auto_id + ")'>查看相册</a> ";
					}*/
					
					h += "<a href='javascript:edit_record(" + rowdata.auto_id + ")'>修改</a> ";
                    h += "<a href='javascript:delete_record(" + rowdata.auto_id + ")'>删除</a> "; 
					/*if(rowdata.content_type=="2")
						h += "<a href='javascript:view_proData(" + rowdata.auto_id + ")'>作品</a> ";*/
                    return h;
                }
                }

                ],  pageSize:20,
				url:dataUrl,
                width: '100%',height:'100%',rownumbers:true

            });
            $("#pageloading").hide();
			
			//设定字典变量的筛选条件
			CmsTools.setSelectOptions({selectId:"memberTypeSelect",vars:enumVars.memberTypeVars,emptyText:"不限"});
			CmsTools.setSelectOptions({selectId:"memberGroupSelect",vars:groupData,emptyText:"不限"});
			CmsTools.setSelectOptions({selectId:"publishSelect",vars:enumVars.publishVars,emptyText:"不限"});
			CmsTools.setSelectOptions({selectId:"isAgreeSelect",vars:enumVars.agreeVars,emptyText:"不限"});
			//CmsTools.setSelectOptions({selectId:"isSynbbsSelect",vars:enumVars.boolVars,emptyText:"不限"});
			
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
		
		function add_record(memberType){
			var url="?acl="+acl+"&method=form";
			if(memberType!=null)
				url+="&type="+memberType;
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
					if(rowdata.content_type=="2" || rowdata.content_type=="3"){
						window.open("../index.php?acl=member&method=companyIndex&id="+rowdata.auto_id);
					}else{
						alert("只有企业会员可以预览");
						return;
					}
				}		
			}else{
				alert("请先选择要预览的行");
				return;
			}
		}
		
		
		//会员分组管理
		function viewGroup(){
			var url="?acl=memberGroup&method=lists";
			CmsTools.pageJump(url,true);

		}
		//查看会员账户记录
		function view_account(recordID){
			if(recordID!=null){
				var url="?acl=memberAccount&method=lists&pid="+recordID;
				CmsTools.pageJump(url,true);
			}
		}
		//查看会员积分记录
		function view_credits(recordID){
			if(recordID!=null){
				var url="?acl=memberCredits&method=lists&pid="+recordID;
				CmsTools.pageJump(url,true);
			}
		}
		
        
    </script>
</head>
<body style="padding:6px; overflow:hidden;">
<div id="searchbar" style="margin:5px;">
<form id="searchForm" onsubmit="f_search();return false">
	<input type="button" value="新增个人" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
	<input type="button" value="新增企业" id="btnAddCompany" class="l-button l-button-submit" onclick="add_record(2)"/>
    <!--<input type="button" value="新增" id="btnAdd" class="l-button l-button-submit" onclick="add_record()"/>
    <input type="button" value="修改" id="btnEdit" class="l-button l-button-submit" onclick="edit_record()"/>
    --><input type="button" value="删除" id="btnDelete" class="l-button l-button-submit" onclick="delete_record()"/>
    <!--<input type="button" value="预览" id="btnPreview" class="l-button l-button-submit" onclick="preview_record()"/>-->
    <input type="button" value="分组管理" id="btnGroup" class="l-button l-button-submit" onclick="viewGroup()"/>
    <input type="button" value="刷新" id="btnRefresh" class="l-button l-button-submit" onclick="location.reload()"/>
    
    <br/>
    &nbsp;
	类型：
	<select id="memberTypeSelect" name="content_type" style="width:100px;">
    	<option value="">不限</option>
    </select>
    &nbsp;
    分组：
	<select id="memberGroupSelect" name="group_id" style="width:100px;">
    	<option value="">不限</option>
    </select>
    &nbsp;
	发布：
	<select id="publishSelect" name="publish" style="width:100px;">
    	<option value="">不限</option>
    </select>
    &nbsp;
	审核：
	<select id="isAgreeSelect" name="is_agree" style="width:100px;">
    	<option value="">不限</option>
    </select>
    <!--&nbsp;
	同步：
	<select id="isSynbbsSelect" name="is_synbbs" style="width:100px;">
    	<option value="">不限</option>
    </select>-->
    &nbsp;
	搜索：
    <select name="searchFieldName" style="width:100px;">
    	<option value="content_mobile">手机号</option>
        <option value="content_email">邮箱</option>
    	<option value="content_name">昵称</option>
        <!--<option value="content_user">用户名</option>-->
        
    </select>
    <input name="searchKeyword" type="text" />
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
