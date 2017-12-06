<?

class acl_download extends acl_base{
	var $default_method="downloadFile";
	function downloadFile(){
		global $global;
		if($_REQUEST["file"]=="")
			return;
			
		$tmpFile=base64_decode($_REQUEST["file"]);
		//判断是否有指向上级的目录
		if(strpos($tmpFile,"../")!==false || strpos($tmpFile,"..\\")!==false){
			echo "不允许访问";
            exit;
		}
		//不允许下载程序文件
		$ext_name =strtolower(substr($tmpFile, strrpos($tmpFile,".")+1 ));
		if($ext_name=="" || in_array($ext_name,array("php","sql","xml","sh","bat"))){
			echo "禁止下载";
            exit;
		}	
		$file=$global->uploadAbsolutePath.$tmpFile;
        
		
		if(!file_exists($file)) {
            echo "文件不存在";
            exit;
        }
		$fileName=$this->getFileName($file);
		if(!$fileName)
			return;
		
		header( "Pragma: public" ); 
		header( "Expires: 0" ); // set expiration time 
		header( "Cache-Component: must-revalidate, post-check=0, pre-check=0" ); 
		header( "Content-type:application/octet-stream" ); 	
		header( "Content-Length: " . filesize( $file ) ); 
		header( "Content-Disposition: attachment; filename=\"{$fileName}\"" ); 
		header( 'Content-Transfer-Encoding: binary' ); 
		readfile( $file ); 
	}
	
	private function getFileName($path){
		$path=str_replace("\\","/",$path);
		$pos = strrpos($path, "/");
		if($pos !== false){
			return substr($path,$pos+1);
		}else{
			return false;
		}
	}
}

?>