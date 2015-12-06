function allow(event){
	event.preventDefault();
}
//触发父级的弹出iframe
function drop(event){
	event.preventDefault();
	var controller = event.dataTransfer.getData("Text");
	//console.log(controller_id);
	window.parent.add_controller(controller);
}
//显示占位符
function dragover(event){
	event.preventDefault();
	var that = event.target;
	// if(!$(that).is('.controller')){
	// 	return;
	// }
	while(!$(that).is('.controller')){
		that = that.parentNode;
		if($(that).is('body'))return;
	}
	// console.log(that);
	if(event.originalEvent.clientY + $('body')[0].scrollTop - that.offsetTop - $('.header').height() > (that.offsetHeight / 2)){
		$('.pro').insertAfter($(that));
	}else{
		$('.pro').insertBefore($(that));
	}
	
}
function dragenter(event){
	//console.log("onDrop enter");
	$('.pro').show();
}
function dragLeave(event){
	$('.pro').hide(); 
}
//初始化编辑框
function initController(elem,cname){
		
		var that = elem;
		//移除其他operation
		$('.operation-elem').remove();
		//组装operation
		var operation_all = document.createDocumentFragment();
		var left_border = document.createElement('div');
		left_border.className = 'operation-elem operation-border operation-left';
		var right_border = document.createElement('div');
		right_border.className = 'operation-elem operation-border operation-right';
		var top_border = document.createElement('div');
		top_border.className = 'operation-elem operation-border operation-top';
		var bottom_border = document.createElement('div');
		bottom_border.className = 'operation-elem operation-border operation-bottom';
		var operation = document.createElement('div');
		operation.className = 'operation-elem operation-nav-bar';
		operation.setAttribute('data-target','0');
		operation.setAttribute('data-controller','0');
		operation.setAttribute('data-name',cname);
		operation.innerHTML = "<div class='oparetion-item edit-controller'>编辑控件</div>"
							// +"<div class='oparetion-item style-controller'>编辑样式</div>"
							+"<div class='oparetion-item del-controller'>&#10006;</div>";
		operation_all.appendChild(left_border);
		operation_all.appendChild(right_border);
		operation_all.appendChild(top_border);
		operation_all.appendChild(bottom_border);
		operation_all.appendChild(operation);
		
		var top = that.offsetTop;
		var width = that.offsetWidth;
		var height = that.offsetHeight;
		var left = that.offsetLeft;

		left_border.style.top = top + 'px';
		left_border.style.left = left + 'px';
		left_border.style.height = height + 'px';

		right_border.style.top = top + 'px';
		right_border.style.height = height + 'px';
		right_border.style.left = width + left - 2 + 'px';

		bottom_border.style.top = top + height - 2 + 'px';
		bottom_border.style.width = width + 'px';
		bottom_border.style.left = left + 'px';

		top_border.style.top = top + 'px';
		top_border.style.width = width + 'px';
		top_border.style.left = left + 'px';

		$('.center').append(operation_all);
		//console.log("add");
		if( that.offsetTop < 30 ){
			operation.style.top = top;
		}else{
			operation.style.top = top - operation.offsetHeight + 'px';
		}
		operation.style.left = left + width - operation.offsetWidth - 2 + 'px';
		
		$('.center').data('elem',that);
}
$(function(){
	//*显示编辑框*//
	$(document).on('mouseover',".center>.controller",function(){
		//console.log("over");
		if($('.operation-elem').length > 0){
			var Y = event.clientY + $('body')[0].scrollTop - $('.header').height();
			var X = event.clientX + $('body')[0].scrollLeft;
			if( Y < $('.operation-top')[0].offsetTop || Y > $('.operation-bottom')[0].offsetTop 
				|| X < $('.operation-left')[0].offsetLeft || X > $('.operation-right')[0].offsetLeft){
			}else{return;}
		}
		initController(this,$(this).attr('data-name'));
	})

	//*显示暂占位符*//
	$(document).on('dragover',".controller",function(event){
		dragover(event);
	});
	//*编辑控件*//
	$(document).on('click',".oparetion-item.edit-controller",function(){
		window.parent.add_controller($(this).parent().attr('data-name'),1);
	})
	//*删除控件*//
	$(document).on('click',".oparetion-item.del-controller",function(){
		$($('.center').data('elem')).slideUp('fast',function(){
			$(this).remove();
			$('.operation-elem').remove();
		})
		$('.operation-elem').hide()
		window.parent.$('.save-all').attr('change-flag','true');
	})

	$('.nav-item a').on('click',function(){
		console.log("11");
		var id = $(this).parent().attr('data-column');
		var href = window.parent.document.getElementById('readHtml-url').value + id;
		window.parent.confirm_load(href,true);
		//event.stopPropagation();
		return false;
	})

	$(document).on('click',".article-link",function(){
		var href = $(this).attr('data-url');
		window.parent.confirm_load(href,true,function(){
			//console.log($('.save-all').attr('data-type'));
			window.parent.$('.save-all').attr('data-type','writeArticle');
		});
		return false;
	})

	$(document).on('click',".back",function(){
		var href = $(this).attr('data-url');
		window.parent.confirm_load(href,true,function(){
			$('.save-all').attr('data-type','writeHtml');
		});
		return false;
	})

	/*保持显示操作框*/
	$('body').on("mouseout",function(event){
		if($('.operation-elem').length <= 0){
			return;
		}
		//console.log("out");
		var Y = event.clientY + $('body')[0].scrollTop - $('.header').height();
		var X = event.clientX + $('body')[0].scrollLeft;
		if( Y < $('.operation-nav-bar')[0].offsetTop 
			|| (Y < $('.operation-top')[0].offsetTop && X < $('.operation-nav-bar')[0].offsetLeft)
			|| Y > $('.operation-bottom')[0].offsetTop 
			|| X < $('.operation-left')[0].offsetLeft 
			|| X > $('.operation-right')[0].offsetLeft){
			$('.operation-elem').remove();
			//console.log("remove");
		}
	})
	window.parent.$('.save-all').attr('change-flag','false');
	window.parent.$("#writeHtml-url").attr("now-column",$('.nav-item.active').attr("data-column"));
	//document.addEventListener('DOMContentLoaded',function(){console.log("onload");},false);
	document.addEventListener("DOMContentLoaded", function(event) {
	    console.log("DOM fully loaded and parsed");
	  })
})