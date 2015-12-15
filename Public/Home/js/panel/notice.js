$(function(){
    $isSave = false;        //标识是否为修改
    //添加
    $(".addBtn").click(function(){
        $(".popup").animate({
            left:"30%"
        })
        $(".setPopup").focus();
    })
    //确定
    $(".addOK").click(function(){
        $title = $(".setPopup").val();
        if($title == ""){
            $(".setPopup").focus();
            $('.hint').html("内容不能为空");
            setTimeout(function(){
                $('.hint').empty();
            },2000)
            return;
        }
        $(".setPopup").val("");
        $(".popup").animate({
            left:"-80%"
        })
        if($isSave){      //判断是否为修改
            that.html($title);
            $isSave = false;
        }else{
            var addHtml = "<div class='showContent'><div>"+$title+"</div><div>无</div>";
            addHtml += "<div><span class='deletePopup'>删除</span><span class='savePopup'>编辑</span></div></div>"
            $(".showContentList").append(addHtml);
        }
    })
    //取消
    $('.addFalse').click(function(){
        $(".setPopup").val("")
        $(".popup").animate({
            left:"-80%"
        })
    })
    //删除公告
    $(document).on('click','.deletePopup',function(){
        $(this).parents('.showContent').remove();
    })
    //修改公告
    $(document).on('click','.savePopup',function(){
        $isSave = true;
        that = $(this).parents(".showContent").find('div').eq(0);      //对象的文本(span)
        $(".popup").animate({
            left:"30%"
        })
        $PopupCentent = that.html();
        $(".setPopup").val($PopupCentent);
    })
})
function save(){
    $url=$(".noticeContent [type=radio]:checked").parent().next().find('img').attr('src');//公告图标
    $setTitle = $(".setNoticeTitle").val();
    if($setTitle == ""){
//        alert("标题不能为空");
        window.parent.alert_info("标题不能为空",-1);
        return;
    }
    $num = $('.showContentList').find('.showContent').length;       //公告的数量
    if($num == 0){
//        alert("公告不能为空");
        window.parent.alert_info("公告不能为空",-1);
        return;
    }else{
        var popupCon={};
        for(i = 0; i < $num; i++){
            $ShowPopup = $('.showContentList').find('.showContent').eq(i).find('div').eq(0).html();
            popupCon[i]={};
            popupCon[i]['con'] = $ShowPopup;
        }
    }
    var popupType = $(".setNoticeType [type=radio]:checked").val()
    var json_data = {
        name:"Notice",
        theme:"notice",
        resource:popupCon,
        option:{icon:$url,type:popupType,title:$setTitle}
    };

    var save_url = $("#save_widget").val();
    $.post(save_url,json_data,function(data){
        //console.log(data);
        console.log(data);
        if(data.status == 1){
            html = data['data']['html'];
            $status = $("#status").val();
            if($status == 1){
                var elem = window.parent.getOperationElem();
                $(elem).hide().before(html).remove();
            }else{
                var pro = window.parent.getPro();
                $(pro).before(html);
            }
        }else{
            alert("失败");
        }
        window.parent.$.layer.close();
    })

    //var html="";
    //html +="<head></head>";
    //html +="<div class='controller' data-id='"+$("#controller-id").val()+"'>";
    //html +="<div class='controller-title'>"+$setTitle+"</div>";
    //html +="<div style='height: 25px;'>";
    //if($url != null){
    //    html +="<span style='float: left; display: inline-block;'><img src='"+$url+"'></span>";
    //}
    //if($(".setNoticeType [type=radio]:checked").val()=='cell'){     //纵向公告
    //    html +="<marquee  style='font-size: 14px; width: 90%; float: left; height:21px;' scrollAmount=1 direction=up onmouseover=stop() onmouseout=start()>";
    //    for(i = 0; i < $num; i++){
    //        $ShowPopup = $('.showContentList').find('.showContent').eq(i).find('div').eq(0).html();
    //        html +="<span style='margin-left: 10%; display: inline-block;'>"+$ShowPopup+"</span><br/>";
    //    }
    //}else{          //横向公告
    //    html +="<marquee  style='font-size: 14px; width: 90%; float: left; height:21px;' scrollAmount=3 onmouseover=stop() onmouseout=start()>";
    //    for(i = 0; i < $num; i++){
    //        $ShowPopup = $('.showContentList').find('.showContent').eq(i).find('div').eq(0).html();
    //        html +="<span style='margin-left: 10%; display: inline-block;'>"+$ShowPopup+"</span>";
    //    }
    //}
    ////$status = $("#status").val();
    ////if($status == 1){
    ////    console.log(window.parent.getOperationElem());
    ////}
    //html +="</marquee></div></div>";
    //
    //var pro = window.parent.getPro();
    //$status = $("#status").val();
    //if($status == 1){
    //    $elem = window.parent.getOperationElem();
    //    $($elem).hide().before(html).remove();
    //}else{
    //    $(pro).before(html);
    //}
    //window.parent.$.layer.close();
}