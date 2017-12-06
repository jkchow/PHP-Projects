<?

class acl_dbBack extends acl_base{
	var $default_method="lists";
	function lists(){
		$this->tpl_file="lists.php";
		$record=array();
		return $record;
	}
	
	function listsData(){
		global $global;
		
		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		$this->tpl_file="";
		$dir="{$global->fileAbsolutePath}/db_back"; 
		
		$handle=opendir($dir); 
		$file_arr=array();
		while (false !== ($file = readdir($handle)))
		{
			if ($file != "." && $file != "..") {
				$file_arr[]=$file;
			}
		}
		
		closedir($handle); 
		rsort($file_arr,SORT_STRING);
		
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		
		
		$list=array_slice($file_arr,$begin_count,$pagesize,true);
		
		$returnList=array();
		if(is_array($list))
		foreach($list as $key=>$file){
			$tmp=array();
			$tmp["file_name"]=$file;;
			$tmp["file_size"]=abs(filesize($dir."/".$file));
			if($tmp["file_size"]>=(1024*1024))
				$tmp["file_size"]=round($tmp["file_size"]/(1024*1024),2)."M";
			else
				$tmp["file_size"]=round($tmp["file_size"]/(1024),2)."K";
			$tmp["modify_time"]=filemtime($dir."/".$file);
			$tmp["modify_time"]=date("Y-m-d H:i:s",$tmp["modify_time"]);
			$returnList[]=$tmp;
		}
		$total=count($file_arr);
		
		$return_arr=array();
		$return_arr["Rows"]=$returnList;
		$return_arr["Total"]=$total;
		
		echo json_encode($return_arr);

	}
	
	
	
	function delete(){
		global $global;
		if($_REQUEST["auto_id"]!=""){
			$idStr=trim($_REQUEST["auto_id"],',');
			$idArr=explode(',',$idStr);
			$dir="{$global->fileAbsolutePath}/db_back/";
			
			
			if(is_array($idArr) && count($idArr)>0){
				foreach($idArr as $key=>$vl){
					if($vl=="")
						unset($idArr[$key]);
					else{
						//判断文件是否存在在，若存在删除文件
						$file_name=$dir.$vl;
						if(file_exists($file_name))
							unlink($file_name);
					}
				}	
			}
		}	
		//$this->redirect("?acl={$_REQUEST["acl"]}&method=lists");
		echo json_encode(array("result"=>1,"msg"=>"操作成功"));
	}
	
	function dbBack(){
		global $global;
		$dir="{$global->fileAbsolutePath}/db_back/";
		$MysqlBack=new MysqliBack();
		$fileName=date('Y-m-d_H-i-s').".sql";
		$msg=$MysqlBack->back_to_file($dir.$fileName);
		//记录到数据库备份恢复日志
		$logFile="{$global->fileAbsolutePath}/log/_db_logs.log";
		file_put_contents($logFile,date("Y-m-d H:i:s")."|数据库备份|{$fileName}|{$msg}\r\n",FILE_APPEND);
		$this->redirect("?acl={$_REQUEST["acl"]}&method=lists","{$msg}");
	}
	
	function downloadDbFile(){
		global $global;
		if($_REQUEST["file"]=="")
			return;
		
		$file=base64_decode($_REQUEST["file"]);
		$file=$global->fileAbsolutePath."/db_back/".$file;
		
		if(!file_exists($file))
			return;
			
		$path=str_replace("\\","/",$file);
		$pos = strrpos($path, "/");
		if($pos !== false){
			$fileName=substr($path,$pos+1);	
			if(!$fileName)
				return;
		}
		
		header( "Pragma: public" ); 
		header( "Expires: 0" ); // set expiration time 
		header( "Cache-Component: must-revalidate, post-check=0, pre-check=0" ); 
		header( "Content-type:application/octet-stream" ); 	
		header( "Content-Length: " . filesize( $file ) ); 
		header( "Content-Disposition: attachment; filename=\"{$fileName}\"" ); 
		header( 'Content-Transfer-Encoding: binary' ); 
		readfile( $file );
	}
	
	function dbRestore(){
		global $global;
		
		$fileName="{$global->fileAbsolutePath}/db_back/".$_GET["auto_id"];
		$mysqlRestore=new MysqliRestore();
		$mysqlRestore->import_file($fileName);
		
		//记录到数据库备份恢复日志
		$logFile="{$global->fileAbsolutePath}/log/_db_logs.log";
		file_put_contents($logFile,date("Y-m-d H:i:s")."|数据库恢复|{$_GET["auto_id"]}|数据库恢复成功\r\n",FILE_APPEND);
		$this->redirect("?acl={$_REQUEST["acl"]}&method=lists","数据库恢复成功");
	}
	
	function logLists(){
		$this->tpl_file="logLists.php";
		$record=array();
		return $record;
	}
	
	function logListsData(){
		global $global;
		
		//page=2&pagesize=20&sortname=content_name&sortorder=asc
		//echo '{Rows:[{"auto_id":"1","content_name":"Alfreds Futterkiste","content_kind":"Maria Anders","publish":"Sales Representative","content_hit":"335","create_user":"Berlin","create_time":null}],Total:21}';
		$this->tpl_file="";
		$logFile="{$global->fileAbsolutePath}/log/_db_logs.log";
		
		$file_arr=file($logFile);
		
		
		
		
		if(is_array($file_arr)){
			if($file_arr[count($file_arr)-1]==""){//防止最后手动多输入空格
				unset($file_arr[count($file_arr)-1]);
			}
		}else{
			$file_arr=array();
		}
		rsort($file_arr,SORT_STRING);
		
		
		$pagesize=20;
		if($_REQUEST["pagesize"]!="")
			$pagesize=$_REQUEST["pagesize"];
		$page=1;
		if($_REQUEST["page"]!="")
			$page=$_REQUEST["page"];
		$begin_count=($page-1)*$pagesize;
		
		
		$list=array_slice($file_arr,$begin_count,$pagesize,true);
		
		$returnList=array();
		if(is_array($list))
		foreach($list as $key=>$vl){
			
			if($vl!=""){
				$tmpArr=explode('|',$vl);
				
				$tmp=array();
				$tmp["c0"]=$tmpArr[0];
				$tmp["c1"]=$tmpArr[1];
				$tmp["c2"]=$tmpArr[2];
				$tmp["c3"]=$tmpArr[3];
				
				$returnList[]=$tmp;
				
			}
			
			
		}
		$total=count($file_arr);
		
		$return_arr=array();
		$return_arr["Rows"]=$returnList;
		$return_arr["Total"]=$total;
		
		
		echo json_encode($return_arr);
	}
	
}

?>