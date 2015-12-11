$(function(){
	var flag = false;
	var url_suffix = "&?";
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
	$(".pattern").click(function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
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

function save() {
	var url = $("#save-url").val();
	var theme = $(".hr").parent().attr('data-theme');
	$.post(url, {'name':'ArticleList', 'theme':theme, 'source':'article', 'option':'option'}, function (data) {
		console.log(data);
		if ($("#status").val() == 1) {
			elem = window.parent.getOperationElem();
			$(elem).hide().before(data.data).remove();
		} else {
			var pro = window.parent.getPro();
			$(pro).before(data.data);
		}
		window.parent.$.layer.close();	
	})			
}