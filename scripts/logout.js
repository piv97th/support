function deleteCookie(name)
{
	var date = new Date();
	date.setTime(date.getTime() - 1);
	document.cookie = name += "=; expires=" + date.toGMTString();
}

$(function(){
	$("#logout").on('click',function(){
		deleteCookie("uid");
		deleteCookie("hash");
		location.reload();
	});
});