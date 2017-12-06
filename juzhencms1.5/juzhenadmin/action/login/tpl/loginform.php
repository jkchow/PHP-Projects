<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<link href="res/css/style.css" rel="stylesheet" style="text/css">
<script src="res/js/jquery-1.5.2.min.js"></script>
<script src="res/js/jquery.form.js"></script>
<script src="res/js/md5.js" type="text/javascript"></script>
<script src="res/js/functions.js"></script>
<script>
$(function(){
	deleteCookie("liger-home-tab");	   
	$("#validateImg,.change-img").click(function(){
			
		var timenow = new Date().getTime();
		$("#validateImg").attr("src","?acl=login&method=validateImg&timenow="+timenow);						
	});
	var timenow = new Date().getTime();
	$("#validateImg").attr("src","?acl=login&method=validateImg&timenow="+timenow);
	$("#validateImg").show();
	

});

function checkLoginForm(){

	var options = {   
		url:       "index.php?acl=login&method=dologin",
		type:      "post" ,
		dataType:  'json',    
		timeout:   10000,
		beforeSerialize: function(){
			$("#loginPass").val(md5($("#loginPass").val()));
		},
		success:function(responseText, statusText){
			$("#loginPass").val("");
			if(responseText.result){
				location.href="index.php?acl=main";
			}else{
				alert(responseText.msg);
				location.reload();
			}
		}
    };
	
	$("#login_form").ajaxSubmit(options);
	
	
	return false;
}

</script>
<style type="text/css">
html,body{ width:100%; height:100%; position:relative;overflow:hidden; margin:0; padding:0;}
</style>

</head>

<body>

<table style="height:100%;width:100%;"><tr style="height:100%; ">
<td style="height:100%; vertical-align:middle;">
<div class="video-css"><div class="video-css2"><div class="video-css3"><img src="res/image/videos_bg.jpg" width="1920" height="1000" alt=""/></div></div></div>
<div class="logo-imgs"><img src="res/image/logo2.png"  alt=""/></div>
<div class="loginCss">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td height="58"><a target="_blank" style="display:block;width:160px; height:45px; overflow:hidden; margin:15px 0 0 15px;"></a></td>
  </tr>
  <tr>
      <td height="144">
<form id="login_form" onsubmit="return checkLoginForm()">
    
<table border="0" cellspacing="0" cellpadding="0" >	

          <tr>
              <td height="65" colspan="2" valign="middle">
			  <input class="login_input login_input3" type="text" id="loginUser" name="username" autocomplete="off"/>
			  </td>
          </tr>
          <tr>
            <td height="78" colspan="2" valign="middle">
            <input  class="login_input login_input3" type="password" id="loginPass" name="password"/>
            </td>
          </tr>
          <tr>
           <td width="150" height="42" >
           <input class="login_input " type="text" name="validateNUM" autocomplete="off"/>
           </td><td width="120"><img class="validateImg" onclick="javascript:valis()"  id="validateImg" style="display:none; cursor:pointer;" /><a class="change-img" onclick="javascript:valis()"></a></td>
        </tr>
          <tr>
              <td align="center" height="60" valign="bottom" ><div class="sbt"><input type="submit" value="" class="btn"/></div></td>
          <td></td>
          </tr>
      </table>
      </form>
      </td>
  </tr>
</table>

</div>
<!--<div class="copycss6"><img src="tple/images/copy_img.png" width="236" height="43" alt=""/></div>--></td></tr>
</table>

</div>
</body>
</html>