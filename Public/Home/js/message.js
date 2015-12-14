$(function(){
	document.getElementById("message_end").click();
	// $("#message_end").click();
	$("#talk").keydown(function(event,mes){
		if (event.ctrlKey && event.keyCode==13 || mes==1) {		
			var text = $.trim($("#talk").val());
			if (!judge()) {return};
			// judge();	
			$.post("talk",{text:text},function(data){
				if (data) {
					window.location.reload();
				}else{
					return;
				}
			})
		};
	});
	function judge() {
			var text = $.trim($("#talk").val());
			if(text.length == 0) {
				alert_info("不能为空", 0);
				return false;
			} else {
				return true;
			}
	}
	$("#submit").click(function(){
		judge();	
		$("#talk").trigger("keydown",1);
	})
})