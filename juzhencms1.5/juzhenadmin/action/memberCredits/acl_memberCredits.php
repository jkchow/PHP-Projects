<?

class acl_memberCredits extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->member_credits,"where auto_id='{$_REQUEST["auto_id"]}'");		
			
			if($recordData["member_id"]!=""){
				$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$recordData["member_id"]}'",array("content_mobile"));
				
				$recordData["member_mobile"]=$member["content_mobile"];
				
			}
			
			
		}else{
			$recordData=array();
			if($_REQUEST["pid"]!=""){
				$recordData["member_id"]=$_REQUEST["pid"];
				$member=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$recordData["member_id"]}'",array("content_mobile"));
				
				$recordData["member_mobile"]=$member["content_mobile"];
				
			}
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
		
		
		$where=" from {$dao->tables->member_credits} where 1=1 ";
		
		if($_REQUEST["pid"]!="")
			$where.=" and member_id='{$_REQUEST["pid"]}'";
			
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
			
		if($_REQUEST["searchKeyword"]!=""){
			if($_REQUEST["searchFieldName"]=="member_mobile"){
				$member=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$_REQUEST["searchKeyword"]}'",array("auto_id"));
				if(is_array($member)){
					$where.=" and member_id='{$member["auto_id"]}' ";
				}else{
					$where.=" and 0=1 ";
				}
			}else{
				$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
			}
			
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
			$list[$key]["member_mobile"]=$member["content_mobile"];		
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
		
		if($dataArray["member_id"]==""){
			/*$backUrl=base64_decode($_REQUEST["backUrl"]);
			$this->redirect($backUrl,"请选择会员");*/
			echo json_encode(array("result"=>0,"msg"=>"请选择会员"));
			exit;
		}
		
		
		/*if($dataArray["order_sn"]!=""){
			//检查订单号
			$order=$dao->get_row_by_where($dao->tables->order,"where order_sn='{$dataArray["order_sn"]}'",array("auto_id","order_sn","member_id","pay_money"));
			if(!is_array($order)){
				
				echo json_encode(array("result"=>0,"msg"=>"订单不存在"));
				exit;
			}elseif($order["member_id"]!=$dataArray["member_id"]){
				
				echo json_encode(array("result"=>0,"msg"=>"订单不属于此会员"));
				exit;
			}else{
				$dataArray["order_id"]=$order["auto_id"];
			}
			
		}else{
			$dataArray["order_id"]=="0";
		}*/
		
		
		if($_POST["auto_id"]==""){
			
			//查询会员信息
			$tmpMember=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$dataArray["member_id"]}'",array("content_credits"));
			
			$dataArray["balance_credits"]=$dataArray["content_credits"]+$tmpMember["content_credits"];
			
			if($dataArray["balance_credits"]<0 && $dataArray["content_credits"]<0){
				//$backUrl=base64_decode($_REQUEST["backUrl"]);
				//$this->redirect($backUrl,"会员账户积分不足");
				
				echo json_encode(array("result"=>0,"msg"=>"会员账户积分不足"));
				exit;
			}
			
			
			$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->member_credits,$dataArray);
			$dao->update($dao->tables->member,array("content_credits"=>$dataArray["balance_credits"]),"where auto_id='{$dataArray["member_id"]}'");
			
			
			
		}else{
			$dao->update($dao->tables->member_credits,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
			
			
			
		}
		
		/*$backUrl=base64_decode($_REQUEST["backUrl"]);	
		$this->redirect($backUrl);*/
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->member_credits,"where auto_id='{$_REQUEST["auto_id"]}'");	
		/*$backUrl=base64_decode($_REQUEST["backUrl"]);	
		$this->redirect($backUrl);	*/
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	

	
}

?>