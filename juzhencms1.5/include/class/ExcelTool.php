<?
class ExcelTool{
	function readExcelFile($filename,$encoding='utf8'){//参数$encoding可以为utf8,gb2312
		import("lib/Spreadsheet_Excel_Reader/Spreadsheet_Excel_Reader");
		$_rec = array();
		$data = new Spreadsheet_Excel_Reader();
	
	
		// 设置输出的编码格式
		$data->setOutputEncoding($encoding);
		
		if($encoding=="utf8")
			$data->setUTFEncoder('mb'); 
		
		
		//导入excel文件读取sheets
		$data->read($filename);
		$tmp = $data->sheets;
		
		//$_rec = $tmp[$sheet]['cells'];
		
		//return $_rec;
		return $tmp;
	
	}
}
?>