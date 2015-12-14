$(function(){
    $album_id = $(".albumList").find("tr").eq(0).attr("date");      //选中对象的id(图册)
    url1 = "/microweb/Public/Home/images/panel/viwepagerAdd1.png";   //选中时图片
    url2 = "/microweb/Public/Home/images/panel/viwepagerAdd2.png";   //非选中时图片
    $(".albumList").find("tr").eq(0).css("background","#D3D1CB");
    $(".albumList").find("img").eq(0).attr("src",url1);
    $type = 1;
    $(".pattern").click(function(){
        $(".pattern").find("div").removeClass("hr");
        $(this).find("div").addClass("hr");
        $type = $(this).find('img').attr("type");
    })
    $(".albumListContent tr").mouseover(function(){
        if($(this).attr("date") != $album_id){
            $(this).css("background","#E8E7E4");
        }
    })
    $(".albumListContent tr").mouseout(function(){
        if($(this).attr("date") != $album_id){
            $(this).css("background","");
        }
    })
    $(".albumListContent tr").click(function(){
        $(this).siblings("tr").css("background","");
        $(this).css("background","#D3D1CB");
        $(this).siblings("tr").find("img").attr("src",url2);
        $(this).find("img").attr("src",url1);
        $album_id = $(this).attr("date");
    })
})

var dynamicLoading = {
    css: function(path){
        if(!path || path.length === 0){
            throw new Error('argument "path" is required !');
        }
        var p_document = window.parent.panelFrame.document;
        var head = p_document.getElementsByTagName('head')[0];
        var link = p_document.createElement('link');
        link.href = path;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        head.appendChild(link);
    },
    js: function(path){
        if(!path || path.length === 0){
            throw new Error('argument "path" is required !');
        }
        var p_document = window.parent.panelFrame.document;
        var head = p_document.getElementsByTagName('head')[0];
        var script = p_document.createElement('script');
        script.src = path;
        script.type = 'text/javascript';
        head.appendChild(script);
    }
}

function save(){
    $title = $(".setTitle").val();
    if($title == ""){
        alert("标题不能为空");
        return;
    }
    if($album_id == undefined){
//        alert("请选择相册");
        window.parent.alert_info("请选择相册",-1);
        return;
    }
    var json_data = {
        name:"pictureShow",
        theme:"pictureShow",
        resource:$album_id,
        //option:{type:$type}
        option:{type:$type,title:$title}
    }
    $.post('PicturesShow',{json_data:json_data},function(data){
        if(data=="false"){
            window.parent.alert_info("相册为空",-1);
            return;
        }
        var pro = window.parent.getPro();
        $status = $("#status").val();
        if($status == 1){
            $elem = window.parent.getOperationElem();
            $($elem).hide().before(data).remove();
        }else{
            $(pro).before(data);
        }
        window.parent.$.layer.close();



//        var html="";
//        var link = "/microweb/UserFiles/Public/Controller/PicturesShow/PicPhoneShow.css";
//        var  loadCss ="<link rel = 'stylesheet' href = " + link + " />";
//        $(parent.document.getElementById('panel-frame').contentDocument.head).append(loadCss);
////        html += "<div class='controller-title'>"+$title+"</div>";
//        html +="<div style='width: 100%;display: inline-block;min-height: 240px;overflow: hidden;' class='controller' data-id='"+$("#controller-id").val()+"'>";
//
//        if($type == 3){
//            html +="<div class='picShowList'>";
//            for(i = 0; i < $pic.length; i++){
//                html +="<img src='/microweb/Uploads/"+$pic[i]['savepath']+$pic[i]['savename']+"'>";
//            }
//        }else if($type == 2){
//            html +="<div class='showPic showRight'><img src='/microweb/Uploads/"+$pic[0]['savepath']+$pic[0]['savename']+"'></div>";
//            html +="<div class='NavRight'>";
//            for(i = 0; i < $pic.length; i++){
//                html +="<img src='/microweb/Uploads/"+$pic[i]['savepath']+$pic[i]['savename']+"'>";
//            }
//        }else if($type == 1){
//            html +="<div class='showPic showDown'><img src='/microweb/Uploads/"+$pic[0]['savepath']+$pic[0]['savename']+"'></div>";
//            html +="<div class='NavDown'>";
//            for(i = 0; i < $pic.length; i++){
//                html +="<img src='/microweb/Uploads/"+$pic[i]['savepath']+$pic[i]['savename']+"'>";
//            }
//        }
//        html +="</div></div>";
//
//        var pro = window.parent.getPro();
//        $status = $("#status").val();
//        if($status == 1){
//            $elem = window.parent.getOperationElem();
//            $($elem).hide().before(html).remove();
//        }else{
//            $(pro).before(html);
//        }
//        window.parent.$.layer.close();
    })

}
