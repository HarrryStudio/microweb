;(function($){

	$.layer = function(options){
		var layer = $.layer;
		var defaults = {
			//width 			: 400,		//长度
			//height 			: 250,		//宽度
			Title 			: '信息',	//标题
			Type 			: 'info',	//类型
			// info 只有信息, 
			// errer 错误提示, 
			// notice 提醒 退出或删除,
			// load 加载页面 自动消失
			html 			: '',		//内容
			autoHide 		: false,    //自动消失
			timeout 		: 1300,	    //消失延迟
			buttonSure 		: true,     //确认按钮
			buttonCancel 	: false,    //取消按钮
			buttonSureText	: "确定",	//确认按钮文字
			buttonCancelText: "取消",	//取消按钮文字
			sure:function(){},			//确认的触发时间
			cancel:function(){},			//取消的触发时间
			alwaysClose     : true
		};
		/*初始化配置*/
		var tipHtml = '';
		var button = '';



		if(options == null){
			options = defaults;
		}else{
			if(options.Type == 'load'){
				defaults.buttonSure = false;
				defaults.buttonCancel = false;
				defaults.Title = "跳转页面";
			}
			if(options.Type == 'notice'){
				defaults.buttonSure = true;
				defaults.buttonCancel = true;
				defaults.Title = "提示";
			}
			options = $.extend(defaults,options);
		}
		

		/*组装html*/
		if(options.buttonSure){
			button += "<button class='tip_sure'>"+options.buttonSureText+"</button>";
		}
		if(options.buttonCancel){
			button += "<button class='tip_cancel'>"+options.buttonCancelText+"</button>";
		}
	
		if(options.Type == 'info' || options.Type == 'load'){
			tipHtml = options.html;
		}else if(options.Type == 'error'){
			tipHtml = "<span class='tip_error'></span>" + "<div class='tip_error_msg'>" + options.html + "</div>";
		}else if(options.Type == 'notice'){
			tipHtml = "<span class='tip_notice'></span>" + "<div class='tip_notice_msg'>" + options.html + "</div>";
		}

		/*清除其他layer*/
		if($('.layer')){
			$('.layer').remove();
		}
		if(st){
			clearTimeout(st);
		}

		/*插入layer*/
		$('body').prepend(
			 "<div class='layer'>"
			+	"<div class='tip_back'></div>"
			+	"<div class='tip'>"
			+		"<p class='tip_title'>"+options.Title+"<span class='close-icon'>×</span></p>"
			+		"<div class='tip_content'>"+tipHtml+"</div>"
			+		"<div class='tip_button_bar'>"+button+"</div>"
			+	"</div>"
			+"</div>");

		/*弹出窗口*/
		$('.layer').show();

		/*调整layer样式*/
		if(options.Type == 'info'){
			//$('.tip').css('width',options.width + 'px');
			// $('.tip').css('backgroundColor','#ececec');
			//$('.tip_content').css('height',options.height+'px');
			$('.tip_content').addClass('tip_info_content');
			// $('.tip_button_bar button').css('width','93px');
		}

		/*弹出位置*/
		$(window).resize(function(){
			if (window.innerWidth){
				winWidth = window.innerWidth;
				winHeight = window.innerHeight;
			}
			else if ((document.body) && (document.body.clientWidth)){
				winWidth = document.body.clientWidth;
				winHeight = document.body.clientHeight;
			}
			var top = (winHeight - $('.tip').height()) / 3 + $('body')[0].scrollTop;
			if (top < 0){
				top = 0;
			}
			var left = (winWidth - $('.tip').width()) / 2;
			$('.tip').css({
				top : top + 'px',
				left : left + 'px'
			});
			$('.layer').css('height',document.body.scrollHeight + 'px');
		}).resize();

		$('.tip').animate({opacity:1},300);


		/*添加事件*/
		if(options.autoHide){
			var st = setTimeout(function(){
				$('.layer').fadeOut(300,function(){
					options.sure();
					$('.layer').remove();
				});
				clearTimeout(st);
			},options.timeout);
		}
		$('.tip_sure').click(function(){
			options.sure();
			if(options.alwaysClose){
				layer.close();
			}
		});
		$('.tip_cancel').click(function(){
			options.cancel();
			// if(options.alwaysClose){
				layer.close();
			// }
		});
		$('.close-icon').click(layer.close);
	}
    $.layer.close = function(){
        $('.layer').fadeOut(20).remove();
    }
})(jQuery);