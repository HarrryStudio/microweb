$(function(){
    $("#Password,#confirmPassword").focus(function(){
        $(this).parent(".input").next().show();
    })
    $(document).keyup(function(e){
        if(!e) var e = window.event;
        var $focused = $(':focus').attr("id");
        switch($focused){
            case "Password":
                $password = $("#Password").val();
                var that = $("#Password").parents(".col-sm-8").find(".hint");
                if(/^\d+$/.test($password) && $password.length<9){
                    that.find("span").eq(1).css("color",'red');
                }else{
                    that.find("span").eq(1).css("color",'green');
                }
                if($password.length<6){
                    that.find("span").eq(0).css("color",'red');
                }else{
                    that.find("span").eq(0).css("color",'green');
                }
                $confirmPassword = $("#confirmPassword").val();
                if($confirmPassword != ""){
                    if($password != $confirmPassword){
                        var that = $("#confirmPassword").parents(".col-sm-8").find(".hint");
                        that.find("span").html("两次密码不一致").show();
                        that.find("span").css("color","red");
                    }
                }
                //$Password_old = $("#Password_old").val();
                //if($Password_old != "" && $Password_old == $password){
                //    $("#Password_old").parents(".col-sm-8").find("span").show().html("新旧密码不能相同").css("color","red");
                //}else{
                //    $("#Password_old").parents(".col-sm-8").find("span").hide();
                //}
                break;
            case  "confirmPassword":
                $confirmPassword = $("#confirmPassword").val();
                $password = $("#Password").val();
                var that = $("#confirmPassword").parents(".col-sm-8").find(".hint");
                if($password ==""){
                    that.find("span").html("密码不能为空").show();
                    that.find("span").css("color","red");
                }else if($confirmPassword != $password){
                    that.find("span").html("两次密码不一致").show();
                    that.find("span").css("color","red");
                }else{
                    that.find("span").html("密码正确").css("color","green").hide();
                }
                break;
        }
        // 监听空格键密码不能有空格
        if(e.keyCode==32){
            $("#Password").parents(".col-sm-8").find(".hint").find("span").eq(1).css("color",'red');
        }
        //监听删除键判断密码是否有空格
        if(e.keyCode==8){
            $password = $("#Password").val();
            if($password.indexOf(" ") == -1){
                $("#Password").siblings("span").eq(1).css("color","green");
            }
            $confirmPassword = $("#confirmPassword").val();
            if($confirmPassword != ""){
                if($password == $confirmPassword){
                    var that = $("#confirmPassword").parents(".col-sm-8").find(".hint");
                    that.find("span").html("密码正确");
                    that.find("span").css("color","green");
                }
            }
        }
    });
    $("#answer,#Password_old").blur(function(){
        if($(this).val() != ""){
        $(this).parents(".col-sm-8").find("span").hide();
        }
    })
    $("#Password").blur(function(){
        $password = $("#Password").val();
        var that = $("#Password").parents(".col-sm-8").find(".hint");
        if($password != ''){
            if((/^\d+$/.test($password) && $password.length>=9)||(!(/^\d+$/.test($password)) && $password.length>=6)){
                that.hide();
            }
        }
    })
    $("#problem").change(function(){
        if($(this).val != -1){
            $("#answer").parents(".col-sm-8").find("span").hide();
        }
    })
    $("#changePassword").click(function(){
        $problem = $("#problem").val();
        if($problem == -1){
            $("#answer").parents(".col-sm-8").find("span").show().html("请选择密保").css("color","red");
            return;
        }else{
            $answer = $("#answer").val();
            if($answer == ''){
                $("#answer").focus();
                $("#answer").parents(".col-sm-8").find("span").show().html("答案不能为空").css("color","red");
                return;
            }
        }
        $password_old = $("#Password_old").val();
        if($password_old == ""){
            $("#Password_old").focus();
            $("#Password_old").parents(".col-sm-8").find("span").html("原密码不能为空").css("color","red");
            return;
        }
        $password = $("#Password").val();
        if(/^\d+$/.test($password) && $password.length<9 || $password.length<6){
            $("#Password").focus();
            return;
        }
        if($password_old == $password){
            $("#Password").focus();
            alert_info("新旧密码不能相同",0);
            //$("#Password_old").parents(".col-sm-8").find("span").html("新旧密码不能相同").css("color","red");
            return;
        }
        $confirmPassword = $("#confirmPassword").val();
        if($password != $confirmPassword){
            $("#confirmPassword").focus();
            return;
        }
        $authCode = $("#authCode").val();
        if($authCode == ""){
            $("#authCode").siblings("span").html("验证码不能为空").css("color","red");
            $(this).focus();
            return;
        }
        $.post('changePassword', {
                problem         : $problem,
                answer          : $answer,
                password_old    : $password_old,
                password        : $password,
                authCode        : $authCode
            },
            function(data){
                if(data == 'ok'){
                    alert_info("修改成功 即将返回登录",1);
                    login_url = $("#changePassword").attr("login_url");
                    setTimeout(function(){
                        window.location.href = login_url;
                    },3000)
                }else if(data == 'false'){
                    alert_info("原密码错误",0);
                }else if(data == 'error'){
                    alert_info("换个问题试试",-1);
                }else{
                    alert_info(data,0);
                }
                var verifyimg = $("#authImg").attr("src");
                $("#authImg").attr("src", verifyimg+'?random='+Math.random());
            }
        )
    })
})