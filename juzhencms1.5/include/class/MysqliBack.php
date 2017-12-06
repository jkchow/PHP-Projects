<?php
//mysql数据备份
/*

$mysqlBack=new MysqlBack();
echo $mysqlBack->get_sql_str();//获取sql字符串
echo $mysqlBack->back_to_file();//保存文件并返回结果
*/


class MysqliBack{
	
	function __construct(){ 	
    }
    
    function get_sql_str(){//参数是需要导出的表名,默认为全部导出
    	//配置备份=====================================================
    	global $dao;
    	
    	$db_config_arr=array();
		$db_config_arr["server"]=$dao->db_host;
		$db_config_arr["user"]=$dao->db_user;
		$db_config_arr["pass"]=$dao->db_pass;
		$db_config_arr["database"]=$dao->db_name;
		
		$tables=(array)$dao->tables;
		
		set_time_limit(0);
		//=============================================================
		
		
		
		$conn=@mysqli_connect($db_config_arr["server"],$db_config_arr["user"],$db_config_arr["pass"],$db_config_arr["database"]);
		//mysql_select_db($db_config_arr["database"],$conn);
		
		
		
		$version=mysqli_get_server_info($conn);
		if($version > '4.1') {
			@mysqli_query($conn,"SET character_set_connection=utf8, character_set_results=utf8, 

character_set_client=binary");
			if($version > '5.0.1') {
				@mysqli_query($conn,"SET sql_mode=''");
			}
		}
		
		
		if(is_array($tables) && count($tables)>0){
			
		}else{
			$tables=array();
			/*$rs=mysqli_list_tables($db_config_arr["database"],$conn);
			while($show=mysqli_fetch_array($rs))
			{
				$tables[]=$show[0];
			}*/
			
			$rs = $conn->query($conn,'SHOW TABLES');//执行查询语句
			$tables=array();
			while($arr = $rs->fetch_assoc()){
				$tables[]=$arr;//遍历查询结果
			}
			
			
		}

		
		
		// 获取数据库结构和数据内容
		if(is_array($tables))
		foreach($tables as $table)
		{		
			$tabledump = "DROP TABLE IF EXISTS $table;\r\n"; 
			$createtable = mysqli_query($conn,"SHOW CREATE TABLE $table");
			if($createtable==""){
				continue;
			}
			$create = mysqli_fetch_row($createtable); 
			$tabledump .= $create[1].";\r\n\r\n"; 
			
			$rows = mysqli_query($conn,"SELECT * FROM $table"); 
			$numfields = mysqli_num_fields($rows); 
			$numrows = mysqli_num_rows($rows); 
			while ($row = mysqli_fetch_row($rows)) 
			{ 	
				$comma = ""; 
				$tabledump .= "INSERT INTO $table VALUES("; 
				for($i = 0; $i < $numfields; $i++) { 
					 $tabledump .= $comma."'".mysqli_escape_string($conn,$row[$i])."'"; 
					 $comma = ","; 
				} 
				$tabledump .= ");\r\n"; 
			} 
			$tabledump .= "\r\n"; 
			
			$sqldump .= $tabledump;
		}
		
		
		if(trim($sqldump))
		{
			// 写入开头信息
			$sqldump =
			"# --------------------------------------------------------\r\n".
			"# 数据表备份\r\n".
			"#\r\n".
			"# 服务器: ".$db_config_arr['server']."\r\n".
			"# 数据库: ".$db_config_arr['database']."\r\n".
			"# 备份编号: ".time()."\r\n". // 这里有一个生成session id的函数
			"# 备份时间: ".date('Y-m-d')."\r\n". // 这里就是获取当前时间的函数
			"#\r\n".
			"# --------------------------------------------------------;\r\n\r\n\r\n".
			$sqldump;
			
			
		}
		
		return $sqldump;
		
    }
    
    function back_to_file($filename=''){
    	if($filename=='')
    		$filename = "./db_back/".date('Y-m-d_H-i-s').".sql";
    	
    	$sqldump=$this->get_sql_str();
    	
    	// 如果数据内容不是空就开始保存
		if(trim($sqldump))
		{
				if($filename != "")
				{
					@$fp = fopen($filename, "w+");
					if ($fp)
					{
						@flock($fp, 3);
						if(@!fwrite($fp, $sqldump))
						{
							@fclose($fp);
							$msg_str="数据文件无法保存到服务器，请检查目录属性你是否有写的权限";
						}
						else
						{
							//$msg_str="数据成功备份至服务器".$filename." 中。";
							$msg_str="数据库备份成功";
						}
					}
					else
					{
						$msg_str="无法打开你指定的目录". $filename ."，请确定该目录是否存在，或者是否有相应权限";
					}
				}
				else
				{
					$msg_str="您没有输入备份文件名，请返回修改";
				}
		}
		else
		{
			$msg_str="数据表没有任何内容";
		}
		
		return $msg_str;
    	
    	
    }
}

?>