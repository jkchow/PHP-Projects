<?

class acl_ckeditor extends acl_base{
	var $default_method="formCkeditor";
	
	
	//在线编辑器表单
	function formCkeditor(){
		$this->tpl_file="formCkeditor.php";
		$record=array();
		return $record;
	}
	
	
	
	//ckeditor的文件上传
	function ckeditorUpload(){
		
		$config=array();
 
		$config['type']=array("flash","img","file"); //上传允许type值
		 
		$config['img']=array("jpeg","jpg","bmp","gif","png"); //img允许后缀
		$config['flash']=array("flv","swf"); //flash允许后缀
		$config['file']=array("doc","docx","xls","xlsx","pdf","zip","rar","txt","jpeg","jpg","bmp","gif","png"); //文件允许后缀
		 
		$config['flash_size']=1000; //上传flash大小上限 单位：KB
		$config['img_size']=500; //上传img大小上限 单位：KB
		$config['file_size']=10000;
		$config['message']="上传成功"; //上传成功后显示的消息，若为空则不显示
		 


		 //判断是否是非法调用
		 if(empty($_GET['CKEditorFuncNum']))
				$this->ckeditorUploadCallback(1,"","错误的功能调用请求");
		 $fn=$_GET['CKEditorFuncNum'];
		 if(!in_array($_GET['type'],$config['type']))
				$this->ckeditorUploadCallback(1,"","错误的文件调用请求");
		 $type=$_GET['type'];
		 if(is_uploaded_file($_FILES['upload']['tmp_name']))
		 {
			//判断上传文件是否允许
			$filearr=pathinfo($_FILES['upload']['name']);
			$filetype=strtolower($filearr["extension"]);
			if(!in_array($filetype,$config[$type]))
			 	$this->ckeditorUploadCallback($fn,"","错误的文件类型！");
			//判断文件大小是否符合要求
			if($_FILES['upload']['size']>$config[$type."_size"]*1024)
			 	$this->ckeditorUploadCallback($fn,"","上传的文件不能超过".$config[$type."_size"]."KB！");
			//$filearr=explode(".",$_FILES['upload']['name']);
			//$filetype=$filearr[count($filearr)-1];
			$uploadFile=new UploadFile();
			$_record=$uploadFile->save_upload_file('upload');
			
		 
		    if($_record['urlPath']!=""){
			 	$this->ckeditorUploadCallback($fn,$_record['urlPath'],$config['message']);
			}
			else{
			 	$this->ckeditorUploadCallback($fn,"","文件上传失败，请检查上传目录设置和目录读写权限");
			}
		 }
	}
	
	//输出ckeditor的文件上传js调用，仅在函数ckeditorUpload内部调用
	private function ckeditorUploadCallback($fn,$fileurl,$message){
		$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
		//echo $str;
		exit($str);
	}
	
}

?>