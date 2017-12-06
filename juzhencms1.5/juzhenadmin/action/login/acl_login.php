<?

class acl_login extends acl_base{
	var $default_method="loginform";
	
	//跳转至登录界面，在iframe多框架页面中，使最外层页面跳转到登录
	function loginJump(){
		$this->tpl_file="loginJump.php";
		$record=array();
		return $record;
	}
	//登录页面
	function loginform(){
		$this->tpl_file="loginform.php";
		$record=array();
		return $record;
	}
	//执行登录操作
	function dologin(){
		global $global;
		$this->tpl_file="";
		
		//检查验证码(随机数连接后md5验证)
		if(
		   $_POST["validateNUM"]=="" || 
		   $_SESSION["validateNUM"]=="" || 
		   md5(strtolower($_POST["validateNUM"]).$_SESSION["validateRand"])!=$_SESSION["validateNUM"]
		){
			//$this->redirect("?acl=login","验证码输入错误");
			echo json_encode(array("result"=>0,"msg"=>"验证码输入错误"));
			exit;
		}
		unset($_SESSION["validateNUM"]);
		unset($_SESSION["validateRand"]);
		
		$user=$_POST["username"];
		$pass=$_POST["password"];
		
		if(!$global->auto_addslashes){
			$user=addslashes($user);
			$pass=addslashes($pass);
		}
				
		
		//判断用户是否存在
		$passport=new Passport();
		$result=$passport->do_login($user,$pass);
		if($result["result"]==1){
			session_regenerate_id(true);
			//$this->redirect("index.php?acl=main");
			echo json_encode(array("result"=>1,"msg"=>""));
			exit;
		}else{
			//$this->redirect("index.php?acl=login",$result["msg"]);
			echo json_encode(array("result"=>0,"msg"=>$result["msg"]));
			exit;
		}
	}
	//退出登录
	function logout(){
		$passport=new Passport();
		$passport->log_out();
		$this->redirect("index.php?acl=login");
	}
	//图片验证码
	function validateImg(){
		//文件头... 
		header("Content-type: image/png"); 
		//创建真彩色白纸 
		$im = @imagecreatetruecolor(50, 20) or die("建立图像失败"); 
		//获取背景颜色 
		$background_color = imagecolorallocate($im, 255, 255, 255); 
		//填充背景颜色(这个东西类似油桶) 
		imagefill($im,0,0,$background_color); 
		//获取边框颜色 
		$border_color = imagecolorallocate($im,200,200,200); 
		//画矩形，边框颜色200,200,200 
		imagerectangle($im,0,0,49,19,$border_color); 
	
		//逐行炫耀背景，全屏用1或0 
		for($i=2;$i<18;$i++){ 
			//获取随机淡色         
			$line_color = imagecolorallocate($im,rand(200,255),rand(200,255),rand(200,255)); 
			//画线 
			imageline($im,2,$i,47,$i,$line_color); 
		} 
	
		//设置字体大小 
		$font_size=12; 
	
		//设置印上去的文字 
		$Str[0] = "ABCDEFGHIJKMNPQRSTUVWXYZAB"; 
		$Str[1] = "abcdefghijkmnpqrstuvwxyzab"; 
		$Str[2] = "12345678912345678912345678"; 
	
		//获取第1个随机文字 
		$imstr[0]["s"] = $Str[rand(0,2)][rand(0,25)]; 
		$imstr[0]["x"] = rand(2,5); 
		$imstr[0]["y"] = rand(1,4); 
	
		//获取第2个随机文字 
		$imstr[1]["s"] = $Str[rand(0,2)][rand(0,25)]; 
		$imstr[1]["x"] = $imstr[0]["x"]+$font_size-1+rand(0,1); 
		$imstr[1]["y"] = rand(1,3); 
	
		//获取第3个随机文字 
		$imstr[2]["s"] = $Str[rand(0,2)][rand(0,25)]; 
		$imstr[2]["x"] = $imstr[1]["x"]+$font_size-1+rand(0,1); 
		$imstr[2]["y"] = rand(1,4); 
	
		//获取第4个随机文字 
		$imstr[3]["s"] = $Str[rand(0,2)][rand(0,25)]; 
		$imstr[3]["x"] = $imstr[2]["x"]+$font_size-1+rand(0,1); 
		$imstr[3]["y"] = rand(1,3); 
	
		$validateNUM="";
		//写入随机字串 
		for($i=0;$i<4;$i++){ 
			//获取随机较深颜色 
			$text_color = imagecolorallocate($im,rand(50,180),rand(50,180),rand(50,180)); 
			//画文字 
			imagechar($im,$font_size,$imstr[$i]["x"],$imstr[$i]["y"],$imstr[$i]["s"],$text_color);
			$validateNUM.=$imstr[$i]["s"];
		} 
	
		//显示图片 
		imagepng($im); 
		//销毁图片 
		imagedestroy($im); 
		
		//验证码不直接使用明文存储在session中，而是使用随机数连接后再md5
		$_SESSION["validateRand"]=rand(1000000,9999999);
		$_SESSION["validateNUM"]=md5(strtolower($validateNUM).$_SESSION["validateRand"]);
		
		exit;
	}
	
}

?>