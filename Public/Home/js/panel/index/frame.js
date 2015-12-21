/**
 * 得到手机的iframe
 * @return jquery对象
 */
function getPanelFrame(){
	return $('#panel-frame').contents();
}
/*得到phone中的占位符*/
function getPro(){
	var iframe = getPanelFrame();
	return iframe.find(".pro")[0];
}
/*得到phone中正在备操作的 控件*/
function getOperationElem(){
	var iframe = getPanelFrame();
	console.log(panelFrame.$('.center'));
	return panelFrame.$('.center').data('elem');
}
/**
 * 在iframe中创建新的controller 或者编辑
 * @param name controller的cname
 */
function add_controller(cname,data){
	console.log(data);
	//隐藏占位符
	//var iframe = getPanelFrame();
	var is_edit = data == null ? 0 : 1;
	$(getPro()).hide();
	var url = "";
	if(is_edit == 0){
		url = $('#control-widget-url').val()+cname;
	}
	$.layer({
		html:"<iframe width='800px' height='400px' name='controEdit' src='"+url+"'></iframe>",
		buttonCancel:true,
		buttonSureText:"保存",
		buttonCancelText:"取消",
		alwaysClose:false,
		sure:function(){
            if( controEdit.window.save ){
            	controEdit.window.save();
            	$('.save-all').attr('change-flag','true');
            }else{
            	$.layer.close();
            }
		}
	});
	if(is_edit == 1){
		var form = $('#iframe-form');
		form.attr('action',$('#control-widget-url').val()+cname);
		form.find('input[name="data"]').val(JSON.stringify(data));
		form.submit();
	}
}
var dynamicLoading = {
    css: function(path){
		if(!path || path.length === 0){
			throw new Error('argument "path" is required !');
		}
		var p_document = panelFrame.document;
		var head = p_document.getElementsByTagName('head')[0];
		var heads = head.children;
		for(var i = 0; i < heads.length; i ++ ){
			if(heads[i].href == path){
				return ;
			}
		}
        var link = p_document.createElement('link');
        link.href = path;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        head.appendChild(link);
    },
    js: function(path){
		if(!path || path.length === 0){
			throw new Error('argument "path" is required !');
		}
		var p_document =panelFrame.document;
		var head = p_document.getElementsByTagName('head')[0];
		var heads = head.children;
		for(var i = 0; i < heads.length; i ++ ){
			if(heads[i].src == path){
				return ;
			}
		}
        var script = p_document.createElement('script');
        script.src = path;
        script.type = 'text/javascript';
        head.appendChild(script);
    }
}
/**
 * url 地址
 */
function save(data,status){
	var url = $('#save-widget-url').val();
	$.post(url,data,function(data){
		if(data.status == 1){
			var html = panelFrame.$(data['data']['html']);
			var json = data['data']['json'];
			var widget = panelFrame.$(html[1]);
			if(status == 1){
				var elem = getOperationElem();
				$(elem).hide().before(html).remove();
			}else{
				var pro = getPro();
				$(pro).before(html);
			}
			widget.data('json',json);
		}else{
			alert("失败");
		}
		$.layer.close();
	});
}
