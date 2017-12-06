<?

class mysqliDao{
	var $conn;
	var $db_host;
    var $db_user;
    var $db_pass;
    var $db_name;
	var $db_encoding;
	var $tables;
	var $debug=false;
	function __construct(){
     	
    }
	//以下是基础操作====================================================================================
	
	function init($db_host,$db_user,$db_pass,$db_name,$db_encoding="utf8"){
		$this->db_host=$db_host;
		$this->db_user=$db_user;
		$this->db_pass=$db_pass;
		$this->db_name=$db_name;
		$this->db_encoding=$db_encoding;
	}
	
	function get_conn(){
		$this->conn=mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
		//mysql_select_db($this->db_name,$this->conn);//连接到指定的数据库
		mysqli_query($this->conn,"set names ".$this->db_encoding);//设置字符编码
	}
	
	function query($sql){
		if($this->conn==''){
			$this->get_conn();
		}
		$rs=mysqli_query($this->conn,$sql);
		//是否开启SQL调试
		if($this->debug){
			$error_msg=$this->get_error_message();
			if($error_msg!=""){
				
				$sql_str=addslashes($sql);
				$error_msg=addslashes($error_msg);
				$url=addslashes($_SERVER["REQUEST_URI"]);
				$debug_sql="insert into {$this->tables->sql_debug} set content_url='{$url}', content_sql='{$sql_str}',content_error='{$error_msg}',create_time=now()";
				mysqli_query($this->conn,$debug_sql);
				
				
			}
			/*echo "<b>".$sql."</b><br/>";
			echo $this->get_error_message();
			echo "<br/>";*/
		}
		return $rs;
	}
	
	function get_insert_id(){
		return mysqli_insert_id($this->conn);
	}
	
	function get_affect_rows(){
		return mysqli_affected_rows($this->conn);
	}
	
	function get_error_message(){
		return mysqli_error ($this->conn);
	}
	
	function get_datalist($sql){
		$R=$this->query($sql);
		if($R)
		while($v=mysqli_fetch_assoc($R)){
			$datalist[]=$v;
		} 
		return $datalist;
	}
	
	function get_row_by_where($table,$where,$field_arr=NULL){
		
		if(!array($field_arr) || count($field_arr)==0){
			$field_str="*";
		}else{
			$field_str=implode(',',$field_arr);
		}
		
		$data_list=$this->get_datalist("select {$field_str} from ".$table." ".$where." limit 0,1");
		return $data_list[0];
	}
	
	//最后一个参数表示是否需要sql转义,默认为自动判断,可为true,false,"auto"
	function insert($table,$array,$escape="auto"){
		//可能需要对$array进行转义
		$array=$this->escape_data($array,$escape);
		
		$field_str="";
		$value_str="";
		if(is_array($array))
		foreach($array as $key=>$vl){
			if($field_str=='')
				$field_str.=$key;
			else
				$field_str.=",".$key;
			
			if($value_str=='')
				$value_str.="'".$vl."'";
			else
				$value_str.=",'".$vl."'";
		}
		$sql="insert into ".$table."(".$field_str.") values(".$value_str.")";
		$this->query($sql);	
		return $this->get_insert_id();
	}
	
	function update($table,$array,$where,$escape="auto"){
		if(!is_array($array) || count($array)==0)
			return;
		
		//可能需要对$array进行转义
		$array=$this->escape_data($array,$escape);
		
		$data_str="";
		foreach($array as $key=>$vl){
			if($data_str=='')
				$data_str.=$key."='".$vl."'";
			else
				$data_str.=",".$key."='".$vl."'";
		}	
		$sql="update ".$table." set ".$data_str." ".$where;	
			
			$this->query($sql);	
		return $this->get_affect_rows();
	}
	
	function delete($table,$where){
		$sql="delete from ".$table." ".$where;
		$this->query($sql);	
		return $this->get_affect_rows();
	}
	
	//转义数据
	function escape_data($array,$escape="auto"){
		if(!is_bool($escape) && $escape=="auto"){
			/*if(get_magic_quotes_gpc())
				$escape=false;
			else
				$escape=true;*/
			
			$escape=false;
			global $global;
			if(!$global->auto_addslashes){
				$escape=true;
			}
			
		}
		$new_array=array();
		if($escape){
			foreach($array as $key=>$vl){
				$new_array[$key]=addslashes($vl);
			}
			return $new_array;
		}else{
			return $array;
		}	
	}
	
	//以下是扩展操作，适用于单表(只用作参考，适用性不好，暂时不使用)===================================================
	/*function get_rows_count($table,$where){
		$data_list=$this->get_datalist("select count(*) as rows_count from ".$table." ".$where);
		if($data_list[0]["rows_count"]=='')
			$data_list[0]["rows_count"]=0;
		return $data_list[0]["rows_count"];
	}
	
	function get_list_page($table,$where,$page_size=20){
		$return_arr=array();
		$page_class=new page_class();
		
		//获取总条数
		$all_count=$this->get_rows_count($table,$where);
		//获取查询的起始和截止条数
		$page_class->page_size=$page_size;
		$page_class->init($all_count);
		$return_arr["pagebar"]=$page_class->get_pagebar();
		$return_arr["list"]=$this->get_datalist("select * from ".$table." ".$where." limit ".$page_class->begin_row.",".$page_class->page_row);
		return $return_arr;
	}*/
	
	
	
}
?>