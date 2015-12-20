var $url;//当前选中图片的地址
var $albumId;//当前相册id
var $img_id; //当前选中图片的id
$(function(){
    $url = $(".hr").find("img").attr("src");
    $albumId = $("#primary_album").val();
    $img_id = $("#primary_pic").val();

    //为图片添加事件
    $(document).on('click','.pattern',function(){
        $(".pattern").find("div").removeClass("hr");
        $url = $(this).find('img').attr('src');
        $img_id = $(this).find('img').attr("img_id");
        $(this).find("div").addClass("hr");
    })

    //为相册添加事件
    $(".album").click(function(){
        $albumId = $(this).attr("albumid");
        $(".chooseAlbum").find(".album").css("color","#000");
        $(this).css("color",'green');
        $.post($("#post_pic").val(),{album_id:$albumId},function(data){
            if(data == "false"){
//                alert("该相册无图片");
                window.parent.alert_info("该相册无图片",-1);
                return;
            }else{
                $(".pic_show").empty();
                $url = "/microWeb/Uploads/"+data[0]['savepath']+data[0]['savename'];
                $img_id = data[0]['id'];
                $(".pic_show").append("<div class='pattern'><div class='hr'><img img_id='"+data[0]['id']+"' src='/microWeb/Uploads/"+data[0]['savepath']+data[0]['savename']+"'></div></div>");
                for(i = 1; i < data.length; i++){
                    $(".pic_show").append("<div class='pattern'><div class=''><img img_id='"+data[i]['id']+"' src='/microWeb/Uploads/"+data[i]['savepath']+data[i]['savename']+"'></div></div>");
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

    window.parent.save(json_data,$("#status").val());
    //var save_url = $("#save_widget").val();
    //$.post(save_url,json_data,function(data){
    //    //console.log(data);
    //    console.log(data);
    //    if(data.status == 1){
    //        html = data['data']['html'];
    //        $status = $("#status").val();
    //        if($status == 1){
    //            var elem = window.parent.getOperationElem();
    //            $(elem).hide().before(html).remove();
    //        }else{
    //            var pro = window.parent.getPro();
    //            $(pro).before(html);
    //        }
    //    }else{
    //        alert("失败");
    //    }
    //    window.parent.$.layer.close();
    //})


    //var html="";
    //html +="<head></head>";
    //html +="<div class ='controller' data-id='"+$("#controller-id").val()+"'>";
    //html +="<div><img width='100%' src='"+$url+"'></div>"
    //html +="</div>";
}