<?
class acl_download extends base_acl{
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
		exit;
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
	
	//app下载
	function downloadApp(){
		global $global,$dao;
		//判断app是否存在
		if($_GET["app_id"]==""){
			$_GET["app_id"]=1;
		}
		
		$app_id=$_GET["app_id"];
			
		//判断是否在微信
		if(strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")){
			//打开提示页面
			$global->tplAbsolutePath=$global->absolutePath."/res/tpl/system/appDownload/";
			$global->tplUrlPath=$global->siteUrlPath."/res/tpl/system/appDownload/";
			$this->tpl_file="appdown.php";
			$record=array();
			return $record;
		}
		
		
		//判断操作系统类型
		if($global->clientOS=="iPhone"){
			//ios跳转到appstore
			$appVersion=$dao->get_row_by_where($dao->tables->app_version,"where app_id='{$app_id}' and os_type='1' order by version_num desc");
			if($appVersion["content_url"]!=""){
				$this->redirect($appVersion["content_url"]);
			}else{
				echo "未找到新版本地址";
				exit;
			}
			
		}elseif($global->clientOS=="Android"){
			//android下载文件
			$appVersion=$dao->get_row_by_where($dao->tables->app_version,"where app_id='{$app_id}' and os_type='2' order by version_num desc");
			if($appVersion["content_file"]!=""){
				
				$file=$global->uploadAbsolutePath.$appVersion["content_file"];
				$fileName=$this->getFileName($file);
				if(!$fileName){
					echo "文件错误";
					exit;
				}
				
				header( "Pragma: public" ); 
				header( "Expires: 0" ); // set expiration time 
				header( "Cache-Component: must-revalidate, post-check=0, pre-check=0" ); 
				header( "Content-type:application/octet-stream" ); 	
				header( "Content-Length: " . filesize( $file ) ); 
				header( "Content-Disposition: attachment; filename=\"{$fileName}\"" ); 
				header( 'Content-Transfer-Encoding: binary' ); 
				readfile( $file );
				exit;
				
			}else{
				echo "未找到新版本地址";
				exit;
			}
			
		}else{
			//其余系统提示请使用手机浏览
			echo "请使用手机进行下载";
			exit;
		}	
		
	}
}
?>