<?
class acl_upload extends base_acl{
	var $default_method="uploadImgCallback";
	//处理后台html表单的图片上传，用于文件上传表单向iframe提交
	function uploadImgCallback(){
		
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->jsAlert("您需要登录后才能进行操作");
			exit;
		}
		
		if($_REQUEST["fieldName"]!="")
			$field_name=$_REQUEST["fieldName"];
		else
			$field_name='Filedata';
			
		$filearr=pathinfo($_FILES[$field_name]['name']);
		$filetype=strtolower($filearr["extension"]);
		
		
		
		
		$uploadFile=new UploadFile();
		
		$uploadFile->allowMaxFileSize=1024*5;//单位是kb
		$uploadFile->allowFileExtNames=array("jpeg","jpg","gif","png","bmp");//允许上传的文件类型,若设置为空则不限定
		
		if(!in_array($filetype,$uploadFile->allowFileExtNames)){
			?>
            <script>
			alert("文件类型不符合要求");
			window.parent.window.document.getElementById("<?=$_REQUEST["fieldId"]?>").value="";
			</script>
			<?        
			exit;
		}
			
		if($_FILES[$field_name]['size']>($uploadFile->allowMaxFileSize *1024)){
			?>
            <script>
			alert("文件太大，请选择5MB以内的文件");
			window.parent.window.document.getElementById("<?=$_REQUEST["fieldId"]?>").value="";
			</script>
			<?            
			exit;
		}
		
		
		$_record=$uploadFile->save_upload_img($field_name,$_REQUEST["imgWidth"],$_REQUEST["imgHeight"]);
		unset($_record["absolutePath"]);
		?>
        
        <script>
		window.parent.window.<?=$_REQUEST["callback"]?>('<?=json_encode($_record)?>'); 
        </script>
        <?
		
		
	}
	
	//处理后台html表单的文件附件上传，用于文件上传表单向iframe提交
	function uploadFileCallback(){
		$memberService=new memberService();
		$mid=$memberService->getLoginMemberInfo("auto_id");
		if($mid==""){
			$this->jsAlert("您需要登录后才能进行操作");
			exit;
		}
		
		if($_REQUEST["fieldName"]!="")
			$field_name=$_REQUEST["fieldName"];
		else
			$field_name='Filedata';
		
		$filearr=pathinfo($_FILES[$field_name]['name']);
		$filetype=strtolower($filearr["extension"]);
		
		$uploadFile=new UploadFile();
		
		$uploadFile->allowMaxFileSize=1024*10;//单位是kb
		$uploadFile->allowFileExtNames=array("doc","docx","pdf","rar","zip","xls","xlsx");//允许上传的文件类型,若设置为空则不限定
		
		if(!in_array($filetype,$uploadFile->allowFileExtNames)){
			?>
            <script>
			alert("文件类型不符合要求");
			window.parent.window.document.getElementById("<?=$_REQUEST["fieldId"]?>").value="";
			</script>
			<?      
			exit;
		}
			
		if($_FILES[$field_name]['size']>($uploadFile->allowMaxFileSize *1024)){
			?>
            <script>
			alert("文件太大，请选择10MB以内的文件");
			window.parent.window.document.getElementById("<?=$_REQUEST["fieldId"]?>").value="";
			</script>
			<?            
			exit;
		}
		
		$_record=$uploadFile->save_upload_file($field_name);
		
		unset($_record["absolutePath"]);
		?>
        <script>
		window.parent.<?=$_REQUEST["callback"]?>('<?=json_encode($_record)?>'); 
        </script>
        <?
		
		
	}
	
}
?>