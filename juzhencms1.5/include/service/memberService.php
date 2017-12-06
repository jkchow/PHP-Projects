<?
class memberService{
	
	function setLoginMemberInfo($record){
		global $dao;
		$loginInfo=array();
		$loginInfo["auto_id"]=$record["auto_id"];
		$loginInfo["content_user"]=$record["content_user"];
		if($record["content_name"]=="")
			$record["content_name"]=$record["content_mobile"];
		$loginInfo["content_name"]=$record["content_name"];
		$loginInfo["content_mobile"]=$record["content_mobile"];
		
		$loginInfo["content_type"]=$record["content_type"];
		$loginInfo["uc_id"]=$record["uc_id"];
		
		$loginInfo["logintime"]=date("Y-m-d H:i:s");
		
		if(isset($_SESSION)){
			$_SESSION[md5(dirname(__FILE__))]["member"]=$loginInfo;
			
			//如果存在微信信息，修改会员绑定的微信信息
			if($_SESSION["weixin"]["weixin_openid"]!=""){
				if($record["weixin_openid"]!=$_SESSION["weixin"]["weixin_openid"] || $record["weixin_appid"]!=$_SESSION["weixin"]["weixin_appid"]){
					$dao->update($dao->tables->member,$_SESSION["weixin"],"where auto_id='{$record["auto_id"]}'");
					
					//若此微信号还绑定了其他手机，解除和其他手机的绑定关系
					$dao->update($dao->tables->member,array("weixin_openid"=>""),"where weixin_openid='{$_SESSION["weixin"]["weixin_openid"]}' and weixin_appid='{$_SESSION["weixin"]["weixin_appid"]}' and auto_id!='{$record["auto_id"]}'");
					
				}
			}
			
			
		}else{
			$GLOBALS["member"]=$loginInfo;
		}
		
		session_regenerate_id(true);
		
	}

	function getLoginMemberInfo($field=""){
		if(isset($_SESSION)){
			$loginInfo=$_SESSION[md5(dirname(__FILE__))]["member"];
		}else{
			$loginInfo=$GLOBALS["member"];
		}
		
		if($field!="")
			return $loginInfo[$field];
		else
			return $loginInfo;
	}
	
	function cleanLoginMemberInfo(){
		if(isset($_SESSION)){
			unset($_SESSION[md5(dirname(__FILE__))]["member"]);
			setcookie("pwd","",time()+60,"/");
		}else{
			unset($GLOBALS["member"]);
		}
		
		
	}
	
	function getMember($id,$field="auto_id"){
		global $dao,$global;
		$member=$dao->get_row_by_where($dao->tables->member,"where {$field}='{$id}'");
		if($member["content_img"]!=""){
			if(!preg_match('/^(http)|(https)/i',$member["content_img"])){
				$member["content_img"]=$global->uploadUrlPath.$member["content_img"];
			}
		}else{
			$member["content_img"]=$global->uploadUrlPath."nophoto.jpg";
		}
		if($member["content_head"]!=""){
			if(!preg_match('/^(http)|(https)/i',$member["content_head"])){
				$member["content_head"]=$global->uploadUrlPath.$member["content_head"];
			}
		}else{
			$member["content_head"]=$global->uploadUrlPath."default_head.jpg";
		}
		if($member["content_name"]==""){
			$member["content_name"]=$member["content_mobile"];
			//$member["content_name"]="匿名";
		}
			
		return $member;
		
	}
	
	/*//此方法只在页面输出之前起作用
	function getLoginUID(){
		require_once './bbs/include/common.inc.php';
		echo $discuz_uid;
		exit;
		if($discuz_uid!=0)
			return $discuz_uid;
		else
			return false;
	}
	
	function synUcenter($member_id){
		global $dao;
		if($member_id!=""){
			$rs=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$member_id}'");
			
			if(is_array($rs)){ 
			
				if(strlen($rs['content_user'])>15){
					return false;
				}
				
				//查询ucenter中是否存在此会员 
				$uc_sql = "select * from cdb_uc_members where username='".$rs['content_user']."'"; 			
				$data = $dao->get_datalist( $uc_sql ); 
				
				if(is_array($data) && count($data)>0 ){ 
					return false;
				} 
				else{ 
					//按照ucenter的规则生成密码
					$salt = substr(uniqid(rand()), -6); 
					$password = md5(md5($rs['content_pass']).$salt);//按照ucenter规则生成用户登陆密码 
					
					
					list($year,$month,$day,$hour,$minute,$second)=split ("[-: ]","2014-07-22 20:10:12"); 
					 //通过split函数分别把2007,9,22存入$year,$month,$day,$hour,$minute,$second六个参数中 
					 
					$seconds=mktime($hour,$minute,$second,$month,$day,$year);//根据年 月 日 时 分 秒输出时间戳
					
					$insert_sql="insert into cdb_uc_members set username='".$rs['content_user']."', password='$password', email='".$rs['content_email']."', lastlogintime ='$seconds', regdate='$seconds', salt='$salt'";			
					//把数据插入到uc_members表 
					$dao->query($insert_sql); 
					
					//查询并获取ucid
					$uc_sql = "select * from cdb_uc_members where username='".$rs['content_user']."'"; 
					$data = $dao->get_datalist( $uc_sql );
					$ucenter_record=$data[0];
					
					//更新uc_memberfields表。 
					$dao->query("insert into cdb_uc_memberfields set uid='".$ucenter_record['uid']."'");				
					
					//将ucid更新到会员表
					$dao->query("update {$dao->tables->member} set uc_id='".$ucenter_record['uid']."',is_syn='1' where auto_id='{$rs["auto_id"]}'");
					
					//将数据更新到论坛会员表
					$onlineip=GetIP();
					
					$ucresult['username'] = addslashes($rs['content_user']);
					$regpassword = md5($this->random(10));
					
					$dz_sql="INSERT INTO cdb_members (uid, username, password, secques, adminid, groupid, regip, regdate, lastvisit, lastactivity, posts, credits,  email, showemail, timeoffset, pmsound, invisible, newsletter)
					VALUES ('{$ucenter_record['uid']}','{$rs["content_user"]}', '$regpassword', '', '0', '10', '$onlineip', '$timestamp', '$timestamp', '$timestamp', '0', '0', '{$rs["content_email"]}', '0', '9999', '1', '0', '1')";
					
					$dao->query($dz_sql);
					
					return true;
					
				} 
			} 	
			
			
		}
	
	}
	
	//生成随机数的函数
	private function random($length, $numeric = 0) {
		PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
		$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}*/
	
	
	//获取会员中心的评论列表
	function memberCommentListsPage($member_id){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$pagesize=10;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->comment} where member_id='{$member_id}' ";
		
		$orderby=" order by auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			
			//根据被评论内容的类型生成链接
			if($vl["content_type"]=="1"){
				$tmpNews=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$vl["object_id"]}'",array("menu_id"));
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?menu={$tmpNews["menu_id"]}&id={$vl["object_id"]}";
			}elseif($vl["content_type"]=="2"){
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=product&method=detail&id={$vl["object_id"]}";
			}elseif($vl["content_type"]=="3"){
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=investProduct&method=detail&id={$vl["object_id"]}";
			}
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		
		
		$page_class=new page_class();
		$page_class->page_size=$pagesize;
		$page_class->init($total);
		$pageBar=$page_class->getPageBar();
		
		$record=array();
		$record["list"]=$list;
		$record["page"]=$pageBar;
		return $record;
	}
	
	//获取会员中心的收藏列表
	function memberCollectListsPage($member_id){
		global $dao,$global;
		$page=$_GET["page"];
		if($page=="")
			$page=1;
		$pagesize=10;
		$begin_count=($page-1)*$pagesize;
		
		$where=" from {$dao->tables->member_collect} where member_id='{$member_id}' ";
		
		$orderby=" order by auto_id desc limit {$begin_count},{$pagesize}";
		
		$list_sql="select * "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			//根据被评论内容的类型生成链接
			if($vl["content_type"]=="1"){
				$tmpNews=$dao->get_row_by_where($dao->tables->news,"where auto_id='{$vl["object_id"]}'",array("menu_id"));
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?menu={$tmpNews["menu_id"]}&id={$vl["object_id"]}";
			}elseif($vl["content_type"]=="2"){
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=product&method=detail&id={$vl["object_id"]}";
			}elseif($vl["content_type"]=="3"){
				$list[$key]["content_link"]=$global->siteUrlPath."/index.php?acl=investProduct&method=detail&id={$vl["object_id"]}";
			}
		}
		
		$list_count=$dao->get_datalist($count_sql);
		$total=$list_count[0]["total"]>0?$list_count[0]["total"]:0;
		
		
		
		$page_class=new page_class();
		$page_class->page_size=$pagesize;
		$page_class->init($total);
		$pageBar=$page_class->getPageBar();
		
		$record=array();
		$record["list"]=$list;
		$record["page"]=$pageBar;
		return $record;
	}
}
?>