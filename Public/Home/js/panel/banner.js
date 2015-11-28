$(function(){
    $url = $(".pic_show").find("img").eq(0).attr("src");        //默认图片的地址
    $(".chooseAlbum").find(".album").eq(0).css("color",'green');
    $(".pic_show").find(".pattern").eq(0).find("div").addClass('hr');
    $(document).on('click','.pattern',function(){
        $(".pattern").find("div").removeClass("hr");
        $(this).find("div").addClass("hr");
        $url = $(this).find('img').attr('src');
    })
    $(".album").click(function(){
        $albumId = $(this).attr("albumId");
        $(".chooseAlbum").find(".album").css("color","#000");
        $(this).css("color",'green');
        $.post('banner',{album_id:$albumId},function(data){
            if(data == "false"){
//                alert("该相册无图片");
                window.parent.alert_info("该相册无图片",-1);
                return;
            }else{
                $(".pic_show").empty();
                $url = "/microWeb/Uploads/"+data[0]['savepath']+data[0]['savename'];
                $(".pic_show").append("<div class='pattern'><div class='hr'><img src='/microWeb/Uploads/"+data[0]['savepath']+data[0]['savename']+"'></div></div>");
                for(i = 1; i < data.length; i++){
                    $(".pic_show").append("<div class='pattern'><div class=''><img src='/microWeb/Uploads/"+data[i]['savepath']+data[i]['savename']+"'></div></div>");
                }
            }
        })
    })
})
function save(){
    if($url == undefined){
        window.parent.alert_info("请选择图片");
        return;
    }
    var html="";
    html +="<head></head>";
    html +="<div class ='controller' data-id='"+$("#controller-id").val()+"'>";
    html +="<div><img width='100%' src='"+$url+"'></div>"
    html +="</div>";

    var pro = window.parent.getPro();
    $status = $("#status").val();
    if($status == 1){
        $elem = window.parent.getOperationElem();
        $($elem).hide().before(html).remove();
    }else{
        $(pro).before(html);
    }
    window.parent.$.layer.close();
}