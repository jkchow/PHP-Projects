// JavaScript Document
if(typeof(CmsTools)=="undefined")
 	CmsTools={
		author:'薛新峰',
		veision:'1.0 (2014-11-09)',
		//页面跳转封装，addBackUrl参数如果为true,则在跳转时会自动添加backUrl参数
		pageJump:function(url,addBackUrl){			
			if(addBackUrl==true){
				var obj=new Base64();
				var backUrl=obj.Encode64(location.href);
				location.href=url+"&backUrl="+backUrl;
			}else{
				location.href=url;
			}
			
		},
		//获取url参数
		getQueryString:function (paramName) {    
			var reg = new RegExp("(^|&)" + paramName + "=([^&]*)(&|$)", "i");    
			var r = window.location.search.substr(1).match(reg);    
			if (r != null) 
				return unescape(r[2]); 
			else
				return null;   
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
		}
		
	}