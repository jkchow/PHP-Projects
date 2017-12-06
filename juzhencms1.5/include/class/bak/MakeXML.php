<?php
/**
* MakeXML
* 
* @author Lin Jiong(slime09@gmail.com)
* @version v1.0
* @license Copyright (c) 2009 Lin Jiong (www.cn09.com)
* The LGPL (http://www.gnu.org/licenses/lgpl.html) licenses.
*/


/*
//导出文件示例
$xml=MakeXML::getInstance();
$data_list=array();
$data_list["expense_money"]=$mysql_class->get_datalist("select * from ".$db_table->expense_money." where is_account='0'");
$xml_string=$xml->getXML($data_list);
$local_filename="当前未结算数据.data";
$local_filename=iconv( "UTF-8","gb2312", $local_filename);
header("Content-type:unknown/unknown;");
header ("Content-Disposition: attachment; filename=$local_filename");
echo $xml_string;
*/


/*
* 从数组生成XML文件
*/
class MakeXML 
{
    private static $instance;
        
    private function __construct(){}

    /**
     * 单件模式调用本类
     *
     * @return 单件模式
     */
    public static function getInstance() {
        if(!isset(self::$instance)){
            self::$instance = new MakeXML();
        }
        return self::$instance;
		
    }
     
    /**
     * 获取XML字串
     * @param $array 用于生成XML的数组,数组可以是二维或多维的，其中的第一个元素作为XML元素名
     * @param $xslName XSL文件名(如:"http://www.xxx.com/templates/normal/xslname.xsl")
     * @return $XMLString 输出XML字符串
     */
    public function getXML($arr,$encoding='utf-8',$xslName=""){
        $XMLString = '<?xml version="1.0" encoding="'.$encoding.'"?>';
        if($xslName!="")
            $XMLString.='<?xml-stylesheet type="text/xsl" href="'.$xslName.'"?>';
        $array=array();
		$array["body"]=$arr;
		$XMLString.=$this->make($array);
        return $XMLString;
    }
    
    /*
     * 递归生成XML字串
     */
    private function make($array)
    {
		foreach($array as $key=>$val) {
			//is_numeric($key)&&$key="item id=\"$key\"";
			is_numeric($key)&&$key="item";
			$xml.="<$key>";
			$xml.=is_array($val)?$this->make($val):htmlspecialchars($val);
			list($key,)=explode(' ',$key);
			$xml.="</$key>";
		}
		return $xml;	
    }
    
    /**
     * 将字串保存到文件
     * @param $fileName 文件名
     * @param $XMLString 已经生成的XML字串
     */
    public function saveToFile($fileName,$XMLString)
    {
        if(!$handle=fopen($fileName,'w'))
        {
            return FALSE;
        }
        if(!fwrite($handle,$XMLString))
        {
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 直接通过数组生成XML文件
     */
    public function write($fileName,$array,$encoding,$xslName=''){
        $XMLString=$this->getXML($array,$encoding,$xslName);
        $result=$this->saveToFile($fileName,$XMLString);
        return $result;
    }
}

?>