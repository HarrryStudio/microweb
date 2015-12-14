$(function() {
	/**
	 * 删除模态框的确认按钮点击后的操作
	 * 模态框隐藏
	 * 将data发送异步请求到url
	 * 返回删除结构
	 * 成功移除元素
	 * 失败提示
	 */
	$("#confirm_modal .btn-primary").click(function() {
		$("#confirm_modal").modal('hide');
		var data = $(this).attr('data');
		var url = $('#delete_site_url').val();
		$.post(url, {id:data}, function(data) {
			console.log(data);
			if (data.code == 0) {
				window.location.reload();
			}
			else {
				alert_info("请稍后再试",0);
			}
		});
	})
	/**
	 * 删除按钮点击时的操作
	 * 弹出模态框
	 * 找到当前网站的id
	 * 设置确认删除模态框的data属性为当前点击记录的id
	 */
	$(".delete_site").click(function() {
		$('#confirm_modal').modal({
		    backdrop:true,
		    keyboard:true,
		    show:true
		});
		var data = $(this).siblings('input').val();
		$("#confirm_modal .btn-primary").attr('data',data);
	})
	/**
	 * 单击修改网站时的操作
	 * 跳转到此修改网站的网址
	 */
	$(".list").click(function() {
		var data = $(this).attr('data');
		var url = $("#compile_site_url").val() + "?site_id=" + data;
		window.location.href = url;
	})
	//阻止时间冒泡
	$('.site-do').click(function(){
		return false;
	})

	$(".download_site").click(function(){
		var data = $(this).siblings('input').val();
		var url = $("#download_site_url").val() + "?site_id=" + data;
		window.location.href = url;
	})
	/**
	 * 单击网站资源管理时的操作
	 * 跳转到当前网站资源管理的详细资源页面
	 * #resource_management_site_url	指向后台管理网站资源的方法
	 */
	$(".resource_management_site").click(function() {
		var data = $(this).siblings('input').val();
		var url = $("#resource_management_site_url").val() + "/site_id/" + data;
		window.location.href = url;
	})
	/**
	 * 单击添加网站按钮时的操作
	 * 先ajax去请求网站是否已经到达上限
	 * 		1.如果到达上限：提示已经到达上限，不弹出模态框；
	 * 		2.未到达上限  ：弹出添加网站模态框，进行添加
	 */
	$(".add_site_button").click(function(eve) {
		var url = $(this).attr('target-url');
		$.post(url, function(data) {
			if (data.code == 1) {
				alert_info("网站数已达上限",0);
			}
			else {
				$('#myModal').modal({
				    backdrop:true,
				    keyboard:true,
				    show:true
				});
			}
		});
		// console.log("123");
	})
	/**
	 * 单机新建网站模态框中的创建按钮时的操作
	 * target_url 目标网址
	 * 收集去空格后的数据
	 * ajax提交过去
	 * 创建成功刷新页面
	 * 否则弹出提示信息 
	 */
	$("#create_new_site").click(function() {
		var url = $(this).attr("target_url");
		site_name = $.trim($("#site_name").val());
		site_url = $.trim($("#site_url").val());
		$.post(url, {site_name:site_name,url:site_url}, function(data) {
			if (data.code == 0) {
				window.location.reload();
			}
			else {
				alert_info(data.message,0);
			}
		})
	})
})