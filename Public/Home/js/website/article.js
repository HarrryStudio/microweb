$(function(){
	/*类型管理按钮跳转  */
	$('.set-item.classify').click(function(){
		window.location.href = $(this).attr('url');
	})
	/*批量操作栏弹出  */
	$('.more-do').click(function(){
		$(this).animate({"opacity":0},300);
		$('.more-do-bar').slideDown('fast');
		$('.table-checkbox').css({"width":'30px'});
		$('.article-item').attr('checked',false);
	});
	/*取消批量操作  */
	$('.cencel-moro-do').click(function(){
		$('.more-do-bar').slideUp('fast');
		$('.more-do').animate({"opacity":1},200);
		$('.table-checkbox').css({"width":'0px'});
		$('.article-item').attr('checked',false);
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
		$('#search-type-id').val($(this).attr('data'));
		$(this).parent().slideUp('fast');
	})
	/*搜索按钮点击  进行搜索  */
	$('.search-icon').click(function(){
		var url = $(this).attr('url');
		var query  = $('.search-form').find('input').serialize();
		console.log(query);
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
	$('#chose-article').change(function(){
		if($(this).is(':checked')){
			$('.article-item').each(function(){
				this.checked = true;
			})
		}else{
			$('.article-item').each(function(){
				this.checked = false;
			})
		}
	})
	/*文章状态改变的异步提交  */
	$('.status-article').click(function(){
		$.post($(this).attr('url'),$('.article-item').serialize(),function(data){
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
	/*文章类型改变的异步提交  */
	$('.change-classify li').click(function(){
		$.post($('.change-classify').attr('url') + $(this).attr('value'),$('.article-item').serialize(),function(data){
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
	/*模态框中的类型选择 */
	$('.type-dropdown li').click(function(){ 
		console.log($(this).text());
		$('#type-name-span').text($(this).text());
		$('#type-id').val($(this).attr('data'));
	})
	/*修改类型模态框弹出  */
	$('.article-option-change').click(function(){
		var ul = $(this).parent();
		$('#myModal').find('#way').val(0);
		$('#myModal').find('#article-id').val(ul.attr('data-id'));
		$('#myModal').find('li[data='+ul.attr('data-type')+']').hide();
		$('#myModal').modal({
		    backdrop:true,
		    keyboard:true,
		    show:true
		});
	})
	/*修改类型模态框 确认按钮事件  提交 */
	$('#change-article-type').click(function(){
		var data;
		var that = this;
		var type_id = $('#myModal').find('#type-id').val();
		if(type_id == ""){
			alert_info("请选择类型",0);
			return;
		}
		$.post($(that).attr('target-url') + type_id,{
				ids:$('#myModal').find('#article-id').val()
			},function(data){
				if(data.status == 1){
					window.location.reload();
				}else{
					alert_info(data.info,0);
				}
			}
		)
	})
	/*单项置顶*/
	$('.top-status-item').click(function(){
		var that = this;
		$.post($('#top-article-url').val(),{
				status:$(that).attr('data-status'),
				id:$(that).parent().attr('data-id')
			},function(data){
				if(data.status == 1){
					window.location.reload();
				}else{
					alert_info(data.info,0);
				}
			}
		)
	})
	/*单项 改变文章状态*/
	$('.aritcle-status-item').click(function(){
		var that = this;
		var status = $(that).attr('data-status');
		if(status == -1){
			
		}
		$.post($('#status-article-url').val(),{
				status:status,
				ids:$(that).parent().attr('data-id')
			},function(data){
				if(data.status == 1){
					window.location.reload();
				}else{
					alert_info(data.info,0);
				}
			}
		)
	})
})