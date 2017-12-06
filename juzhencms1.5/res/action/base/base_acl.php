<?
class base_acl{
	var $default_method="";
	var $tpl_file="";
	
	function forward($method){
		global $global,$dao,$enumVars;
		
		//引入自定义的全局变量
		global $top_menu_focus,$local_menu,$global_params,$global_link;
		
		if($method==""){
			$method=$this->default_method;
			$_REQUEST["method"]=$method;
			if($method==""){
				echo "method is null";
				exit;
			}
		}
			
		if(method_exists($this,$method)){
			$global->requestMethodName=$method;
			$_record=$this->$method();
			if($this->tpl_file!=""){
				if(file_exists($global->tplAbsolutePath.$this->tpl_file)){
					//记录访问日志
					$vistorService=new vistorService();
					$vistorService->addLog("web");
					include($global->tplAbsolutePath.$this->tpl_file);
				}else{
					echo "模板{$this->tpl_file}不存在";
				}
			}
		}else{
			echo "method not exist ";
			//$action=get_acl("error");
			//$action->forward("error404");
		}
		exit;
	}
	
	protected function tplFile(){
		global $local_menu;
		$this->tpl_file=$local_menu["action_method"];
	}
	
	protected function detailTplFile(){
		global $local_menu;
		$this->tpl_file=$local_menu["detail_method"];
	}
	
	protected function redirect($url,$alertMsg=NULL){
		if($alertMsg==NULL && $alertMsg=="" && !headers_sent()){
			header("location:{$url}");
			exit;
		}else{
			echo "<script>";
			if($alertMsg!=NULL && $alertMsg!="")
				echo "alert('{$alertMsg}');";
			echo "location.href='{$url}';</script>";
			exit;
		}
	}
	
	protected function redirectBack($alertMsg=NULL){
		if($alertMsg!=""){
			$alertStr="alert('{$alertMsg}');";
		}
		echo "<script>{$alertStr}history.back();</script>";
		exit;
	}
	
	
	protected function jsAlert($alertMsg){
		echo "<script>alert('{$alertMsg}');</script>";
	}
}
?>