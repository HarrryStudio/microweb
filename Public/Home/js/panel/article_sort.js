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
function serialize_to_obj(str){
	str = str.replace(/=/g,':');
	str = str.replace(/&/g,',');
	str = '{'+str+'}';
	console.log(JSON.parse(str));

	return;
}
/*function zidingyi () {
	$('form [name]').each(function () {
		console.log(this);
	});
}*/
function save(){
	if ($(".type_checkbox").length == 0) {
		window.parent.alert_info("请先添加文章分类",0);
		return;
	}
	var i = 0;
	var length = $(".type_checkbox:checked").length;
	var temp = "";
	$(".type_checkbox:checked").each(function() {
		that  = $(this).parent().parent();
		var column_id = that.find('select').val();
		var column_url = that.find('select').find('option:selected').attr('data');
		var type_name = that.find('label').html();
		temp += "<li><a class='article-link' href='"+column_url+".html' data-url='/microWeb/index.php/Home/Panel/readHtml/column_id/"+column_id+"'>"+type_name+"</a></li>";
		i++;
		if (i != length) {
			temp += "<hr>";
		};
	})


	var sort_ids = $("#type_data").serializeArray();
	var save_url = $("#save-url").val();
	var title = $(".setting input:first").val();
	// var option = {'column_id':column_id, 'column_url':column_url, 'type_name':type_name};
	// var option = {'sort_ids':sort_ids, 'title':title};
	var option = {'list':temp, 'title':title};

	var data = {'name':'ArticleSort', 'theme':null, 'source':'type', 'option':option};
	$.post(save_url, data, function (data) {
		console.log(data);
		html = data['data']['html'];
		var pro = window.parent.getPro();
		$(pro).before(html);
		window.parent.$.layer.close();
	})
}


