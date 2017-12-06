<?

class acl_img extends acl_base{
	function QRcode(){
		if($_REQUEST["value"]=="")
			return;
		
		if(!class_exists("QRcode",false)){
			import("lib/phpqrcode/qrlib");
		}
		$errorCorrectionLevel = "L";  
		$matrixPointSize = "4";
		QRcode::png($_REQUEST["value"], false, $errorCorrectionLevel, $matrixPointSize); 
	}
	
	
}

?>