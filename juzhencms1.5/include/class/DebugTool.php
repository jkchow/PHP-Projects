<?
class DebugTool{
	//可以通过重置此变量修改日志文件名
	static private $filename="_debug_logs.log";
	
	static function getFilename(){
		global $global;
		return $global->fileAbsolutePath."/log/".self::$filename;
	}

	//记录规律性的内容，如访问记录等(会自动记录时间及url)
	static function log($text){
		$url="\r\nhttp://{$_SERVER["HTTP_HOST"]}:{$_SERVER["SERVER_PORT"]}/{$_SERVER["REQUEST_URI"]}";
		$data=date("Y-m-d H:i:s")." {$url}\r\n{$text}\r\n\r\n";
		file_put_contents(self::getFilename(),$data,FILE_APPEND);
	}
	//打印调试的变量，会自动添加换行和回车
	static function printArray($arr){
		ob_start();
		print_r($arr);
		$out =  ob_get_contents();
		ob_end_clean();

		$url="\r\nhttp://{$_SERVER["HTTP_HOST"]}:{$_SERVER["SERVER_PORT"]}/{$_SERVER["REQUEST_URI"]}";
		$data=date("Y-m-d H:i:s")." {$url}\r\n{$out}\r\n\r\n";
		file_put_contents(self::getFilename(),$data."\r\n",FILE_APPEND);
	}
}
?>