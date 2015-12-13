$(function(){
    $(document).on('click','.NavDown>img',function(){
        var index = $(".NavDown>img").index($(this));
        if(index != 0 && index != $(".NavDown").find('img').length-1){
            $(".NavDown").animate({left:-109*(index-1)});
        }
        $(".showPic").find("img").attr("src",$(this).attr("src"));
    })
    $(document).on('click','.NavRight>img',function(){
        var index = $(".NavRight>img").index($(this));
        if(index != 0 && index != $(".NavRight").find('img').length-1){
            $(".NavRight").animate({marginTop:-(75*(index-1))});
        }
        $(".showPic").find("img").attr("src",$(this).attr("src"));
    })

})