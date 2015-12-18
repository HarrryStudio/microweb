// 第一个最后一个column的调序箭头失效
function reFirstLast(){
	$('.unmove').removeClass('unmove');
	$('.column-table').find('tbody').find('tr:first-child').find('.column-up').addClass('unmove');
	$('.column-table').find('tbody').find('tr:last-child').find('.column-down').addClass('unmove');
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
					url : $("#add-column-url").val(),
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
					url : $("#edit-column-url").val(),
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
