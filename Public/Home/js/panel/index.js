window.onload = function(){
	reFirstLast();
}
$(function(){
	//调整 编辑区 和栏目区 的高
	$(window).resize(function(){
		var height = window.innerHeight || document.body.clientHeight;
		// console.log(height);
		$('.middle').height(height - $('.header').height() - $('.footer').height());
		console.log(document.body.scrollHeight);
		var table_height = $('.footer')[0].offsetTop - $('.column-table-body')[0].offsetTop - 50;
		console.log( table_height);
		$('.column-table-body').css({"max-height": table_height + "px"});
	}).resize();
	// 控件区 的 page
	if($('.left-side-page-item').length > 1){
		$('.left-side-page-item:first>.point').addClass('active');
	}else{
		$('.left-side-page-item:first').hide();
	}
	$('.point').each(function(index){
		$(this).on('click',function(){
			$('.point.active').removeClass('active');
			$('.controller-list-bar').animate(
				{"top": - index * $('.controller-list-item').height() + "px"},250)
			$(this).addClass('active');
		})
	})

	// column编辑功能
	addColumnEvent();
	/*拖放*/
	$('.controller-item').each(function(){
		this.ondragstart = function(event){
			console.log("dragStart");
	        event.dataTransfer.setData("Text", $(this).attr('data-name'));
		}
	})
	// 鼠标移出panel时隐藏 占位div
	$('body')[0].ondragover = function(event){
		panelFrame.window.dragLeave(event);
	}
	//footer栏 的选择面板显示
	$('.updown').on('click',function(){
		var body = $('.footer-body');
		if(body.is('.up')){
			footToDown();
		}else{
			footToUp();
		}
	})
	//切换 主题,背景页面
	$('.footer-nav-button.theme').on('click',function(){
		$('.footer-bar').animate({"top" : 0},250);
		footToUp();
	})

	$('<div class="footer-nav-bu"></div>tton.back-img').on('click',function(){
		$('.footer-bar').animate({"top" : '-200px'},250);
		footToUp();
	})
	//隐藏 主题,背景页面
	$('body').on('click',function(e){
		var elem = $('.footer-body.up')
		//console.log("11");
		if(elem.length <= 0){return;}
		var height = document.body.scrollHeight + elem[0].offsetTop -  $('.footer').height();
		console.log(e.clientY+"//"+height);
		if(e.clientY + document.body.scrollTop < height){
			footToDown();
		}
	})
	var flag = true;
	//主题,背景页面 的 左右按钮
	$('.left-arrow').on('click',function(){
		if(!flag){return;}
		flag = !flag;
		list = $(this).next();
		bar = $(this).parent();
		var item_width = bar.width() - $(this).width() * 2;
		var left = list[0].offsetLeft;
		if(left > -item_width + 95){
			list.animate({'left': 95 + "px"},function(){
				flag = !flag;
			});
		}else{
			list.animate({'left':  left + item_width + "px"},function(){
				flag = !flag;
			});
		}
	})

	$('.right-arrow').on('click',function(){
		if(!flag){return;}
		flag = !flag;
		list = $(this).prev();
		bar = $(this).parent();
		var item_width = bar.width() - $(this).width() * 2;
		var left = list[0].offsetLeft;
		if(left < item_width - list[0].offsetWidth){flag = !flag;return;}
		list.animate({'left': left - item_width + "px"},function(){
			flag = !flag;
		});
	})
	//切换主题
	$('.theme-item').on('click',function(){
		$('.theme-item.active').removeClass('active');
		getPanelFrame().find('#theme-css').attr('href',$(this).attr('addr') + "/theme.css");
		$('.save-all').attr('data-theme',$(this).attr('data-id'));
		$('.save-all').attr('change-flag',"true");
		$(this).addClass('active');
	})
	//切换背景
	$('.back-item').on('click',function(){
		$('.back-item.active').removeClass('active');
		if($(this).is('.default')){
			getPanelFrame().find('.background').css({"background-image":""});
		}else{
			getPanelFrame().find('.background').css({"background-image":"url("+$(this).find('img').attr('src')+")"});
		}
		$('.save-all').attr('data-back',$(this).attr('data-id'));
		$('.save-all').attr('change-flag',"true");
		$(this).addClass('active');
	})

	//保存
	$('.save-all').on('click',function(){
		//if($('.save-all').attr('change-flag') == 'false') return;
		// var iframe = getPanelFrame();
		// var div = document.createElement('div');
		// var that = this;
		// div.innerHTML = iframe.find('.center').html();
		// $(div).find('.pro').remove();
		// var data = {back:$(that).attr('data-back'),theme:$(that).attr('data-theme')};
		// var url = "";
		// if($(this).attr("data-type") == "writeHtml"){
		// 	data['content'] = $(div).html();
		// 	url = $('#writeHtml-url').val() + $('#writeHtml-url').attr('now-column');
		// }
		// else{
		// 	url = $('#writeArticle-url').val();
		// }
		// $.post(url,data,function(data){
		// 	if(data.status == 1){
		// 		alert_info(data.info,1);
		// 		$('.save-all').attr('change-flag',"false");
		// 	}else{
		// 		alert_info(data.info,0);
		// 	}
		// })
		saveAll(function(data){
			if(data.status == 1){
				alert_info(data.info,1);
				$('.save-all').attr('change-flag',"false");
			}else{
				alert_info(data.info,0);
			}
		})
	});

	$(document).on('click','.column-name',function(){
		confirm_load($("#readHtml-url").val() + $(this).parent().attr('index'),true);
	})
	$(document).on('click','.nav-item a',function(){
		confirm_load($(this).attr("href"),false);
		return false;
	})

	// window.onbeforeunload =  function () {
	// 	$.post('index',{},function(){
	// 		alert('ddd');
	// 	})
	//  };
	//$(window).unload( function () { alert("Bye now!"); } );
	// $(document).on('click','.confirm',function(){
	// 	confirm_load($(this).attr('href'));
	// })
	//
	//
	//
	//window.onbeforeunload = function() {return '正处于编辑,离开页面可能会丢失修改';};

	// $(document).on('click','a',function(event){
	// 	event.stopPropagation();
	// 	confirm_load($(this).attr('href'),!$(this).is('.win'));
	// 	return false;
	// })
})
function confirm_load(url,win,fun){
	//alert(url);
	if($('.save-all').attr('change-flag') == 'false'){
		window.onbeforeunload = function(){};
		if(win){
			panelFrame.location.href = url;
		}else{
			window.location.href = url;
		}
		fun();
		return;
	}
	$.layer({
		html:'<div style="margin:20px 20px">尚未保存，确认离开页面？</div>',
		buttonCancel:true,
		buttonSureText:"立即保存",
		buttonCancelText:"直接离开",
		sure:function(){
			// var iframe = getPanelFrame();
			// var div = document.createElement('div');
			// var that = $('.save-all');
			// div.innerHTML = iframe.find('.center').html();
			// $(div).find('.pro').remove();
			// var data = {content:$(div).html(),theme:that.attr('data-theme')};
			// $.post($('#writeHtml-url').val() + $('#writeHtml-url').attr('now-column'),data,function(data){
			// 	if(data.status == 1){
			// 		alert_info("保存成功",1);
			// 	}else{
			// 		alert_info("保存失败",0);
			// 	}
			// 	if(win){
			// 		setTimeout(function() {
			// 			panelFrame.location.href = url;
			// 		}, 1500);
			// 	}else{
			// 		setTimeout(function() {
			// 			window.onbeforeunload = function(){};
			// 			window.location.href = url;
			// 		}, 1500);
			// 	}
			// 	fun();
			// })
			saveAll(function(data){
				if(data.status == 1){
					alert_info("保存成功",1);
				}else{
					alert_info("保存失败",0);
				}
				if(win){
					setTimeout(function() {
						panelFrame.location.href = url;
					}, 1500);
				}else{
					setTimeout(function() {
						window.onbeforeunload = function(){};
						window.location.href = url;
					}, 1500);
				}
				fun();
			})
		},
		cancel:function(){
			window.onbeforeunload = function(){};
			if(win){
				panelFrame.location.href = url;
			}else{
				window.location.href = url;
			}
			fun();
		}
	})
}
function saveAll(fun){
	var iframe = getPanelFrame();
	var div = document.createElement('div');
	var that =  $('.save-all');
	div.innerHTML = iframe.find('.center').html();
	$(div).find('.pro').remove();
	var data = {back:$(that).attr('data-back'),theme:$(that).attr('data-theme')};
	var url = "";
	if($(that).attr("data-type") == "writeHtml"){
		data['content'] = $(div).html();
		console.log(data);
		url = $('#writeHtml-url').val() + $('#writeHtml-url').attr('now-column');
	}
	else{
		url = $('#writeArticle-url').val();
	}
	$.post(url,data,function(data){
		fun(data);
	})
}
function footToUp(){
	var body = $('.footer-body');
	body.animate({
			"top" : "-200px",
			"height" : "200px"
		},250).addClass('up');
	$(".updown").removeClass('glyphicon-chevron-up')
			.addClass('glyphicon-chevron-right')
}
function footToDown(){
	var body = $('.footer-body');
	body.animate({
			"top" : 0,
			"height" : 0
		},250).removeClass('up');
	$(".updown").removeClass('glyphicon-chevron-right')
			.addClass('glyphicon-chevron-up')
}
/**
 * 得到手机的iframe
 * @return jquery对象
 */
function getPanelFrame(){
	return $('#panel-frame').contents();
}
/*得到phone中的占位符*/
function getPro(){
	var iframe = getPanelFrame();
	return iframe.find(".pro")[0];
}
/*得到phone中正在备操作的 控件*/
function getOperationElem(){
	var iframe = getPanelFrame();
	console.log(panelFrame.$('.center'));
	return panelFrame.$('.center').data('elem');
}
// 第一个最后一个column的调序箭头失效
function reFirstLast(){
	$('.unmove').removeClass('unmove');
	$('.column-table').find('tbody').find('tr:first-child').find('.column-up').addClass('unmove');
	$('.column-table').find('tbody').find('tr:last-child').find('.column-down').addClass('unmove');
}
/**
 * 在iframe中创建新的controller 或者编辑
 * @param name controller的cname
 */
function add_controller(cname,is_edit,json){
	//隐藏占位符
	//var iframe = getPanelFrame();
	// console.log(iframe);
	is_edit = is_edit || 0;
	$(getPro()).hide();
	var url = $('#control-widget-url').val()+cname+"/is_edit/"+is_edit;
	$.layer({
		html:"<iframe width='800px' height='400px' name='controEdit' src='"+url+"'></iframe>",
		buttonCancel:true,
		buttonSureText:"保存",
		buttonCancelText:"取消",
		alwaysClose:false,
		sure:function(){
            if( controEdit.window.save ){
            	controEdit.window.save();
            	$('.save-all').attr('change-flag','true');
            }else{
            	$.layer.close();
            }
		}
	});
}
/**
 * 添加新栏目
 */
function newColumn(column_info){
	/*<--do:html-->*/
	var tr = document.createElement("tr");
	tr.innerHTML = '<td class="column-name">'
						+'<span class="rel-name">'+column_info.name+'<span>'
					+'</td>'
					+'<td class="column-forbidden">'
						+'<span class="forbide allowed"></span>'
					+'</td>'
					+'<td class="column-do-bar">'
						+'<span class="column-do-item column-edit glyphicon glyphicon-pencil"></span>'
						+'<span class="column-do-item column-up glyphicon glyphicon-arrow-up"></span>'
						+'<span class="column-do-item column-down glyphicon glyphicon-arrow-down"></span>'
						+'<span class="column-do-item column-del glyphicon glyphicon-remove"></span>'
					+'</td>';

	$('.column-table').find('tbody').append(tr);
	var style = ""
	$(tr).attr("data-name",column_info.name);
	$(tr).attr("data-link",column_info.url);
	if(column_info.icon_url != null){
		$(tr).attr("data-icon",column_info.icon_url);
		style = 'background-image:url('+column_info.icon_url+')';
	}

	$(tr).attr("data-forbide",0);
	$(tr).attr("data-sort",column_info.sort);
	$(tr).attr("index",column_info.column_id);

	reFirstLast();

	addColumnEvent();

	/*<--do:panel-->*/
	var iframe = getPanelFrame();
	var nav_item = '<div data-column="'+ column_info.column_id +'" class="nav-item">'
						+'<a href="'+column_info.url+'"><span class="nav-icon" style="'+style+'" ></span>'
						+'<span class="nav-name">'+ column_info.name +'</span></a>'
					+'</div>';
	iframe.find('.nav-bar').append(nav_item);

	//console.log(iframe[0]);

	$.layer.close();
}
/**
 * 编辑新栏目
 */
function editColumn(tr,column_info){
	/*<--do:html-->*/
	tr.attr("data-name",column_info.name);
	tr.attr("data-link",column_info.url);
	tr.find('.rel-name').text(column_info.name);
	var nav = getPanelFrame().find(".nav-item[data-column=" + column_info.id + "]");
	nav.find('.nav-name').text(column_info.name).attr('href',column_info.url);
	if(column_info.icon_url != ""){
		tr.attr("data-icon",column_info.icon_url);
		nav.find('.nav-icon').css({"background-image":"url("+column_info.icon_url+")"});
	}
	/*<--do:panel-->*/
	$.layer.close();
}
/**
 * 为栏目添加事件
 */
function addColumnEvent(){
	//添加column
	$('.column-add').click(function(){
		var html =   "<div class='column-form'><form><div class='column-form-item'>"
						+"<label class='column-form-label' >栏目名称：</label>"
						+"<input name='name' class='column-form-input'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >链接地址：</label>"
						+"<input name='link' class='column-form-input'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<input type='file' name='column_icon' id='add_column_icon'>"
						+"<div id='show_icon'></div>"
					+"</div></form></div>";

		$.layer({
			html:html,
			buttonCancel:true,
			buttonSureText:"保存",
			buttonCancelText:"取消",
			//sure:newColumn,
			sure:function(){
				var form = $(".column-form").find('form')[0];
				var formData = new FormData(form); // 获得form内容

				$.ajax({
					url : "addColumn",
					type: 'post',
					data: formData,
					cache: false,
					processData:false,
					contentType:false,
					success:function(data){
						//console.log(data);
						if(data.status > 0){
							newColumn(data['data']);
						}else{
							alert_info(data_info,0);
						}
					}
				})
			}
		});

	});
	//及时查看图片效果
	$(document).on('change',"#add_column_icon",function(){
		var fileTag = document.getElementById("add_column_icon").files[0];
		if (fileTag) {
			var reader = new FileReader();
            reader.readAsDataURL(fileTag);
            reader.onload = function (e) {
                var urlData = this.result;
                document.getElementById("show_icon").innerHTML = "<img src='" + urlData + "' alt='" + fileTag.name + "'/>";
            };
        }else{
            return;
        }
		return false;
	});
	// 编辑column
	$('.column-edit').click(function(){
		var tr = $(this).parent().parent();
		var name = tr.attr("data-name");
		var link = tr.attr("data-link");
		var icon = tr.attr("data-icon");
		var id = tr.attr('index');

		var html =   "<div class='column-form'><form><input name='id' type='hidden' value='"+id+"'/>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >栏目名称：</label>"
						+"<input name='name' class='column-form-input' value='"+name+"'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >链接地址：</label>"
						+"<input name='link' class='column-form-input' value='"+link+"'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<input type='file' name='column_icon' id='add_column_icon'>"
						+"<div id='show_icon'><img src='" + icon + "' /></div><div class='clear-float'></div>"
					+"</div></form></div>";
		$.layer({
			html:html,
			buttonCancel:true,
			buttonSureText:"保存",
			buttonCancelText:"取消",
			sure:function(){
				/*<--do:ajax-->*/
				var form = $(".column-form").find('form')[0];
				var formData = new FormData(form); // 获得form内容
				$.ajax({
					url : "editColumn",
					type: 'post',
					data: formData,
					cache: false,
					processData:false,
					contentType:false,
					success:function(data){
						//console.log(data);
						if(data.status > 0){
							editColumn(tr,data['data']);
						}else{
							alert_info(data_info,0);
						}
					}
				})
			}
		});
	});
	// column 禁用启用 功能
	$('.forbide').click(function(){
		/*<--do:ajax-->*/
		var tr = $(this).parent().parent();
		var that = this;
		var index = parseInt(tr.attr('index'));
		//console.log(index);
		var status = parseInt(tr.attr('data-forbide'));
		status = status>0?0:1;
		//console.log(status);
		// var now_column_id = $('#writeHtml-url').attr('now-column');
		// var sure = false;
		// if(parseInt(now_column_id) == parseInt(index)){
		// 	$.layer({
		// 		Type:'notice',
		// 		html:'此栏目正在编辑 禁用?',
		// 		sure:function(){
		// 			sure = true;
		// 		}
		// 	});
		// }else{
		// 	sure = true;
		// }
		// if(!sure)return ;
		$.post($('#forbide-column-url').val(),
			{
				status:status,
				column_id:index
			},
			function(data){
				if(data.status == 0){
					alert_info(data_info);
					return;
				}
				/*<--do:html-->*/
				var nav = getPanelFrame().find(".nav-item[data-column=" + index+ "]");
				if($(that).is(".forbidden")){
					$(that).removeClass('forbidden').addClass("allowed");
					tr.attr('data-forbide',0);
					/*<--do:panel-->*/
					nav.show();
				}else{
					$(that).removeClass('allowed').addClass("forbidden");
					tr.attr('data-forbide',1);
					/*<--do:panel-->*/
					nav.hide();
				}
			}
		)

	})
	// column 向上调序 功能
	$('.column-up').click(function(){
		if($(this).is('.unmove')){
			return;
		}
		var tr = $(this).parent().parent();
		var pre = tr.prev();
		/*<--do:ajax-->*/
		$.post($('#sort-column-url').val(),
			{
				now_column_id:tr.attr('index'),
				to_column_id:pre.attr('index'),
			},
			function(data){
				if(data.status == 0){
					alert_info(data_info);
					return;
				}
				/*<--do:html-->*/
				var temp = tr.attr("data-sort");
				tr.attr("data-sort",pre.attr("data-sort"));
				pre.attr("data-sort",temp);
				tr.insertBefore(pre);
				reFirstLast();
				/*<--do:panel-->*/
				var nav = getPanelFrame().find(".nav-item[data-column=" + tr.attr('index')+ "]");
				nav.insertBefore(nav.prev());
			}
		)
	});
	// column 向下调序 功能
	$('.column-down').click(function(){
		if($(this).is('.unmove')){
			return;
		}
		/*<--do:ajax-->*/
		var tr = $(this).parent().parent();
		var next = tr.next();
		/*<--do:ajax-->*/
		$.post($('#sort-column-url').val(),
			{
				now_column_id:tr.attr('index'),
				to_column_id:next.attr('index'),
			},
			function(data){
				if(data.status == 0){
					alert_info(data_info);
					return;
				}
				/*<--do:html-->*/
				var temp = tr.attr("data-sort");
				tr.attr("data-sort",next.attr("data-sort"));
				next.attr("data-sort",temp);
				tr.insertAfter(next);
				reFirstLast();
				/*<--do:panel-->*/
				var nav = getPanelFrame().find(".nav-item[data-column=" + tr.attr('index')+ "]");
				nav.insertAfter(nav.next());
			}
		)
	});
	// column 删除 功能
	$('.column-del').click(function(){
		var that = this;
		var tr = $(this).parent().parent();
		var index = tr.attr('index');
		var now_column_id = $('#writeHtml-url').attr('now-column');
		var html = "将栏目删除后,栏目下的所有内容都将删除,确定吗?";
		if(parseInt(now_column_id) == parseInt(index)){
			html = '此栏目正在编辑,删除后,栏目下的所有内容都将删除 , 是否删除?';
		}
		$.layer({
			Type:'notice',
			html:html,
			sure:function(){
				/*<--do:ajax-->*/
				$.post($('#del-column-url').val(),
					{
						column_id:index,
					},
					function(data){
						if(data.status == 0){
							alert_info(data_info);
							return;
						}
						/*<--do:html-->*/
						// tr.remove();

						// /*<--do:panel-->*/
						// var nav = getPanelFrame().find(".nav-item[data-column=" + index + "]");
						// nav.remove();
						window.location.reload();
					}
				)
			}
		});
	});
}
