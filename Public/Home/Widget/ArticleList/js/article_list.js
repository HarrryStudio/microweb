$(function(){
    $(document).on("click",".article_title",function(){
        $index = $(".article_title").index($(this));
        var parent = $(this).parents(".controller");
        console.log(parent);
        console.log("==================")
        parent.find('a').hide();
        // $(".detail").parents("a").hide();
        $(".detail").parents(".textContent").find('a').eq($index).show();
    })
})