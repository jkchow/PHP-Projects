<?
class acl_index extends base_acl{
	var $default_method="index";
	//首页
	function index(){
		$this->tpl_file="index.php";
		$record=array();
		return $record;
	}
	
	function activity(){
		$this->tpl_file="activity.php";
		$record=array();
		return $record;
	}
	
	
	//关于我们首页
	function about(){
		$this->tpl_file="about.php";
		$record=array();
		return $record;
	}
	
	//招商加盟
	function joinUs(){
		$this->tpl_file="join.php";
		$record=array();
		return $record;
	}
	
	//中心分布
	function intelnet(){
		$this->tpl_file="intelnet.php";
		global $local_menu;
		$menuService=new menuService();
		//获取当前聚焦栏目，如果当前栏目为目录且无频道模板，则自动找下一级数据
		$local_menu=$menuService->getData(82);
		
		$record=array();
		return $record;
	}
	
	//资讯首页
	function newsindex(){
		$this->tpl_file="newsindex.php";
		$record=array();
		return $record;
	}
	/*
	//理财收益计算器
	function jisuanqi(){
		$this->tpl_file="caluate.php";
		$record=array();
		return $record;
	}
	
	//理财社区首页
	function bbsindex(){
		$this->tpl_file="bbsindex.php";
		$record=array();
		return $record;
	}
*/
	
}
?>