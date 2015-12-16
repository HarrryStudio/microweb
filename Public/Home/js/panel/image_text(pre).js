$(function() {
	$('.article_list .article_item').eq(0).css('background','#D0D0D0');
	$('.article_list .article_item').eq(0).find('img').attr('src','/microweb/Public/Home/images/panel/viwepagerAdd1.png');
	$('.article_item label').click(function(){
		$('.article_list .article_item').css('background','');
		$(this).parents('.article_item').css('background','#D0D0D0');
		$('.article_list .article_item').find('img').attr('src','/microweb/Public/Home/images/panel/viwepagerAdd2.png');
		$(this).next().attr('src','/microweb/Public/Home/images/panel/viwepagerAdd1.png');
	})
	//选择样式
	$(".pattern").on("click",function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
		var index = $(this).index();
/*		switch(index){
			case 0: $show_way="image_text_show.css"; break;
			case 1: $show_way="image_left_around.css"; break;
			case 2: $show_way="image_left.css"; break;
			case 3: $show_way="image_right.css"; break;
			default: break;
		}*/
	})
	//选择图片
	$(".pattern2").on("click",function(){
		$(".pattern2").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
	})
	$(".img_list").find('.pattern2').eq(0).find('div').addClass('hr');
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
function save(){

/*	if ($(".img_list img").length == 0) {
		window.parent.alert_info("请先添加图片",0);
		return;
	};*/
	if ($(".article_item input").length==0) {
		window.parent.alert_info("请先添加文章",0);
		return;
	};
	
/*	if ($(".hr").length < 2) {
		console.log("请先添加图片");
		return;
	};
	if ($("input:radio:checked").length==0) {
		console.log("请先添加文章");
		return;
	}*/
	var article_id = $('input:radio:checked').val();
	var article_title = $("input:radio:checked").next('label').html();
	var article_content = $('input:radio:checked').siblings('input').val();
	// var img_src = $(".pattern2>.hr>img").attr('src');
	var img_src = $('input:radio:checked').siblings('.img_src').val();
	console.log("-------------"+img_src);
	var pathName=window.document.location.pathname;
	var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
	typeof($show_way)=="undefined"? $show_way="image_text_show.css" : $show_way;
	console.log("pathName"+pathName);
	console.log("projectName"+projectName);
	var html = "";
	/*var link1 = projectName+"/UserFiles/Public/Controller/image_text/"+$show_way;
	console.log("link1"+link1);
	var  loadCss ="<link rel = 'stylesheet' href = '" + link1 + "'  />";
	$(parent.document.getElementById('panel-frame').contentDocument.head).append(loadCss);
	var temp;*/
	var index = $(".pattern").index($(".pattern > .hr").parent());
	console.log(index);
	switch(index) {
		case 1: temp = "image_text_container2"; break;
		case 2: temp = "image_text_container3"; break;
		case 3: temp = "image_text_container4"; break;
		default: temp = "image_text_container"; break;
	}
	html += "<div class='"+temp+" controller' data-id='"+$('#controller-id').val()+"'>";
		html += "<div class='controller-title '>"+$(".setting input:first").val()+"</div>";
		// html += "<div class='image_text_container'>";
			html += "<div>"
			html += "<div class='image_text_img'>";
			if (index == 2) {
					html += "<h4>"+article_title+"</h4>";
			};
				html += "<img src=" +img_src+">";
			html += "</div>";
			if (index != 2) {
				html += "<div class='image_text_title'>";
					html += "<h4>"+article_title+"</h4>";
				html += "</div>";				
			};
			html += "<br/>"
			html +=  article_content;
			html += "<div class='clear_float'></div>"
		html += "</div>";
		html += "</div>";
	html += "</div>";
	var pro = window.parent.getPro();
	if ($("#status").val() == 1) {
		elem = window.parent.getOperationElem();
		$(elem).hide().before(html).remove();
	} else {
		$(pro).before(html);
	}
	window.parent.$.layer.close();
}
