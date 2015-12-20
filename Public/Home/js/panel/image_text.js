$(function () {
	//选择样式
	$(".pattern").on("click",function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
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

});

function save () {
	if ($(".article_item input").length == 0) {
		window.parent.alert_info("请先添加文章",0);
		return;
	};
/*	var article_title = $("input:radio:checked").next('label').html();
	var article_content = $('input:radio:checked').siblings('input').val();
	var img_src = $('input:radio:checked').siblings('.img_src').val();*/

	var save_url = $('#save-url').val();
	var title = $(".setting input:first").val();
	var article_id = $('input:radio:checked').val();
	var theme = $(($('.hr')[0])).parent().attr('data-style');
	var index = $('.pattern').index($(($('.hr')[0])).parent())+1;
	var option = {article_id:article_id, index:index, title: title, theme:theme};
	var data = {name:"ImageText", theme:theme, source:"article", option:option};
	window.parent.save(data,$("#status").val());
}


