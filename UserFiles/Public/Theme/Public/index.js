(function(){
    var isTouch = ('ontouchend' in document.documentElement) ? 'touchend' : 'click', _on = $.fn.on;
    $.fn.on = function(){
        arguments[0] = (arguments[0] === 'click') ? isTouch: arguments[0];
        return _on.apply(this, arguments);
    };
})();
$(function(){

	 if($('.nav-bar').width() - $('.side').width() > 0){
	 	$('.nav-move-right').show();
	 }

	// $('.head-icon').css({"height": $('.head-icon').width()});


	$('.menu-button').on('click',function(){
		if($(this).is('.extended')){
			$(this).removeClass('extended');
		}else{
			$(this).addClass('extended');
		}
		// console.log("aa");
		$('.main').each(function(){
			if($(this).is('.moveRight')){
				// $(this).addClass('moveLeft');
				$(this).removeClass('moveRight');
			}else{
				// $(this).removeClass('moveLeft');
				$(this).addClass('moveRight');
			}
		})
		
	})
	$('.top-bar').on('click',function(){
		$('html,body').animate({'scrollTop':0},500);
	})

	$(window).on('scroll',function(){
		if($('.menu-button').is('.extended')){
			$('.menu-button').removeClass('extended');
		}
		$('.main').each(function(){
			if($(this).is('.moveRight')){
				// $(this).addClass('moveLeft');
				$(this).removeClass('moveRight');
			}
		})
		if(document.documentElement.scrollTop + document.body.scrollTop > 0){
			$('.top-bar').removeClass('zi').addClass('tu');
		}else{
			$('.top-bar').removeClass('tu').addClass('zi');
		}
	})
	// $('.menu-button')[0].ontouchstart = function(){
	// 	console.log("aa");
	// }
	// 
	$('.nav-move-left').on('click',function(){
		var that = this;
		$('.nav-bar').animate({"left":0},200)
		$(that).hide();
		$('.nav-move-right').show();
	})
	$('.nav-move-right').on('click',function(){
		var left = $('.nav-bar').width() - $('.side').width();
		var that = this;
		$('.nav-bar').animate({"left":-left + 'px'},200)
		$(that).fadeOut();
		$('.nav-move-left').fadeIn();
	})
});
// function aa(){
// 	main.addClass('moveRight');
// 	return;
// 	//alert("aa");
// 	var main = $('.header');
// 	if(main.is('.moveRight')){
// 		main.addClass('moveLeft');
// 		main.removeClass('moveRight');
// 	}else{
// 		main.removeClass('moveLeft');
// 		main.addClass('moveRight');
// 	}
// }; 