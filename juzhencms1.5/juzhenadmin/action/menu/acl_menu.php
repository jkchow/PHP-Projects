<?

class acl_menu extends acl_base{
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
			$recordData=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$_REQUEST["auto_id"]}'");
			if($recordData["pid"]=="0")
				$recordData["pid"]="";
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

		
		
		return $record;
	}
	
	function treeGridJsonData(){
		global $dao;
		
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->menu} where pid = 0 ";
			
		$orderby.=" order by auto_position asc,auto_id asc";

		$pagesize=10;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		
		
		$begin_count=($page-1)*$pagesize;
		$orderby.=" limit {$begin_count},{$pagesize}";
		
		$list_sql="select auto_id,pid,content_name,content_module,publish,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//获取下级数据
			$children=$this->getSubGridLists($vl["auto_id"]);
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
	
	private function getSubGridLists($pid){
		global $dao;
		$where=" from {$dao->tables->menu} where pid ='{$pid}' ";
			
		$orderby.=" order by auto_position asc,auto_id asc";
		
		$list_sql="select auto_id,pid,content_name,content_module,publish,create_time "
		.$where.$orderby;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//获取下级数据
			$children=$this->getSubGridLists($vl["auto_id"]);
			if(is_array($children) && count($children)>0)
				$list[$key]["children"]=$children;
		}
		return $list;
		
	}
	
	
	
	//获取栏目编辑时上级栏目的选择数据
	function pidFormJsonData(){
		
		if($_REQUEST["editId"]!="")
			$sqlStr="auto_id != '{$_REQUEST["editId"]}%'";
		$return_arr=$this->getTreeData($sqlStr);
		if(!is_array($return_arr)){
			$return_arr=array();
		}
		echo json_encode($return_arr);
	}
	
	//获取广告发布时选择显示栏目的选择数据
	function adMenuFormJsonData(){	
		$return_arr=$this->getTreeData();
		echo json_encode($return_arr);
	}
	
	private function getTreeData($where="",$pid="0"){
		global $dao;
		$whereStr=" pid='{$pid}' ";	
		if(trim($where)!="")
			$whereStr.=" and {$where} ";
		
		$list_sql="select auto_id,pid,content_name as text from {$dao->tables->menu} where {$whereStr} order by auto_position asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);
		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){
			$subList=$this->getTreeData($where,$vl["auto_id"]);
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
		if($dataArray["pid"]=="null" || $dataArray["pid"]=="")
			$dataArray["pid"]="0";
		
		if($dataArray["show_submenu"]=="null" || $dataArray["show_submenu"]=="")
			$dataArray["show_submenu"]="0";
			
		if($dataArray["content_module"]=="null")
			$dataArray["content_module"]="";
		
		if($_POST["auto_id"]==""){

			$dataArray["auto_position"]=time();
			$dataArray["create_user"]=$this->getLoginUserId();
			
			
			$dao->insert($dao->tables->menu,$dataArray);
			
		}else{
			
			//如果更换上级栏目，需要将排序位置重置，确保排在新目录的最后
			$tmp=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$_POST["auto_id"]}'",array("pid"));
			if($dataArray["pid"]=="")
				$dataArray["pid"]=0;
			if($dataArray["pid"]!=$tmp["pid"])
				$dataArray["auto_position"]=time();
			
			$dao->update($dao->tables->menu,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
		}
		
		
		
		//静态化相关操作
		if($dao->tables->define_url!=""){
			
			//判断目录格式
			if($dataArray["url_path"]!="" && !preg_match('/^\/[a-zA-Z0-9\/]*[a-zA-Z0-9]$/',$dataArray["url_path"])){
				//$this->redirectBack("目录名称{$dataArray["url_path"]}不符合要求,请更换");
				echo json_encode(array("result"=>0,"msg"=>"目录名称{$dataArray["url_path"]}不符合要求,请更换"));
				exit;
			}

			//查询数据库是否存在
			$menu_id=$_POST["auto_id"];
			if($menu_id=="")
				$menu_id=$dao->get_insert_id();
				
			$pathRecord=array();
			
			$pathRecord["acl"]="menu";
			$pathRecord["method"]="";
			$pathRecord["menu_id"]=$menu_id;
			$pathRecord["file_name"]="";
			$pathRecord["url_path"]=$dataArray["url_path"];
			$pathRecord["create_time"]=date("Y-m-d H:i:s");
			
			//判断目录是否重复
			if($pathRecord["url_path"]!=""){
				$tmp=$dao->get_row_by_where($dao->tables->define_url,"where url_path='{$pathRecord["url_path"]}' and file_name='{$pathRecord["file_name"]}' and menu_id!='{$menu_id}'");
				if(is_array($tmp)){
					//$this->redirectBack("已经存在相同的目录{$dataArray["url_path"]},请更换");
					echo json_encode(array("result"=>0,"msg"=>"已经存在相同的目录{$dataArray["url_path"]},请更换"));
					exit;
				}
			}
			
			$oldPathRecord=$dao->get_row_by_where($dao->tables->define_url,"where menu_id='{$menu_id}' and acl='menu'");
			if(is_array($oldPathRecord)){
				if($pathRecord["url_path"]!="")
					$dao->update($dao->tables->define_url,$pathRecord,"where menu_id='{$menu_id}' and acl='menu'");
				else
					$dao->delete($dao->tables->define_url,"where menu_id='{$menu_id}' and acl='menu'");
				
			}else{
				if($pathRecord["url_path"]!="")//不会向数据表加入没有目录的数据
					$dao->insert($dao->tables->define_url,$pathRecord);
				
			}
			
			//更新和此频道相关的所有目录信息
			$dao->update($dao->tables->define_url,array("url_path"=>$pathRecord["url_path"]),"where menu_id='{$menu_id}'");
			
		}
		
			
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		//$this->redirectBack();
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
				$dao->delete($dao->tables->menu,"where auto_id in({$idStr})");
				
				//静态化相关操作
				if($dao->tables->define_url!=""){
					$dao->delete($dao->tables->define_url,"where menu_id in({$idStr}) and acl='menu'");
				}
				
				
			}
			
			
			
			
		}
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}

	
	//栏目顺序向前移动
	function position_up(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","pid","auto_position"));
			
			//查找上一栏目
			$previous_record=$dao->get_row_by_where($dao->tables->menu,"where pid = '{$this_record["pid"]}' and auto_position <='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position desc",array("auto_id","pid","auto_position"));
			
			if(is_array($previous_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$previous_record["auto_position"]){
					$this_position["auto_position"]=$previous_record["auto_position"];
					$dao->update($dao->tables->menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$previous_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->menu,$previous_position,"where auto_id='{$previous_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$previous_record["auto_position"]-1;
					$dao->update($dao->tables->menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//栏目顺序向后移动
	function position_down(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","pid","auto_position"));
			
			//查找下一栏目
			$next_record=$dao->get_row_by_where($dao->tables->menu,"where pid = '{$this_record["pid"]}' and auto_position >='{$this_record["auto_position"]}' and auto_id!='{$_REQUEST["auto_id"]}' order by auto_position asc",array("auto_id","pid","auto_position"));
			
			if(is_array($next_record)){
				//排序位是否相等
				if($this_record["auto_position"]!=$next_record["auto_position"]){
					$this_position["auto_position"]=$next_record["auto_position"];
					$dao->update($dao->tables->menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
					$next_position["auto_position"]=$this_record["auto_position"];
					$dao->update($dao->tables->menu,$next_position,"where auto_id='{$next_record["auto_id"]}'");
					
				}else{
					$this_position["auto_position"]=$next_record["auto_position"]+1;
					$dao->update($dao->tables->menu,$this_position,"where auto_id='{$this_record["auto_id"]}'");
				}
			}		
		}
	}
	//为栏目添加测试数据(针对资讯、视频、友情链接模块)
	function addTestData(){
		if($_REQUEST["auto_id"]!=""){
			//查找栏目
			global $dao;
			
			$this_record=$dao->get_row_by_where($dao->tables->menu,"where auto_id='{$_REQUEST["auto_id"]}'",array("auto_id","content_name","content_module"));
			if($this_record["content_module"]=="news"){
				for($i=1;$i<=20;$i++){
					$tmp_record=array();
					$tmp_record["menu_id"]=$this_record["auto_id"];
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
					
					$dao->insert($dao->tables->news,$tmp_record,true);
					
				}
			}elseif($this_record["content_module"]=="video"){
				
				for($i=1;$i<=20;$i++){
					$tmp_record=array();
					$tmp_record["menu_id"]=$this_record["auto_id"];
					$tmp_record["content_name"]=$this_record["content_name"]."-测试视频数据标题".$i;
					$tmp_record["content_author"]="匿名作者";
					$tmp_record["content_source"]="互联网虚构";
					$tmp_record["content_desc"]=$this_record["content_name"]."-测试视频数据简介,测试视频数据简介,测试视频数据简介,测试视频数据简介,测试视频数据简介,测试视频数据简介.".$i;
					$tmp_record["content_img"]="nophoto.jpg";
					$tmp_record["content_video"]="test.flv";
					$tmp_record["content_hit"]=99;
					$tmp_record["auto_position"]=999;
					$tmp_record["publish"]=1;
					$tmp_record["create_time"]=date("Y-m-d H:i:s");
					$tmp_record["create_user"]=$this->getLoginUserId();
					
					$dao->insert($dao->tables->video,$tmp_record,true);
					
				}
			
			}elseif($this_record["content_module"]=="links"){
				
				for($i=1;$i<=20;$i++){
					$tmp_record=array();
					$tmp_record["menu_id"]=$this_record["auto_id"];
					$tmp_record["content_name"]=$this_record["content_name"]."-测试友情链接标题".$i;
					$tmp_record["content_link"]="http://www.baidu.com";
					
					$tmp_record["content_img"]="nophoto.jpg";
					
					$tmp_record["position"]=999;
					$tmp_record["publish"]=1;
					$tmp_record["create_time"]=date("Y-m-d H:i:s");
					$tmp_record["create_user"]=$this->getLoginUserId();
					
					$dao->insert($dao->tables->links,$tmp_record,true);
					
				}
			
			}else{
				echo "此类型的栏目无法添加测试数据";
				exit;
			}
			echo "已经添加测试数据";
		
		}
	}
	
	function updateMenuPath(){
		global $global;
		if(!is_writable($global->absolutePath)){
			echo "目录{$global->absolutePath}没有写入权限";
			exit;
		}
		
		$menuService=new menuService();
		$menuService->updateMenuPath();
		
		echo "栏目目录更新完成";
	}
	
	function updateSitemapXml(){
		global $global,$dao;
		if(!is_writable($global->absolutePath)){
			echo "目录{$global->absolutePath}没有写入权限";
			exit;
		}
		
		//读取栏目数据
		$menuList=$dao->get_datalist("select auto_id,pid,content_link,content_name,content_module,url_path from {$dao->tables->menu} where publish='1' order by auto_id asc limit 0,1000");
		$menuService=new menuService();
		
		ob_start();
		echo '<?xml version="1.0"?>';
		?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?
if(is_array($menuList))
foreach($menuList as $key=>$vl){
	$tmpUrl=$menuService->getMenuLink($vl);
?>
<url>
<loc><?=$tmpUrl?></loc>
<changefreq>daily</changefreq>
</url>
<?		
}
?>
</urlset>
        <?
		$_res =  ob_get_contents();
		ob_end_clean();
		
		//写入文件
		if ($fp = @fopen($global->absolutePath."/sitemap.xml", "w+")) {
			//利用读写锁实现单例模式
			flock($fp, LOCK_EX); 	
			//将新的统计数据写入文本文件
			fputs($fp,$_res);//写文件时不会有冲突
			//关闭文件
			flock($fp, LOCK_UN); 
			fclose($fp);
		}
		
		
		echo "sitemap.xml已经更新";
	}
	
}

?>