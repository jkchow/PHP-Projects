<?

class acl_upload extends acl_base{
	var $default_method="uploadFile";
	
	//上传图片的html表单
	function formImgUpload(){
		$this->tpl_file="formImgUpload.php";
		$record=array();
		return $record;
	}
	//上传文件的html表单
	function formFileUpload(){
		$this->tpl_file="formFileUpload.php";
		$record=array();
		return $record;
	}
	//flash上传图片的表单模板
	function formImgUpload_flash(){
		$this->tpl_file="formImgUpload_flash.php";
		$record=array();
		return $record;
	}
	//flash上传文件的表单模板
	function formFileUpload_flash(){
		$this->tpl_file="formFileUpload_flash.php";
		$record=array();
		return $record;
	}
	//flash上传视频的表单模板
	function formVideoUpload(){
		$this->tpl_file="formVideoUpload.php";
		$record=array();
		return $record;
	}
	
	
	
	//后台文件上传，用于flash上传文件附件
	function uploadFile(){	
		if($_REQUEST["fieldName"]!="")
			$fieldName=$_REQUEST["fieldName"];
		else
			$fieldName='Filedata';		
		$uploadFile=new UploadFile();
		$_record=$uploadFile->save_upload_file($fieldName);
		echo json_encode($_record);
	}
	//后台图片上传，用于flash上传图片附件，可以设定图片的裁切方式与缩放尺寸
	function uploadImg(){
		if($_REQUEST["fieldName"]!="")
			$fieldName=$_REQUEST["fieldName"];
		else
			$fieldName='Filedata';
		
		$uploadFile=new UploadFile();
		$_record=$uploadFile->save_upload_img($fieldName,$_REQUEST["imgWidth"],$_REQUEST["imgHeight"],$_REQUEST["cutType"]);
		echo json_encode($_record);
	}
	
	//处理后台html表单的图片上传，用于文件上传表单向iframe提交
	function uploadImgCallback(){
		if($_REQUEST["fieldName"]!="")
			$field_name=$_REQUEST["fieldName"];
		else
			$field_name='Filedata';
		
		
		$uploadFile=new UploadFile();
		
		$uploadFile->allowMaxFileSize=1024;//单位是kb
		$uploadFile->allowFileExtNames=array("jpeg","jpg","gif","png","bmp");//允许上传的文件类型,若设置为空则不限定
		
		
		$_record=$uploadFile->save_upload_img($field_name,$_REQUEST["imgWidth"],$_REQUEST["imgHeight"]);
		unset($_record["absolutePath"]);
		?>
        
        <script>
		window.parent.uploadCallback('<?=json_encode($_record)?>'); 
        </script>
        <?
		
		
	}
	
	//处理后台html表单的文件附件上传，用于文件上传表单向iframe提交
	function uploadFileCallback(){
		if($_REQUEST["fieldName"]!="")
			$field_name=$_REQUEST["fieldName"];
		else
			$field_name='Filedata';
		
		
		
		$uploadFile=new UploadFile();
		
		$uploadFile->allowMaxFileSize=1024*20;//单位是kb
		$uploadFile->allowFileExtNames=array();//允许上传的文件类型,若设置为空则不限定
		
		$_record=$uploadFile->save_upload_file($field_name);
		
		unset($_record["absolutePath"]);
		?>
        
        <script>
		window.parent.uploadCallback('<?=json_encode($_record)?>'); 
        </script>
        <?
		
		
	}
	
	
	
}

?>