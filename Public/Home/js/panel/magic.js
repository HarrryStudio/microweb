//魔方导航js
//gaoyadong
$(function(){
	$(".pattern").click(function(){
		$(".pattern").find("div").removeClass("hr");
		$(this).find("div").addClass("hr");
	})
})

function save(){
	var theme = $(".hr").parent().attr('va');
	window.parent.save({name:"Magic",resource:"",theme: theme, option:""},$("#status").val());
}