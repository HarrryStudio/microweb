window.onload = function(){
	/*修改相册名操作提示*/
	if($('.album-item').length ==1){
		var item = $('.album-item')[0];
		var label = $(item).find('.album-name-label')[0];
		var tooltip = $('.tooltip')[0];
		var content = $('.content')[0];
		console.log(item.offsetTop + label.offsetTop - tooltip.offsetHeight + 'px');
		$(tooltip).css({
			"top" : item.offsetTop + content.offsetTop + label.offsetTop - tooltip.offsetHeight + 'px',
			"left" : item.offsetLeft + content.offsetLeft + label.offsetLeft + (label.offsetWidth - tooltip.offsetWidth) / 2 + 'px',
		}).show().animate({"opacity":1},300);
		setTimeout(function(){
		    $(tooltip).animate({"opacity":0},300,function(){$(this).hide()});
		},2000);
	}
}
$(function(){
	/**
	 * 单机创建新相册时的操作
	 * 创建成功刷新页面
	 * 否则弹出提示信息
	 */
	$("#create_new_album").click(function() {
		var site_id = $("#site_id").val();
		var name = $.trim($("#site_name").val());
		var url = $("#create_album_url").val();
		$.post(url, {site_id: site_id,name: name}, function(data) {
			if (data.code == 0) {
				alert_info("创建成功",1);
				window.location.reload();
			}
			else {
				alert_info(data.message,0);
				$("#site_name").focus();
			}
		});
	});

	/*"打开"跳转*/
	$('.album-item-button').click(function(){
		window.location.href = $(this).attr("url");
	})

	/*双击弹出改名输入框*/
	$('.album-name-label').dblclick(function(event){
		event.preventDefault();
		$(this).animate({"opacity":0},300,function(){$(this).hide()});
		$(this).next('.album-name-input').focus();
	})

	/*光标在最后*/
	$('.album-name-input').focus(function(){
		this.selectionEnd = this.selectionStart = this.value.length;
	});

	/*修改 相册名*/
	$('.album-name-input').blur(function(){
		var label = $('.album-name-label:hidden');
		var that = this;
		if(label.text() != $(this).val()){
			console.log("11");
			$.ajax({
				url:$('#edit_album_url').val(),
				type:'post',
				data:{
					album_id:$(that).parent().parent().parent().attr('data-id'),
					name    :$(that).val()
				},
				success:function(data){
					if(data.status == 1){
						label.text(label.next('input').val());
						label.show().animate({"opacity":1},300);
					}else{
						alert_info(data.info,0);
					}
				}
			});
		}else{
			label.show().animate({"opacity":1},300);
		}
		
	})
	/*键盘回车 提交相册名*/
	$(window).on('keypress',function(event){
		// console.log(event.keyCode);
		if(event.keyCode == 13){
			$('.album-name-input').blur();
		}
	})
	/*删除相册*/
	$('.del_album-bar').click(function(){
		var that = this;
		$.ajax({
			url:$('#del_album_url').val(),
			type:'post',
			data:{
				album_id:$(that).parent().attr('data-id'),
			},
			success:function(data){
				if(data.status == 1){
					$(that).parent().animate({"opacity":0,"width":0},300,function(){
						$(this).remove();
					});
				}else{
					alert_info(data.info,0);
				}
			}
		});
	})

})