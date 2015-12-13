$(function () {
	//选择样式
	$(".pattern").on("click",function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
		var index = $(this).index();
	})
	//选择图片
	$(".pattern2").on("click",function(){
		$(".pattern2").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
	})

	$(":radio").eq(0).attr('checked', true);
	var url = $(".article_info a").attr('url');
	$(document).on("click",".page a", function () {
		var url = $(this).attr('href');
		$.get(url, function(data) {
			console.log("==================="+data.article_list);
			var list = "";
			for (var i = 0; i < data.article_list.length; i++) {
				data.article_list[i]
				list += "<li><input id=article_"+data.article_list[i].id+" type='radio' name='article_id' value="+data.article_list[i].id+">";
				list += "<label for=article_"+data.article_list[i].id+">"+data.article_list[i].title+"</label>";
				list += "</li>";
			};
			$(".article_list")[0].innerHTML = list;
			$(".page")[0].innerHTML = data.page;
		});
	})
})