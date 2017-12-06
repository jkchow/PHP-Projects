//重新定义提示文字
$.extend($.validator.messages, {
   required: "必选字段",
   remote: "请修正该字段",
   email: "请输入正确格式的电子邮件",
   url: "请输入合法的网址",
   date: "请输入合法的日期",
   dateISO: "请输入合法的日期 (ISO).",
   number: "请输入合法的数字",
   digits: "只能输入整数",
   creditcard: "请输入合法的信用卡号",
   equalTo: "请再次输入相同的值",
   accept: "请输入拥有合法后缀名的字符串",
   maxlength: $.validator.format("请输入一个 长度最多是 {0} 的字符串"),
   minlength: $.validator.format("请输入一个 长度最少是 {0} 的字符串"),
   rangelength: $.validator.format("请输入 一个长度介于 {0} 和 {1} 之间的字符串"),
   range: $.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
   max: $.validator.format("请输入一个最大为{0} 的值"),
   min: $.validator.format("请输入一个最小为{0} 的值")
});

//增加自定义的方法
$.validator.addMethod("mobile", function(value) {
	if(value==null || value=="")
		return true;									 
	var mobile_reg = new RegExp('^[1][3578][0-9]{9}$');
	if(!mobile_reg.test(value)){
		return false;
	}else{
		return true;
	}
}, '请输入正确的手机号!');

$.validator.addMethod("tel", function(value) {	
	if(value==null || value=="")
		return true;
	var tel_reg = new RegExp('^[0-9\\-\\/\\\\]{7,20}$');
	if(!tel_reg.test(value)){
		return false;
	}else{
		return true;
	}
}, '请输入正确的电话号码!');

$.validator.addMethod("qq", function(value) {
	if(value==null || value=="")
		return true;								 
	var tel_reg = new RegExp('^[0-9]{5,14}$');
	if(!tel_reg.test(value)){
		return false;
	}else{
		return true;
	}
}, '请输入正确的QQ号码!');

$.validator.addMethod("postCode", function(value) {	
	if(value==null || value=="")
		return true;									   
	var tel_reg = new RegExp('^[0-9]{6}$');
	if(!tel_reg.test(value)){
		return false;
	}else{
		return true;
	}
}, '请输入正确的邮编!');

$.validator.addMethod("pwd", function(val) {	
	if(!val.match(/.{8,20}/g)){
		return false;
	}
	
	var lv = 0;
	if(val.match(/[a-z]/g)){lv++;}
	if(val.match(/[0-9]/g)){lv++;}
	if(val.match(/([^a-z0-9])/g)){lv++;}
	if(val.length < 6){lv=0;}
	if(lv > 3){lv=3;}
	
	if(lv<3){
		return false;
	}
	return true;
	
}, '密码强度不符合要求，密码必须是8位以上并且包含数字及大小写字母');