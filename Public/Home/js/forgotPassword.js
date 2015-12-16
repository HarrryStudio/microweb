$(function(){
    //弹出信息提示
    function alert_info(text,type){
        var top_alert = $('#top-alert');
        top_alert.find(".alert-content").text(text);
        if(type == 1){
            top_alert.removeClass('alert-danger alert-warning').addClass('alert-success');
        }else if(type == 0){
            top_alert.removeClass('alert-success alert-warning').addClass('alert-danger');
        }else{
            top_alert.removeClass('alert-success alert-danger').addClass('alert-warning');
        }
        $('#top-alert-back').show();
        top_alert.animate({"opacity":1},250);

        setTimeout(function(){
            $('#top-alert').find('button').click();
        },2000);
    }
    /**弹出信息框的关闭**/
    $('.close_hint').click(function(){
        $('#top-alert').animate({"opacity":0},250,function(){$('#top-alert-back').hide()});
    });

    $("#Password,#confirmPassword").focus(function(){
        $(this).parent(".input").next().show();
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
    $("#confirmPassword").blur(function(){
        $confirmPassword = $("#confirmPassword").val();
        if($confirmPassword == $password){
            $("#confirmPassword").parents(".col-sm-8").find(".hint").hide();
        }
    })
    function verifyPwd(){
        $password = $("#Password").val();
        var that = $("#Password").parents(".col-sm-8").find(".hint");
        //验证是否为九位以下纯数字
        if(/^\d+$/.test($password) && $password.length<9){
            that.find("span").eq(2).css("color",'red');
        }else{
            that.find("span").eq(2).css("color",'green');
        }
        //验证密码至少六位(非纯数字)
        if($password.length<6){
            that.find("span").eq(0).css("color",'red');
        }else{
            that.find("span").eq(0).css("color",'green');
        }
        //验证两次密码是否一样
        $confirmPassword = $("#confirmPassword").val();
        if($confirmPassword != ""){
            if($confirmPassword != $password){
                var that = $("#confirmPassword").parents(".col-sm-8").find(".hint");
                that.show();
                that.find("span").html("密码不一致");
                that.find("span").css("color","red");
            }
        }
    }
    //验证两次密码是否一致
    function verifyPwdEqual(){
        $confirmPassword = $("#confirmPassword").val();
        $password = $("#Password").val();
        var that = $("#confirmPassword").parents(".col-sm-8").find(".hint");
        if($password ==""){
            that.find("span").html("密码不能为空");
            that.find("span").css("color","red");
        }else if($confirmPassword != $password){
            that.find("span").html("密码不一致");
            that.find("span").css("color","red");
        }else{
            that.find("span").html("密码正确").css("color","green");
        }
    }
    $(document).keyup(function(e){
        if(!e) var e = window.event;
        var $focused = $(':focus').attr("id");
        switch($focused){
            case "Password":
                verifyPwd();
                break;
            case  "confirmPassword":
                verifyPwdEqual();
                break;
        }
        //监听空格键密码不能有空格
        if(e.keyCode==32){
            $("#Password").parents(".col-sm-8").find(".hint").find("span").eq(1).css("color",'red');
        }
        //监听删除键判断账户密码是否有空格
        if(e.keyCode==8){
            switch($focused){
            case "Password":
                $password = $("#Password").val();
                if($password.indexOf(" ") == -1){
                    $("#Password").parents(".col-sm-8").find(".hint").find("span").eq(1).css("color",'green');
                }
                //验证两次密码是否一样
                $confirmPassword = $("#confirmPassword").val();
                if($confirmPassword != ""){
                    if($confirmPassword == $password){
                        var that = $("#confirmPassword").parents(".col-sm-8").find(".hint");
                        that.show();
                        that.find("span").html("密码正确").css("color","green");
                    }
                }
                break;
            }
        }
    })
    //问题重复处理
    //$("select").change(function(){
    //    $("select option").show();
    //    for(i = 0; i < $("select").length; i++){
    //        that = $("select").eq(i);
    //        $val = that.val();
    //        if($val != -1){
    //            $("select").not(that).find("option[value="+$val+"]").hide();
    //        }
    //    }
    //})
    $("select").change(function(){
        $("select option").attr("disabled",false);
        $("select option").show();
        for(i = 0; i < $("select").length; i++){
            that = $("select").eq(i);
            $val = that.val();
            if($val != -1){
                $("select").not(that).find("option[value="+$val+"]").hide();
                $("select").not(that).find("option[value="+$val+"]").attr("disabled",true);
            }
        }
    })
    /*
     * 收集数据
     * 验证数据
     */
    function getVerifyData(){
        $account = $.trim($("#account").val());
        if($account == ""){
            $("#account").parents(".col-sm-8").find('.hint').show().find("span").html("账号不能为空").css("color","red");
            setTimeout(function(){
                $("#account").parents(".col-sm-8").find('.hint').hide();
            },2000)
            return false;
        }
        $problem1 = $("#problem1").val();
        if($problem1 == -1){
            $("#answer1").parents(".col-sm-8").find('.hint').show().find("span").html("请选择密保").css("color","red");
            setTimeout(function(){
                $("#answer1").parents(".col-sm-8").find('.hint').hide();
            },2000)
            return false;
        }else{
            $answer1 = $.trim($("#answer1").val());
            if($answer1 == ''){
                $("#answer1").focus();
                $("#answer1").parents(".col-sm-8").find(".hint").show().find("span").html("答案不能为空").css("color","red");
                setTimeout(function(){
                    $("#answer1").parents(".col-sm-8").find('.hint').hide();
                },2000)
                return false;
            }else{
                $("#answer1").parents(".col-sm-8").find('.hint').hide();
            }
        }
        $problem2 = $("#problem2").val();
        if($problem2 == -1){
            $("#answer2").parents(".col-sm-8").find('.hint').show().find("span").html("请选择密保").css("color","red");
            setTimeout(function(){
                $("#answer2").parents(".col-sm-8").find('.hint').hide();
            },2000)
            return false;
        }else{
            $answer2 = $.trim($("#answer2").val());
            if($answer2 == ''){
                $("#answer2").focus();
                $("#answer2").parents(".col-sm-8").find(".hint").show().find("span").html("答案不能为空").css("color","red");
                setTimeout(function(){
                    $("#answer2").parents(".col-sm-8").find('.hint').hide();
                },2000)
                return false;
            }else{
                $("#answer2").parents(".col-sm-8").find('.hint').hide();
            }
        }
        $problem3 = $("#problem3").val();
        if($problem3 == -1){
            $("#answer3").parents(".col-sm-8").find(".hint").show().find("span").html("请选择密保").css("color","red");
            setTimeout(function(){
                $("#answer3").parents(".col-sm-8").find('.hint').hide();
            },2000)
            return false;
        }else{
            $answer3 = $.trim($("#answer3").val());
            if($answer3 == ''){
                $("#answer3").focus();
                $("#answer3").parents(".col-sm-8").find(".hint").show().find("span").html("答案不能为空").css("color","red");
                setTimeout(function(){
                    $("#answer3").parents(".col-sm-8").find('.hint').hide();
                },2000)
                return false;
            }else{
                $("#answer3").parents(".col-sm-8").find('.hint').hide();
            }
        }
    }
    //验证密保问题
    $("#verifyNow").click(function(){
        var val = getVerifyData();
        if(val == false){
            return;
        }
        $.post(
            'forgotPassword',
            {
                account  : $account,
                problem1 : $problem1,
                problem2 : $problem2,
                problem3 : $problem3,
                answer1  : $answer1,
                answer2  : $answer2,
                answer3  : $answer3
            },
            function(data){
                if(data != false){
                    $(".verifyProblem").hide();
                    $(".forgetPassword").show();
                    $user_id = data;
                }else{
                    alert_info("账号或问题或答案错误",0);
                }
            }
        )
    })
    //重置密码
    $("#getPassword").click(function(){
        $password = $("#Password").val();
        if(/^\d+$/.test($password) && $password.length<9 || $password.length<6){
            $("#account").focus();
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

        $.post('changePassword',
            {   id       : $user_id,
                password : $password,
                authCode : $authCode
            },
            function(data){
                if(data == 'ok'){
                    location.href = "login";
                }else if(data == "false"){
                    alert_info("修改失败",0);
                }else{
                    alert_info(data,-1);
                }
            }
        )
    })
})