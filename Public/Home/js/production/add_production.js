$(function(){
	/*ue编辑器*/
	var ue = UE.getEditor('editor',{
        initialFrameHeight: 300,
        initialFrameWidth: "100%"
    });
	/*编辑模式下   初始化类型选择*/
	if($('.dropdown-menu li.checked').length > 0){
		$('#type-name-span').text($('.dropdown-menu li.checked').text());
	}

	/*点击保存按钮  提交表单  */
	$('button.save').click(function(){
		var form = $('#production-form')[0];
		var formData = new FormData(form); // 获得form内容
		$.ajax({
			url : $(form).attr('action'),
			type: 'post',
			data: formData,
			cache: false,
			processData:false,
			contentType:false,
			success:function(data){
				if(data.status == 1){
					window.location.href = $('#production-url').val();
				}else{
					alert_info(data.info,0);
					// alert(obj2string(data));
				}
			}
		})
		return false;
	});

	/*点击取消按钮  回到列表页  */
	$('button.cencel').click(function(){
		window.location.href = $(this).attr('url');
	})

	/*类型选择列表的模拟选择事件  */
	$('.dropdown-menu li').click(function(){
		$('.dropdown-menu li.checked').removeClass('checked');
		$(this).addClass('checked');
		$('#type-name-span').text($(this).text());
		$('#production-type').val($(this).attr('data'));
	})

	$('.add-picture-button').on('click',function(){
		$('#production-picture').click();
	})

	$('#production-picture').on('change',function(event){
			var file = this.files[0];
			if(!/image\/\w+/.test(file.type)){
			    return ;
			}
			var reader = new FileReader();
			reader.onloadend = function (e) {
                var urlData = e.target.result;
                $(".show-picture").html("<img src='" + urlData + "' />");
            };
			reader.readAsDataURL(file);
		})
	function obj2string(o){
		var r=[];
		if(typeof o=="string"){
			return "\""+o.replace(/([\'\"\\])/g,"\\$1").replace(/(\n)/g,"\\n").replace(/(\r)/g,"\\r").replace(/(\t)/g,"\\t")+"\"";
		}
		if(typeof o=="object"){
			if(!o.sort){
				for(var i in o){
					r.push(i+":"+obj2string(o[i]));
				}
				if(!!document.all&&!/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/.test(o.toString)){
					r.push("toString:"+o.toString.toString());
				}
				r="{"+r.join()+"}";
			}else{
				for(var i=0;i<o.length;i++){
					r.push(obj2string(o[i]))
				}
				r="["+r.join()+"]";
			}
			return r;
		}
		return o.toString();
	}

})