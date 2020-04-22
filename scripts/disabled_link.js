	$(function() {
	var url = location.href;

	$("nav.navbar [href]").each(function(indx, element){
		if(url == element)
		{
			var el = $("nav.navbar [href]").eq(indx).attr("id", "disabled_link");
		}
	});
	
	$("#disabled_link").css({"background-color":"#DDDDDD", "color":"#FFFFFF"});
	$("#disabled_link").on("click", function() {
		return false;
	});
});