$(function(){
	$(".pattern").on("click",function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
	})
	var flag = false;
	$("#type_all").on("change",function () {
		$(".type_checkbox").each(function() {
			console.log(flag);
			this.checked = !flag;
		})
		flag = ! flag;
	}).click();
	$(".type_checkbox").on('change',function () {
		if ($(".type_checkbox:checked").length == $(".type_checkbox").length) {
			$("#type_all")[0].checked = true;
			console.log("true");
			flag = true;
		} else {
			$("#type_all")[0].checked = false;
			console.log("false");
			flag = false;
		}
	})
	console.log(window.parent.getOperationElem());
})
function save(){
	if ($(".type_checkbox").length == 0) {
		window.parent.alert_info("请先添加文章分类",0);
		return;
	}
	console.log($(".type_checkbox").length);
	var temp = "";

	// var column_id = $(".column_list_checkbox:checked").val();
	// var column_url = $(".column_list_checkbox:checked").attr('data');
	var i = 0;
	var length = $(".type_checkbox:checked").length;
	$(".type_checkbox:checked").each(function() {
		that  = $(this).parent().parent();
		var column_id = that.find('select').val();
		var column_url = that.find('select').find('option:selected').attr('data');
		var type_name = that.find('label').html();
		// temp += "<li><a href='/microWeb/index.php/Home/Panel/article_sort_info/"+column_url+".html/?article_sort_id="+column_id+"'>"+type_name+"</a></li>";
		temp += "<li><a class='article-link' href='"+column_url+".html' data-url='/microWeb/index.php/Home/Panel/readHtml/column_id/"+column_id+"'>"+type_name+"</a></li>";
		i++;
		if (i != length) {
			temp += "<hr>";
		};
	})
/*	$(".type_checkbox:checked").each(function() {
		// temp += "<li><a href='/microWeb/index.php/Home/Panel/article_sort_info?article_sort_id="+$(this).prev().html()+"&column_id="+column_id+"'>"+$(this).prev().html()+"</a></li>";
		temp += "<li><a href='/"+column_url+".html'>"+$(this).prev().html()+"</a></li>";
	})*/
	var url = $("#target_url").val();
	var type_data = $("#type_data").serialize();
	var img_url = $("#img_url").val();


/*	var link1 ="/microWeb/UserFiles/Public/Controller/article_sort/article_sort_show.css";
	var  loadCss ="<link rel = 'stylesheet' href = " + link1 + "  />";
	console.log("loadCss"+loadCss);
	$(parent.document.getElementById('panel-frame').contentDocument.head).append(loadCss);*/

	var html = "";
	html += "<div class='article_container controller' data-id='"+$('#controller-id').val()+"'>";
		html += "<div class='controller-title'>"+$(".setting input:first").val()+"</div>";
		html += "<div class='article_sort'>"
			html += "<ul class = 'article_sort_list'>";
			// html += "<ul class = 'article_sort_list' data='"+column_id+"'>";
			html += temp;
			html += "</ul>";
		html += "</div>";
	html += "</div>";   
	console.log(html);

	var pro = window.parent.getPro();
	if ($("#status").val() == 1) {
		elem = window.parent.getOperationElem();
		$(elem).hide().before(html).remove();
	} else {
		$(pro).before(html);
	}
	window.parent.$.layer.close();
}


