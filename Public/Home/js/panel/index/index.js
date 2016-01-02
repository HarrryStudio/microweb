window.onload = function(){
	reFirstLast();
}
$(function(){
	//调整 编辑区 和栏目区 的高
	$(window).resize(function(){
		var height = window.innerHeight || document.body.clientHeight;
		// console.log(height);
		$('.middle').height(height - $('.header').height() - $('.footer').height());
		//console.log(document.body.scrollHeight);
		var table_height = $('.footer')[0].offsetTop - $('.column-table-body')[0].offsetTop - 50;
		//console.log( table_height);
		$('.column-table-body').css({"max-height": table_height + "px"});
	}).resize();
	// 控件区 的 page
	if($('.left-side-page-item').length > 1){
		$('.left-side-page-item:first>.point').addClass('active');
	}else{
		$('.left-side-page-item:first').hide();
	}
	$('.point').each(function(index){
		$(this).on('click',function(){
			$('.point.active').removeClass('active');
			$('.controller-list-bar').animate(
				{"top": - index * $('.controller-list-item').height() + "px"},250)
			$(this).addClass('active');
		})
	})

	// column编辑功能
	addColumnEvent();
	/*拖放*/
	$('.controller-item').each(function(){
		this.ondragstart = function(event){
			console.log("dragStart");
	        event.dataTransfer.setData("Text", $(this).attr('data-name'));
		}
	})
	// 鼠标移出panel时隐藏 占位div
	$('body')[0].ondragover = function(event){
		panelFrame.window.dragLeave(event);
	}
	//footer栏 的选择面板显示
	$('.updown').on('click',function(){
		var body = $('.footer-body');
		if(body.is('.up')){
			footToDown();
		}else{
			footToUp();
		}
	})
	//切换 主题,背景页面
	$('.footer-nav-button.theme').on('click',function(){
		$('.footer-bar').animate({"top" : 0},250);
		footToUp();
	})

	$('<div class="footer-nav-bu"></div>tton.back-img').on('click',function(){
		$('.footer-bar').animate({"top" : '-200px'},250);
		footToUp();
	})
	//隐藏 主题,背景页面
	$('body').on('click',function(e){
		var elem = $('.footer-body.up')
		//console.log("11");
		if(elem.length <= 0){return;}
		var height = document.body.scrollHeight + elem[0].offsetTop -  $('.footer').height();
		console.log(e.clientY+"//"+height);
		if(e.clientY + document.body.scrollTop < height){
			footToDown();
		}
	})
	var flag = true;
	//主题,背景页面 的 左右按钮
	$('.left-arrow').on('click',function(){
		if(!flag){return;}
		flag = !flag;
		list = $(this).next();
		bar = $(this).parent();
		var item_width = bar.width() - $(this).width() * 2;
		var left = list[0].offsetLeft;
		if(left > -item_width + 95){
			list.animate({'left': 95 + "px"},function(){
				flag = !flag;
			});
		}else{
			list.animate({'left':  left + item_width + "px"},function(){
				flag = !flag;
			});
		}
	})

	$('.right-arrow').on('click',function(){
		if(!flag){return;}
		flag = !flag;
		list = $(this).prev();
		bar = $(this).parent();
		var item_width = bar.width() - $(this).width() * 2;
		var left = list[0].offsetLeft;
		if(left < item_width - list[0].offsetWidth){flag = !flag;return;}
		list.animate({'left': left - item_width + "px"},function(){
			flag = !flag;
		});
	})
	//切换主题
	$('.theme-item').on('click',function(){
		$('.theme-item.active').removeClass('active');
		getPanelFrame().find('#theme-css').attr('href',$(this).attr('addr') + "/theme.css");
		$('.save-all').attr('data-theme',$(this).attr('data-id'));
		$('.save-all').attr('change-flag',"true");
		$(this).addClass('active');
	})
	//切换背景
	$('.back-item').on('click',function(){
		$('.back-item.active').removeClass('active');
		if($(this).is('.default')){
			getPanelFrame().find('.background').css({"background-image":""});
		}else{
			getPanelFrame().find('.background').css({"background-image":"url("+$(this).find('img').attr('src')+")"});
		}
		$('.save-all').attr('data-back',$(this).attr('data-id'));
		$('.save-all').attr('change-flag',"true");
		$(this).addClass('active');
	})

	//保存
	$('.save-all').on('click',function(){
		saveAll(function(data){
			if(data.status == 1){
				alert_info(data.info,1);
				$('.save-all').attr('change-flag',"false");
			}else{
				alert_info(data.info,0);
			}
		})
	});

	$(document).on('click','.column-name',function(){
		confirm_load($("#readHtml-url").val() + $(this).parent().attr('index'),true);
	})
	$(document).on('click','.nav-item a',function(){
		confirm_load($(this).attr("href"),false);
		return false;
	})
})
function confirm_load(url,win,fun){
	if(!fun){
		fun = function(){};
	}
	if($('.save-all').attr('change-flag') == 'false'){
		window.onbeforeunload = function(){};
		if(win){
			panelFrame.location.href = url;
		}else{
			window.location.href = url;
		}
		fun();
		return;
	}
	$.layer({
		html:'<div style="margin:20px 20px">尚未保存，确认离开页面？</div>',
		buttonCancel:true,
		buttonSureText:"立即保存",
		buttonCancelText:"直接离开",
		sure:function(){
			saveAll(function(data){
				if(data.status == 1){
					alert_info("保存成功",1);
				}else{
					alert_info("保存失败",0);
				}
				if(win){
					setTimeout(function() {
						panelFrame.location.href = url;
					}, 1500);
				}else{
					setTimeout(function() {
						window.onbeforeunload = function(){};
						window.location.href = url;
					}, 1500);
				}
				fun();
			})
		},
		cancel:function(){
			window.onbeforeunload = function(){};
			if(win){
				panelFrame.location.href = url;
			}else{
				window.location.href = url;
			}
			fun();
		}
	})
}
function saveAll(fun){
	var $fn = panelFrame.$;
	var that =  $('.save-all');
	var data = {back:$(that).attr('data-back'),theme:$(that).attr('data-theme')};
	var content = {header:"",content: new Array(), footer:""};
	$fn('.controller').each(function(){
		content.content.push($fn(this).data("json"));
	});
	var url = "";
	if($(that).attr("data-type") == "writeHtml"){
		data['content'] = content;
		console.log(data);
		url = $('#writeHtml-url').val() + $('#writeHtml-url').attr('now-column');
	}
	else{
		url = $('#writeArticle-url').val();
	}
	$.post(url,data,function(data){
		fun(data);
	})
}
function footToUp(){
	var body = $('.footer-body');
	body.animate({
			"top" : "-200px",
			"height" : "200px"
		},250).addClass('up');
	$(".updown").removeClass('glyphicon-chevron-up')
			.addClass('glyphicon-chevron-right')
}
function footToDown(){
	var body = $('.footer-body');
	body.animate({
			"top" : 0,
			"height" : 0
		},250).removeClass('up');
	$(".updown").removeClass('glyphicon-chevron-right')
			.addClass('glyphicon-chevron-up')
}
