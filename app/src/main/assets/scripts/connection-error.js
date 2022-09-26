$(document).ready(function() {
	
	var get = {}
	
	var urlString = window.location.href;
	
	var paramString = urlString.split('?')[1];
	
	var params_arr = paramString.split('&');
	
	for (var i = 0; i < params_arr.length; i++) {
	
		var pair = params_arr[i].split('=');
		
		get[pair[0]] = pair[1];
		
	}
	
	
	$("#reload").click(function() {
		
		$(this).html('<div id="loader"></div>');
	
		window.location.href = get["next"];
		
	});

});