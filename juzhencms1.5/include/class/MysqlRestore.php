<?php
//mysql数据恢复,导入sql文件

/*
$mysqlRestore=new MysqlRestore();

$mysqlRestore->import_file($file_name);
*/

class MysqlRestore{
	function __construct(){ 	
    }
    
    
    function import_file($file_name){
    	
    	//参数配置部分=====================================	
		global $dao;
    	
    	$db_config_arr=array();
		$db_config_arr["server"]=$dao->db_host;
		$db_config_arr["user"]=$dao->db_user;
		$db_config_arr["pass"]=$dao->db_pass;
		$db_config_arr["database"]=$dao->db_name;
		//要导入到SQL文件
		$sql_file_name=$file_name;
		set_time_limit(0);
		//配置结束=========================================
		
		
		$conn=@mysql_pconnect($db_config_arr["server"],$db_config_arr["user"],$db_config_arr["pass"]);
		mysql_select_db($db_config_arr["database"],$conn);
		mysql_query("set names utf8");
		
		
		    $tmp="";
		
			$fp=fopen($sql_file_name,"r");
			$ch=fgetc($fp);
			while(!feof($fp))
			{
			  
			   if($ch=='D')
			   {   
		           $tmp.=$ch;
		 	       for($i=0;$i<4&&!feof($fp);$i++)
				   {
				       $ch=fgetc($fp);
					   $tmp.=$ch;
		            }
		 			 if($tmp=="DROP ")
					{ 
						 while(!feof($fp)&&$ch!=';')
			             {
			                 $ch=fgetc($fp);
							   
						     $tmp.=$ch;
						 }
						mysql_query($tmp,$conn);
					 }  
		
		
		         $tmp="";
			   }
		
			   if($ch=='C')
			   {   
		           $tmp.=$ch;
		 	       for($i=0;$i<6&&!feof($fp);$i++)
				   {
				       $ch=fgetc($fp);
					   $tmp.=$ch;
		            }
		 			 if($tmp=="CREATE ")
					{ 
					 while(!feof($fp)&&$ch!=';')
			             {
			                 $ch=fgetc($fp);
							   
						     $tmp.=$ch;
						 } 
		               mysql_query($tmp,$conn);
		
					 }  
		
		         $tmp="";
			   }
			   
			   if($ch=='I')
			   {   
		           $tmp.=$ch;
		 	       for($i=0;$i<6&&!feof($fp);$i++)
				   {
				       $ch=fgetc($fp);
					   $tmp.=$ch;
		            }
		 			 if($tmp=="INSERT ")
					{ 
						 while(!feof($fp)&&ord($ch)!=10)
			             {
			                 $ch=fgetc($fp);
							   
						     $tmp.=$ch;
						 } 
		              mysql_query($tmp,$conn);
		
					 }  
		
		         $tmp="";
			   }
			   	   
			 $ch=fgetc($fp);
		 	   
			   
			}
		fclose($fp);


    	
    	
    	
    }
}

?>