
$(function(){
	
	$(".closed").click(function(){$(".body-bg,.pops-wrap").hide();});


	/*登录注册弹出框开始*/
	$(".show-layer").css({left:($(window).width()-$(".show-layer").width())/2,top:"80px"});
	$(window).resize(function(){
		$(".show-layer").css({left:($(window).width()-$(".show-layer").width())/2,top:"80px"});
	});

	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			//input.val(input.attr('placeholder'));
		}
	});
	
	$('[placeholder]').parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		});
	});
	/*登录注册弹出框结束*/  

	/*//ajax载入会员登录状态,这部分已经添加到系统共用代码中了
	$.ajax({
		url:siteUrlPath+"/index.php?acl=member&method=ajaxGetLoginInfo",
		dataType:'json',
		success:function(data){
			//alert(data.isLogin);
			if(data.isLogin=="1"){
				$("#loginUsername").html(data.usrname);
				$("#login_before_div").hide();
				$("#login_after_div").show();
			}else{
				
			}
			
		}}
	);*/

});