//弹出信息提示
function alert_info(text,type){
    var top_alert = $('#top-alert');
    top_alert.find(".alert-content").text(text);
    if(type == 1){
        top_alert.removeClass('alert-danger alert-warning').addClass('alert-success');
    }else if(type == 0){
        top_alert.removeClass('alert-success alert-warning').addClass('alert-danger');
    }else{
        top_alert.removeClass('alert-success alert-danger').addClass('alert-warning');
    }
    $('#top-alert-back').show();
    top_alert.animate({"opacity":1},250);

    setTimeout(function(){
        $('#top-alert').find('button').click();
    },2000);
}
/**弹出信息框的关闭**/
$(function(){
    $('.close_hint').click(function(){
        $('#top-alert').animate({"opacity":0},250,function(){$('#top-alert-back').hide()});
    });
})
