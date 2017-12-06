<?
class Passport{
	
	var $passport_type="session";//可选session,cookie
	var $passport_key="passport";//通行证一级键名
	static $publicPermissions;//公共权限，不登录也可以访问
	static $commonPermissions;//通用权限(登录即可)
	var $permissions_key="permissions";
	var $passport_path="";//设定后台权限的作用范围，用网站后台的物理路径加密后的字符串赋值
	
	//构造函数,若session未开启,则自动开启
	function __construct()
    {
     	if($this->passport_type=="session"){
			if(!isset($_SESSION)){
				session_start();
			}
		}
		$this->passport_path=md5(dirname (__FILE__));
    }
	
	private function set_passport($user){
		$passport_arr=array();
		$passport_arr["ID"]=$user["auto_id"];
		$passport_arr["USER"]=$user["content_user"];
		$passport_arr["NAME"]=$user["content_name"];
		$passport_arr["ROLE"]=$user["content_role"];
		$passport_arr["ORG"]=$user["org_id"];
		$passport_arr["LOGINTIME"]=date("Y-m-d H:i:s");
		//$passport_arr["TOKEN"]=$user["content_token"];
		
		switch($this->passport_type){
			case "session":
				$_SESSION[$this->passport_path][$this->passport_key]=$passport_arr;
				break;
			case "cookie":
				$_COOKIE[$this->passport_path][$this->passport_key]=$passport_arr;
				break;
		}
	}
	
	
	function get_passport(){
		$passport_arr=array();
		switch($this->passport_type){
			case "session":
				$passport_arr=$_SESSION[$this->passport_path][$this->passport_key];
				break;
			case "cookie":
				$passport_arr=$_COOKIE[$this->passport_path][$this->passport_key];
				break;
		}
		return $passport_arr;
	}
	
	private function set_permissions($permissions){
		$_SESSION[$this->passport_path][$this->permissions_key]=$permissions;
	}
	
	function get_permissions(){
		return $_SESSION[$this->passport_path][$this->permissions_key];
	}
	
	//判断当前用户有无操作权限
	function permissions_validate($acl,$method=""){
		
		if($acl=="") return false;
		//如果method为空
		if($method==""){
			
			/*$aclName=$acl;
			$acl_obj=get_acl($aclName);
			$method=$acl_obj->default_method;*/
		}
		

		
		$role_permissions=$this->get_permissions();
		
		//如果是root权限
		if($role_permissions=="root")
			return true;
			
		//如果是公共权限
		$publicPermissions=self::$publicPermissions;
		if(is_array($publicPermissions["actions"][$acl])){
			if($method==""){
				return true;
			}else{
				if(in_array($method,$publicPermissions["actions"][$acl]))
					return true;
			}	
		}

		//如果是通用权限
		$commonPermissions=self::$commonPermissions;
		if(is_array($commonPermissions["actions"][$acl])){
			if($method==""){
				return true;
			}else{
				if(in_array($method,$commonPermissions["actions"][$acl]))
					return true;
			}
		}
		//权限验证
		if(is_array($role_permissions[$acl])){
			if($method==""){
				return true;
			}else{
				if(in_array($method,$role_permissions[$acl]))
					return true;
			}
		}else{
			//如果是栏目权限，但可能权限数组忘记定义，不单独处理，必须要求在权限数组中进行定义
		}
			
		
		return false;
	}
	
	
	//检验当前是否已登
	function is_login(){
		$passport_arr=$this->get_passport();
		
		if($passport_arr["ID"]!=''){
			return true;
		}else{
			return false;
		}	
	}
	
	//递归获取用户权限数据，用于向session中写入
	private function setUserSubPermissions($subRolePermissions,$selected_arr,&$return_arr,$parentKey=""){
		
		/*echo "<pre>";
		print_r($selected_arr);
		print_r($subRolePermissions);
		exit;*/
		
		
		if($parentKey!="")
			$parentKey=$parentKey.".";
		if(is_array($subRolePermissions))
		foreach($subRolePermissions as $key=>$vl){
			$subKey=$parentKey.$key;
			
			if(in_array($subKey,$selected_arr)){
				
				
				//判断如果是栏目，需要设定栏目的特殊标识
				preg_match('/^(\d+)$/',$key,$preg_result_1);
				preg_match('/(\.)?(\d+)(\.)$/',$parentKey,$preg_result_2);
				if($preg_result_1[1]!=""){//如果本级是栏目
					
					//模块基础权限
					if(is_array($vl["actions"]))
						foreach($vl["actions"] as $k=>$v){
							$newKey=$key.".".$k;//key中增加栏目标识
							if(!is_array($return_arr[$newKey])){//如果已加入的权限中不存在则加入
								$return_arr[$newKey]=$v;
							}else{//若已存在则合并
								if(is_array($v))
								foreach($v as $k2=>$v2){
									if(!in_array($v2,$return_arr[$newKey]))
										$return_arr[$newKey][]=$v2;
								}
							}
						}
					else
						$return_arr[$key]=array();//目录频道直接设置为空数组(也会存储在当前用户的权限数组中,用以显示相关的栏目树形菜单，不存储的话下级菜单无法显示)
					
				}elseif($preg_result_2[2]!=""){//如果本级是权限（不是栏目），但上级是栏目（用于资讯栏目下的编辑权限）
					//模块基础权限
					if(is_array($vl["actions"]))
					foreach($vl["actions"] as $k=>$v){
						$newKey=$preg_result_2[2].".".$k;//key中增加栏目标识，如2.news
						if(!is_array($return_arr[$newKey])){
							$return_arr[$newKey]=$v;
						}else{
							if(is_array($v))
							foreach($v as $k2=>$v2){
								if(!in_array($v2,$return_arr[$newKey]))
									$return_arr[$newKey][]=$v2;
							}
						}
					}
				}else{
					
					//模块基础权限
					if(is_array($vl["actions"])){
						foreach($vl["actions"] as $k=>$v){
							if(!is_array($return_arr[$k])){
								$return_arr[$k]=$v;
							}else{
								if(is_array($v))
								foreach($v as $k2=>$v2){
									if(!in_array($v2,$return_arr[$k]))
										$return_arr[$k][]=$v2;
								}
							}
						}
					}else{
						//如果没有下级权限，说明只是目录，建一个空的目录权限
						if(!is_array($return_arr[$key])){
							$return_arr[$key]=array("");
						}
						
					}
				
				}
				
				
				$this->setUserSubPermissions($vl["sub"],$selected_arr,$return_arr,$subKey);
			}
		}	
	}
	
	//获取角色的可用权限(栏目的权限信息与模块权限合并,用于在为角色选择权限时显示权限树)
	private function getPermissionsData(){
		global $modulePermissions,$menuModulePermissions;
		//查询数据库获取栏目树信息
		$menuPermissions=array();
		$menuPermissions["text"]="频道栏目";
		$menuPermissions["sub"]=$this->getMenuPermissions($menuModulePermissions);
		if(is_array($menuPermissions["sub"]) && count($menuPermissions["sub"])>0){
			//栏目的权限信息与模块权限合并
			return array_merge(array("menu"=>$menuPermissions),$modulePermissions);
		}else{//如果没有栏目数据，直接返回模块权限的数据
			return $modulePermissions;
		}
	}
	
	//根据角色的权限设置获取相关的权限action数组,登录时调用
	function getRolePermissions($role_value){
		$role_value=trim($role_value);
		$selected_arr=explode(',',$role_value);
		
		//因为采用单用户多角色的权限，这里先对权限数组去重复
		$selected_arr=array_unique($selected_arr);
		
		$rolePermissionsArr=array();
		$rolePermissions=$this->getPermissionsData();
		
		/*echo "<pre>";
		print_r($rolePermissions);
		exit;*/
		
		$this->setUserSubPermissions($rolePermissions,$selected_arr,$rolePermissionsArr);//第三个参数用于存放返回值数组
		
		/*echo "<pre>";
		print_r($selected_arr);
		echo "<br/>";
		print_r($rolePermissionsArr);
		exit;*/
		return $rolePermissionsArr;
	}
	
	//登录验证成功后执行的操作
	private function login_options($user){
		global $dao;
		//获取角色信息
		if($user["content_role"]!=""){
			
			//可以是多角色
			$user["content_role"]=trim($user["content_role"],',');
			$roleIdArr=explode(';',$user["content_role"]);
			$roleIdStr=implode(',',$roleIdArr);
			if($roleIdStr=="")
				$roleIdStr="0";
			
			$roleList=$dao->get_datalist("select * from {$dao->tables->role} where auto_id in({$roleIdStr}) and publish='1'");
			$role_value_arr=array();
			if(is_array($roleList))
			foreach($roleList as $key=>$vl){
				
				$role_value=trim($vl["content_value"]);
				if($role_value=="")
					continue;
				if($role_value=="root"){
					$this->set_permissions($role_value);
					break;
				}else{
					$role_value_arr[]=$role_value;	
				}			
			}else{
				//return false;
			}
			if(is_array($role_value_arr) && count($role_value_arr)>0){
				$roleValueStr=implode(',',$role_value_arr);
				$userPermissionsArr=$this->getRolePermissions($roleValueStr);
				
				$this->set_permissions($userPermissionsArr);
			}
				
		}else{
			//return false;
		}
		$this->set_passport($user);

		//return true;

	}
	
	//执行登录操作,返回结果数组
	function do_login($content_user,$content_pass){
		global $dao;
		if($content_user=='')
			return array("result"=>0,"msg"=>"请输入用户名");
		if($content_pass=='')
			return array("result"=>0,"msg"=>"请输入密码");
			
		//查询数据库	
		$tmpuser=$dao->get_row_by_where($dao->tables->user,"where content_user='{$content_user}' and publish='1'");
		if(!is_array($tmpuser)){
			return array("result"=>0,"msg"=>"用户名或密码错误");
		}
		
		//判断是否存在登录限制
		if(strtotime("+1 day",strtotime($tmpuser["last_login_fail_time"]))>=strtotime(date("Y-m-d H:i:s")) && $tmpuser["login_fail_times"]>=3){
			return array("result"=>0,"msg"=>"登录失败次数过多，请明天再试");
		}
		
		$content_pass=md5($content_pass.$tmpuser["pass_randstr"]);
		$user=$dao->get_row_by_where($dao->tables->user,"where content_user='{$content_user}' and content_pass='{$content_pass}' and publish='1'");
		
		//若用户名及密码正确,写入通行证
		if(is_array($user)){
			
			$this->login_options($user);
			
			//写入登录日志
			$log=array();
			$log["user_id"]=$user["auto_id"];
			$log["content_user"]=$user["content_user"];
			$log["content_name"]=$user["content_name"];
			$log["create_time"]=date("Y-m-d H:i:s");
			$dao->insert($dao->tables->user_login_log,$log,true);
			
			//如果存在登录限制，则清除限制
			if($user["login_fail_times"]>0){
				$tmp=array();
				$tmp["login_fail_times"]=0;
				$dao->update($dao->tables->user,$tmp,"where auto_id='{$user["auto_id"]}'");
			}
			
			return array("result"=>1,"msg"=>"登录成功");
		}else{
			
			//记录登录失败的信息
			$tmp=array();
			$tmp["last_login_fail_time"]=date("Y-m-d H:i:s");
			//如果上次登录失败时间到现在小于24小时，则次数加1
			if(strtotime("+1 day",strtotime($tmpuser["last_login_fail_time"])>=strtotime(date("Y-m-d H:i:s")))){
				$tmp["login_fail_times"]=$tmpuser["login_fail_times"]+1;
			}else{
				//否则此时置为1
				$tmp["login_fail_times"]=1;
			}
			$dao->update($dao->tables->user,$tmp,"where auto_id='{$tmpuser["auto_id"]}'");
			
			return array("result"=>0,"msg"=>"用户名或密码错误");
		}
	}
	
	function log_out(){
		$this->set_permissions(NULL);
		$this->set_passport(NULL);	
	}
	
	//获取当前访问的url
	function get_location_url(){
		$url_this = 'http://'.$_SERVER['SERVER_NAME'];
		if($_SERVER["SERVER_PORT"]!=80)
			$url_this.=':'.$_SERVER["SERVER_PORT"];
		$url_this.=$_SERVER["REQUEST_URI"];
		return $url_this;
	}
	
	function validate(){
		//如果采用token方式传参(例如使用flash执行上传文件的操作)
		if($_REQUEST["passport_id"]!="" && $_REQUEST["validate"]!="" && $_REQUEST["timestamp"]!="" && is_numeric($_REQUEST["passport_id"])){
			
			if($_REQUEST["timestamp"]+1800<time()){
				echo json_encode(array("error"=>"validateError","msg"=>"验证失败，请刷新界面后重试"));
				exit;
			}
			
			global $dao;
			$tmpUser=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$_REQUEST["passport_id"]}' and publish='1' ");
			if(is_array($tmpUser) && md5($tmpUser["content_token"].$_REQUEST["timestamp"])==$_REQUEST["validate"]){
				//将用户信息写入session
				$this->login_options($tmpUser);
			}
		}
		
		//如果是公共权限，允许访问
		$publicPermissions=self::$publicPermissions;
		if(is_array($publicPermissions["actions"][$_REQUEST["acl"]]))
			if(in_array($_REQUEST["method"],$publicPermissions["actions"][$_REQUEST["acl"]]))
				return;	
				
		
		//登录验证,如未登录跳转到登录界面
		if(!$this->is_login()){
			$action=get_acl("login");
			$action->forward("loginJump");
		}
		
		//权限验证,如没有权限则显示未授权界面
		if(!$this->permissions_validate($_REQUEST["acl"],$_REQUEST["method"])){		
			$action=get_acl("error");
			$action->forward("noPermission");
		}
		
		/*echo "<pre>";
		echo "用户已登录，用户信息如下：";
		print_r($this->get_passport());
		exit;*/
		
	}
	
	//用于获取编辑角色的树形菜单数据
	function getRolePermissionsFormData($role_id){
		global $dao;
		$recordData=$dao->get_row_by_where($dao->tables->role,"where auto_id='{$role_id}'",array("content_value"));
		$recordData["content_value"]=trim($recordData["content_value"],',');
		$selected_arr=explode(',',$recordData["content_value"]);
	
		//设定权限数据(模块权限与栏目权限)
		$rolePermissions=$this->getPermissionsData();
		
		return $this->getSubRolePermissions($rolePermissions,$selected_arr);
	}
	
	//获取栏目权限数组(用于为角色选择权限时显示栏目权限树)
	private function getMenuPermissions($menuModulePermissions,$where="",$pid=""){
		global $dao;
		
		$whereStr=" 1 ";
		if(strlen($pid)>0)
			$whereStr.=" and pid='{$pid}' ";
		else
			$whereStr.=" and pid='0' ";
		if(trim($where)!="")
			$whereStr.=" and {$where} ";
		
		
		$list_sql="select auto_id,pid,content_name as text,content_module from {$dao->tables->menu} where  {$whereStr} order by auto_position asc,auto_id asc ";
		$list=$dao->get_datalist($list_sql);

		
		$return_arr=array();
		
		if(is_array($list)&& count($list)>0)
		foreach($list as $key=>$vl){
			$item=array();
			if($vl["content_module"]!=""){
				if(is_array($menuModulePermissions[$vl["content_module"]])){
					$item=$menuModulePermissions[$vl["content_module"]];
				}else{
					//此栏目所对应的模块在权限数组中未定义，但会和正常栏目一起显示，也会正常存入角色表，但在登录时无法获取权限
				}
			}
			$item["text"]=$vl["text"];	
			$subList=$this->getMenuPermissions($menuModulePermissions,$where,$vl["auto_id"]);
			if(is_array($subList) && count($subList)>0){
				if(!is_array($item["sub"]))
					$item["sub"]=array();
				foreach($subList as $key=>$v){
					$item["sub"][$key]=$v;//避免key被重置（如果是下级栏目$key是数字，不能采用array_merge方式合并）
				}
				//$item["sub"]=array_merge($item["sub"],$subList);	//如果是下级栏目$key是数字，不能采用array_merge方式合并
			}
			$return_arr[$vl["auto_id"]]=$item;
		}
		return $return_arr;
	}
	
	
	//递归获取权限表单数据
	private function getSubRolePermissions($rolePermissions,$selected_arr,$parentKey=""){
		if($parentKey!="")
			$parentKey.=".";
		$return_arr=array();
		if(is_array($rolePermissions))
		foreach($rolePermissions as $key=>$vl){
			$item=array();
			$item["text"]=$vl["text"];
			$item["value"]=$parentKey.$key;
			if(in_array($item["value"],$selected_arr)){
				$item["ischecked"]=true;	
			}
			$children=$this->getSubRolePermissions($vl["sub"],$selected_arr,$item["value"]);
			if(is_array($children)&& count($children)>0)
				$item["children"]=$children;
			$return_arr[]=$item;
		}
		return $return_arr;
	}
	
	
	//获取用户的token信息
	function getToken($userId){
		global $dao;
		$tmp=$dao->get_row_by_where($dao->tables->user,"where auto_id='{$userId}'",array("content_token"));
		return $tmp["content_token"];
	}
	
}


?>