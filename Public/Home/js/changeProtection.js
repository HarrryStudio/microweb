$(function(){
    //搜集数据
    function getdata(){
        $problem1 = $("#problem1").val();
        if($problem1 == -1){
            $("#verifyNow").off("click");
            $("#answer1").parents(".col-sm-8").find("span").html("请选择密保").css("color","red");
            hint_hide("answer1");
            return false;
        }else{
            $answer1 = $("#answer1").val();
            if($answer1 == ''){
                $("#answer1").focus();
                $("#answer1").parents(".col-sm-8").find("span").html("答案不能为空").css("color","red");
                hint_hide("answer1");
                return false;
            }
        }
        $problem2 = $("#problem2").val();
        if($problem2 == -1){
            $("#answer2").parents(".col-sm-8").find("span").html("请选择密保").css("color","red");
            hint_hide("answer2");
            return false;
        }else{
            $answer2 = $("#answer2").val();
            if($answer2 == ''){
                $("#answer2").focus();
                $("#answer2").parents(".col-sm-8").find("span").html("答案不能为空").css("color","red");
                hint_hide("answer2");
                return false;
            }
        }
        $problem3 = $("#problem3").val();
        if($problem3 == -1){
            $("#answer3").parents(".col-sm-8").find("span").html("请选择密保").css("color","red");
            hint_hide("answer3");
            return false;
        }else{
            $answer3 = $("#answer3").val();
            if($answer3 == ''){
                $("#answer3").focus();
                $("#answer3").parents(".col-sm-8").find("span").html("答案不能为空").css("color","red");
                hint_hide("answer3");
                return false;
            }
        }
    }
    function hint_hide(obj){
        setTimeout(function(){
            $("#"+obj).parents(".col-sm-8").find(".hint").hide();
        },2000);
    }
    //问题重复
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
    //验证密保问题
    $("#verifyNow").click(function(){
        var ret = getdata();
        if (ret=="") return;
        $.post('changeProtection', {
                problem1 : $problem1,
                problem2 : $problem2,
                problem3 : $problem3,
                answer1  : $answer1,
                answer2  : $answer2,
                answer3  : $answer3
            },
            function(data){
                if(data[3] == "ok"){
                    $old_problem_id = data;
                    alert_info("验证通过",1);
                    $("#verifyNow").hide();
                    $("#changeProtection").show();
                }else{
                    alert_info("问题或答案错误",0);
                }
            }
        )
    })
    //修改密保
    $("#changeProtection").click(function(){
        var ret = getdata();
        if (ret=="") return;
        $problem = new Array();
        $problem[0] = $problem1;
        $problem[1] = $problem2;
        $problem[2] = $problem3;
        for($i = 0; $i < 3; $i++){
            $num = $.inArray($old_problem_id[$i], $problem);
            if($num != -1){
                $middle = $old_problem_id[$num];
                $old_problem_id[$num] = $old_problem_id[$i];
                $old_problem_id[$i] = $middle;
            }
        }
        $.post(
            'changeProtection',
            {
                old_problem_id : $old_problem_id,
                problem1 : $problem1,
                problem2 : $problem2,
                problem3 : $problem3,
                answer1  : $answer1,
                answer2  : $answer2,
                answer3  : $answer3
            },
            function(data){
                if(data == 'ok'){
                    alert_info("修改成功",1);
                }else{
                    alert_info("修改失败",0);
                }
            })
    })
})