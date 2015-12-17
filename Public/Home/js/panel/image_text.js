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

})
var dynamicLoading = {
    css: function(path){
		if(!path || path.length === 0){
			throw new Error('argument "path" is required !');
		}
		var p_document = window.parent.panelFrame.document;
		var head = p_document.getElementsByTagName('head')[0];
        var link = p_document.createElement('link');
        link.href = path;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        head.appendChild(link);
    },
    js: function(path){
		if(!path || path.length === 0){
			throw new Error('argument "path" is required !');
		}
		var p_document = window.parent.panelFrame.document;
		var head = p_document.getElementsByTagName('head')[0];
        var script = p_document.createElement('script');
        script.src = path;
        script.type = 'text/javascript';
        head.appendChild(script);
    }
}
function save () {
	var save_url = $('#save-url').val();
	var article_id = $('input:radio:checked').val();
	var article_title = $("input:radio:checked").next('label').html();
	var article_content = $('input:radio:checked').siblings('input').val();
	var img_src = $('input:radio:checked').siblings('.img_src').val();
	var theme = $(($('.hr')[0])).parent().attr('data-style');
	var index = $('.pattern').index($(($('.hr')[0])).parent());
	var option = {'article_id':article_id, 'index':index, 'article_title': article_title, 'img_src':img_src, 'article_content':article_content, 'resource':'article', 'theme':theme};
	var data = {'name':'ImageText', 'theme':theme, 'source':'article', 'option':option};
	console.log(data);
	if ($(".article_item input").length == 0) {
		window.parent.alert_info("请先添加文章",0);
		return;
	};
	$.post(save_url, data, function (data) {
		console.log(data);
		html = data['data']['html'];
		var pro = window.parent.getPro();
		$(pro).before(html);
		window.parent.$.layer.close();
	});
}


