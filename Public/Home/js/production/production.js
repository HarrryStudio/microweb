$(function(){
	/*初始搜索类型*/
	var serch_type = $('.search-type').find('ul').find('li[data='+(parseInt($('#search-type').val()) || -1)+']').text();
	$('.search-type-name').text(serch_type);

	/*类型管理按钮跳转  */
	$('.set-item.classify').click(function(){
		window.location.href = $(this).attr('url');
	})
	/*批量操作栏弹出  */
	$('.more-do').click(function(){
		$(this).animate({"opacity":0},300);
		$('.more-do-bar').slideDown('fast');
		$('.table-checkbox').css({"width":'30px'});
		$('.production-item').attr('checked',false);
	});
	/*取消批量操作  */
	$('.cencel-moro-do').click(function(){
		$('.more-do-bar').slideUp('fast');
		$('.more-do').animate({"opacity":1},200);
		$('.table-checkbox').css({"width":'0px'});
		$('.production-item').attr('checked',false);
	});
	/*搜索类型选择下拉显示  */
	$('.search-type').hover(function(){
		$(this).find('ul').slideDown('fast');
	},function(){
		$(this).find('ul').slideUp('fast');
	})
	/*类型选择下拉 选择后隐藏  */
	$('.search-type ul li').click(function(){
		$('.search-type-name').text($(this).text());
		$('#search-type').val($(this).attr('data'));
		$(this).parent().slideUp('fast');
	})
	/*搜索按钮点击  进行搜索  */
	$('.search-icon').click(function(){
		var url = $(this).attr('url');
		var query  = $('.search-form').find('input').serialize();
        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
        query = query.replace(/^&/g,'');
        if( url.indexOf('?')>0 ){
            url += '&' + query;
        }else{
            url += '?' + query;
        }
		window.location.href = url;
	})
	/*全选效果  */
	$('#chose-production').change(function(){
		if($(this).is(':checked')){
			$('.production-item').each(function(){
				this.checked = true;
			})
		}else{
			$('.production-item').each(function(){
				this.checked = false;
			})
		}
	})
	/*  批量操作中产品状态改变的异步提交  */
	$('.status-production').click(function(){
		if ($(this).attr('id') == "delete") {
			// 弹出产品删除确认模态框
			$('#delete_tip').modal({
		    	backdrop:true,
		   		keyboard:true,
		    	show:true
			});
			$('#delete_tip .btn-primary').click(function() {
				$("#delete_tip").modal('hide');
				$.post($('#delete').attr('url'),$('.production-item').serialize(),function(data){
					if(data.status == 1){
						alert_info(data.info,1);
						setTimeout(function() {
							window.location.reload();
						}, 2000);
					}else{
						alert_info(data.info,0);
					}
				})
			})
		}else{
			$.post($(this).attr('url'),$('.production-item').serialize(),function(data){
				if(data.status == 1){
					alert_info(data.info,1);
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				}else{
					alert_info(data.info,0);
				}
			})
		}

	})

	/*  批量操作中产品类型改变的异步提交  */
	$('.change-classify li').click(function(){
		$.post($('.change-classify').attr('url') + $(this).attr('value'),$('.production-item').serialize(),function(data){
			if(data.status == 1){
				alert_info(data.info,1);
				setTimeout(function() {
					window.location.reload();
				}, 1000);
			}else{
				alert_info(data.info,0);
			}
		})
	})
	/*单项 模态框中的类型选择 */
	$('.type-dropdown li').click(function(){
		console.log($(this).text());
		$('#type-name-span').text($(this).text());
		$('#type').val($(this).attr('data'));
	})
	/*单项 修改类型模态框弹出  */
	$('.production-option-change').click(function(){
		var ul = $(this).parent();
		$('#myModal').find('#way').val(0);
		$('#myModal').find('#production-id').val(ul.attr('data-id'));
		$('#myModal').find('li[data='+ul.attr('data-type')+']').hide();
		$('#myModal').modal({
		    backdrop:true,
		    keyboard:true,
		    show:true
		});
	})
	/*单项 修改类型模态框 确认按钮事件 提交 */
	$('#change-production-type').click(function(){
		var data;
		var that = this;
		var type = $('#myModal').find('#type').val();
		if(type == ""){
			alert_info("请选择类型",0);
			return;
		}
		$.post($(that).attr('target-url') + type,{
				ids:$('#myModal').find('#production-id').val()
			},function(data){
				if(data.status == 1){
					alert_info(data.info,1);
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				}else{
					alert_info(data.info,0);
				}
			}
		)
	})

	/*单项置顶*/
	// $('.top-status-item').click(function(){
	// 	var that = this;
	// 	$.post($('#top-production-url').val(),{
	// 			status:$(that).attr('data-status'),
	// 			id:$(that).parent().attr('data-id')
	// 		},function(data){
	// 			if(data.status == 1){
	// 				window.location.reload();
	// 			}else{
	// 				alert_info(data.info,0);
	// 			}
	// 		}
	// 	)
	// })

	/*单项 改变产品状态*/
	$('.production-status-item').click(function(){
		var that = this;
		var status = $(that).attr('data-status');
		if(status == 1){
			// 弹出对话框，确认操作
			$('#delete_tip').modal({
		    	backdrop:true,
		   		keyboard:true,
		    	show:true
			});
			$('#delete_tip .btn-primary').click(function() {
				$("#delete_tip").modal('hide');
				$.post($('#status-production-url').val(),{
					status:status,
					ids:$(that).parent().attr('data-id')
				},function(data){
					if(data.status == 1){
						alert_info(data.info,1);
						setTimeout(function() {
							window.location.reload();
						}, 2000);
					}else{
						alert_info(data.info,0);
					}
				})
			})
		}else{
			$.post($('#status-production-url').val(),{
				status:status,
				ids:$(that).parent().attr('data-id')
			},function(data){
				if(data.status == 1){
					alert_info(data.info,1);
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				}else{
					alert_info(data.info,0);
				}
			})
		}

	})
})
