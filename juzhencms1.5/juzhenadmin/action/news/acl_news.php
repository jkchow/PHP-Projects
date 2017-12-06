<?

class acl_news extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$_REQUEST["auto_id"]}'");	
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
			if($key!="auto_id")
				$formData["frm[{$key}]"]=$vl;
			else
				$formData["{$key}"]=$vl;
		}
		
		$record["formData"]=$formData;
		
		//$record["menuVars"]=$dao->get_datalist("select auto_id as id,content_name as text from {$dao->tables->menu} order by position asc");
		
		return $record;
	}
	function listsData(){

		global $dao;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->news} where 1=1 ";
		
		if($_REQUEST["menu"]!='')
			$where.=" and menu_id = '{$_REQUEST["menu"]}' ";
		
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
		
		if($_REQUEST["recommend"]!='')
			$where.=" and recommend = '{$_REQUEST["recommend"]}' ";
			
			
		if($_REQUEST["searchKeyword"]!="")
			$where.=" and {$_REQUEST["searchFieldName"]} like '%{$_REQUEST["searchKeyword"]}%' ";
		
		if(USER_LEVEL){//如果开启用户职位
			$userStr=$this->getManageUserIdStr();
			$where.=" and create_user in({$userStr}) ";	
		}
		
		$orderby="";
		if($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,create_time desc,auto_id desc";
		}else{
			$orderby.=" order by position asc,create_time desc,auto_id desc";
		}
		/*if($_REQUEST["recommend"]=='1'){
			$orderby.=" order by auto_position desc,create_time desc,auto_id desc";
		}elseif($_REQUEST["sortname"]!="" && $_REQUEST["sortorder"]!="" ){
			$orderby.=" order by {$_REQUEST["sortname"]} {$_REQUEST["sortorder"]} ,auto_id desc";
		}else{
			$orderby.=" order by create_time desc,auto_id desc";
		}*/
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,content_name,menu_id,recommend,content_hit,publish,position,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$user=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$vl["create_user"]}'",array("content_name"));
			$list[$key]["create_user"]=$user["content_name"];
			
			/*$tmp=$dao->get_datalist("select count(auto_id) as img_count from {$dao->tables->news_img} where pid='{$vl["auto_id"]}'");
			$list[$key]["img_count"]=$tmp[0]["img_count"];
			if($list[$key]["img_count"]=="")
				$list[$key]["img_count"]="0";*/
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
		
		if($dataArray["content_hit"]=="")
			$dataArray["content_hit"]="0";
		if($dataArray["recommend"]=="")
			$dataArray["recommend"]="0";
		
		if($_POST["auto_id"]==""){
			$dataArray["menu_id"]=$_REQUEST["menu"];
			$dataArray["create_user"]=$this->getLoginUserId();
			//$dataArray["auto_position"]=time();
			$dao->insert($dao->tables->news,$dataArray);			
		}else{
			$dao->update($dao->tables->news,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
		
		//静态化相关操作
		if($dao->tables->define_url!=""){
			
			//判断文件名格式
			if($dataArray["file_name"]!="" && !preg_match('/^[a-zA-Z][a-zA-Z0-9]*\.html$/',$dataArray["file_name"])){
				//$this->redirectBack("页面文件名{$dataArray["file_name"]}不符合要求,请更换");
				echo json_encode(array("result"=>0,"msg"=>"页面文件名{$dataArray["file_name"]}不符合要求,请更换"));
				exit;
			}
			
			//查询数据库是否存在
			$data_id=$_POST["auto_id"];
			if($data_id=="")
				$data_id=$dao->get_insert_id();
				
			$pathRecord=array();
			$pathRecord["acl"]="news";
			$pathRecord["method"]="detail";
			$pathRecord["menu_id"]=$dataArray["menu_id"];
			$pathRecord["data_id"]=$data_id;
			$pathRecord["id_field"]="id";
			//获取栏目的静态化路径
			$menuUrl=$dao->get_row_by_where($dao->tables->define_url,"where acl='menu' and menu_id='{$pathRecord["menu_id"]}'");
			if($menuUrl["url_path"]!=""){
				$pathRecord["url_path"]=$menuUrl["url_path"];
			}
			$pathRecord["file_name"]=$dataArray["file_name"];
			$pathRecord["create_time"]=date("Y-m-d H:i:s");
			
			//判断目录是否重复
			if($pathRecord["file_name"]!=""){
				$tmp=$dao->get_row_by_where($dao->tables->define_url,"where file_name='{$pathRecord["file_name"]}' and acl='news' and data_id!='{$data_id}'");
				if(is_array($tmp)){
					//$this->redirectBack("已经存在相同的文件名{$dataArray["file_name"]},请更换");
					echo json_encode(array("result"=>0,"msg"=>"已经存在相同的文件名{$dataArray["file_name"]},请更换"));
					exit;
				}
			}
			
			$oldPathRecord=$dao->get_row_by_where($dao->tables->define_url,"where data_id='{$data_id}' and acl='news'");
			if(is_array($oldPathRecord)){
				if($pathRecord["file_name"]!="")
					$dao->update($dao->tables->define_url,$pathRecord,"where data_id='{$data_id}' and acl='news'");
				else
					$dao->delete($dao->tables->define_url,"where data_id='{$data_id}' and acl='news'");
				
			}else{
				if($pathRecord["file_name"]!="")//不会向数据表加入没有文件名的数据
					$dao->insert($dao->tables->define_url,$pathRecord);
				
			}
			
		}
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"信息提交成功"));
	}
	
	function delete(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$idStr=trim($_REQUEST["auto_id"],',');
			$idArr=explode(',',$idStr);
			if(is_array($idArr) && count($idArr)>0){
				foreach($idArr as $key=>$vl){
					if($vl=="")
						unset($idArr[$key]);
				}
				$idStr=implode(',',$idArr);
				$dao->delete($dao->tables->news,"where auto_id in({$idStr})");
				
				//静态化相关操作
				if($dao->tables->define_url!=""){
					$dao->delete($dao->tables->define_url,"where data_id in({$idStr}) and acl='news'");
				}
			}
		}
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	
	//保存排序操作
	function savePosition(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["position"]=$_REQUEST["position"];	
			
			if($dataArray["position"]=="")
				$dataArray["position"]="0";
			$dao->update($dao->tables->news,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	//修改推荐状态
	function changeRecommend(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["recommend"]=$_REQUEST["value"];
			if($dataArray["recommend"]=="0")
				$dataArray["recommend"]="1";
			else
				$dataArray["recommend"]="0";
			$dao->update($dao->tables->news,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	//修改发布状态
	function changePublish(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$dataArray=array();
			$dataArray["publish"]=$_REQUEST["value"];
			if($dataArray["publish"]=="0")
				$dataArray["publish"]="1";
			else
				$dataArray["publish"]="0";
			$dao->update($dao->tables->news,$dataArray,"where auto_id='{$_REQUEST["auto_id"]}'");		
		}
	}
	
	/*//栏目顺序向前移动
	function position_up(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","menu_id","auto_position"));
			
			//查找上一栏目
			$previous_record=$dao->get_row_by_where($dao->tables->news,"where menu_id='{$this_record["menu_id"]}' and auto_position >='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position asc",array("auto_id","menu_id","auto_position"));
			
			if(is_array($previous_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$previous_record["auto_position"]){
					$this_position["auto_position"]=$previous_record["auto_position"];
					$dao->update($dao->tables->news,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$previous_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->news,$previous_position,"where auto_id='{$previous_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$previous_record["auto_position"]-1;
					$dao->update($dao->tables->news,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//栏目顺序向后移动
	function position_down(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","menu_id","auto_position"));
			$p_code=substr($this_record["auto_code"],0,strlen($this_record["auto_code"])-4);
			//查找下一栏目
			$next_record=$dao->get_row_by_where($dao->tables->news,"where menu_id='{$this_record["menu_id"]}' and auto_position <='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position desc",array("auto_id","menu_id","auto_position"));
			
			if(is_array($next_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$next_record["auto_position"]){
					$this_position["auto_position"]=$next_record["auto_position"];
					$dao->update($dao->tables->news,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$next_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->news,$next_position,"where auto_id='{$next_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$next_record["auto_position"]+1;
					$dao->update($dao->tables->news,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}*/
	
	
}

?>