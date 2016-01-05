$(function(){

});

function save() {
    var form = $('form')[0];
    var length = form.length;
    var option = {};
    for(var i = 0; i < length; i ++){
        option[form[i].name] = form[i].checked;
    }
	var data = {option:option,name:$('#desc-name').val(),resource:$('#resource-id').val()};
	window.parent.save(data,$("#status").val());
};
