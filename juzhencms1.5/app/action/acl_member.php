<?
class acl_member extends base_acl{
	  /**
	   * 会员注册
	   * @param  $requestData
	   *          mobile(手机号)
	   *          pass 密码
	   *          code手机验证码
	   *          app_type 手机类型 
	   *          device_id设备ID       
	   * @return multitype:string 
	   *  */   
	   function  register($requestData){
	   	 global $dao;
	   	 //验证手机号码是否已经注册过
	   	 $tmp=$dao->get_row_by_where($dao->tables->member, "where content_mobile='{$requestData['mobile']}'",array("auto_id"));
	   	 if(empty($tmp)){
	   	 	$mobile=$requestData['mobile'];
	   	 	$code=$requestData['code'];
	   	 	$mobileMsgService=new mobileMsgService();
	   	 	$msg='';
	   	    $check=$mobileMsgService->CheckNoteCode($mobile, 1,$msg, $code);
	   	    if(!$check) return array('result'=>'0','msg'=>$msg);
	   	    //注册保存会员信息
	   	    $_arr=array();
	   	    $_arr['pass_randstr']=rand(1000000, 9999999);
	   	    $_arr['content_mobile']=$mobile;
	   	    $_arr['content_pass']=md5($requestData['pass']. $_arr['pass_randstr']);
	   	    $_arr['content_type']=1;
	   	    $_arr['create_time']=date("Y-m-d H:i:s");
	   	    $dao->insert($dao->tables->member, $_arr);
	   	    $result=$this->doLogin($requestData);
	   	    if($result['result']==1){
	   	      return array('result'=>'1','msg'=>"注册成功",'data'=>$result['data']);
	   	    }else 
	   	      return array('result'=>'0','msg'=>"注册有误请联系客服人员！");
	   	 }else{
	   	 	return array('result'=>'0','msg'=>'会员已经注册过请登录！');
	   	 }
	   } 
     /*   function checkValidate($requestData){
          global $dao,$global;
       	  if(!empty($requestData['device_id']) && !empty($requestData['validate'])){
	        $where="where device_id='{$requestData['device_id']}' and app_id='{$global->app_id}'";
      	 	$tmp=$dao->get_row_by_where($dao->tables->app_device,$where);
       	    if(is_array($tmp) && !empty($tmp)){
       	        if($tmp['member_id']!=$requestData['mid'])
       	    		return array('result'=>'-1','msg'=>"会员登录有误！");
       	    	$where="where auto_id='{$tmp['member_id']}'";
       	    	$field=array('auto_id','content_mobile','token');
       	    	$tmp=$dao->get_row_by_where($dao->tables->member,$where,$field);
       	    	if(is_array($tmp) && !empty($tmp)){
       	    		$string=md5($tmp['token'].$requestData['timestamp']);
       	    		if($requestData['validate']==$string){
       	    			$this->saveLoginInfo($tmp);
       	    			return  array('result'=>'1','msg'=>"验证正确");
       	    		}
       	    		return array('result'=>'-1','msg'=>"会员登录失效！");
       	    	 }else return array('result'=>'-1','msg'=>"会员登录失效！");
       	    }else  return array('result'=>'-1','msg'=>"会员登录有误！"); 
       	  }else return array('result'=>'-1','msg'=>"设备参数有误！");
       }
     function saveLoginInfo($array){
    	if(!empty($array['auto_id'])){
    		$arr=array();
    		$arr['mid']=$array['auto_id'];
    		$arr['mobile']=$array['content_mobile'];
    		$GLOBALS['loginInfo']=$arr;
    	}
     } */
    /**
     * @author 王
     * @param mobile (手机号码)
     * @param pass(密码)
     * @param device_id
     * @param app_type 1:ios,2:android
     * @param
     *   */
     function doLogin($requestData){ //会员执行登录操作
     	global $dao,$global;
     	$mobile=$requestData["mobile"];
     	$content_pass=$requestData["pass"];
     	$device_id=$requestData['device_id'];
     	if($mobile=='' || $content_pass=='' ){
     		return array("result"=>"0","msg"=>"用户名和密码不能为空");
     	}else{
     		$filed=array("auto_id","content_mobile",'content_pass');
     		$memberTmp=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$mobile}'");
     		if(empty($memberTmp)){
     			return array("result"=>"0",'msg'=>'此手机号还未注册！');
     		}else{
     			if(md5($content_pass.$memberTmp['pass_randstr'])!=$memberTmp['content_pass']){
     				return array("result"=>"0",'msg'=>'密码有误！');
     			}
     			$token=rand(1000, 9999);
     			$where="where auto_id='{$memberTmp['auto_id']}'";
     			$dao->update($dao->tables->member, array("token"=>$token), $where);
     			//更新设备信息
     			$field=array("auto_id");
     			$result=$dao->get_row_by_where($dao->tables->app_device, "where device_id='{$device_id}' and member_type='1'",$field);
     			if(!empty($result)){
     				$array=array('member_id'=>$memberTmp['auto_id']);
     				$where="where auto_id='{$result['auto_id']}'";
     				$dao->update($dao->tables->app_device, $array, $where);
     			}
     			return array('result'=>'1','msg'=>"登录成功！","data"=>array('mid'=>$memberTmp['auto_id'],"token"=>$token));
     		}
     	}
     }
      /* mobile ,event=1,2
       * $event=1(注册短信验证码)
	   * $event=2(找回密码验证码)
	   * $event=3(登录短信验证码)
       * //找回密码，登录使用此方法发送短信验证码
       *   */
     function getMobileMsg($requestData){ 
     	global $dao;
     	$content_mobile=$requestData['mobile'];
     	$event=$requestData['event']=2;
     	//查找此手机号是否为会员
     	$memberTmp=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{$content_mobile}'");
        if(empty($memberTmp)){
        	return array('result'=>'0','msg'=>"此手机号还不是会员，请先注册");
        }else{
        	//验证手机号是否能够发送短信验证码
        	$mobileMsgService=new mobileMsgService();
        	if($mobileMsgService->isSendCode($content_mobile)){
        	  //生成验证码
        	  $num=rand(1000,9999);
        	  $msg="手机验证码是：".$num;
        	  if($event=="1") $type="login";
        	  if($event=='2') $type="forgetPwd";
        	  $mobileMsgService->sendMsg($content_mobile,$msg,array("content_type"=>$type));
        	  $mobileMsgService->saveNoteCode($content_mobile,$event,$num);
        	  return array('result'=>'1','msg'=>"短信验证码已经成功发送");
        	}else{
        	  return array('result'=>'0','msg'=>"请在60秒后再发送短信");
        	}
        }
     }
     /**
      * 忘记密码验证手机短信是否正确
      * 
      *   */
     function checkMsgCode($requestData){
     	global $dao;
     	$mobile=$requestData['mobile'];
     	$code=$requestData['code'];
     	$mobileMsgService=new mobileMsgService();
     	$msg='';
     	$check=$mobileMsgService->CheckNoteCode($mobile, 2,$msg, $code);
     	if(!$check){
     		return array('result'=>'0','msg'=>$msg);
     	}else return array('result'=>'1','msg'=>"验证成功！");
     }
     
     /**
      * 忘记密码重置密码
      * 
      *   */
     function findPwd($requestData){
     	global $dao;
     	$mobile=$requestData['mobile'];
     	$code=$requestData['code'];
     	$mobileMsgService=new mobileMsgService();
     	$msg='';
     	$check=$mobileMsgService->CheckNoteCode($mobile, 2,$msg, $code);
     	if(!$check){
     		return array('result'=>'0','msg'=>$msg);
     	}else{ 
     		$where="where content_mobile='{$mobile}'";
     		$_tmp=$dao->get_row_by_where($dao->tables->member,$where,array('content_pass','pass_randstr',"auto_id"));
     		if(is_array($_tmp) && !empty($_tmp)){
     			$array=array('content_pass'=>md5($requestData['pwd'].$_tmp['pass_randstr']));
     			$where="where auto_id='{$_tmp['auto_id']}'";
     			$dao->update($dao->tables->member,$array,$where );
     			return array('result'=>'1','msg'=>"修改成功！");
     		}else return array('result'=>'0','msg'=>"会员信息有误！");
     	}
     }
     
     
     /*//发送注册短信验证码
      *  mobile ,event=1,2，3
      * $event=1(注册短信验证码)
      * $event=2(找回密码验证码)
      * $event=3(登录短信验证码)
      *   */
     function getRegMobileMsg($requestData){ 
     	global $dao;
     	$content_mobile=$requestData['mobile'];
     	$event=1;
     	//查找此手机号是否为会员
     	$memberTmp=$dao->get_row_by_where($dao->tables->member,"where content_mobile='{}'");
     	if(empty($memberTmp)){
     		//验证手机号是否能够发送短信验证码
     		$mobileMsgService=new mobileMsgService();
     		if(!($mobileMsgService->checkMobile($content_mobile))){
     			return array('result'=>'-1','msg'=>'手机号有误！');
     		}
     		if($mobileMsgService->isSendCode($content_mobile)){
     			//生成验证码
     			$num=rand(1000,9999);
     			$msg="手机验证码是：".$num;
     			$type="reg";
     			$mobileMsgService->sendMsg($content_mobile,$msg,array("content_type"=>$type));
     			$mobileMsgService->saveNoteCode($content_mobile,$event,$num);
     			return array('result'=>'1','msg'=>"短信验证码已经成功发送");
     		}else{
     			return array('result'=>'0','msg'=>"请在60秒后再发送短信");
     		}
     	}else{
     		return array('result'=>'0','msg'=>"此手机号已经注册，请登录！");
     	}
     }
     /** 重置密码
      * @param old_pass
      * @param new_pass
      *   */
     function resetPwd($requestData){ 
     	global $dao;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     	  //验证旧密码是否正确
     	  $where="where content_mobile='{$loginInfo['mobile']}'";
     	  $_tmp=$dao->get_row_by_where($dao->tables->member,$where,array('content_pass','pass_randstr'));
     	  
     	  if($requestData['old_pass']==$requestData['new_pass'])
     	  	return array('result'=>'0','msg'=>'请更换密码！');
     	  if($_tmp['content_pass']!=md5($requestData['old_pass'].$_tmp['pass_randstr'])){
     	  	return array('result'=>'0','msg'=>'当前的密码有误！');
     	  }else{
     	  	$array=array('content_pass'=>md5($requestData['new_pass'].$_tmp['pass_randstr']));
     	  	$where="where auto_id='{$loginInfo['mid']}'";
     	  	$dao->update($dao->tables->member,$array,$where );
     	  	return array('result'=>'1','msg'=>'修改成功！');
     	  }	
     	}else{
     	  return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     }
     /**
      * 修改用户名（昵称）
      *   */
     function updateUserName($requestData){
     	global $dao;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     		if(empty($requestData['content_name']))
     			return array('result'=>'0','msg'=>'昵称不能空！');
     	$array=array('content_name'=>$requestData['content_name']);
     	$where="where auto_id='{$loginInfo['mid']}'";
     	$dao->update($dao->tables->member,$array,$where );
     	return array('result'=>'1','msg'=>'修改成功！');
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     }
     /**
      * 修改用户头像
      *   */
     function updataUserFace($requestData){
     	global $dao;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     		$uploadFile=new UploadFile();
     		$field_name="content_head_file";
     		$_record=$uploadFile->save_upload_img($field_name,320,320);
     		if(!empty($_record['error'])){
     			return array('result'=>'0','msg'=>$_record['msg']);
     		}
     		$array=array('content_head'=>$_record['savePath']);
     		$where="where auto_id='{$loginInfo['mid']}'";
     		$dao->update($dao->tables->member,$array,$where );
     		return array('result'=>'1','msg'=>'修改成功！');
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     }
     /**
      * //获取会员信息
      * @param unknown $requestData  */
     function getMemberInfo($requestData){ 
     	global $dao,$global;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     		$where="where auto_id='{$loginInfo['mid']}'";
     		$field=array("auto_id",'content_email','content_mobile','content_head',"content_name");
     		$tmp=$dao->get_row_by_where($dao->tables->member,$where,$field );
     		if($tmp["content_head"]=="")
     			$tmp["content_head"]="nophoto.jpg";
     		if($tmp["content_head"]!="")
     			$tmp["content_head"]=$global->uploadUrlPath.$tmp["content_head"];
     		if(empty($tmp['content_mobile']))$tmp['content_mobile'] ="未填写";
     		if(empty($tmp['content_email']))$tmp['content_email'] ="未填写";
     		return array('result'=>'1','msg'=>"获取成功","data"=>$tmp);
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     	
     }
     
     /**会员添加收藏
      *
     * @return multitype:string NULL  */
     function addCollect($requestData){
     	global $dao,$global;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     		$goodsId=$requestData["goodsid"];
     		$mid=$loginInfo['mid'];
     		if($goodsId==""){
     			return array("result"=>"0","msg"=>"收藏失败，请选择商品");
     
     		}
     		$oldRecord=$dao->get_row_by_where($dao->tables->goods_collection,"where member_id='{$mid}' and goods_id='{$goodsId}'");
     			
     		if(empty($oldRecord)){
     			$record=array();
     			$record["goods_id"]=$goodsId;
     			$record["member_id"]=$mid;
     			$record["create_time"]=date("Y-m-d H:i:s");
     			$dao->insert($dao->tables->goods_collection,$record);
     				
     			return array("result"=>"1","msg"=>"收藏成功，您可在会员中心的“我的收藏”中进行查看");
     		}else{
     			return array("result"=>"0","msg"=>"您已经收藏过此商品了");
     		}
     			
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     
     }
     
     
     function deleteCollect($requestData){
     	global $dao,$global;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     		$goodsId=$requestData["goodsid"];
     		$mid=$loginInfo['mid'];
     		if($goodsId==""){
     			return array("result"=>"0","msg"=>"取消收藏失败，请选择商品");
     		}
     		$oldRecord=$dao->get_row_by_where($dao->tables->goods_collection,"where member_id='{$mid}' and goods_id='{$goodsId}'");
     		if(empty($oldRecord)){
     			return array("result"=>"0","msg"=>"取消收藏失败，您还没有收藏此商品");
     		} else{
     			$dao->delete($dao->tables->goods_collection,"where auto_id='{$oldRecord['auto_id']}' and member_id='{$mid}'");
     			return array("result"=>"1","msg"=>"成功取消收藏！");
     		}
     
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     
     }
     

     /**
      * 收藏列表
      * @return multitype:string NULL  */
     function collectLists($requestData){
     	global $dao,$global;
     	$loginInfo=$this->getLoginInfo();
     	if(!empty($loginInfo)){
     		$mid=$loginInfo['mid'];
     		$tmp=$dao->get_rows_by_where($dao->tables->goods_collection,"where member_id='{$mid}'",array("goods_id"));
     		if(!empty($tmp)){
     			foreach ($tmp as $key=>$val){
     				$_tmpArr[]=$val['goods_id'];
     			}
     			$str=implode(",", $_tmpArr);
     			$page=$requestData['page'];
     			$num=10; //每页默认为10条数据
     			if(empty($page)){
     				$page=1;
     			}
     			$start=($page-1)*$num;
     			$end=$num;
     			$table=$dao->tables->goods;
     			$filed=array("auto_id","content_img",'content_name','category_id',"content_price",'sub_title');
     			$where="where auto_id in ({$str})";
     			$where.=" limit {$start},{$end}";
     			$_tmpGoods=$dao->get_rows_by_where($table, $where,$filed);
     		    if(!empty($_tmpGoods)){
     		    	foreach ($_tmpGoods as $key=>$val){
     		    		$_tmpGoods[$key]['content_img']=$global->uploadUrlPath.$val["content_img"];
     		    	}
     		    	return array("result"=>"1",'msg'=>"sucess",'data'=>$_tmpGoods);
     		    }else{
     		    	return array("result"=>"0",'msg'=>"暂无收藏");
     		    }
     		} else{
     			return array("result"=>"0",'msg'=>"暂无收藏");
     		}
     	}else{
     		return  array('result'=>"-1",'msg'=>$this->getLoginError());
     	}
     
     }
     
}
?>