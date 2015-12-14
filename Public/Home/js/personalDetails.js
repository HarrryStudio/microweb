$(function(){
	$("#redact").click(function(){
		$(".info").hide();
		$(".redact").show();
	})
	$(".redact_no").click(function(){
		$(".redact").hide();
		$(".info").show();
	})
	$("#submit_btn").on("click",function(){
		var account = $("#account").val();
		var nickname = $.trim($("#nickname").val());
		var phone = $.trim($("#phone").val());
		var inputEmail3 = $.trim($("#inputEmail3").val());
        if (phone != "") {
            var re = /^1\d{10}$/
            if (!re.test(phone)) {
                $("#phone").focus();
                alert_info("手机号不合法",-1);
                return false;
            }
        };
        if (inputEmail3 != "") {
        	var re = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/
        	if (!re.test(inputEmail3)) {
        		alert_info("邮箱不合法", -1);
        		return false;
        	};
        };
/*		if (nickname=="") {
			$("#nickname").focus();
			return false;
		};
		if (phone=="") {
			$("#phone").focus();
			return false;
		};
		if (inputEmail3=="") {
			$("#inputEmail3").focus();
			return false;
		};*/
	})

	$("#head_img").mouseenter(function(){
		$("#file_upload").fadeIn();
	}).mouseleave (function(){
		$("#file_upload").fadeOut();
		return false;
	})

	$("#file_upload").on("change",function(){
		var fileTag = document.getElementById("file_upload").files[0];
		if (fileTag) {
			var reader = new FileReader();
            reader.readAsDataURL(fileTag);
            $("#show_img").find("img").remove();
            reader.onload = function (e) {
                var urlData = this.result;
                document.getElementById("show_img").innerHTML += "<img src='" + urlData + "' alt='" + fileTag.name + "'/>";
            }; 
        }else{
            return;
        }
		return false;
	})


})