<?

class acl_member extends acl_base{
	var $default_method="lists";
	function lists(){
		global $dao;
		$this->tpl_file="lists.php";
		$record=array();
		//会员分组数据
		$record["groupData"]=$dao->get_datalist("select auto_id as id,content_name as text from {$dao->tables->member_group} order by position asc,auto_id asc");
		return $record;
	}
	function form(){
		global $dao;
		$record=array();
		
		if($_REQUEST["auto_id"]!=""){
			$recordData=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$_REQUEST["auto_id"]}'");
		}else{
			
			$recordData=array();
			$recordData["publish"]='1';
			$recordData["group_id"]='1';
			$recordData["is_agree"]='1';
			$recordData["create_time"]=date("Y-m-d H:i:s");
			$recordData["content_type"]=$_REQUEST["type"];
			
			
		}
		
		if($recordData["content_type"]=="")
			$recordData["content_type"]="1";
		//根据type参数确定显示哪个表单
		if($recordData["content_type"]=="1")
			$this->tpl_file="form.php";
		elseif($recordData["content_type"]=="2")
			$this->tpl_file="formCompany.php";

		$formData=array();
		if(is_array($recordData))
		foreach($recordData as $key=>$vl){
			if($vl==NULL)
				continue;
			elseif($key=="auto_id")
				$formData["{$key}"]=$vl;
			elseif($key=="content_pass")
				$formData["frm[{$key}]"]="";
			else
				$formData["frm[{$key}]"]=$vl;
				
		}
		
		$record["formData"]=$formData;
		
		//会员分组数据
		$record["groupData"]=$dao->get_datalist("select auto_id as id,content_name as text from {$dao->tables->member_group} order by position asc,auto_id asc");
		
		
		return $record;
	}
	function listsData(){

		
		global $dao,$global;
		$this->tpl_file="";
		
		
		$where=" from {$dao->tables->member} where 1=1 ";
		
		
		
		//如果引入的作用是选择企业会员
		if($_REQUEST["use"]=='companySelect'){
			$where.=" and content_type='2' ";
		}
		
		//用于选择框筛选
		if($_REQUEST["condition"]!=''){
			$str=urldecode($_REQUEST["condition"]);
			if($global->auto_addslashes)
				$str=stripslashes($str);
			$conditionArr=(array)json_decode($str);
			if(is_array($conditionArr))
			foreach($conditionArr as $key=>$vl){
				$vl=(array)$vl;
				if($vl["value"]!=""){
					if($vl["op"]=="like"){
						$where.=" and {$vl["field"]} like '%{$vl["value"]}%' ";
					}elseif($vl["op"]=="="){
						$where.=" and {$vl["field"]} = '{$vl["value"]}' ";
					}
				}	
			}
		}
		
		if($_REQUEST["content_type"]!='')
			$where.=" and content_type = '{$_REQUEST["content_type"]}' ";
		
		if($_REQUEST["group_id"]!='')
			$where.=" and group_id = '{$_REQUEST["group_id"]}' ";
	
		if($_REQUEST["publish"]!='')
			$where.=" and publish = '{$_REQUEST["publish"]}' ";
			
		if($_REQUEST["is_agree"]!='')
			$where.=" and is_agree = '{$_REQUEST["is_agree"]}' ";
			
		if($_REQUEST["is_synbbs"]!='')
			$where.=" and is_synbbs = '{$_REQUEST["is_synbbs"]}' ";
			
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
		
		$list_sql="select auto_id,content_name,content_user,content_type,content_mobile,content_email,group_id,account_balance,content_credits,publish,is_synbbs,is_agree,create_user,create_time "
		.$where.$orderby;
		$count_sql="select count(auto_id) as total "
		.$where;
		
		$list=$dao->get_datalist($list_sql);
		if(is_array($list))
		foreach($list as $key=>$vl){
			$group=$dao->get_row_by_where($dao->tables->member_group,"where auto_id='{$vl["group_id"]}'",array("content_name"));
			$list[$key]["group_id"]=$group["content_name"];
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
		
		if($dataArray["content_pass"]!=""){
			$dataArray["pass_randstr"]=rand(1000000,9999999);
			$dataArray["content_pass"]=md5($dataArray["content_pass"].$dataArray["pass_randstr"]);
		}else{
			unset($dataArray["content_pass"]);
		}
		
		
		//校验手机号是否可以注册
		$tmpmember=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$dataArray["content_mobile"]}' and auto_id!='{$_POST["auto_id"]}'");
		if(is_array($tmpmember)){
			//判断手机号是否已经注册
			//$this->redirectBack("此手机号已经被注册，请更换手机号");
			echo json_encode(array("result"=>0,"msg"=>"此手机号已经被注册，请更换手机号"));
			exit;
		}
		
		//校验邮箱是否可以注册
		if($dataArray["content_email"]!=""){
			$tmpmember=$dao->get_row_by_where($dao->tables->member,"where content_email='{$dataArray["content_email"]}' and auto_id!='{$_POST["auto_id"]}'");
			if(is_array($tmpmember)){
				//判断手机号是否已经注册
				//$this->redirectBack("此邮箱已经被注册，请更换邮箱");
				echo json_encode(array("result"=>0,"msg"=>"此邮箱已经被注册，请更换邮箱"));
				exit;
			}
		}
		
		
		/*if($dataArray["content_name"]!=""){
			//保存首字拼音first_letter
			$Pinyin=new Pinyin();
			$dataArray["first_letter"]=$Pinyin->getFirstCharPinyinLetter($dataArray["content_name"]);
		}*/
		
		
		
		
		if($_POST["auto_id"]==""){
			
			/*//个人会员默认为已审核
			if($dataArray["content_type"]=="1")
				$dataArray["is_agree"]="1";*/
			$dataArray["create_user"]=$this->getLoginUserId();
			$dao->insert($dao->tables->member,$dataArray);			
		}else{
			$dao->update($dao->tables->member,$dataArray,"where auto_id='{$_POST["auto_id"]}'");
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
				$dao->delete($dao->tables->member,"where auto_id in({$idStr})");
			}
		}	
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	
	//把用户同步至DZ论坛
	function synUcenter(){
		global $dao;
		if($_REQUEST["auto_id"]!=""){
			$rs=$dao->get_row_by_where($dao->tables->member,"where auto_id='{$_REQUEST["auto_id"]}'");
			
			if(is_array($rs)){ 
			
				if(strlen($rs['content_user'])>15){
					echo "用户名不能超过15个字符，同步失败";
					exit;
				}
				
				//查询ucenter中是否存在此会员 
				$uc_sql = "select * from cdb_uc_members where username='".$rs['content_user']."'"; 			
				$data = $dao->get_datalist( $uc_sql ); 
				
				if(is_array($data) && count($data)>0 ){ 
					echo "已经存在相同会员，同步失败";
					exit;
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
					
					echo "同步成功";
					exit;	
					
				} 
			} 	
			
			
		}
	
	}
	
	//dz论坛的加密函数(暂时没用到)
	private function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	
		$ckey_length = 4;
		$key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
	
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
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
	}
	
	function showMap(){
		$this->tpl_file="showMap.php";
		$record=array();
		return $record;
	}
	
	
}

?>