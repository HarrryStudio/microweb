//魔方导航js
//gaoyadong
$(function(){
	url = $("#url").attr("value");
	site_id = $("#web_info").attr("value");
	$(".pattern").click(function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
		var site = $(this).attr("va");
		
/*		switch(site){
			case "type_a": $cs_url="/first_nav.css"; $choice=1; $index=1; break;
			case "type_b": $cs_url="/second_nav.css"; $choice=1; break;
			case "type_c": $cs_url="/third_nav.css"; $choice=2; break;
			case "type_d": $cs_url="/forth_nav.css"; $choice=1; break;
			case "type_e": $cs_url="/fifth_nav.css"; $choice=1; break;
			case "type_f": $cs_url="/sixth_nav.css"; $choice=2; break;
			default: return false; break;
		}*/
	})
})

function save(){
	typeof($cs_url)=="undefined"? $cs_url="/first_nav.css" : $cs_url;
	typeof($choice)=="undefined"? $choice=1 : $choice;
	console.log('lllllllllllllllllllllllll');
	// var ICON_ROOT_PATH = APP+"/Public/Controller/nav/Images/";
	$index = $(".pattern").index($(".hr").parent());
	console.log(url);
	$.post(url,{id:site_id},function(data){
		console.log(data);
/*		var link1 = APP + "/Public/Controller/nav/Css" +$cs_url;
		var  loadCss ="<link rel = 'stylesheet' href = " + link1 + " />";
		$(parent.document.getElementById('panel-frame').contentDocument.head).append(loadCss);*/
		// alert(site_id);
		// alert($choice+"///"+data.length);
		if ($choice==1 && data.length != 0) {
			var html = randomadd(data);			//调用遍历添加函数	
		}else if($choice==2 && data.length==6){
			var html = fixadd(data);			//调用定值函数	
		}else{
			// alert("请重新选择导航样式"+$choice+"///"+data.length);
			return;
		}

		var pro = window.parent.getPro();
		$status = $("#status").val();
		if($status == 1){
			$elem = window.parent.getOperationElem();
			$($elem).hide().before(html).remove();
		}else{
			$(pro).before(html);
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

// function randomadd(){
// 	var html="";

// 	html += "<div id='show_nav' onmouseover='initController(this)'>";

// 		html +="<div class='nav_all nav_one'>";
// 			html +="<div id='one'></div><p>栏目一</p><span>></span>";
// 		html +="</div>";

// 		html +="<div class='nav_all nav_two'>";
// 			html +="<div id='two'></div>";
// 		html +="<p>栏目二</p><span>></span></div>";

// 		html +="<div class='nav_all nav_three'>";
// 			html +="<div id='three'></div>";
// 		html +="<p>栏目三</p><span>></span></div>";

// 		html +="<div class='nav_all nav_four'>";
// 			html +="<div id='five'></div>";
// 		html +="<p>栏目四</p><span>></span></div>";

// 		html +="<div class='nav_all nav_five'>";
// 			html +="<div id='five'></div>";
// 		html +="<p>栏目五</p><span>></span></div>";

// 		html +="<div class='nav_all nav_six'>";
// 			html +="<div id='six'></div>";
// 		html +="<p>栏目六</p><span>></span></div>";
// 	html +="</div>";

// 	return html;
// }