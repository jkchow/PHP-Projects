<?

class acl_cashApply extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	function form(){
		global $dao;
		$this->tpl_file="form.php";
		$record=array();
		
		if($_REQUEST["auto_id"]!=""){
			$recordData=$dao->get_row_by_where($dao->tables->cash_apply,"where auto_id='{$_REQUEST["auto_id"]}'");		
			
			if($recordData["member_id"]!=""){
				$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$recordData["member_id"]}'",array("content_mobile"));
				
				$recordData["member_mobile"]=$member["content_mobile"];
				
			}
			
			
		}else{
			$recordData=array();
			//$recordData["publish"]='1';
			//$recordData["goods_id"]=$_REQUEST["pid"];
			//$recordData["member_id"]=$_REQUEST["pid"];
			$recordData["create_time"]=date("Y-m-d H:i:s");
		}

		$formData=array();
		if(is_array($recordData))
		foreach($recordData as $key=>$vl){
			if($vl==NULL)
				continue;
			if($key!="auto_id")
				$formData["frm[{$key}]"]=$vl;
			else
				$formData["{$key}"]=$vl;
		}
		
		$record["formData"]=$formData;
		
		
		return $record;
	}
	function listsData(){

		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		global $dao;
		$this->tpl_file="";
		
		$where=" from {$dao->tables->cash_apply} where 1=1 ";
		
		if($_REQUEST["pid"]!="")
			$where.=" and member_id='{$_REQUEST["pid"]}'";
			
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
			
		if($_REQUEST["searchKeyword"]!=""){
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		}
			
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,auto_id desc";
		}else{
			$orderby.=" order by auto_id desc";
		}
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$vl["member_id"]}'",array("content_mobile"));
			$list[$key]["content_mobile"]=$member["content_mobile"];	
			//$agent=$dao->get_row_by_where($dao->tables->agent,"where auto_id='{$vl["agent_id"]}'",array("content_name"));
			//$list[$key]["agent_id"]=$agent["content_name"];		
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);

	}
	
	function save(){
		global $dao;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		
		//已处理过的提现申请不允许修改
		if($_POST["auto_id"]!=""){
			$oldRecord=$dao->get_row_by_where($dao->tables->cash_apply,"where auto_id='{$_POST["auto_id"]}'");
			if($oldRecord["content_status"]!="0"){
				//$backUrl=base64_decode($_REQUEST["backUrl"]);
				//$this->redirect($backUrl,"处理过的提现申请不允许修改");
				echo json_encode(array("result"=>0,"msg"=>"处理过的提现申请不允许修改"));
				exit;
			}
		}
		
		if($dataArray["member_id"]==""){
			//$backUrl=base64_decode($_REQUEST["backUrl"]);
			//$this->redirect($backUrl,"请选择会员");
			echo json_encode(array("result"=>0,"msg"=>"请选择会员"));
			exit;
		}
		
		if($_POST["auto_id"]==""){
			//判断此会员是否存在未处理的提现申请
			$tmpRecord=$dao->get_row_by_where($dao->tables->cash_apply,"where member_id='{$dataArray["member_id"]}' and content_status='0'");
			if($tmpRecord["auto_id"]!=""){
				//$backUrl=base64_decode($_REQUEST["backUrl"]);
				//$this->redirect($backUrl,"此会员存在尚未处理的提现申请，不允许再次申请");
				echo json_encode(array("result"=>0,"msg"=>"此会员存在尚未处理的提现申请，不允许再次申请"));
				exit;
			}
		}
		
		//查询会员信息
		$tmpMember=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$dataArray["member_id"]}'",array("account_balance","content_mobile"));
		
		$dataArray["content_mobile"]=$tmpMember["content_mobile"];
		if($dataArray["content_money"]>$tmpMember["account_balance"]){
			//$backUrl=base64_decode($_REQUEST["backUrl"]);
			//$this->redirect($backUrl,"提现金额不能大于会员账户余额，当前账户余额为{$tmpMember["account_balance"]}");
			echo json_encode(array("result"=>0,"msg"=>"提现金额不能大于会员账户余额，当前账户余额为{$tmpMember["account_balance"]}"));
			exit;
		}
		
		
		
		
		//如果是确认状态，修改账户余额，添加账户记录
		if($dataArray["content_status"]=="1"){
			//查询账户记录
			if($_POST["auto_id"]!="")
				$accountLog=$dao->get_row_by_where($dao->tables->member_account,"where cash_apply_id='{$_POST["auto_id"]}'");
			if(!is_array($accountLog)){	
				$record=array();
				$record["member_id"]=$dataArray["member_id"];
				$record["content_type"]=2;
				$record["content_money"]=$dataArray["content_money"]*(-1);
				$record["balance_monay"]=$tmpMember["account_balance"]+$record["content_money"];
				$record["content_desc"]="申请提现";
				$record["content_event"]="cashApply";
				$record["create_time"]=date("Y-m-d H:i:s");
				
				if($record["content_money"]!=""){
					$dao->insert($dao->tables->member_account,$record,true);
					$dao->update($dao->tables->member,array("account_balance"=>$record["balance_monay"]),"where auto_id='{$dataArray["member_id"]}'",true);
					
				}
				
			}	
		
		}
		
		if($_POST["auto_id"]==""){
			$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->cash_apply,$dataArray);
		}else{
			$dao->update($dao->tables->cash_apply,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
		
		//$backUrl=base64_decode($_REQUEST["backUrl"]);	
		//$this->redirect($backUrl);
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->cash_apply,"where auto_id='{$_REQUEST["auto_id"]}'");	
		//$backUrl=base64_decode($_REQUEST["backUrl"]);	
		//$this->redirect($backUrl);
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	

	
}

?>