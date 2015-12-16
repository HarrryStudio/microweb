$(function() {

	/*删除图片*/
	$('.photo-del').click(function(){
		var item = $(this).parent().parent();
		$.layer({html:'确定删除',Type:'notice',sure:function(){
			$.post($('#del-photo-url').val(),{photo_id:item.attr('data-id')},function(data){
				if(data.status == 1){
					item.remove();
				}else{
					alert_info(data.info,0);
				}
			})
		}})
	})

	/*显示上传窗口*/
	$('#update-photo-button').click(function(){
		
		$('.upload-photo-body').show();
		$(window).resize();
		$('.upload-photo-body').animate({opacity:1},300);
	});
	/*调节上传窗口的位置*/
	$(window).resize(function(){
		if (window.innerWidth){
			winWidth = window.innerWidth;
			winHeight = window.innerHeight;
		}
		else if ((document.body) && (document.body.clientWidth)){
			winWidth = document.body.clientWidth;
			winHeight = document.body.clientHeight;
		}
		var top = (winHeight - $('.upload-photo-dialog').height()) / 3;
		if (top < 0){
			top = 0;
		}
		var left = (winWidth - $('.upload-photo-dialog').width()) / 2;
		$('.upload-photo-dialog').css({
			top : top + 'px',
			left : left + 'px'
		});
		$('.upload-photo-dialog-content').css({
			"height" : $('.upload-photo-dialog').height() - $('.upload-photo-dialog-title').height() + 'px'
		});
	})

	/*添加隐藏file input 并触发*/
	$('.chose-photo-button,.add-update-photo').click(function(){
		$('#upload-file-form').append('<input type="file" multiple="multiple" name="upload_files[]">');
		//添加事件
		$('#upload-file-form input').on('change',function(event){
			var fileList = this.files;
			$(".update-photo").css({"left":0});
			addUploadFile(fileList);
		})
		$('#upload-file-form').find('input:last-child').click();
	});
	

	/*开始上传(异步)*/
	$('.start-update').click(function(){
		var form = $("#upload-file-form")[0];
		var formData = new FormData(form); // 获得form内容
		$('.upload-progress-bar').show();
		$.ajax({
			url : $("#upload-file-form").attr('action'),
			type: 'post',
			data: formData,
			cache: false,
			/** 
	         * 必须false才会避开jQuery对 formdata 的默认处理 
	         * XMLHttpRequest会对 formdata 进行正确的处理 
	         */  
			processData:false,
			/** 
	         *必须false才会自动加上正确的Content-Type 
	         */ 
			contentType:false,
			xhr: function() {  // custom xhr
            	myXhr = $.ajaxSettings.xhr();
            	console.log(myXhr);
	            if(myXhr.upload){ // check if upload property exists
	            	console.log(myXhr.upload);
	                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
	            }
	            return myXhr;
	        },
			success:function(data){
				if(data.status == 1){
					alert_info(data.info,1);
					setTimeout(function(){
					    //window.location.reload();
					},2000);
				}else{
					alert_info(data.info,0);
				}
			}
		})
	});

	/*关闭上传窗口*/
	$('.upload-photo-dialog-close').click(function(){
		$('.upload-photo-body').hide();
		$(".update-photo-list").innerHTML = "";
	})

	$('.close').click(function(){
		$('#top-alert').animate({"opacity":0},1000,function(){$(this).hide()});
	});

});
/*进度事件*/
function progressHandlingFunction(e){
	console.log(e);
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
        $('.upload-progress-bar span').text((e.loaded / e.total)*100);
    }
}
/*向上传列表中添加文件*/
function addUploadFile(fileList){
	if(fileList){
		for(var i = 0; i < fileList.length; i ++){
			if(!/image\/\w+/.test(fileList[i].type)){  
			    continue;  
				}
				//读取文件
			var reader = new FileReader();
			reader.onloadend = function (e) {
                var urlData = e.target.result;
                $(".update-photo-list").prepend("<div class='update-photo-item'><img src='" + urlData + "' /></div>");
            }; 
			reader.readAsDataURL(fileList[i]);
		}
	}
}