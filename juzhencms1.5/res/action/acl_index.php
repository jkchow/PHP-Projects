<?
class acl_index extends base_acl{
	var $default_method="index";
	//��ҳ
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
	
	
	//����������ҳ
	function about(){
		$this->tpl_file="about.php";
		$record=array();
		return $record;
	}
	
	//���̼���
	function joinUs(){
		$this->tpl_file="join.php";
		$record=array();
		return $record;
	}
	
	//���ķֲ�
	function intelnet(){
		$this->tpl_file="intelnet.php";
		global $local_menu;
		$menuService=new menuService();
		//��ȡ��ǰ�۽���Ŀ�������ǰ��ĿΪĿ¼����Ƶ��ģ�壬���Զ�����һ������
		$local_menu=$menuService->getData(82);
		
		$record=array();
		return $record;
	}
	
	//��Ѷ��ҳ
	function newsindex(){
		$this->tpl_file="newsindex.php";
		$record=array();
		return $record;
	}
	/*
	//������������
	function jisuanqi(){
		$this->tpl_file="caluate.php";
		$record=array();
		return $record;
	}
	
	//���������ҳ
	function bbsindex(){
		$this->tpl_file="bbsindex.php";
		$record=array();
		return $record;
	}
*/
	
}
?>