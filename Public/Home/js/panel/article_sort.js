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
})

function save(){
	if ($(".type_checkbox").length == 0) {
		window.parent.alert_info("请先添加文章分类",0);
		return;
	}
	var i = 0;
	var length = $(".type_checkbox:checked").length;
	var info = [];
	$(".type_checkbox:checked").each(function() {
		that  = $(this).parent().parent();
		var sort_id = $(this).val();
		var column_id = that.find('select').val();
		var column_url = that.find('select').find('option:selected').attr('data');
		var type_name = that.find('label').html();
		info.push({sort_id:sort_id,column_id:column_id,column_url:column_url});
		i++;
	});
	var save_url = $("#save-url").val();
	var title = $(".setting input:first").val();
	var option = {info:info, title:title};
	var data = {name:"ArticleSort", theme:"", source:"type", option:option};
	window.parent.save(data,$("#status").val());
}
