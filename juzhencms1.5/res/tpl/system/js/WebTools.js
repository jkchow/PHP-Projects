// JavaScript Document
if(typeof(WebTools)=="undefined")
 	WebTools={
		author:'juzhencms.com',
		veision:'1.2 (2016-11-28)',
		
		//将当前页面加入收藏夹
		addFavorite:function(){

			var url = window.location;
			var title = document.title;
			var ua = navigator.userAgent.toLowerCase();
			if (ua.indexOf("360se") > -1) {
				alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
			}
			else if (ua.indexOf("msie 8") > -1) {
				window.external.AddToFavoritesBar(url, title); //IE8
			}
			else if (document.all) {
				try{
					window.external.addFavorite(url, title);
				}catch(e){
					alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
				}
			}
			else if (window.sidebar) {
				window.sidebar.addPanel(title, url, "");
			}
			else {
				alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
			}
			
			
		},
		
		//获取单个url参数
		getQueryString:function (paramName) {    
			var reg = new RegExp("(^|&)" + paramName + "=([^&]*)(&|$)", "i");    
			var r = window.location.search.substr(1).match(reg);    
			if (r != null) 
				return unescape(r[2]); 
			else
				return null;   
		},
		
		//获取url参数数组
		getQueryParams:function(){
			var testStr = window.location.search.substr(1);
			var re = /(^|&)?([^&=]+)=([^&]*)(&|$)/g;  
			var params={};
			while(r = re.exec(testStr)) {    
				params[r[2]]=r[3];
			}
			return params;
		},
		//跳转页面并传递参数
		getUrl:function(url,params){
			if(url==null)
				url=siteUrlPath+"/index.php";
			if(url.indexOf("?")<0){
				url+="?";
			}
			if(params!=null && typeof(params)=="object")
				for(var i in params){
					url+=i+"="+encodeURI(params[i])+"&";	   
		    }
			return url;
		},
		
		//根据url中的backUrl参数返回,如果没有则返回上一页面
		jumpBack:function(){
			var backUrl=this.getQueryString("backUrl");
			if(backUrl!=null && backUrl!=""){
				var obj=new Base64();
				backUrl=obj.Decode64(backUrl);
				location.href=backUrl;
			}else{
				history.back();
			}		
		},
		//根据iframe的id获取iframe的document对象
		getIframeDocument:function(frameId){
			var win;
			if(document.getElementById(frameId).contentDocument){//火狐下
					win=document.getElementById(frameId).contentDocument;//获取iframe中的document对象,通过此对象可以获取其中的表单等	
			}else{ //IE下
					win=document.frames[frameId].document;//获取iframe中的document对象,通过此对象可以获取其中的表单等		
			}
			return win;
		},
		
		//使用数据字典填充筛选的select
		setSelectOptions:function(params){
			var defaultParams={
				selectId:null,
				vars:null,
				allowEmpty:true,
				emptyText:"请选择",
				emptyValue:""
			};
			
			//将传入的参数覆盖到默认配置,没有的参数采用缺省配置
			if(typeof params == "object")
			for(var i in defaultParams){
				if(defaultParams[i]!=null)
					if(params[i]==null)
						params[i]=defaultParams[i];    
			}
			
			if(params.selectId==null)
				return;
			var select_id=params.selectId;
			if(params.vars!=null){
				var arr=params.vars;
				if(typeof arr !='object')//将得到的数据转换成json对象	
					arr = eval('('+ arr +')');
			
				var obj=document.getElementById(select_id);
				obj.options.length=0;
				if(params.allowEmpty){
					obj.options[0]=new Option(params.emptyText,params.emptyValue);
					for(i=0;i<arr.length;i++){
						if(arr[i]["selected"]!=null)
							obj.options[i+1]=new Option(arr[i]["text"],arr[i]["id"],true,true);
						else
							obj.options[i+1]=new Option(arr[i]["text"],arr[i]["id"]);
					}
				}else{
					for(i=0;i<arr.length;i++){
						if(arr[i]["selected"]!=null)
							obj.options[i]=new Option(arr[i]["text"],arr[i]["id"],true,true);
						else
							obj.options[i]=new Option(arr[i]["text"],arr[i]["id"]);
					}
				}				
			}
		},
		
		//cookie部分开始==========================================
		//获取cookie值
		getCookie:function(name)
		{
			var arg = name + "=";
			var alen = arg.length;
			var clen = document.cookie.length;
			var i = 0;
			while (i < clen)
			{
				var j = i + alen;
				if (document.cookie.substring(i, j) == arg)
					return this.getCookieVal(j);
				i = document.cookie.indexOf(" ", i) + 1;
				if (i == 0) break;
			}
			return "";
		},
		
		//设置cookie值
		setCookie:function(name, value)
		{
			var argv = this.setCookie.arguments;
			var argc = this.setCookie.arguments.length;
			var expDay = (argc > 2) ? argv[2] : -1;
			try
			{
				expDay = parseInt(expDay);
			}
			catch(e)
			{
				expDay = -1;
			}
			if(expDay < 0) {
				this.setCookieVal(name, value);
			} else {
				var expDate = new Date();
				// The expDate is the date when the cookie should expire, we will keep it for a month
				expDate.setTime(expDate.getTime() + (expDay * 24 * 60 * 60 * 1000));
				this.setCookieVal(name, value, expDate);
			}
		},
		
		deleteCookie:function(name)
		{
			var exp = new Date();
			exp.setTime(exp.getTime() - 1);
			// This cookie is history
			var cval = this.getCookie(name);
			document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
		},
		getCookieVal:function(offset)
		{
			var endstr = document.cookie.indexOf(";", offset);
			if (endstr == -1)
				endstr = document.cookie.length;
			return decodeURIComponent(document.cookie.substring(offset, endstr));
		},
		setCookieVal:function (name, value)
		{
			var argv = this.setCookieVal.arguments;
			var argc = this.setCookieVal.arguments.length;
			var expires = (argc > 2) ? argv[2] : null;
			var path = (argc > 3) ? argv[3] : null;
			var domain = (argc > 4) ? argv[4] : null;
			var secure = (argc > 5) ? argv[5] : false;
			document.cookie = name + "=" + encodeURIComponent(value) +
							  ((expires == null || expires < 0) ? "" : ("; expires=" + expires.toGMTString())) +
							  ((path == null) ? "" : ("; path=" + path)) +
							  ((domain == null) ? "" : ("; domain=" + domain)) +
							  ((secure == true) ? "; secure" : "");
		},
		
		//cookie部分结束======================================
		
		
		//提示框，为了保证不同项目中方便修改，所以封装为函数
		impromptuAlert:function(text){
			alert(text);
			return;
			$.prompt(text, {
				title: "提示",
				buttons: { "确定": 1 },
				submit: function(e,v,m,f){
					
				}
			});
		},
		
		changeValidateImg:function(obj){
			if(typeof(obj)=="string")
				obj=document.getElementById(obj);
			var timenow = new Date().getTime();
			$(obj).attr("src",siteUrlPath+"/index.php?acl=img&method=validateImg&timenow="+timenow);
		},
		
		
		//验证会员信息
		/*//调用示例
		WebTools.validateMemberInfo({
			success:function(data){
				//data中的字段包含isLogin(1或0),usrname(用户名),id(用户id)
				//添加执行后续操作代码
			}
		});*/
		validateMemberInfo:function(param){
			//检查传入的参数是否合法
			if(typeof param != "object") return;
			var thisObj=this;
			//ajax载入会员登录状态
			$.ajax({
				url:siteUrlPath+"/index.php?acl=member&method=ajaxGetLoginInfo",
				dataType:'json',
				success:function(data){
					if(data.isLogin=="1"){
						//data中的字段包含isLogin(1或0),usrname(用户名),id(用户id)
						param.success(data);	
					}else{
						//判断是否需记录回跳地址
						if(param.autoRedirect==null || param.autoRedirect==true){
							//将当前页面地址存入cookie
							thisObj.setCookie("redirectUrl",location.href);
						}
						$("#loginBg").show();
						$("#loginTip").show();
						return;
						//弹出登录对话框
						//alert("需要登录，这个先用着，等改好会显示对话框的");
						
						
					}
				}}
			);	
		},
		//验证密码是否符合要求
		validatePassword:function(val){
			var text="密码强度不符合要求，密码必须是8位以上并且包含数字及大小写字母";
			if(!val.match(/.{8,20}/g)){
				return text;
			}
			
			var lv = 0;
			if(val.match(/[a-z]/g)){lv++;}
			if(val.match(/[0-9]/g)){lv++;}
			if(val.match(/([^a-z0-9])/g)){lv++;}
			if(val.length < 6){lv=0;}
			if(lv > 3){lv=3;}
			
			if(lv<3){
				return text;
			}
			return null;
		},
		/*//上传文件使用示例
		<form id="memberinfo_form">
		<input id="id_card_file" value="" autocomplete="off" accept="image/*" type="file">
		</form>
		<script>
		$(function(){
			WebTools.uploadInit({
				url:siteUrlPath+"/index.php?acl=upload&method=uploadImgCallback",//上传图片
				//url:siteUrlPath+"/index.php?acl=upload&method=uploadFileCallback",//上传文件
				formId:"memberinfo_form",//form的id
				fieldId:"id_card_file",//file的id
				success:function(data){
					alert(data.urlPath);//url路径
					alert(data.savePath);//保存到数据库的路径
				}
			});
		});
		</script>*/
		
		uploadInit:function(param){
			
			var url=param.url;
			
			var formId=param.formId;
			var fieldId=param.fieldId;
			var success=param.success;
			
			$("#"+fieldId).change(function(){
		   
				var tmpId="uploadframe_"+new Date().getTime();
			
				var tmpIframe='<iframe name="'+tmpId+'" id="'+tmpId+'" src="" frameborder="0" scrolling="no" marginwidth="0"  width="0" height="0" allowtransparency="true" style="display:none;"></iframe>';
				var callbackId="callback_"+tmpId;
				$("body").eq(0).append(tmpIframe);
				
				var tmpFieldName=$("#"+fieldId).attr("name");
				if(tmpFieldName==null || tmpFieldName==""){
					tmpFieldName=tmpId;
					$("#"+fieldId).attr("name",tmpFieldName);
				}
				
				//获取表单原有的部分属性
				var oldTarget=$("#"+formId).attr("target");
				var oldAction=$("#"+formId).attr("action");
				var oldMethod=$("#"+formId).attr("method");
				var oldEnctype=$("#"+formId).attr("enctype");
				
				$("#"+formId).attr("target",tmpId);
				$("#"+formId).attr("action",url+"&&fieldName="+tmpFieldName+"&fieldId="+fieldId+"&callback=WebTools."+callbackId);
				$("#"+formId).attr("method","post");
				$("#"+formId).attr("enctype","multipart/form-data");
				
				document.getElementById(formId).submit();
				
				//将form的action属性修改回之前的属性
				if(typeof(oldTarget)=="undefined"){
					$("#"+formId).attr("target","");
				}else{;
					$("#"+formId).attr("target",oldTarget);
				}
				
				if(typeof(oldAction)=="undefined"){
					$("#"+formId).attr("action","");
				}else{
					$("#"+formId).attr("action",oldAction);
				}
				
				if(typeof(oldMethod)=="undefined"){
					$("#"+formId).attr("method","");
				}else{
					$("#"+formId).attr("method",oldMethod);
				}
				
				if(typeof(oldEnctype)=="undefined"){
					$("#"+formId).attr("enctype","");
				}else{
					$("#"+formId).attr("enctype",oldEnctype);
				}
				
				WebTools[callbackId]=function(result){
					var data=eval('('+result+')');
					success(data);
					$("#"+fieldId).val("");
					$("#"+tmpId).remove();
				}
				
			});
			
			
			
		},
		//倒计时
		/*WebTools.secondCountTimer({
			beginTime:"2017-06-25 12:00:00",
			showTime:function(data){	
				//展示倒计时
			},
			endCallback:function(){
				//时间到了
			}
		});*/
		secondCountTimer:function(param){
			var beginTime=param.beginTime;
			var str1 = beginTime.split(/[-\s:]/);
			var time1 = new Date(str1[0],str1[1]-1,str1[2],str1[3],str1[4],str1[5]);
			var time2 = new Date();
			if(time1.getTime()>time2.getTime()){
				var second_count = (time1.getTime() - time2.getTime())/1000;
				var d=Math.floor(second_count / ( 60 * 60 * 24));
				var h=Math.floor(second_count / ( 60 * 60 ))%24;
				var m=Math.floor(second_count /60)%60;
				var s=Math.floor(second_count %60);
				var data={
						d:d,
						h:h,
						m:m,
						s:s,
					};
				//展示时间数据
				param.showTime(data);
				//创建定时任务
				var date_task = window.setInterval(function(){
					second_count--;
					if(second_count>0){
						var d=Math.floor(second_count / ( 60 * 60 * 24));
						var h=Math.floor(second_count / ( 60 * 60 ))%24;
						var m=Math.floor(second_count /60)%60;
						var s=Math.floor(second_count %60);
						var data={
								d:d,
								h:h,
								m:m,
								s:s,
							};
						//展示时间数据
						param.showTime(data);
					}else{
						window.clearInterval(date_task); 
						param.endCallback();
					}
				}, 1000);
			}else{
				//param.endCallback();
			}
		}
		
	}


