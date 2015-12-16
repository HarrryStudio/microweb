$(function(){
	$(".pattern").on("click",function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
	})
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
	})
})

function save(){
    that = $(".hr").parent();
    var status = $("#status").val();
    $index = $(".pattern").index(that);     //标识当前选择的是哪个样式0(表示第一个)
	var oj = window.parent.getOperationElem();
	if ($(".type_checkbox:checked").length == 0) {
		window.parent.alert_info("请先添加文章分类和文章",0);
		return;
	};
	var url = $("#target_url").val();
	var type_data = $("#type_data").serialize();
	var img_url = $("#img_url").val();
	var column_id = $("#column").val();
	var column_url = $("#column").find("option:selected").attr("data");
	$.get(url, type_data, function(data) {
		console.log(data);
		var article_url = $("#article_url").val();
		var html="";
        //第三个样式
        if($index == 2){
/*            var link1 = APP + "/Userfiles/Public/Controller/article_list/article_list_show2.css";
            var  loadCss ="<link rel = 'stylesheet' href = " + link1 + "  />";
            $(parent.document.getElementById('panel-frame').contentDocument.head).append(loadCss);*/
            html += "<div class='article_list_container2 controller' data-id='"+$('#controller-id').val()+"'>";
            html += "<div class='controller-title'>"+$(".setting input:first").val()+"</div>";
            html += "<div class='article_info'>";
            html += "<div class='navText'><div class = 'article_list'>";
            for (var i = 0; i < data.length; i++) {
                html += "<div><div class='row'></div>";
                html += "<span class='article_title style3'>" + data[i].title + "</span>";
                html +="</div>";
            };
            html += "</div></div>";
            html +="<div class='textContent'>";
            for (var i = 0; i < data.length; i++) {
                if(data[i].savepath == null) {
                    img_src = $("#home_img").val()+"/article/"+"default.jpg";
                }else{
                    img_src = img_url+data[i].savepath+data[i].savename;
                }
                if(i==0){
					html += "<a class='article-link' href='"+column_url+".html' data-url='"+article_url+data[i].id+"&column_id="+column_id+"'><div class='detail'><img src="+img_src+">";
                    // html += "<a class='article-link' href='"+column_url+".html' data-url='/microWeb/index.php/Home/Panel/article_info/column_id/"+column_id+"'>;<div class='detail'><img src="+img_src+">";
                }else{
					html += "<a style='display:none' class='article-link' href='"+column_url+".html' data-url='"+article_url+data[i].id+"&column_id="+column_id+"'><div class='detail'><img src="+img_src+">";
                    // html += "<a style='display=none' class='article-link' href='"+column_url+".html' data-url='/microWeb/index.php/Home/Panel/article_info/column_id/"+column_id+"'>;<div class='detail'><img src="+img_src+">";
                // html += "<div class='article_content'>" + data[i].content + "...</div></div>";
                }
                html += data[i].content +"</div></a>";


                html += "";
            }
            html += "</div><div class='clear_float'></div></div>"
            html += "<div class='clear_float'>"
            html += "</div>"
        }
    	else if ($index == 0) {
			console.log("uuuuuuuuuuuuuuuuu"+data.length);
			html += "<div class='article_list_container0 controller' data-id='"+$('#controller-id').val()+"'>";
			html += "<div class='controller-title'>"+$(".setting input:first").val()+"<br><span>News</span></div>";
			html += "<div class='article_info'>";
				html += "<ul class='article_list'>";
				var length = data.length;
				for (var i = 0; i < length; i++) {
					if (data[i].savepath == null) {
						img_src = $("#home_img").val()+"/article/"+"default.jpg";
					} else {
						img_src = img_url+data[i].savepath+data[i].savename;
					};
					if (i == 0) {
						html += "<li><a class='article-link main_article' href'"+column_url+".html' data-url='"+article_url+data[i].id+"&column_id="+column_id+"'>";
						html += "<div class='first_article' style='background-image:url("+img_src+"); background-repeat: no-repeat; background-size:cover'>";
						html += "<div class='article_title'>"+data[i].title+"</div>"
						html += "</div>"
						// html += "<div class='article_text'>";
						// 	html += "<ul><li class='article_title'>" + data[i].title + "</li></ul>";;
						// html += "</div>";
						// html += "<div class='img_container'>";
						// 	if (data[i].savepath == null) {
						// 		img_src = $("#home_img").val()+"/article/"+"default.jpg";
						// 	} else {
						// 		img_src = img_url+data[i].savepath+data[i].savename;
						// 	};
						// 	html += "<img src="+img_src+">";
						// html += "</div>";
					} else {
						html += "<li><a class='article-link sub_article' href='"+column_url+".html' data-url='"+article_url+data[i].id+"&column_id="+column_id+"'>";
							html += "<div class='article_text'>";
								html += "<ul><li class='article_title'>" + data[i].title + "</li></ul>";;
							html += "</div>";
							html += "<div class='img_container'>";
								html += "<img src="+img_src+">";
							html += "</div>";
							console.log(img_src);
					}
					html += "</a></li>";
					if (i != length-1) {
						html += "<hr />";
					};
				};
				html += "</ul>";
			html += "</div></div>";
			html += "</div>"
		}

        //之前的文章列表样式
/*    	else if ($index == 0) {
			html += "<div class='article_list_container controller' data-id='"+$('#controller-id').val()+"'>";
				html += "<div class='controller-title'>"+$(".setting input:first").val()+"</div>";
				html += "<div class='article_info'>"
					html += "<ul class = 'article_list'>"
					for (var i = 0; i < data.length; i++) {
						// html += "<li><a href="+article_url+data[i].id+">";
						
						html += "<li><a class='article-link' href='"+column_url+".html' data-url='"+article_url+data[i].id+"&column_id="+column_id+"'>";

						// html += "<li><a class='article-link' href='"+column_url+".html' data-url='article_url/readHtml/column_id/+"+column_id+"type/"+data[i].id+"'>";
						// html += "<li><a href="+article_url+data[i].id+">";
							html += "<span class='article_title'>" + data[i].title + "</span>";
							if (data[i].savepath == null) {
								img_src = $("#home_img").val()+"/article/"+"default.jpg"; 
							} else {
								img_src = img_url+data[i].savepath+data[i].savename; 
							}
							console.log(img_src+"dffdgdgggfgfg");
							html += "<img src="+img_src+">";
							html += "<div class='article_content'>" + data[i].content + "...</div>";
							// html += "<span class='article_content'>" + data[i].content + "...</span>";
						html +="</a></li>"
					};
					html += "</ul>"
				html += "</div>"
			html += "</div>"
		}*/
		else if ($index == 1) {
/*			var link3 = APP + "/Userfiles/Public/Controller/article_list/article_list_show3.css";
       		var  loadCss;
       		loadCss ="<link rel = 'stylesheet' href = " + link3 + "  />";
			console.log(loadCss);
			$(parent.document.getElementById('panel-frame').contentDocument.head).append(loadCss);*/
			html += "<div class='article_list_container3 controller' data-id='"+$('#controller-id').val()+"'>";
				html += "<div class='controller3-title'>"+$(".setting input:first").val()+"<br><span>News</span></div>";
				html += "<div class='article_info3'>";
					html += "<ul class='article_list3'>";
					console.log(data.length);
					for (var i = 0; i < data.length; i++) {
						html += "<li><a class='article-link' href='"+column_url+".html' data-url='"+article_url+data[i].id+"&column_id="+column_id+"'>";
							html += "<div class='article_text3'>";
								html += "<ul><li class='article_title3'>" + data[i].title + "</li></ul>";
								html += "<div class='article_content3'>" +data[i].content + "</div>";
							html += "</div>";
							html += "<div class='img_container3'>";
								if (data[i].savepath == null) {
									img_src = $("#home_img").val()+"/article/"+"default.jpg"; 
								} else {
									img_src = img_url+data[i].savepath+data[i].savename; 
								}
								html += "<img src="+img_src+">";
							html += "</div>";
							console.log(img_src);
						html +="</a></li>";
						if (i < data.length - 1) {
							html += "<hr />";
						};
					};
					html += "</ul>"
				html += "</div>"
			html += "</div>"
        }
        var pro = window.parent.getPro();
        if ($("#status").val() == 1) {
        	elem = window.parent.getOperationElem();
        	$(elem).hide().before(html).remove();
        } else {
        	$(pro).before(html);
        }
        window.parent.$.layer.close();
	})


}
