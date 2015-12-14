var $url;//当前选中图片的地址
var $albumId;//当前相册id
var $img_id; //当前选中图片的id
$(function(){
    var old_json_data = $(".controller").attr("old_json_data");
    if(old_json_data!=null){

    }else{
        primary(0);
    }

    //预选一个默认横幅
    function primary(index){
        $url = $(".pic_show").find("img").eq(index).attr("src");        //默认图片的地址
        $albumId = $(".album").eq(index).attr("albumId");
        $img_id = $(".pic_show").find("img").eq(index).attr("img_id");
        $(".chooseAlbum").find(".album").eq(index).css("color",'green');
        $(".pic_show").find(".pattern").eq(index).find("div").addClass('hr');
    }

    //为图片添加事件
    $(document).on('click','.pattern',function(){
        $(".pattern").find("div").removeClass("hr");
        $url = $(this).find('img').attr('src');
        $img_id = $(this).find('img').attr("img_id");
        $(this).find("div").addClass("hr");
    })

    //为相册添加事件
    $(".album").click(function(){
        $albumId = $(this).attr("albumId");
        $(".chooseAlbum").find(".album").css("color","#000");
        $(this).css("color",'green');
        $.post("banner",{album_id:$albumId},function(data){
            if(data == "false"){
//                alert("该相册无图片");
                window.parent.alert_info("该相册无图片",-1);
                return;
            }else{
                $(".pic_show").empty();
                $url = "/microWeb/Uploads/"+data[0]['savepath']+data[0]['savename'];
                $(".pic_show").append("<div class='pattern'><div class='hr'><img src='/microWeb_v2/Uploads/"+data[0]['savepath']+data[0]['savename']+"'></div></div>");
                for(i = 1; i < data.length; i++){
                    $(".pic_show").append("<div class='pattern'><div class=''><img src='/microWeb_v2/Uploads/"+data[i]['savepath']+data[i]['savename']+"'></div></div>");
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
    var json_data = {name:"Banner",theme:"banner",resource:$url,option:{albumId:$albumId,img_id:$img_id}}

    var url = $("#save-url").val();
    $.post(url, json_data,function(data){
        //console.log(data);
        var pro = window.parent.getPro();
        $status = $("#status").val();
        if($status == 1){
            $elem = window.parent.getOperationElem();
            $($elem).hide().before(data).remove();
        }else{
            $(pro).before(data);
        }
        window.parent.$.layer.close();
    })


    //var html="";
    //html +="<head></head>";
    //html +="<div class ='controller' data-id='"+$("#controller-id").val()+"'>";
    //html +="<div><img width='100%' src='"+$url+"'></div>"
    //html +="</div>";
}