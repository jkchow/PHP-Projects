<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>




<div class="mem-com-wrap">
<div class="m-login-tit">忘记密码</div>
<div class="mem-inner-wrap">

           
            <div class="login-box">
<div class="head-portrait"><a><img src="<?=$global->tplUrlPath?>images/head-portrait-img.gif" alt=""></a></div>
<div class="set-pwd"><img src="<?=$global->tplUrlPath?>images/sucess.png">邮件发送成功</div>
              
                
 <br>
<br>

              <?
			  if($_GET["email"]!=""){
				  $email=$_GET["email"];
				  $p=strpos($email,"@");
				  $tmpLink="http://mail.".substr($email,$p+1);
			  ?>
              <div class="pop-btn-box"><a href="<?=$tmpLink?>" target="_blank">立刻登录邮箱</a>
			  <?
			  }else{
			  ?>
              <div class="pop-btn-box"><a href="<?=$global_link["login"]?>">操作完成，去登录</a>
              <?
			  }
			  ?>
              </div>
            </div>
            
            
          </div>


</div>

<div class="clear"></div>
<div class="item-height"></div>
<div class="clear"></div>

<!--公共底部-->
<? include($global->tplAbsolutePath."common/member_footer.php"); ?>
</body>
</html>
