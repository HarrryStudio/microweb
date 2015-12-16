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
//跳回主页
    $(".close").click(function() {
        var home = $("#home").val();
        window.location.href = home;
    })

    $("#log_top_left").css({'background' : '#017BD1'});
    $("#log_top_right").css({"background":"#017BD1"});
    // $("#log_top_left:before").css({'border-top': '10px solid #017BD1'});

//注册和登陆的点击效果
    $("#log_top_left").click(function(){
        $("#log_top_left").css({"background":"#017BD1","color":"white"});
        $("#log_top_right").css({"background":"#F1F6F2","color":"black"});

    });
    $("#log_top_right").click(function(){
        $("#log_top_right").css({"background":"#017BD1","color":"white"});
        $("#log_top_right:before").css({"border-top":"10px solid #017BD1"});
        $("#log_top_left").css({"background":"#F1F6F2","color":"black"});

    });

//记住密码判断选中
    $account = $.trim($(".account").val());
    $password = $(".password").val();
    if($account != "" && $password != ""){
        $(".remember").attr("checked", true);
    }


 /*
 *搜集数据
 */
    function getData(){
        $account = $.trim($(".account").val());
        if($account == ""){
            $(".account").focus();
            return false;
        }
        $password = $(".password").val();
        if($password == ""){
            $(".password").focus();
            return false;
        }
        $authCode = $.trim($("#authCode").val());
        if($authCode ==""){
            $("#authCode").focus();
            return false;
        }

        if($(".remember").is(':checked')){
            $remember = 0;
        }else{
            $remember = 1;
        }
        return true;
    }


//登陆
    $(".login").click(function(){
        if (!getData()) {
            return;
        };
        var url = $(this).attr("value");
        $.post('login',
            {account: $account, password: $password, authCode: $authCode, remember: $remember },
            function(data){
//                console.log(data);
                if (data=="ok") {
                    window.location.href=url;
                }else if(data == "false"){
                    alert_info("账号或密码错误",0);
                    $("#authImg").click();
                }else{
                    alert_info(data,0);
                    $("#authImg").click();
                }
            }
        )
    });
//按键登陆
    $(document).keydown(function(event){
        if(event.keyCode == 13){
            $(".login").click();
        }
    });

})