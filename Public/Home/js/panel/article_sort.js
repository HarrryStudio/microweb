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

function save(){
	if ($(".type_checkbox").length == 0) {
		window.parent.alert_info("请先添加文章分类",0);
		return;
	}
	var list = [];
	list['column_id'] = [];
	list['column_url'] = [];
	list['type_name'] = [];
	$(".type_checkbox:checked").each(function() {
		that  = $(this).parent().parent();
		list['column_id'].push(that.find('select').val());
/*		list['column_url'].push(that.find('select').find('option:selected').attr('data'));
		list['type_name'].push(that.find('label').html());*/
	});
	var save_url = $("#save-url").val();
	var json;
	json = JSON.stringify(list['column_id']);
	console.log(json);
	return;
	// var option = {'column_id':column_id, 'column_url':column_url, 'type_name':type_name};
	var option = {'list':JSON.stringify(list), 'test':'test'};
	var data = {'name':'ArticleSort', 'theme':null, 'source':'type', 'option':option};
	$.post(save_url, data, function (data) {
		console.log(data);
		html = data['data']['html'];
		var pro = window.parent.getPro();
		$(pro).before(html);
		window.parent.$.layer.close();

	})
}


