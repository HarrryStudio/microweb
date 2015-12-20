var type = 1;      //选中的轮播样式
var album_id = $(".albumList").find("tr").eq(0).attr("date");      //选中对象的id(图册)
$(function(){
//    $("img").css('border','solid 2px #666');
//    $lickStatus = true;         //表示当前是点击状态
    url1 = "/microweb/Public/Home/images/panel/viwepagerAdd1.png";   //选中时图片
    url2 = "/microweb/Public/Home/images/panel/viwepagerAdd2.png";   //非选中时图片
    $(".albumList").find("tr").eq(0).css("background","#D3D1CB");
    $(".albumList").find("img").eq(0).attr("src",url1);
    $(".img>img").eq(0).css('border','solid 2px #0f0');
    $(".img>img").click(function(){
        $(this).css('border','solid 2px #0f0');
        $(this).parents(".img").find("img").not(this).css('border','solid 2px #666');
        type = $(this).attr('type');
    })
    $(".albumListContent tr").mouseover(function(){
        if($(this).attr("date") != album_id){
            $(this).css("background","#E8E7E4");
        }
    })
    $(".albumListContent tr").mouseout(function(){
        if($(this).attr("date") != album_id){
            $(this).css("background","");
        }
    })
    $(".albumListContent tr").click(function(){
        $(this).siblings("tr").css("background","");
        $(this).css("background","#D3D1CB");
        $(this).siblings("tr").find("img").attr("src",url2);
        $(this).find("img").attr("src",url1);
        album_id = $(this).attr("date");
    })
})

//var dynamicLoading = {
//    css: function(path){
//        if(!path || path.length === 0){
//            throw new Error('argument "path" is required !');
//        }
//        var p_document = window.parent.panelFrame.document;
//        var head = p_document.getElementsByTagName('head')[0];
//        var link = p_document.createElement('link');
//        link.href = path;
//        link.rel = 'stylesheet';
//        link.type = 'text/css';
//        head.appendChild(link);
//    },
//    js: function(path){
//        if(!path || path.length === 0){
//            throw new Error('argument "path" is required !');
//        }
//        var p_document = window.parent.panelFrame.document;
//        var head = p_document.getElementsByTagName('head')[0];
//        var script = p_document.createElement('script');
//        script.src = path;
//        script.type = 'text/javascript';
//        head.appendChild(script);
//    }
//}

function save(){
    //var title = $(".setTitle").val();
    //if(title == ""){
    //    window.parent.alert_info("标题不能为空",-1);
    //    return;
    //}

    if(album_id == undefined){
        window.parent.alert_info("请选择相册",-1);
        return;
    }
    var json_data = {
        name:"ViwePager",
        theme:"viwepager",
        resource:album_id,
        option:{type:type}
        //option:{title:title,type:type}
    }
    window.parent.save(json_data,$("#status").val());
//    var save_url = $("#save_widget").val();
//    $.post(save_url,json_data,function(data){
//        //console.log(data);
//        console.log(data);
//        if(data.status == 1){
//            html = data['data']['html'];
//            $status = $("#status").val();
//            if($status == 1){
//                var elem = window.parent.getOperationElem();
//                $(elem).hide().before(html).remove();
//            }else{
//                var pro = window.parent.getPro();
//                $(pro).before(html);
//            }
//        }else{
//            alert("失败");
//        }
//        window.parent.$.layer.close();
//
//
////        var html="";
////        html +="<head></head>";
//////        html += "<div class='controller-title'>"+$title+"</div>";
////        html +="<div style='max-height: 230px' class='controller' data-id='"+$("#controller-id").val()+"'>";
////        html +="<div id='carousel-example-generic' class='carousel slide'>";
////        //显示的内容
////        html +="<div class='carousel-inner' style='height:210px'>";
////        html +="<div class='item active'><img style='width: 100%;height:210px;' src='/microweb/Uploads/"+$pic[0]['savepath']+$pic[0]['savename']+"'></div>";
////        for(i = 1; i < $pic.length && i < 10; i++){
////            html +="<div class='item'><img style='width: 100%;height:210px;' src='/microweb/Uploads/"+$pic[i]['savepath']+$pic[i]['savename']+"'></div>";
////        }
////        html +="</div>";
////        //滚动效果
////        if($type == 1){         //左右按钮轮播
////            html += "<a class='left carousel-control' href='#carousel-example-generic' data-slide='prev'>";
////            html += "<span class='glyphicon glyphicon-chevron-left'></span></a>";
////            html += "<a class='right carousel-control' href='#carousel-example-generic' data-slide='next'>";
////            html += "<span class='glyphicon glyphicon-chevron-right'></span></a>";
////        }else if($type == 2){         //下方导航轮播
////            html += "<ol class='carousel-indicators'><li data-target='#carousel-example-generic' data-slide-to='0' class='active'></li>";
////            for(i= 1; i < $pic.length && i < 10; i++){
////                html += "<li data-target='#carousel-example-generic' data-slide-to="+i+"></li>";
////            }
////            html += "</ol>";
////        }else if($type == 3){          //上下按钮轮播
////            html += "<a style='margin-left:49%' class='getdown' id='down'>";
////            html += "<span style='cursor: pointer;' class='glyphicon glyphicon-chevron-down'></span></a>";
////        }
////        html +="</div>";
////        html +="</div>";
////
////        var pro = window.parent.getPro();
////        $status = $("#status").val();
////        if($status == 1){
////            $elem = window.parent.getOperationElem();
////            $($elem).hide().before(html).remove();
////        }else{
////            $(pro).before(html);
////        }
//////        window.parent.$.layer.close();
////        if($type != 3){
////            window.parent.panelFrame.$('.carousel').carousel({interval: 3000});     //轮播自动滚动及时间
////        }else{
////          window.parent.panelFrame.$.showImg();
////        }
////        window.parent.$.layer.close();
//    })
}
