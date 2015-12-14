$(function(){
    $(document).on('click','.NavDown>img',function(){
//        var index = $(".NavDown>img").index($(this));
        var index = $(this).index();
        if(index != 0 && index != $(this).parents(".NavDown").find('img').length-1){
            $(this).parents('.controller').find(".NavDown").animate({left:-125*(index-1)});
        }
        $(this).parents('.controller').find(".showPic").find("img").attr("src",$(this).attr("src"));
    })
    $(document).on('click','.NavRight>img',function(){
//        var index = $(".NavRight>img").index($(this));
        var index = $(this).index();
        if(index != 0 && index != $(this).parents(".NavRight").find('img').length-1){
            $(this).parents('.controller').find(".NavRight").animate({marginTop:-(80*(index-1))});
        }
        $(this).parents('.controller').find(".showPic").find("img").attr("src",$(this).attr("src"));
    })
})