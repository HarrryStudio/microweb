$(function(){
    $(document).on('click','.getdown',function(){
        switchover();
    })

    $.showImg = function(){
        show = setInterval(function(){
            switchover();
        },5000);
    }

    function switchover(){
        $("#down").removeClass("getdown");      //用于取消频繁点击
        that = $(".carousel-inner").find('.active');
        if(that.next('div').find('img').attr('src') != null){
            that.next().addClass("active");
        }else{
            $(".carousel-inner").find('.item').eq(0).addClass("active");
        }
        that.animate({
            marginTop:"-210px"
        },1500,function(){
            clearInterval(show);
            that.remove();
            $imgurl = that.find('img').attr('src');
            $(".carousel-inner").append("<div class='item'><img style='width: 100%;height:210px;' src='"+$imgurl+"'></div>");
            $("#down").addClass("getdown");
            show = setInterval(function(){
                switchover();
            },3500);
        });
    }
})