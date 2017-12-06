<?

/*//环境变量格式
$isPayType=array();

$isPayType[0]['label_en']='s0';
$isPayType[0]['label']='未支付';
$isPayType[0]['value']='0';
$isPayType[0]['color']='';

$isPayType[1]['label_en']='s1';
$isPayType[1]['label']='已支付';
$isPayType[1]['value']='1';
$isPayType[1]['color']='';*/


class form_class
{
	
	//根据时间产生随即的订单号
	function create_no()
	 {
	  list ($usec, $sec) = explode(' ', microtime());
	  return (float) $sec + ((float) $usec * 1000000);
	 }

	
	//根据环境变量的value获取单个变量
	function getVarByValue($arr,$value){
		if(is_array($arr))
		foreach($arr as $key => $vl){
			if($vl["value"]==$value)
				return $vl;
		}
		return '';
	}
	
	function getVarLabelByValue($arr,$value){
		if(is_array($arr))
		foreach($arr as $key => $vl){
			if($vl["value"]==$value){
				if($vl["color"]!='')
					return "<font color=\"#FF0000\">".$vl["label"]."</font>";
				else
					return $vl["label"];
			}
		}
		return '';
	}
	
	//通过数据表获取环境变量数组
	function get_arr_by_table($table,$value_field,$label_field,$where){
		$tmp=getDataList($table,$where);
		return $this->get_arr_by_datalist($tmp,$value_field,$label_field);
	}
	
	//通过数据集合获取环境变量数组
	function get_arr_by_datalist($datalist,$value_field,$label_field){
		$tmp=$datalist;
		$num = count($tmp);
		$arr=array();
		for($i=0; $i<$num; $i++){
			$arr[$i]["label"]=$tmp[$i][$label_field];
			$arr[$i]["value"]=$tmp[$i][$value_field];
		}
		return $arr;
	}
	
	//根据数值字符串获取部分数组,参数2格式如',3,4,5,'
	function get_sub_arr($arr,$value_str,$compart=","){
		$value_str=trim($value_str,$compart);
		$value_arr=explode($compart,$value_str);
		
		if(is_array($value_arr) && count($value_arr)>0){
			$return_arr=array();
			foreach($value_arr as $key=>$vl){
				$return_arr[]=$this->getVarByValue($arr,$vl);
			}

			return $return_arr;
		}else{
			return '';
		}
	}
	
	//利用环境变量生成option
	function make_select_option($array,&$selected='',$auto_select=false,$value_field='id',$text_field='text'){
		$num = count($array);
		
		if($selected=='' && $auto_select==true)
			$selected=$array[0][$value_field];
		
		ob_start();
		for($i=0; $i<$num; $i++){
			$_curr = $array[$i];
			
			if($value_field!='')
				$_curr['value']=$_curr[$value_field];
			?>
			<option value='<?=$_curr['value']?>' <?=($_curr['value']==$selected)?'selected':''?>><?=$_curr[$text_field]?></option>
			<?
		}
		$_res =  ob_get_contents();
		ob_end_clean();
		return $_res;
	}
	
	//利用数据表生成树形option
	function make_tree_option($table,$value_field='',$label_field='',$code_field='',$where='',$selected=''){
		
		$list=getDataList($table,$where);
		ob_start();
		if(is_array($list))
		foreach($list as $key=>$vl){
			$deep="";
			for($i=0;$i<strlen($vl[$code_field])-4;$i++)
				$deep.="-";
			?>
			<option value='<?=$vl[$value_field]?>' <?=($vl[$value_field]==$selected)?'selected':''?>><?=$deep.$vl[$label_field]?></option>
			<?
		}
		$_res =  ob_get_contents();
		ob_end_clean();
		return $_res;
	}
	
	//获得复选框数组
	function get_checkbox_arr($arrray,$name='checkbox',$value='',$class=''){
		$num = count($arrray);
		$checked=explode(',',$value);
		if($class!='')
			$class_str=" class='".$class."' ";
		$checkbox_arr=array();
		for($i=0; $i<$num; $i++){
	
			$_curr = $arrray[$i];
			$_enlabel = '';
			ob_start();
			if(is_array($checked))
			{
			?>
			<input type="checkbox" value="<?=$_curr['value']?>" name="<?=$name?>[]" <?=$class_str?> <?=(in_array($_curr['value'],$checked))?'checked':''?>/><?=$_curr['label']?>	
			<? }else{?>
			<input type="checkbox" value="<?=$_curr['value']?>" name="<?=$name?>[]"  <?=$class_str?> /><?=$_curr['label']?>
			<?php }
			$checkbox_arr[] =  ob_get_contents();
			ob_end_clean();
		}
		return $checkbox_arr;
	}
	
	
	
	//利用环境变量生成checkbox
	function make_checkbox($arrray,$name='checkbox',$value='',$class='',$compart="&nbsp;"){
		
		$checkbox_arr=$this->get_checkbox_arr($arrray,$name,$value,$class);
		$_res="<ul style=\" margin:5px 0;\">";
		if(is_array($checkbox_arr))
		foreach($checkbox_arr as $key=>$vl){
			$_res.="<li style=\" width:75px; float:left;\">".$vl."</li>";
		}
		$_res.="</ul>";
		return $_res;
	}
	
	//生成带有id的checkbox
	function make_checkbox2($arrray,$name='checkbox',$id='',$value='',$class='',$compart="&nbsp;"){
		
		$checkbox_arr=$this->get_checkbox_arr2($arrray,$name,$id,$value,$class);
		$_res="<ul style=\" margin:10px 0;\">";
		if(is_array($checkbox_arr))
		foreach($checkbox_arr as $key=>$vl){
			$_res.="<li style=\" width:90px; float:left;\">".$vl."</li>";
		}
		$_res.="</ul>";
		return $_res;
	}
	
	//获得单选按钮数组
	function get_radio_arr($arrray,$name='radio',$value='',$class=''){
		$num = count($arrray);
		$checked=explode(',',$value);
		if($class!='')
			$class_str=" class='".$class."' ";
		$checkbox_arr=array();
		for($i=0; $i<$num; $i++){
	
			$_curr = $arrray[$i];
			$_enlabel = '';
			ob_start();
			if(is_array($checked))
			{
			
			$id=$name."_".($i+1);
			?>
			<input type="radio" value="<?=$_curr['value']?>" title="<?=$_curr['label']?>" id="<?=$id?>" name="<?=$name?>" <?=$class_str?> <?=(in_array($_curr['value'],$checked))?'checked':''?>/>
            <a href="javascript:document.getElementById('<?=$id?>').click();"><?=$_curr['label']?></a>	
			<? }else{?>
			<input type="radio" value="<?=$_curr['value']?>" title="<?=$_curr['label']?>" id="<?=$id?>" name="<?=$name?>"  <?=$class_str?> />
			<a href="javascript:document.getElementById('<?=$id?>').click();"><?=$_curr['label']?></a>
			
			<?php }
			$checkbox_arr[] =  ob_get_contents();
			ob_end_clean();
		}
		return $checkbox_arr;
	}
	
	//利用环境变量生成radio
	function make_radio($arrray,$name='radio',$value='',$class='',$compart="&nbsp;"){

		
		$checkbox_arr=$this->get_radio_arr($arrray,$name,$value,$class);
		$_res='';
		if(is_array($checkbox_arr))
		foreach($checkbox_arr as $key=>$vl){
			$_res.=$vl.$compart;
		}
		return $_res;
	}
	
	
	
	
	//获取复选框的值
	function access_check_value(&$value_arr){
		if(is_array($value_arr)){
			$str=",";
			foreach ($value_arr as $key => $vl){
				$str.=$vl.",";
			}
			$value_arr=$str;
			return $str;	
		}	
	}
	
	//将复选框的值替换成文本
	function get_checkbox_value_text($arr,$value_str){
		$value_arr=explode(',',$value_str);
		if(is_array($value_arr)){
			$value_text="";
			foreach($value_arr as $key=>$vl){
				if($vl!=''){
					if($value_text=="")
						$value_text=$this->getVarLabelByValue($arr,$vl);
					else
						$value_text.=",".$this->getVarLabelByValue($arr,$vl);
				}
			}
			return $value_text;
		}
	}
	
	
	
	//获取文本区textarea中的内容，将\n转换为<br/>,将空格转换为&nbsp;&nbsp;
	function get_textarea_string($str){
		$return_str="";
		$text_arr=explode("\n",trim($str,"\n"));
		$line_count=count($text_arr);
		foreach($text_arr as $key=>$vl){
			if($key<$line_count-1)
				$return_str.=str_replace(" ","&nbsp;&nbsp;",$vl)."<br/>";
			else $return_str.=str_replace(" ","&nbsp;&nbsp;",$vl);
		}
		return $return_str;
	}
	
	//打印html代码(加转义,参数可以是数组)
	function print_html($arr,$deep=0){
		if(is_array($arr)){
			echo "array<br/>";
			for($i=0;$i<$deep;$i++)
				echo "&nbsp;&nbsp;";
			echo "(<br/>";	
			$deep++;
			foreach($arr as $key=>$vl){
				
				for($i=0;$i<$deep;$i++)
					echo "&nbsp;&nbsp;";
				echo "[".$key."]=";
				$this->print_html($vl,$deep);
			}
			$deep--;
			for($i=0;$i<$deep;$i++)
				echo "&nbsp;&nbsp;";
			echo ");<br/>";
		}
		else{
			echo htmlspecialchars($arr)."<br>";
		}
	}
	/**
	 * 用插件替换数组字段
	 * @param $arr
	 * @param $Plugins
	 */
	function set_plugins($arr,$Plugins){
		$_array=array();
		if(is_array($arr))
		foreach($arr as $key=>$_arr){
			if (is_array($Plugins)) {
	
				foreach ($Plugins as $key => $val) {
	
					$key = key($val);
					$val = $val[$key];
					array_unshift($val, $_arr);
					call_user_func_array($key, $val);
				}
			}
	
			if (!empty ($_arr))
				$_array[] = $_arr;
		}
		return $_array;
	}
	//获取随机数
	function get_random()
	{
		list ($usec, $sec) = explode(' ', microtime());
		return (float) $sec + ((float) $usec * 1000000);
	}
	
	//根据地区编码获取地区名称
	function get_label_by_db_code($code,$table,$code_field,$label_field){

			$member_address="";
			$area_level=strlen($code);
			for($i=4;$i<=$area_level;$i++){
				$tmp_area=getData($table,substr($code,0,$i),$code_field);
				$member_address.=$tmp_area[$label_field]."&nbsp;";	
			}
			return $member_address;
	}
	
	function get_index_vars($table,$value_field,$label_field,$where=''){
		$list=getDatalist($table,$where);
		
		
		$return_arr=array();
		if(is_array($list))
		foreach($list as $key=>$vl){
			$return_arr[$vl[$value_field]]=$vl[$label_field];
		}
		
		return $return_arr;
	}
	
	function get_url(){
		$url_this = 'http://'.$_SERVER['SERVER_NAME'];
		if($_SERVER["SERVER_PORT"]!=80)
			$url_this.=':'.$_SERVER["SERVER_PORT"];
		
		return $url_this.$this->parseURL(array(),array($this->tag));
		
		return $url_this;
	}
	
	function parseURL($add = array (), $del = array (), $page = '') {
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
			foreach ($_GETS AS $key => $value) {
				if (!$foreach) {
					$newQuery = '?'.$key.'='.$value;
					$foreach ++;
				} else {
					$newQuery .= '&'.$key.'='.$value;
				}
			}
		}
	
		return ($page.$newQuery);
	}
	
}
?>