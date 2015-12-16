$(function(){
	//高亮设置
	$('.main-nav').find('.nav-item:nth-child('+$('#primary-index').val()+')').addClass('active');
	$('.senior-nav').find('.senior-nav-item:nth-child('+$('#senior-index').val()+')').addClass('active');
	$($('.side-item')[parseInt($('#nav-index').val()) - 1]).addClass('active');

	/*调节中间部分的高并显示*/
	$(window).resize(function(){
		$('.center').css({"opacity":0});
		var winW = document.getElementsByTagName('body')[0].offsetWidth;
		var margin = ( winW - $('.center')[0].offsetWidth) / 2;
		if(margin < 0){
			margin = 0
		}
		$('.center').css({
			"margin-left": margin + 'px'
		})
		$('.content').css({
			"min-height":$('.center').height()
		});
		$('.center').css({"opacity":1});
	}).resize();

	/**弹出信息框的关闭**/
	$('.close').click(function(){
		$('#top-alert').animate({"opacity":0},250,function(){$('#top-alert-back').hide()});
	});
})
/**
 * 弹出信息框
 * @param  string text 输出文字
 * @param  int type 方式  1:success  0:error  2:warning
 */
function alert_info(text,type){
	var top_alert = $('#top-alert');
	top_alert.find(".alert-content").text(text);
	if(type == 1){
		top_alert.removeClass('alert-danger alert-warning').addClass('alert-success'); 
	}else if(type == 0){
		top_alert.removeClass('alert-success alert-warning').addClass('alert-danger');
	}else{
		top_alert.removeClass('alert-success alert-danger').addClass('alert-warning');
	}
	$('#top-alert-back').show();
	top_alert.animate({"opacity":1},250);
	
	setTimeout(function(){
	    $('#top-alert').find('button').click();
	},2000);
}