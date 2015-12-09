//魔方导航js
//gaoyadong
$(function(){
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
function save(){
	var theme = $(".hr").parent().attr('va');
	var url = $('#save-url').val();
	console.log(url);
	$.post(url,{name:"Magic",resource:"",theme: theme, option:""},function(data){
		console.log(data);
		if(data.status == 1){
			html = data['data'];
			$status = $("#status").val();
			if($status == 1){
				var elem = window.parent.getOperationElem();
				$(elem).hide().before(html).remove();
			}else{
				var pro = window.parent.getPro();
				$(pro).before(html);
			}
		}else{
			alert("失败");
		}
		window.parent.$.layer.close();
	});

}

//可以根据栏目数随机添加
function randomadd(data){
console.log(data);
	var html="";
		html += "<div style='display: inline-block;' class='controller show_nav"+$index+"' data-id='"+$("#controller-id").val()+"'>";
			for (var i = 0; i < data.length; i++) {
				var images = APP+"/Uploads/column/"+data[i]['savepath']+data[i]['savename'];
				console.log(images);
				html += "<div class='nav_all nav-"+i%6+"'><a href="+data[i]['url']+">";
					html +="<div style='background-image: url("+images+")'></div>";
				html += "<p>"+data[i]['name']+"</p><span>></span></a></div>";
			};
			html+="<div class='clear_float'></div>";
		html +="</div>";
	html += "</div>";
	return html;
}


//固定的只能添加六个栏目信 息
function randomadd(data){
console.log(data);
	var html="";
		html += "<div style='display: inline-block;' class='controller show_nav"+$index+"' data-id='"+$("#controller-id").val()+"'>";
			for (var i = 0; i < data.length; i++) {
				var images = APP+"/Uploads/"+data[i]['savepath']+data[i]['savename'];
				html += "<div class='nav_all nav-"+i%6+"'><a href="+data[i]['url']+">";
					html +="<div style='background-image: url("+images+")'></div>";
				html += "<p>"+data[i]['name']+"</p><span>></span></a></div>";
			};
			if($index == 5){
				html += "<div class='nav_all nav-6'><a>";
				html +="<div></div>";
				html += "<p></p><span></span></a></div>";
			}
			html+="<div class='clear_float'></div>";
		html +="</div>";
	html += "</div>";
	return html;
}
