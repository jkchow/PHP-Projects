<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>专题管理</title>
    <link href="res/js/LigerUI/lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" id="mylink"/>   
    <script src="res/js/LigerUI/lib/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>    
    <script src="res/js/LigerUI/lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script> 
    <script src="res/js/LigerUI/lib/jquery.cookie.js"></script>
    <script src="res/js/LigerUI/lib/json2.js"></script>
    <script type="text/javascript">
		
			/*var menudata_1 = [
			{ text: '资讯管理',isexpand:false, children: [ 
				{url:"?acl=news&method=lists",text:"查看资讯"},
				{url:"demos/base/drag2.htm",text:"资讯分类"}
			]},
			{ text: '菜单管理', isexpand: false, children: [
				{ url: "demos/filter/filterwin.htm", text: "菜单管理" }
			]}
			];*/
		
		
		
            var tab = null;
            var accordion = null;
            var tree = null;
            var tabItems = [];
            $(function ()
            {

                //布局
                $("#layout1").ligerLayout({ leftWidth: 190, height: '100%',heightDiff:-22,space:4, onHeightChanged: f_heightChanged });

                var height = $(".l-layout-center").height();

                //Tab
                $("#framecenter").ligerTab({
                    height: height,
                    showSwitchInTab : true,
                    showSwitch: true,
                    onAfterAddTabItem: function (tabdata)
                    {
                        tabItems.push(tabdata);
                        saveTabStatus();
                    },
                    onAfterRemoveTabItem: function (tabid)
                    { 
                        for (var i = 0; i < tabItems.length; i++)
                        {
                            var o = tabItems[i];
                            if (o.tabid == tabid)
                            {
                                tabItems.splice(i, 1);
                                saveTabStatus();
                                break;
                            }
                        }
                    },
                    onReload: function (tabdata)
                    {
                        var tabid = tabdata.tabid;
                        addFrameSkinLink(tabid);
                    }
                });

                //面板
                $("#accordion1").ligerAccordion({ height: height - 32, speed: null });

                $(".l-link").hover(function ()
                {
                    $(this).addClass("l-link-over");
                }, function ()
                {
                    $(this).removeClass("l-link-over");
                });
                //树
                $("#tree1").ligerTree({
                    url:"?acl=topic&method=menuTreeData",
                    ajaxType: 'get',
                    //data : menudata_1,
                    checkbox: false,
                    slide: false,
					isExpand:false,
                    nodeWidth: 120,
                    attribute: ['content_name', 'link'],
                    onSelect: function (node)
                    {
                        if (!node.data.url) return;
                        var tabid = $(node.target).attr("tabid");
                        if (!tabid)
                        {
                            tabid = new Date().getTime();
                            $(node.target).attr("tabid", tabid);
                        } 
                        f_addTab(tabid, node.data.text, node.data.url);
                    }
                });

                tab = liger.get("framecenter");
                accordion = liger.get("accordion1");
                tree = liger.get("tree1");
                $("#pageloading").hide();

                pages_init();
				
				
				//快速通道
				$("#fastLink").change(function(){
					var value=$(this).val();
					switch(value){
						case "menu":
							f_addTab('topicMenu','频道管理','index.php?acl=topicMenu&method=lists');
							break;
						case "adSpace":
							f_addTab('topicAdSpace','广告管理','index.php?acl=topicAdSpace&method=lists');
							break;
						case "refresh":
							location.reload();
							break;
					}
					$(this).val("");
				});
				
				
            });
            function f_heightChanged(options)
            {  
                if (tab)
                    tab.addHeight(options.diff);
                if (accordion && options.middleHeight - 24 > 0)
                    accordion.setHeight(options.middleHeight - 24);
            }
            function f_addTab(tabid, text, url)
            {
                tab.addTabItem({
                    tabid: tabid,
                    text: text,
                    url: url,
                    callback: function ()
                    {
                        
                        addFrameSkinLink(tabid); 
                    }
                });
            }
            function addFrameSkinLink(tabid)
            {
                var prevHref = getLinkPrevHref(tabid) || "";
                var skin = getQueryString("skin");
                if (!skin) return;
                skin = skin.toLowerCase();
                attachLinkToFrame(tabid, prevHref + skin_links[skin]);
            }
            var skin_links = {
                "aqua": "lib/ligerUI/skins/Aqua/css/ligerui-all.css",
                "gray": "lib/ligerUI/skins/Gray/css/all.css",
                "silvery": "lib/ligerUI/skins/Silvery/css/style.css",
                "gray2014": "lib/ligerUI/skins/gray2014/css/all.css"
            };
            function pages_init()
            {
                var tabJson = $.cookie('topic-home-tab'); 
                if (tabJson)
                { 
                    var tabitems = JSON2.parse(tabJson);
                    for (var i = 0; tabitems && tabitems[i];i++)
                    { 
                        f_addTab(tabitems[i].tabid, tabitems[i].text, tabitems[i].url);
                    } 
                }
            }
            function saveTabStatus()
            { 
                $.cookie('topic-home-tab', JSON2.stringify(tabItems));
            }
            function getQueryString(name)
            {
                var now_url = document.location.search.slice(1), q_array = now_url.split('&');
                for (var i = 0; i < q_array.length; i++)
                {
                    var v_array = q_array[i].split('=');
                    if (v_array[0] == name)
                    {
                        return v_array[1];
                    }
                }
                return false;
            }
            function attachLinkToFrame(iframeId, filename)
            { 
                if(!window.frames[iframeId]) return;
                var head = window.frames[iframeId].document.getElementsByTagName('head').item(0);
                var fileref = window.frames[iframeId].document.createElement("link");
                if (!fileref) return;
                fileref.setAttribute("rel", "stylesheet");
                fileref.setAttribute("type", "text/css");
                fileref.setAttribute("href", filename);
                head.appendChild(fileref);
            }
            function getLinkPrevHref(iframeId)
            {
                if (!window.frames[iframeId]) return;
                var head = window.frames[iframeId].document.getElementsByTagName('head').item(0);
                var links = $("link:first", head);
                for (var i = 0; links[i]; i++)
                {
                    var href = $(links[i]).attr("href");
                    if (href && href.toLowerCase().indexOf("ligerui") > 0)
                    {
                        return href.substring(0, href.toLowerCase().indexOf("lib") );
                    }
                }
            }
			
     </script> 
<style type="text/css"> 
    body,html{height:100%;}
    body{ padding:0px; margin:0;   overflow:hidden;}  
    .l-link{ display:block; height:26px; line-height:26px; padding-left:10px; text-decoration:underline; color:#333;}
    .l-link2{text-decoration:underline; color:white; margin-left:2px;margin-right:2px;}
    .l-layout-top{background:#102A49; color:White;}
    .l-layout-bottom{ background:#E5EDEF; text-align:center;}
    #pageloading{position:absolute; left:0px; top:0px; background:white url('res/js/LigerUI/lib/images/loading.gif') no-repeat center; width:100%; height:100%;z-index:99999;}
    .l-link{ display:block; line-height:22px; height:22px; padding-left:16px;border:1px solid white; margin:4px;}
    .l-link-over{ background:#FFEEAC; border:1px solid #DB9F00;} 
    .l-winbar{ background:#2B5A76; height:30px; position:absolute; left:0px; bottom:0px; width:100%; z-index:99999;}
    .space{ color:#E7E7E7;}
    /* 顶部 */ 
    .l-topmenu{ margin:0; padding:0; height:31px; line-height:31px; background:url('res/js/LigerUI/lib/images/top.jpg') repeat-x bottom;  position:relative; border-top:1px solid #1D438B;  }
    .l-topmenu-logo{ color:#E7E7E7; padding-left:35px; line-height:26px;background:url('res/js/LigerUI/lib/images/topicon.gif') no-repeat 10px 5px;}
    .l-topmenu-welcome{  position:absolute; height:24px; line-height:24px;  right:30px; top:2px;color:#070A0C;}
    .l-topmenu-welcome a{ color:#E7E7E7; text-decoration:underline} 
     .body-gray2014 #framecenter{
        margin-top:3px;
    }
      .viewsourcelink {
         background:#B3D9F7;  display:block; position:absolute; right:10px; top:3px; padding:6px 4px; color:#333; text-decoration:underline;
    }
    .viewsourcelink-over {
        background:#81C0F2;
    }
    .l-topmenu-welcome label {color:white;
    }
    #skinSelect {
        margin-right: 6px;
    }
 </style>
</head>
<body style="padding:0px;background:#EAEEF5;">  
<div id="pageloading"></div>  
<div id="topmenu" class="l-topmenu">
    <div class="l-topmenu-logo"><?=$_record["topic"]["content_name"]?></div>
    <div class="l-topmenu-welcome">
        <label> 快速通道：</label>
        <select id="fastLink">
            <option value="" selected="selected">请选择</option> 
            <option value="menu">专题频道</option>
            <option value="adSpace">专题广告</option>
            <option value="refresh">刷新</option>
            <!--<option value="cleanCache">清空缓存</option>
            <option value="count">流量分析</option>-->
        </select>
        <a href="index.php?acl=main" class="l-link2">返回主站</a> 
        <span class="space">|</span>
        <a href="../index.php?acl=topic&method=index&id=<?=$_SESSION["topicId"]?>" class="l-link2" target="_blank">专题预览</a> 
        <span class="space">|</span>
        <a href="?acl=login&method=logout" class="l-link2">退出</a>
    </div> 
</div>

  <div id="layout1" style="width:99.2%; margin:0 auto; margin-top:4px; "> 
        <div position="left" title="专题管理" id="accordion1"> 
                     <div title="内容管理" class="l-scroll">
                         <ul id="tree1" style="margin-top:3px;"/>
                    </div>
                    <div title="功能模块">
                    <div style=" height:7px;"></div>
                    	 <a class="l-link" href="javascript:f_addTab('topicParams','专题设置','index.php?acl=topic&method=paramsForm')">专题设置</a>
                         <a class="l-link" href="javascript:f_addTab('topicMenu','频道管理','index.php?acl=topicMenu&method=lists')">频道管理</a>
                         <!--<a class="l-link" href="javascript:f_addTab('topicLink','快捷菜单','index.php?acl=topicLink&method=lists')">快捷菜单</a>-->                     
                         <a class="l-link" href="javascript:f_addTab('topicAdSpace','广告管理','index.php?acl=topicAdSpace&method=lists')">广告管理</a>
                         <a class="l-link" href="javascript:f_addTab('meetingRegister','报名管理','index.php?acl=meetingRegister&method=lists')">报名管理</a>
                         
                         
                          
                    </div>    
                      
        </div>
        <div position="center" id="framecenter"> 
            <div tabid="home" title="专题信息" style="height:300px" >
                <iframe frameborder="0" name="home" id="home" src="?acl=topic&method=welcome"></iframe>
            </div> 
        </div> 
        
    </div>
  <!--  <div  style="height:32px; line-height:32px; text-align:center;">
            Copyright © 2011-2014 SMALL CMS 版权所有
    </div>-->
    <div style="display:none"></div>
</body>
</html>
