<?
class Pinyin{
	
	static $pinyin_arr;//存储拼音数据，以便多次使用时不会重复读取文件
	
	//获取字符串的首字拼音
	function getFirstCharPinyinLetter($str){
		$first_char= $this->csubstr($str, 0, 1,"utf-8",false);
		if($this->is_chinese_str($first_char))
			return substr($this->get_pinyin($first_char),0,1);
		else
			return $first_char;
	}
	
	//截取字符串的函数,中文算作1个字符
	function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
		if(function_exists("mb_substr")){
			if(mb_strlen($str, $charset) <= $length) return $str;
			$slice = mb_substr($str, $start, $length, $charset);
		}else{
			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			if(count($match[0]) <= $length) return $str;
			$slice = join("",array_slice($match[0], $start, $length));
		}
		if($suffix) return $slice."...";
		return $slice;
	}

	//判断字符串是否是中文
	function is_chinese_str($str,$charset="utf-8"){
		if($charset=="utf-8"){
			if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$str)){
				return true;
			} else {
				return false;
			}
		}
	}

	//获取汉字的拼音(获取一个汉字)
	function get_pinyin($chinese_char){
		if(!is_array(Pinyin::$pinyin_arr)){
			global $global;
			Pinyin::$pinyin_arr=file($global->absolutePath.'/file/pinyin_utf8.dat');
		}
			
		foreach(Pinyin::$pinyin_arr as $vl){
			$pos = strpos($vl, "`");
			if ($pos === false) {
			}else{
				$pinyin_char=substr($vl,0,$pos);
				if($chinese_char==$pinyin_char){
					$pinyin=substr($vl,$pos+1);
					return trim($pinyin);
				}
			}
		}
	}
	
	//将字符串转换为中文
	
}
?>