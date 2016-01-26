 $(function(){
	/*新建类型*/
	$('#create-new-type').click(function(){
		$.post($(this).attr('target-url'),
			{
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
		$.post(url, {id:tr.attr('data-id')}, function(data){
			if(data.status == 1){
				console.log(tr);
				tr.remove();
			}else{
				alert_info(data.info,0);
			}
		});
	})
	/*编辑类型  弹出输入框  并为输入框添加事件*/
	$(".type-edit").click(function(){
		var item = $(this).parent().prev();
		item.html('<input type="text" id="edit-type-name" class="form-control" value="'+ item.text() +'">');
		$("#edit-type-name").focus();
		$('#edit-type-name').blur(function(){  // 值改变时提交
			var val = $(this).val();
			var id = $(this).parent().parent().attr('data-id');
			$.post($('#add-type-url').val(),{name:val,id:id},function(data){

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
/*function resort(){
	$('.type-sort div').css({"display":'inline-block'});
	$('.type-sort-up:first').css({"display":'none'});
	$('.type-sort-down:last').css({"display":'none'});
}*/
