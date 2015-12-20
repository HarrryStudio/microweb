$(function(){
	$(".pattern").on("click",function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
	})
	var flag = false;
	var url = $(".article_info a").attr('url');
	$("#type_all").on("click",function () {
		$(".type_checkbox").each(function() {
			this.checked = !flag;
		})
		flag = ! flag;
	}).click();
	$(".type_checkbox").on('change',function () {
		if ($(".type_checkbox:checked").length == $(".type_checkbox").length) {
			$("#type_all")[0].checked = true;
			flag = true;
		} else {
			$("#type_all")[0].checked = false;
			flag = false;
		}
	});
});

function save() {
	var save_url = $("#save-url").val();
	var theme = $(".hr").parent().attr('data-theme');
	var title = $("#title").val();
	var selected = $("#type_data").serialize();
	var column_url = $("#column option:selected").attr('data');
	var column_id = $("#column").val();
	var article_url = $("#article_url").val();
	var option ={title:title, column_id:column_id, column_url:column_url, selected:selected, article_url:article_url};
	var data = {name:"ArticleList", theme:theme, source:"article", option:option};
	window.parent.save(data,$("#status").val());
};