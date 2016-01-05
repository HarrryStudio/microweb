function fun(){
	alert($(".nav-item.active").find('a').html());
	$(".nav-item.active").find('a').click();
}
