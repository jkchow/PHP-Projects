<!doctype html>
<html>
<head>
<? include($global->tplAbsolutePath."common/title.php"); ?>
</head>
<body>
<? include($global->tplAbsolutePath."common/member_header.php"); ?>




<div class="mem-com-wrap">
<div class="m-login-tit">重置密码</div>
<div class="mem-inner-wrap">

           
            <div class="login-box">
<div class="head-portrait"><a><img src="<?=$global->tplUrlPath?>images/head-portrait-img.gif" alt=""></a></div>
<div class="set-pwd"><img src="<?=$global->tplUrlPath?>images/sucess.png">重置密码成功</div>
              
                
 <br>
<br>

              <div class="pop-btn-box"><a href="<?=$global_link["login"]?>">立即登录</a>

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
