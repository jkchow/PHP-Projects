<?
/*echo "<pre>";
print_r($_SERVER);
exit;*/

class page_class{
	
	var $page_size=15;
	var $total_row;
	var $max_page;
	var $now_page;
	var $tag="page";
	var $begin_row;//当前页数据起始行.从0开始
	var $page_row;//当前页的数据条数
	var $pageStyle=1;//默认分页样式，一般会在入口文件重新定义
	
	function __construct()
    {
     	global $global;
		if($global->pageStyle!="")
			$this->pageStyle=$global->pageStyle;
    }
	
	function init($total_row){
		$this->total_row=$total_row;
		if($this->total_row=='')
			$this->total_row=0;
		$this->max_page=$this->get_maxpage($this->total_row,$this->page_size);
		if($_REQUEST[$this->tag]!=''){
			$this->now_page=$_REQUEST[$this->tag];
		}else{
			$this->now_page=1;
		}
		
		if($this->now_page<1)
			$this->now_page=1;
		elseif($this->now_page>$this->max_page)
			$this->now_page=$this->max_page;
			
		$this->begin_row=($this->now_page-1)*$this->page_size;
		$this->page_row=$this->get_pagerow($this->total_row,$this->page_size,$this->now_page);
		
	}
	
	function getPageBar($pageStyle=""){
		if($pageStyle=="")
			$pageStyle=$this->pageStyle;
		switch($pageStyle){
			case 1:
				return $this->get_pageStr_1();
				break;
			case 2:
				return $this->get_pageStr_2();
				break;
			case 3:
				return $this->get_pageStr_3();
				break;	
		}
	}
	
	
	
	//获取最大页数
	private function get_maxpage($total_row,$page_size){
		$totalPages = ceil ($total_row / $page_size);
		if ($total_row == 0) {
			$totalPages++;
		}
		return $totalPages;
	}
	
	//获取当前页数据的条数
	private function get_pagerow($total_row,$page_size,$page){
		if($total_row==0)
			return 0;
		$totalPages=$this->get_maxpage($total_row,$page_size);
		if($page==$totalPages){
			$mod=$total_row % $page_size;
			if($mod!=0)
				return $mod;
		}
		return $page_size;
		
	}
	
	
	
	
	
	
	
	
	private function get_pageStr_1(){
		$url=$this->getUrl();

		$pos = strpos($url, "?");
		if ($pos === false) {
			$url.="?".$this->tag."=";
		}else{
			$url.="&".$this->tag."=";
		}
		ob_start();
		?>
        <ul>
        	<!--<li class="first"><a title="第一页" href="<?=$url."1"?>"></a></li>-->
            <li class="prev"><a title="上一页" href="<?=$url.($this->now_page>1?($this->now_page-1):1)?>"><</a></li>
            <?
			
			$begin_page=$this->now_page-5;
			if($begin_page<1) $begin_page=1;
			$end_page=$this->now_page+5;
			if($end_page>$this->max_page) $end_page=$this->max_page;
			for($i=$begin_page;$i<=$end_page;$i++){
			?>
            <li<? if($i==$this->now_page) echo " class=\"cr\""; ?>><a title="第<?=$i?>页" href="<?=$url.$i?>"><?=$i?></a></li>
            <?
			}
			?>
            
            <li class="next"><a title="下一页" href="<?=$url.($this->max_page>$this->now_page?($this->now_page+1):$this->max_page)?>">></a></li>
            <!--<li class="last"><a title="最后一页" href="<?=$url.$this->max_page?>"></a></li>-->
            
            <!--<li class="total">共<em><?=$this->total_row?></em>个结果</li>-->
            
        </ul>
        <?
		$_res =  ob_get_contents();
		ob_end_clean();
		return $_res;
	
	}
	
	private function get_pageStr_2(){
		$url=$this->getUrl();

		$pos = strpos($url, "?");
		if ($pos === false) {
			$url.="?".$this->tag."=";
		}else{
			$url.="&".$this->tag."=";
		}
		
		$pre_page=$this->now_page>1?($this->now_page-1):1;
		$pre_link="#";
		if($pre_page!=$this->now_page){
			$pre_link=$url.$pre_page;
		}
		
		$next_page=$this->max_page>$this->now_page?($this->now_page+1):$this->max_page;
		$next_link="#";
		if($next_page!=$this->now_page){
			$next_link=$url.$next_page;
		}
		
		ob_start();
		?>	
        <a class="pre" href="<?=$pre_link?>">上一页</a>        
        <a class="num" href="javascript:void(0);"><?=$this->now_page?>/<?=$this->max_page?></a>
        <a class="next" href="<?=$next_link?>">下一页</a>
        <?
		$_res =  ob_get_contents();
		ob_end_clean();
		return $_res;
	
	}
	
	private function get_pageStr_3(){
		$url=$this->getUrl();
		
		$pos = strpos($url, "?");
		if ($pos === false) {
			$url.="?".$this->tag."=";
		}else{
			$url.="&".$this->tag."=";
		}
		
		ob_start();
		?>
        共<?=$this->total_row?>条记录,当前第<?=$this->now_page?>页,共<?=$this->max_page?>页
        <select style="width:100px;" onChange="location.href='<?=$url?>'+this.value">
        	<?
			for($i=1;$i<=$this->max_page;$i++){
			?>
            <option value="<?=$i?>" <? if($i==$this->now_page) echo "selected=\"selected\"" ?>><?=$i?></option>
            <?
			}
			?>
        </select>
        <?
		$_res =  ob_get_contents();
		ob_end_clean();
		return $_res;
	}
	
	
	private function parseURL($add = array (), $del = array (), $page = '') {
		$_GETS = $_GET;
		if ('' === $page)
			$page = $_SERVER['PHP_SELF'];
		//
		if ($del === '') {
			$_GETS = array ();
		}
		elseif (is_array($del) && count($del)) {
			foreach ($del as $key => $value) {
				unset ($_GETS[$value]);
			}
		}
		//
		if (is_array($add) && count($add))
			$_GETS = array_merge($_GETS, $add);
	
		$foreach = 0;
		$newQuery = '';
		if (is_array($_GETS) && count($_GETS)) {
			foreach ($_GETS as $key => $value) {
				if (!$foreach) {
					if(!$global->html_filter)
						$newQuery = '?'.htmlspecialchars($key).'='.htmlspecialchars($value);
					else
						$newQuery = '?'.htmlspecialchars($key).'='.$value;
					$foreach ++;
				} else {
					if(!$global->html_filter)
						$newQuery .= '&'.htmlspecialchars($key).'='.htmlspecialchars($value);
					else
						$newQuery .= '&'.htmlspecialchars($key).'='.$value;
				}
			}
		}
	
		return ($page.$newQuery);
	}
	
	//获取不包含分页参数的URL
	private function getUrl(){
		//判断静态化路径数据是否存在
		global $global,$pathRecord;
		if($pathRecord["auto_id"]!=""){
			return $global->siteUrlPath.$pathRecord["url_path"]."/".$pathRecord["file_name"];	
		}else{
			$url="http://".$_SERVER["HTTP_HOST"];
			if($_SERVER["SERVER_PORT"]!=80)
				$url.=":".$_SERVER["SERVER_PORT"];
			return $url.$this->parseURL(array(),array($this->tag));
		}
		
		
		
	}
	
	
}
?>