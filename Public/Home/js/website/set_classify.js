$(function(){
	resort(); //重整调序按钮

	/*新建类型*/
	$('#create-new-type').click(function(){
		$.post($(this).attr('target-url'),
			{
				site_id:$('#site_id').val(),
				name:$('#type_name').val()
			},
			function(data){
				if(data.status == 1){
					window.location.reload();
				}else{
					alert_info(data.info,0);
				}
			}
		)
	})
	/*向上调序类型*/
	$('.type-sort-up').click(function(){
		var tr = $(this).parent().parent();
		var prev = tr.prev();
		$.post($('#change-sort-url').val(),{
			now_type_id:tr.attr('data-id'),
			to_type_id:prev.attr('data-id')
		},function(data){
			if(data.status == 1){
				tr.insertBefore(prev);
				resort();
			}else{
				alert_info(data.info,1);
			}
		})
	})
	/*向下调序类型*/
	$('.type-sort-down').click(function(){
		var tr = $(this).parent().parent();
		var next = tr.next();
		$.post($('#change-sort-url').val(),{
			now_type_id:tr.attr('data-id'),
			to_type_id:next.attr('data-id')
		},function(data){
			if(data.status == 1){
				tr.insertAfter(next);
				resort();
			}else{
				alert_info(data.info,0);
			}
		})
	})
	/*删除类型 弹出模态框*/
	$(".type-del").click(function() {
		$('#confirm_modal').modal({
		    backdrop:true,
		    keyboard:true,
		    show:true
		});
		var data = $(this).parent().parent();
		$("#confirm_modal .btn-primary").data('tr',data);
	})
	/*模态框按钮事件 删除类型*/
	$("#confirm_modal .btn-primary").click(function() {
		$("#confirm_modal").modal('hide');
		var tr = $(this).data('tr');
		var url = $('#del-type-url').val();
		$.post(url, {id:tr.attr('data-id')}, function(data) {
			if(data.status == 1){
				console.log(tr);
				tr.remove();
				resort();
			}else{
				alert_info(data.info,0);
			}
		});
	})
	/*编辑类型  弹出输入框  并为输入框添加事件*/
	$('.type-edit').click(function(){
		var item = $(this).parent().prev().prev();
		item.html('<input type="text" id="edit-type-name" class="form-control" value="'+ item.text() +'">');
		$('#edit-type-name').focus();
		$('#edit-type-name').blur(function(){  // 值改变时提交
			var val = $(this).val();
			var id = $(this).parent().parent().attr('data-id');
			$.post($('#add-type-url').val(),{name:val,type_id:id},function(data){
				if(data.status == 1){
					item.html(val);
				}else{
					alert_info(data.info,0);
				}
			})
		})
	})
	/*键盘控制输入框确定 */
	$(window).on('keypress',function(e){
		if(e.keyCode == 13){
			$('#edit-type-name').blur();
		}
	})
})
//重整调序按钮
function resort(){
	$('.type-sort div').css({"display":'inline-block'});
	$('.type-sort-up:first').css({"display":'none'});
	$('.type-sort-down:last').css({"display":'none'});
}
