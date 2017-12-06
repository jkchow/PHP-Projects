<?
class acl_index extends base_acl{
	//app初始化
	function init($requestData){
		global $dao,$global;
		
		//根据客户端app版本号判断是否需要更新
		
		//判断客户端的登录状态是否有效
		
		//收集客户端的设备信息及GPS信息
		
		$return_data=array();
		$array=array();
		if(!empty($requestData['lat']) && !empty($requestData['lng'])){
			$addressService=new addressService();
			$_tmp=$addressService->localInfo($requestData);
			
			
			
			if($_tmp['result']){
				$array['lat']=$requestData['lat'];
				$array['lng']=$requestData['lng'];
				$array['address']=$_tmp['data']['address'];
				//$return_data['address']=$array['address'];
				//$return_data['address']=$_tmp['data']['address'];
				$return_data=array_merge($return_data,$_tmp['data']);
			}
		}
		if(empty($requestData['device_id'])){
			return array('result'=>'0','msg'=>"缺少设备ID参数");
		}else{
			$array['push_id']=$requestData['push_id'];
			$array['app_id']=$global->app_id;
			if($requestData["devie_type"]!="")
				$array["devie_type"]=$requestData["devie_type"];
			if($requestData["os_version"]!="")
				$array["os_version"]=$requestData["os_version"];
				
			$where="where device_id='{$requestData['device_id']}' and member_type='1'";
			$tmp=$dao->get_row_by_where($dao->tables->app_device,$where);
			if(is_array($tmp) && !empty($tmp)){ //查到这个设备
				if(!empty($array)){
					$dao->update($dao->tables->app_device,$array,"where auto_id='{$tmp['auto_id']}'");
				}
			}else{ //保存设备信息
				$array['device_id']=$requestData['device_id'];
				$array['member_type']=1;
				$array['app_type']=$requestData['app_type'];
				$array['create_time']=date("Y-m-d H:i:s");
				$dao->insert($dao->tables->app_device,$array);
			}
		}
		$return_data["updateVersion"]=0;
		//获取当前最新版本，判断是否需要客户端更新版本
		$versionRecord=$dao->get_row_by_where($dao->tables->app_version,"where os_type='{$requestData["app_type"]}' order by version_num desc");
		if($requestData["app_version"]<$versionRecord["version_num"]){
			$return_data["updateVersion"]=1;
			//获取app版本下载地址，只获取android版本的
			if($requestData["app_type"]=="2"){
				$tmpArr=array("acl"=>"index",'method'=>"download",'app_type'=>'2');
				$str=json_encode($tmpArr);
				$string=urlencode($str);
				$return_data["updateUrl"]=$global->siteUrlPath."/app/index.php?param={$string}";
			}
		}
		
		//返回客服电话、QQ、起送金额
		$paramsService=new paramsService();
		$global_params=$paramsService->getParams(array("content_tel","content_qq","buy_min_limit"));
		$return_data=array_merge($return_data,$global_params);
		
		
		//验证会员登录是否有效
		//memberService
		
		return array('result'=>'1','msg'=>'有新的版本，请更新',"update"=>"1","loginStatus"=>"1","data"=>$return_data);
		
	}
	
}
?>