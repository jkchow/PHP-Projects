<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>关于矩阵CMS</title>
    
    <style type="text/css">
        p.l-log-content
        {
            margin: 0;
            padding: 0;
            padding-left: 20px;
            line-height: 22px;
            font-size: 12px;
        }
        span.l-log-content-tag
        {
            color: #008000;
            margin-right: 2px;
            font-weight: bold;
        }
        h2.l-title
        {
            margin: 7px;
            padding: 0;
            font-size: 17px;
            font-weight: bold;
        }
        h3.l-title
        {
            margin: 4px;
            padding: 0;
            font-size: 15px;
            font-weight: bold;
        }
        a {
            color:#1870A9;
        }
        a.hover {
            color: #BC2A4D;
        }
    </style>
</head>
<body style="background: white; font-size: 12px;">
 
    <h2>&nbsp;矩阵CMS内容管理系统</h2>
    <p class="l-log-content">
        软件当前版本<? global $global;echo $global->version; ?></p>
    <p class="l-log-content">
        QQ: 273464581</p>
    <p class="l-log-content">
        Email: xuexinfeng@126.com</p>
        
    <p class="l-log-content">&nbsp;</p>
    
    <p class="l-log-content">
    1.6.9更新内容:<br/>
    升级mysql相关操作，采用mysqli，增加mysqliDao、MysqliBack、MysqliRestore三个类，兼容php7.1<br/>
    完善伪静态部分，读取静态文件时路径前加$global->absolutePath变量<br/>
    改进图片裁切功能，可以兼容oss<br/>
    会员存储密码规则修改为md5(md5(密码)+随机数)<br/>
    会员登录、注册、找回密码等操作不再传输密码明文<br/>
    后台管理员存储密码规则修改为md5(md5(密码)+随机数)，登录不再提交明文密码<br/>
    修复了后台管理员登录失败时效判断的bug<br/>
    前后台用户登录成功后使用session_regenerate_id(true)更新sessionid<br/>
    在后台登录界面使用js清除cooike中的liger-home-tab<br/>
    后台管理员登录提交改为采用ajax方式<br/>
    微信支付接口中的$GLOBALS['HTTP_RAW_POST_DATA']替换为file_get_contents("php://input")，以便兼容php7<br/>
    <br/>
    </p>
    
    <p class="l-log-content">
    1.6.8更新内容:<br/>
    修复了因为增加强制addslashes转义造成的不开启gpc选项时的转义错误<br/>
    访问日志表vistor_log增加了索引，提升查询效率<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.7更新内容:<br/>
    改进了分页类中获取当前链接的方法，对参数增加htmlspecialchars处理，以避免跨站脚本攻击<br/>
    增加全局设置ini_set("session.cookie_httponly", 1);<br/>
    增加全局设置header('X-Frame-Options: SAMEORIGIN');<br/>
    完善了静态化操作，当删除栏目及资讯时会同步删除相应的静态链接数据<br/>
    增加了资讯、广告、友情链接部分的通用缓存功能;<br/>
    global.php中增加了vars_filter方法对用户提交的数据进行html转义;<br/>
    global.php中增加了addslashes方法对用户提交的数据进行sql转义以适应高版本php中没有magic_quotes_gpc的情况,mysqlDao中也进行了对应的修改;<br/>
    DebugTool日志类升级，改为采用静态方法写日志DebugTool::log($msg);<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.6更新内容:<br/>
    改进了后台上传文件及图片的表单，兼容完整url路径的字段值<br/>
    更新了前台获取栏目及资讯链接的函数menuService->getMenuLink和newsService->getNewsLink，可以兼容锚点的写法<br/>
    后台系统管理中增加了ip地址禁用的功能<br/>
    增加了会员修改手机号功能<br/>
    修改了jquery-validation设置，支持验证hidden表单<br/>
    升级了会员积分功能，可以设置积分事件<br/>
    更新了会员中心-安全设置<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.5更新内容:<br/>
    抑制函数exif_read_data的报错信息，避免文件没有exif属性时会报错<br/>
    后台权限验证方法Passport->permissions_validate改进，增加了对公共权限publicPermissions的验证<br/>
    改进了微信支付接口调用代码，支付成功和支付失败可以跳转到不同的指定页面<br/>
    改进了获取当前url目录的函数getRequestUrlPath<br/>
    增加了会员上传文件的js封装WebTools.uploadInit和用于处理上传文件的控制器acl_upload(测试中)<br/>
    改进了JSSDK中httpGet函数，支持在阿里云虚拟主机中使用<br/>
    改进后台grid组件上方的搜索表单，文本框回车可直接进行搜索<br/>
    更新了伪静态规则，可兼容apache和nginx<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.4更新内容:<br/>
    为了适应高版本的spl_autoload_register自动加载类的方式(避免与支付宝AopSdk类的冲突)，不再使用__autoload，改为使用spl_autoload_register<br/>
    修复了app支付中获取微信支付订单接口中的字段错误<br/>
    集成了极光推送SDK文件jpush-api-php-client-3.5.5，并封装成类AppPush以便程序调用<br/>
    栏目管理模块中增加了明细页面的模板配置，可用于配置资讯频道的明细页模板<br/>
    增加了后台管理员及前台会员的的登录限制，24小时内密码输错三次账号将被锁定24小时<br/>
    增加了针对后台管理员及前台会员的密码强度限制，密码必须是8位以上并且包含数字及大小写字母<br/>
    增加了前台模板的标签引入功能，模板名为*.dev.html时可使用#(default/common/header)#方式包含子模板，可重用的基础结构存储在res/tpl/block目录中,通过web服务器预览时可自动生成拼接后的静态页面(*.pub.html)<br/>
    为了不同项目部署在同一服务器时前台会员session不相互影响，会员信息存储在session中时增加了一层数组目录<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.3更新内容:<br/>
    后台示例模块example中增加了复杂表单的示例，开发时可用作参考<br/>
    后台模块的保存及删除操作都改为采用ajax提交的方式，避免因填写错误而返回时表单被清空<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.2更新内容:<br/>
    在global.php中定义了文件存储的目录变量$global->fileAbsolutePath，在数据库备份、日志、缓存等功能涉及到的存储文件的目录统一使用此变量<br/>
    修改了引入php文件的import函数的参数规则，路径分隔符改为使用/,使用方式由import("lib.phpqrcode.qrlib")修改为import("lib/phpqrcode/qrlib");<br/>
    系统增加了对阿里云oss的支持，在global.php中增加了oss配置的开关参数$global->ossEnable<br/>
	更新了支付宝接口，当开启get_magic_quotes_gpc时，使用stripslashes函数对post数据进行sql反转义<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.1更新内容:<br/>
    后台增加了会员账户管理和提现申请模块<br/>
    前台会员模板中增加了账户充值和提现申请的功能<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.6.0更新内容:<br/>
    增加了模板开发时的系统模板路径变量$global->sysTplUrlPath,用于引用系统模板的js库和默认皮肤<br/> 
    后台模块中增加了标准的会员系统（个人会员及企业会员）<br/>
    模板目录中增加了标准的会员功能模板（会员基础功能）<br/>
    后台模块中增加了标准的问卷功能<br/>
    模板目录中增加了标准的问卷功能模板<br/>
    升级了伪静态功能，伪静态规则可以匹配到扩展模块，并且改进了后台栏目保存时的伪静态路径校验<br/>
    后台网站设置模块中增加了清除缓存的功能<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.7更新内容:<br/>
    升级了后台用户职位级别功能，增加了所属部门的字段及部门管理模块<br/>
    管理员用户级别开关变量由USER_ORG更改为USER_LEVEL<br/>
    增加了邮件发送服务类emailService，发送邮件会自动写入邮件记录表email_record<br/>
    删除了后台旧版的静态化操作模块makeHtml<br/>
    改进了获取站点目录的函数getSiteUrlPath，兼容了$_SERVER['DOCUMENT_ROOT']和__FILE__路径不一致的情况<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.6更新内容:<br/>
    外链频道策略优化，访问外链频道时，当method参数为空时才跳转至外链地址，否则还是执行控制器功能<br/>
    为了后台界面兼容IE7,在后台引入的jquery1.3.2.js中的attr函数中增加了判断项(源代码第1060行)<br/>
    修改了后台用户职位级别的bug<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.5更新内容:<br/>
    global.php中获取当前url的函数中增加了对https协议的兼容，后台入口文件中可以设定是否只允许https协议访问<br/>
    增加了访问日志表vistor_log，并在基础控制器base_acl中增加了记录访问日志的功能<br/>
    后台欢迎界面中增加了最近10天的访问量统计图表<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.4更新内容:<br/>
    规范类库目录，二维码操作类目录phpqrcode和邮件发送类目录mail_class都移动到include/lib下<br/>
    后台系统管理中增加了查看管理员操作日志的功能<br/>
    后台广告模块中增加了广告html代码或js代码录入功能，支持后台录入个性化广告代码<br/>
    后台系统管理中增加了部门级别管理，用于配置相同的角色的不同级别用户拥有不同的查看权限<br/>
    后台控制器基础类中增加了getManageUserIdStr方法，用于获取当前用户职位可管理的下级用户id<br/>
    后台入口文件中增加了USER_ORG常量的定义，用于判断是否开启后台用户职位级别<br/>
    后台创建管理员用户时添加了校验，必须选择角色才允许提交<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.3更新内容:<br/>
    短信操作类mobileMsgService的发送短信函数参数做了修改，增加了扩展字段参数<br/>
    修复了在未开启magic_quotes_gpc的情况下，后台登录名的sql注入漏洞<br/>
    后台增加了app操作的相关模块(app版本管理、app接口日志、app设备管理)<br/>
    前台增加了app接口的入口文件<br/>
    前台会员服务类memberService对于登录会员的操作部分修改为可以兼容app接口(自动判断使用session或是全局变量)<br/>
    增加了在线支付的api接口文件<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.2更新内容:<br/>
    前台系统模板目录system在使用时按照模块划分，直接在控制器中定义到具体模块的目录，参考视频播放器video控制器<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.1更新内容:<br/>
    后台界面样式优化<br/>
    后台权限系统修改，菜单分组也可以根据权限显示或隐藏<br/>
    对前台控制器初始化进行了限制，只允许获取一次控制器，后台登录校验失败后需要使用控制器转向登录，所以后台未做限制<br/>
    修改了登录验证，即便会员没有角色也允许其登录并使用公共权限<br/>
    后台界面顶部增加了当前登录用户的显示<br/>
    修复了在后台刷新界面后，点击菜单出现的标签和之前打开的同样标签会同时显示的问题<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.5.0更新内容:<br/>
    cms系统更名为juzhencms<br/>
    后台目录更名为juzhenadmin<br/>
    新增了频道和资讯页面的伪静态功能<br/>
    后台示例模块example增加了checkbox表单示例<br/>
	修改了前后台的入口文件中的get_acl函数，只允许获取一次控制器，在业务层不允许生成新的控制器对象<br/>
    添加了文件缓存类cache<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.6更新内容:<br/>
    将后台jquery的版本恢复到1.3.2,之前升级到1.5出现bug<br/>
    修复了menuService中的语法错误bug<br/>
    修复了获取上一篇、下一篇资讯算法的错误<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.5更新内容:<br/>
    将后台ligerUI的版本升级到了1.3.3，修复了弹出的gird选择框分页不能使用的bug<br/>
    将后台jquery的版本升级到了1.5.2(jquery不升级也可以，升级jquery并不是针对bug)<br/>
    修复了menuService中的getFirstSubMenu函数的死循环bug<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.4更新内容:<br/>
    在后台网站设置模块增加了流量统计代码的配置<br/>
    后台编辑器插入超链接时允许上传word、pdf、zip、rar等类型的附件供用户下载<br/>
    更新了后台的注入过滤设置，允许除登录模块外的其他模块提交js等标签<br/>
    前台增加了视频播放器的封装<br/>
    修复了因为升级修改栏目表结构而造成的无法按照频道读取广告数据的bug<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.3更新内容:<br/>
    在系统管理下增加了运行环境检测菜单，管理员可以自行对服务器环境进行检测<br/>
    修复了上传的文件名中未标明扩展名的bug<br/>
    修复了ios系统中上传的图片方向不正确的问题，增加自动判断图片方向的功能<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.2更新内容:<br/>
    更新了资讯的上一条和下一条功能的封装<br/>
    修复了编辑器上传图片路径不正确的bug<br/>
    修改栏目的上级栏目时会自动更新排序字段，确保在移动到新目录后排在最后<br/>
    增加了系统根目录url变量$global->sysSiteUrlPath和系统根目录物理路径变量$global->sysAbsolutePath<br/>
    增加了二维码类库QRcode及前后台相关的控制器方法<br/>
    改进了后台token的获取方式，改为从数据库读取而不是从session读取，并且修改密码时会更新token，增强了flash上传文件的安全性<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.1更新内容:<br/>
    对后台token身份验证进行了加强，限定20分钟有效期<br/>
    统一了标准文件上传表单，采用统一的控制器方法及页面模板并且放入公共权限，简化开发<br/>
    增加了文件上传的错误提示功能<br/>
    修复了api/uc.php中的discuz代码执行漏洞<br/>
    调用导航菜单及左侧菜单的函数进行了封装<br/>
    栏目管理中增加了控制栏目链接是否在新窗口打开的设置<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.4.0更新内容:<br/>
    增加了栏目目录的设定，用于为栏目自动生成目录，利于SEO优化<br/>
    在栏目模型中封装了获取链接的方法，用于支持栏目目录<br/>
    普通的文件上传已经改为采用html表单而不是flash<br/>
    原有的flash文件上传用于视频文件的上传，并且改进了session验证方式，可以支持IE、火狐、谷歌等多种浏览器<br/>
    后台管理员用户增加了token字段，用于验证flash文件上传<br/>
  	原有的后台物理路径变量$global->admin_absolute_path修改为$global->admin_absolutePath
    ，并且增加了后台url路径变量$global->admin_siteUrlPath<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.3.2更新内容:<br/>
    增加了全局配置参数分类(默认是golbal分类)、增加了配置调用的查询缓存<br/>
    资讯及介绍类栏目增加了内容预览功能<br/>
    后台增加了静态化配置的模块（开发中）<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.3.1更新内容:<br/>
    增加了广告位的分类，便于对广告位进行分类查找<br/>
    网站设置中增加了网站简短名称的设置，用于显示在邮件及短信通知<br/>
    集成了常用的会员功能模块及相关操作方法<br/>
    集成了ucenter1.6，可以整合discuz_x3.2<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.3.0更新内容:<br/>
    增加了mysql数据库的备份和恢复功能<br/>
    后台权限做了优化(公共权限也可以进行单独定义)，权限改为定义在后台入口文件中<br/>
    增加了系统环境检测工具，可以在部署前测试系统环境及数据库连接<br/>
    增加了DebugTool日志调试工具类，可以使用tail查看调试信息<br/>
    后台的ui组件由ligerUI1.2.3升级为ligerUI1.2.5<br/>
    后台增加了复选框全选进行批量删除的功能<br/>
    栏目的父子级关联由code改为pid，提升了处理速度<br/>
    管理员由单用户单角色改为同一用户可以同时拥有多个角色<br/>
    数据库中的密码存储由简单的md5加密修改为采用密码与随机串组合后再md5加密，避免被暴力破解<br/>
    登录验证码的session由明文存储改为采用验证码与随机串组合再md5的加密方式，避免后门程序读取session进行破解<br/>
    sql报错日志中增加了url字段<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.2.0更新内容:<br/>
    修复了部分php环境下由于php设置问题导致的后台登录session错乱的问题<br/>
    <br/>
    </p>
    <p class="l-log-content">
    1.1.0更新内容:<br/>
    同一个广告位支持按照不同的栏目设定不同的广告内容<br/>
    <br/>
    </p>
         
    
</body>
</html>
