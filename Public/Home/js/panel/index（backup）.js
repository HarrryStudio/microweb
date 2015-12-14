window.onload = function(){
	// 第一个最后一个column的调序箭头失效
	$('.column-table').find('tbody').find('tr:first-child').find('.column-up').addClass('unmove');
	$('.column-table').find('tbody').find('tr:last-child').find('.column-down').addClass('unmove');
}

$(function(){
	// column编辑功能
	addColumnEvent();
	/*拖放*/

	$('.controller-item').each(function(){
		this.ondragstart = function(event){
			console.log("dragStart");
	        event.dataTransfer.setData("Text", $(this).attr('index'));
		}
	})
	$('body')[0].ondragover = function(event){
		panelFrame.window.dragLeave(event);  // 鼠标移除panel时隐藏 占位div
	}

	$('.updown').on('click',function(){
		var body = $('.footer-body');
		if(body.is('.up')){
			footToDown();
		}else{
			footToUp();
		}
	})

	$('.footer-nav-button.theme').on('click',function(){
		$('.footer-bar').animate({"top" : 0},250);
		footToUp();
	})
	
	$('.footer-nav-button.back-img').on('click',function(){
		$('.footer-bar').animate({"top" : '-200px'},250);
		footToUp();
	})

})
function footToUp(){
	var body = $('.footer-body');
	body.animate({
			"top" : "-200px",
			"height" : "200px"
		},250).addClass('up');
	$(this).removeClass('glyphicon-chevron-up')
			.addClass('glyphicon-chevron-right')
}
function footToDown(){
	var body = $('.footer-body');
	body.animate({
			"top" : 0,
			"height" : 0
		},250).removeClass('up');
	$(this).removeClass('glyphicon-chevron-right')
			.addClass('glyphicon-chevron-up')
}
/**
 * 得到手机的iframe
 * @return jquery对象 
 */
function getPanelFrame(){
	return $('#panel-frame').contents();
}
function getPro(){
	var iframe = getPanelFrame();
	return iframe.find(".pro")[0];
}
function getOperationElem(){
	var iframe = getPanelFrame();
	return iframe.find('.operation').data('elem');
}
function reFirstLast(){
	$('.unmove').removeClass('unmove');
	$('.column-table').find('tbody').find('tr:first-child').find('.column-up').addClass('unmove');
	$('.column-table').find('tbody').find('tr:last-child').find('.column-down').addClass('unmove');
}
/**
 * 在iframe中创建新的controller 或者编辑
 * @param index controller的id
 */
function add_controller(index,is_edit){
	//隐藏占位符
	is_edit = is_edit || 0;
	$(getPro()).hide();
	var url = $('.controller-item[index='+index +']').attr('data-url');
	$.layer({
		html:"<iframe width='600px' height='300px' name='controEdit' src='"+$('#contro-root').val()+url+"/is_edit"+is_edit+"'></iframe>",
		buttonCancel:true,
		buttonSureText:"保存",
		buttonCancelText:"取消",
		alwaysClose:false,
		sure:function(){
            controEdit.window.save();
		}
	});
}
/**
 * 添加新栏目
 */
function newColumn(){
	/*<--do:ajax-->*/
	var data = {id:10,sort:10};
	var form = $(".column-form");
	var column_name = form.find('input[name=column_name]').val();
	var column_link = form.find('input[name=column_link]').val();
	var column_icon = form.find('input[name=column_icon]').val();
	// $.post($('#add-column-url'), function(){})

	/*<--do:html-->*/
	var tr = document.createElement("tr");
	tr.innerHTML = '<td class="column-name">'
						+'<span class="rel-name">'+column_name+'<span>'
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

	$(tr).attr("data-name",column_name);
	$(tr).attr("data-link",column_link);
	$(tr).attr("data-icon",column_icon);
	$(tr).attr("data-forbide",0);
	$(tr).attr("data-sort",data.sort);
	$(tr).attr("index",data.id);

	reFirstLast();

	addColumnEvent();

	/*<--do:panel-->*/
	var iframe = getPanelFrame();
	var nav_item = '<div id="'+ data.id +'" url="'+ column_link +'" class="nav-item">'
						+'<span class="nav-icon glyphicon glyphicon-home"></span>'
						+'<a>'+ column_name +'</a>'
					+'</div>';
	iframe.find('.navbar').append(nav_item);

	$.layer.close();
}
/**
 * 为栏目添加事件
 */
function addColumnEvent(){
	//添加column
	$('.column-add').click(function(){
		var html =   "<div class='column-form'><div class='column-form-item'>"
						+"<label class='column-form-label' >栏目名称：</label>"
						+"<input name='column_name' class='column-form-input'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >链接地址：</label>"
						+"<input name='column_link' class='column-form-input'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >图标：</label>"
						+"<input name='column_icon' class='column-form-input'/>"
					+"</div></div>";
		$.layer({
			html:html,
			buttonCancel:true,
			buttonSureText:"保存",
			buttonCancelText:"确定",
			sure:newColumn,
			alwaysClose:false
		});
	});
	// 编辑column
	$('.column-edit').click(function(){
		var tr = $(this).parent().parent()
		var name = tr.attr("data-name");
		var link = tr.attr("data-link");
		var icon = tr.attr("data-icon");
	
		var html =   "<div class='column-form'><div class='column-form-item'>"
						+"<label class='column-form-label' >栏目名称：</label>"
						+"<input name='column_name' class='column-form-input' value='"+name+"'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >链接地址：</label>"
						+"<input name='column_link' class='column-form-input' value='"+link+"'/>"
					+"</div>"
					+"<div class='column-form-item'>"
						+"<label class='column-form-label' >图标：</label>"
						+"<input name='column_icon' class='column-form-input' value='"+icon+"'/>"
					+"</div></div>";
		$.layer({
			html:html,
			buttonCancel:true,
			buttonSureText:"保存",
			buttonCancelText:"取消",
			sure:function(){
				/*<--do:ajax-->*/
				var form = $(".column-form");
				var column_name = form.find('input[name=column_name]').val();
				var column_link = form.find('input[name=column_link]').val();
				var column_icon = form.find('input[name=column_icon]').val();

				tr.attr("data-name",column_name);
				tr.attr("data-link",column_link);
				tr.attr("data-icon",column_icon);
				tr.find('.rel-name').text(column_name);
				/*<--do:panel-->*/
				var nav = getPanelFrame().find("#" + tr.attr('index'));
				nav.find('a').text(column_name);
				nav.attr('url',column_link);
			}
		});
	});
	// column 禁用启用 功能
	$('.forbide').click(function(){
		/*<--do:ajax-->*/

		/*<--do:html-->*/
		var tr = $(this).parent().parent();
		var nav = getPanelFrame().find("#" + tr.attr('index'));
		if($(this).is(".forbidden")){
			$(this).removeClass('forbidden').addClass("allowed");
			tr.attr('data-forbide',0);

			/*<--do:panel-->*/
			nav.show();
		}else{
			$(this).removeClass('allowed').addClass("forbidden");
			tr.attr('data-forbide',1);

			/*<--do:panel-->*/
			nav.hide();
		}
	})
	// column 向上调序 功能
	$('.column-up').click(function(){
		if($(this).is('.unmove')){
			return;
		}
		/*<--do:ajax-->*/

		/*<--do:html-->*/
		var tr = $(this).parent().parent();
		var pre = tr.prev();
		var temp = tr.attr("data-sort");
		tr.attr("data-sort",pre.attr("data-sort"));
		pre.attr("data-sort",temp);
		tr.insertBefore(pre);
		reFirstLast();

		/*<--do:panel-->*/
		var nav = getPanelFrame().find("#" + tr.attr('index'));
		nav.insertBefore(nav.prev());
	});
	// column 向下调序 功能
	$('.column-down').click(function(){
		if($(this).is('.unmove')){
			return;
		}
		/*<--do:ajax-->*/

		/*<--do:html-->*/
		var tr = $(this).parent().parent();
		var next = tr.next();
		var temp = tr.attr("data-sort");
		tr.attr("data-sort",next.attr("data-sort"));
		next.attr("data-sort",temp);
		if($(this).prev().is('.unmove')){
			$(this).prev().removeClass('unmove');
			next.find('.column-up').addClass('unmove');
		}
		tr.insertAfter(next);
		reFirstLast();

		/*<--do:panel-->*/
		var nav = getPanelFrame().find("#" + tr.attr('index'));
		nav.insertAfter(nav.next());
	});
	// column 删除 功能
	$('.column-del').click(function(){
		var that = this;
		$.layer({
			Type:'notice',
			html:'将栏目删除后,栏目下的所有内容都将删除,确定吗?',
			sure:function(){
				/*<--do:ajax-->*/
				var tr = $(that).parent().parent();
				var index = tr.attr('index');
				tr.remove();
				
				/*<--do:panel-->*/
				var nav = getPanelFrame().find("#" + index);
				nav.remove();
			}
		});
	});
}