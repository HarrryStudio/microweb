$(function() {

	if (localStorage["statu"]){
		var sit = localStorage["statu"];
		$("a").eq(sit).find("li").css("border","1px solid #00FFFF");
	}else{
		$("li:first").css("border","1px solid #00FFFF");
	}

	$("li").mouseenter(function(){
		$("li").css("border","");
		$(this).css("border","1px solid #00FFFF");
		var index = $(this).parent("a").index();
		localStorage.setItem("statu",index);
	})

	var scrollFunc = function(e){
		e = e || window.event;
		if (e.wheelDelta) {
			if (e.wheelDelta > 0) {
				scrollUp();
			}
			if (e.wheelDelta < 0) {
				scrollDown();
			}
		}else if (e.detail) {	 //Firefox 滑轮事件
			if (e.detail > 0) {
				scrollUp();
			}
			if (e.detail < 0) {
				scrollDown();
			}
		}
	}
	//给页面绑定滑轮滚动事件  
	if (document.addEventListener) {//firefox  
	document.addEventListener('DOMMouseScroll', scrollFunc, false);  
	}  
	//滚动滑轮触发scrollFunc方法  //ie 谷歌  
	window.onmousewheel = document.onmousewheel = scrollFunc;   
	function scrollUp(){
		
		// alert("滑轮向上滚动");
	}

	function scrollDown(){
		var set = parseInt(document.body.scrollTop);
		if (set >=100) {
			$("#intro").css({transition:"all 2000ms",transform:"rotate(-45deg) translate(550px,335px)"});
			setTimeout(function(){
				$(".trait").fadeIn(2000,function(){
					$(this).css({display:"block"});
				});
			},500);
			localStorage.setItem("intro",1);
		};
		if (set>=600) {
			$("#effect").css({transition:"all 2000ms",transform:"rotate(-45deg) translate(550px,330px)"});
			setTimeout(function(){
				$("#first_line,#second_line").fadeIn(2000,function(){
					$(this).css({display:"block"});
				});
			},500);
			localStorage.setItem("effect",1);
		};
	}
	if (localStorage['intro']==1){
		$("#intro").css({transform:"rotate(-45deg) translate(550px,335px)"});
		$(".trait").css({display:"block"});
	};
	if (localStorage['effect']==1) {
		$("#effect").css({transform:"rotate(-45deg) translate(550px,330px)"});
		$("#first_line,#second_line").css({display:"block"});
	};
	

})