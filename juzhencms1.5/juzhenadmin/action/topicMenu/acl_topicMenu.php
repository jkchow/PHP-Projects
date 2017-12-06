<?

class acl_topicMenu extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$_REQUEST["auto_id"]}'");	
		}else{
			$recordData=array();
			$recordData["publish"]='1';
			$recordData["create_time"]=date("Y-m-d H:i:s");
		}

		$formData=array();
		if(is_array($recordData))
		foreach($recordData as $key=>$vl){
			if($vl==NULL)
				continue;
			if($key!="auto_id" && $key!="auto_code")
				$formData["frm[{$key}]"]=$vl;
			else
				$formData["{$key}"]=$vl;
		}
		
		if($formData["auto_code"]!="" && strlen($formData["auto_code"])>4){
			$formData["p_code"]=substr($formData["auto_code"],0,strlen($formData["auto_code"])-4);
		}
		
		$record["formData"]=$formData;

		
		
		return $record;
	}
	
	function treeGridJsonData(){
		global $dao;
		
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->topic_menu} where topic_id='{$_SESSION["topicId"]}' and auto_code like '____' ";
			
		$orderby.=" order by auto_position asc,auto_id asc";

		$pagesize=10;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		
		
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,auto_code,content_name,content_module,menu_key,publish,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//获取下级数据
			$children=$this->getSubGridLists($vl["auto_code"]);
			if(is_array($children) && count($children)>0)
				$list[$key]["children"]=$children;
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		$return_arr=array();
		$return_arr["Rows"]=$list;
		$return_arr["Total"]=$total;
		
		/*echo "<pre>";
		print_r($return_arr);
		exit;*/
		
		echo json_encode($return_arr);
	}
	
	private function getSubGridLists($code){
		global $dao;
		$where=" from {$dao->tables->topic_menu} where topic_id='{$_SESSION["topicId"]}' and auto_code like '{$code}____' ";
			
		$orderby.=" order by auto_position asc,auto_id asc";
		
		$list_sql="select auto_id,auto_code,content_name,content_module,menu_key,publish,create_time "
		.$where.$orderby;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//获取下级数据
			$children=$this->getSubGridLists($vl["auto_code"]);
			if(is_array($children) && count($children)>0)
				$list[$key]["children"]=$children;
		}
		return $list;
		
	}
	
	
	//获取栏目编辑时上级栏目的选择数据
	function pcodeFormJsonData(){
		
		if($_REQUEST["editCode"]!="")
			$sqlStr="auto_code not like '{$_REQUEST["editCode"]}%'";
		
		$return_arr=$this->getTreeData($sqlStr);
		if(!is_array($return_arr)){
			$return_arr=array();
		}
		echo json_encode($return_arr);
	}
	
	private function getTreeData($where="",$pCode=""){
		
		if(trim($where)!="")
			$whereStr=" and ".$where;
		
		global $dao;
		$list_sql="select auto_id,auto_code,content_name as text from {$dao->tables->topic_menu} where topic_id='{$_SESSION["topicId"]}' and auto_code like '{$pCode}____' {$whereStr} order by auto_position asc,auto_code asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);
		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){
			$subList=$this->getTreeData($where,$vl["auto_code"]);
			if(is_array($subList) && count($subList)>0)
				$list[$key]["children"]=$subList;
		}
		return $list;
	}
	
	
	
	
	function save(){
		global $dao;
		/*echo "<pre>";
		print_r($_POST);
		exit;*/
		
		$dataArray=$_POST["frm"];
		if($dataArray["auto_code"]=="null")
			$dataArray["auto_code"]="";
		if($dataArray["content_module"]=="null")
			$dataArray["content_module"]="";
		
		if($_POST["auto_id"]==""){
			
			//生成code编码
			
			//如果pcode为空，查询当前级别code最大值，然后加1
			$tmp=$dao->get_datalist("select max(right(auto_code,4)) as max_code from {$dao->tables->topic_menu} where auto_code like '{$_POST["p_code"]}____'");

			
			
			if($tmp[0]["max_code"]==NULL || $tmp[0]["max_code"]=="")
				$dataArray["auto_code"]=$_POST["p_code"]."1000";
			else
				$dataArray["auto_code"]=$_POST["p_code"].(1+$tmp[0]["max_code"]);

			$dataArray["auto_position"]=time();
			$dataArray["create_user"]=$this->getLoginUserId();
			$dataArray["topic_id"]=$_SESSION["topicId"];
			
			
			$dao->insert($dao->tables->topic_menu,$dataArray);			
		}else{
			
			$dao->update($dao->tables->topic_menu,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
			
			//保存时需要判断$_POST["auto_code"]与$_POST["p_code"]
			
			//auto_code 与 pcode对比
			if(substr($_POST["auto_code"],0,strlen($dataArray["auto_code"])-4)!=$_POST["p_code"]){
				
				//如果pcode为空，查询当前级别code最大值，然后加1
				$tmp=$dao->get_datalist("select max(right(auto_code,4)) as max_code from {$dao->tables->topic_menu} where auto_code like '{$_POST["p_code"]}____'");

				
				if($tmp[0]["max_code"]==NULL || $tmp[0]["max_code"]=="")
					$new_code=$_POST["p_code"]."1000";
				else
					$new_code=$_POST["p_code"].(1+$tmp[0]["max_code"]);

				
				$code_length=strlen($_POST["auto_code"])+1;
				
				$update_sql="update {$dao->tables->topic_menu} "
							."set auto_code=concat('{$new_code}',substring(auto_code,{$code_length})) "
							."where auto_code like '{$_POST["auto_code"]}%'";			
				
				$dao->query($update_sql);	
			}	
		}
			
		//$this->redirect("?acl=topicMenu&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!="")
			$dao->delete($dao->tables->topic_menu,"where auto_id='{$_REQUEST["auto_id"]}'");	
		//$this->redirect("?acl=topicMenu&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	//栏目顺序向前移动
	function position_up(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","auto_code","auto_position"));
			$p_code=substr($this_record["auto_code"],0,strlen($this_record["auto_code"])-4);
			//查找上一栏目
			$previous_record=$dao->get_row_by_where($dao->tables->topic_menu,"where topic_id='{$_SESSION["topicId"]}' and auto_code like '{$p_code}____' and auto_position <='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position desc",array("auto_id","auto_code","auto_position"));
			
			if(is_array($previous_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$previous_record["auto_position"]){
					$this_position["auto_position"]=$previous_record["auto_position"];
					$dao->update($dao->tables->topic_menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$previous_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->topic_menu,$previous_position,"where auto_id='{$previous_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$previous_record["auto_position"]-1;
					$dao->update($dao->tables->topic_menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//栏目顺序向后移动
	function position_down(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","auto_code","auto_position"));
			$p_code=substr($this_record["auto_code"],0,strlen($this_record["auto_code"])-4);
			//查找下一栏目
			$next_record=$dao->get_row_by_where($dao->tables->topic_menu,"where topic_id='{$_SESSION["topicId"]}' and auto_code like '{$p_code}____' and auto_position >='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position asc",array("auto_id","auto_code","auto_position"));
			
			if(is_array($next_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$next_record["auto_position"]){
					$this_position["auto_position"]=$next_record["auto_position"];
					$dao->update($dao->tables->topic_menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$next_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->topic_menu,$next_position,"where auto_id='{$next_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$next_record["auto_position"]+1;
					$dao->update($dao->tables->topic_menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//为栏目添加测试数据(针对资讯、视频、友情链接模块)
	function addTestData(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->topic_menu,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","content_name","content_module"));
			if($this_record["content_module"]=="topicNews"){
				for($i=1;$i<=20;$i++){
					$tmp_record=array();
					$tmp_record["menu_id"]=$this_record["auto_id"];
					$tmp_record["topic_id"]=$_SESSION["topicId"];
					$tmp_record["content_name"]=$this_record["content_name"]."-测试资讯数据标题".$i;
					$tmp_record["content_subname"]="副标题".$this_record["content_name"]."-".$i;
					$tmp_record["content_author"]="匿名作者";
					$tmp_record["content_source"]="互联网虚构";
					$tmp_record["content_desc"]=$this_record["content_name"]."-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.".$i;
					$tmp_record["content_img"]="nophoto.jpg";
					$tmp_record["content_body"]=$this_record["content_name"]."-测试资讯数据正文".$i;
					$tmp_record["content_hit"]=99;
					$tmp_record["auto_position"]=999;
					$tmp_record["publish"]=1;
					$tmp_record["create_time"]=date("Y-m-d H:i:s");
					$tmp_record["create_user"]=$this->getLoginUserId();
					
					$dao->insert($dao->tables->topic_news,$tmp_record,true);
					
				}
			}elseif($this_record["content_module"]=="topicLinks"){
				
				for($i=1;$i<=20;$i++){
					$tmp_record=array();
					$tmp_record["menu_id"]=$this_record["auto_id"];
					$tmp_record["topic_id"]=$_SESSION["topicId"];
					$tmp_record["content_name"]=$this_record["content_name"]."-测试友情链接标题".$i;
					$tmp_record["content_link"]="http://www.baidu.com";
					
					$tmp_record["content_img"]="nophoto.jpg";
					
					$tmp_record["position"]=999;
					$tmp_record["publish"]=1;
					$tmp_record["create_time"]=date("Y-m-d H:i:s");
					$tmp_record["create_user"]=$this->getLoginUserId();
					
					$dao->insert($dao->tables->topic_links,$tmp_record,true);
					
				}
			
			}else{
				echo "此类型的栏目无法添加测试数据";
				exit;
			}
			echo "已经添加测试数据";
		
		}
	}
	
}

?>