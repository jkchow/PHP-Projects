<?
//操作文件上传
//$uploadFile=new UploadFile();
//echo $uploadFile->save_upload_file('Filedata');

class UploadFile{
	var $uploadAbsolutePath;
	var $uploadUrlPath;
	var $allowMaxFileSize=20480;//允许上传的文件大小，单位是KB
	var $allowFileExtNames=array("jpeg","jpg","png","bmp","txt","rar","zip","doc","docx","xls","xlsx","pdf","flv","mp4","swf","apk");//允许上传的文件扩展名，若不做限制置空即可
	var $forbiddenFileExtNames=array("php","asp","aspx","jsp","js","htm","html","xhtml","sh","exe");//禁止上传的文件扩展名
	var $errorMsgs=array(
				"fieldNameNull"=>"文件上传字段名为空",
				"fileIsNull"=>"文件为空",
				"fileTypeError"=>"文件类型错误",
				"forbiddenTypeError"=>"禁止上传此类型的文件",
				"fileSizeError"=>"文件大小超出了服务器限制",
				"fileSizeTooLarge"=>"文件过大",
			);
	
	function __construct(){
     	global $global;
		$this->uploadAbsolutePath=$global->uploadAbsolutePath;
		$this->uploadUrlPath=$global->uploadUrlPath;
    }

	//保存上传的文件，上传文件的基础方法，带有相关校验，其余上传方法都是从此方法扩展而来
	function save_upload_file($input_name){
		$_record=$this->check_file($input_name);
		if($_record["error"]!=""){
			return $_record;
		}
		$temploadfile = $_FILES[$input_name]['tmp_name']; 
		move_uploaded_file($temploadfile , $_record["absolutePath"]); //移动文件
		
		//使用oss相关代码
		global $global;
		if($global->ossEnable){
			import("lib/oss_php_sdk/sdk.class");
			$oss = new ALIOSS();
			$bucket=$global->ossBucket;
			$file_path =$_record["absolutePath"];//上传的文件
			$object=$_record['savePath'];//上传后的文件路径及名称
			$options = array();
			$res = $oss->upload_file_by_file($bucket, $object, $file_path, $options);	
		}
		
		//unset($_record["absolutePath"]);
		return $_record;
	}
	
	//保存上传的图片，宽度和高度若不设定则不使用图片裁切
	function save_upload_img($input_name,$imgWidth="",$imgHeight="",$cutType="cut"){
		$_record=$this->check_file($input_name);
		if($_record["error"]!=""){
			return $_record;
		}
		$temploadfile = $_FILES[$input_name]['tmp_name']; 
		move_uploaded_file($temploadfile , $_record["absolutePath"]); //移动文件
		
		if($imgWidth!="" && $imgHeight!=""){
			//生成缩略图
			if($cutType=="cut"){//裁切
				$ImgCut=new ImgCut($_record["absolutePath"],$imgWidth,$imgHeight);
				$newFilePath=$ImgCut->produce();
			}elseif($cutType=="fill"){//填充
				$ImgFill=new ImgFill($_record["absolutePath"],$imgWidth,$imgHeight);
				$newFilePath=$ImgFill->produce();
			}elseif($cutType=="zoom"){//缩放
				$ImgThumb=new ImgThumb($_record["absolutePath"],$imgWidth,$imgHeight);
				$newFilePath=$ImgThumb->produce();
			}
			
			
			$position = strrpos($newFilePath,'/');
			$newFileName = substr($newFilePath,($position + 1));
			$position = strrpos($_record["absolutePath"],'/');
			$oldFileName = substr($_record["absolutePath"],($position + 1));
			
			if(file_exists($_record["absolutePath"]))
				unlink($_record["absolutePath"]);
			if(is_array($_record))
			foreach($_record as $key=>$vl){
				$_record[$key]=str_replace($oldFileName,$newFileName,$vl);
			}
		}
		return $_record;
	}
	
	//内部调用，在save_upload_file和save_upload_img中进行调用
	private function check_file($input_name){
		if($input_name=='') return array("error"=>"fieldNameNull","msg"=>$this->errorMsgs["fieldNameNull"]);
		
		//设置为执行不超时
		set_time_limit(0);
		
		
		//判断文件大小是否合法
		$allowFileSize=$this->allowMaxFileSize;//程序参数限定大小
		$sysAllowFileSize=$this->get_system_upload_limit();//系统设置大小
		$fileSize=round($_FILES[$input_name]["size"]/1024,2);
		if($fileSize>$sysAllowFileSize){
			return array("error"=>"fileSizeError","msg"=>$this->errorMsgs["fileSizeError"]);
		}
		if($fileSize>$allowFileSize){
			return array("error"=>"fileSizeTooLarge","msg"=>$this->errorMsgs["fileSizeTooLarge"]);
		}
		
		$_record=$this->get_upload_filename($_FILES[$input_name]["name"]);
		
		return $_record;
	}
	
	//原来文件名得到文件全名,并创建目录
	function get_upload_filename($oldname){//第二个参数是基于站点根目录的相对路径
		
		if($oldname=="")
			return array("error"=>"fileIsNull","msg"=>$this->errorMsgs["fileIsNull"]);
			
		
		
		//得到原文件的扩展名
		$ext_name =strtolower(substr($oldname, strrpos($oldname,".")+1 ));
		
		//判断文件扩展名是否合法
		$allow_types=$this->allowFileExtNames;
		
		
		if(is_array($allow_types) && count($allow_types)>0 && !in_array($ext_name,$allow_types))
			return array("error"=>"fileTypeError","msg"=>$this->errorMsgs["fileTypeError"]);
		
		//判断是否为安全的文件类型
		$forbidden_types=$this->forbiddenFileExtNames;
		if(in_array($ext_name,$forbidden_types))
			return array("error"=>"forbiddenTypeError","msg"=>$this->errorMsgs["forbiddenTypeError"]);
			
		//由时间得到随机文件名
		list ($usec, $sec) = explode(' ', microtime());
		$filename=(float) $sec + ((float) $usec * 1000000);	
		
		$filename.=".".$ext_name;
		
		//由时间得到目录
		$_dateDir=date("Y/m/d");
		
		$path= $this->uploadAbsolutePath.$_dateDir;
		//创建目录
		$this->_mkdirs($path);
		
		$_record=array();
		$_record['fileName']=$oldname;
		$_record['absolutePath']=$path."/".$filename;
		$_record['savePath']=$_dateDir."/".$filename;
		$_record['urlPath']=$this->uploadUrlPath.$_record['savePath'];
		return $_record;
		
	}
	
	//创建目录
	static function _mkdirs($path)
	{
		$adir = explode('/',$path);
		$dirlist = '';
		$rootdir = array_shift($adir);
		if(($rootdir!='.'||$rootdir!='..')&&!file_exists($rootdir))
		{
			@mkdir($rootdir);
		}
	
		foreach($adir as $key=>$val)
		{
			if($val!='.'&&$val!='..')
			{
				$dirlist .= "/".$val;
				$dirpath = $rootdir.$dirlist;
				if(!@file_exists($dirpath))
				{
					@mkdir($dirpath);
					@chmod($dirpath,0777);
				}
			}
		}
	}
	
	//获取系统允许上传文件的大小（kb）
	function get_system_upload_limit(){
		$upload_max_filesize = $this->PMA_get_real_size(ini_get('upload_max_filesize'));
		$post_max_size = $this->PMA_get_real_size(ini_get('post_max_size'));
		$min_upload_size = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;
		$upload_max_mbsize=round($min_upload_size/1024,2);
		return $upload_max_mbsize;
	}
	
	private function PMA_get_real_size($size = 0) {
		 if (! $size) {
			 return 0;
		 }
		 $scan['gb'] = 1073741824; //1024 * 1024 * 1024;
		 $scan['g']  = 1073741824; //1024 * 1024 * 1024;
		 $scan['mb'] = 1048576;
		 $scan['m']  = 1048576;
		 $scan['kb'] =    1024;
		 $scan['k']  =    1024;
		 $scan['b']  =       1;
	 
		foreach ($scan as $unit => $factor) {
			 if (strlen($size) > strlen($unit)
			  && strtolower(substr($size, strlen($size) - strlen($unit))) == $unit) {
				 return substr($size, 0, strlen($size) - strlen($unit)) * $factor;
			 }
		}
		return $size;
	}

}


?>