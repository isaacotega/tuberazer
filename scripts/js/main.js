$(document).ready(function() {

	$("footer #bottomNav .option").click(function() {
	
		selectNav($(this).attr("id"));
	
		loadPage($(this).attr("id"));

	});
	
	loadAllPages();
				
	selectNav("home");

	loadPage("home");
	
});

var website = [];
	
getWebsiteData();
	
	function selectNav(id) {
	
		$("footer #bottomNav .option").removeAttr("selected");
		
		$("footer #bottomNav #" + id).attr("selected", "true");
		
	}
	
	var loader = {
		show: function() {
			$("#body #loader").css({
				display: "block"
			});
		},
		hide: function() {
			$("#body #loader").css({
				display: "none"
			});
		}
	}
	

	function loadAllPages() {
	
		for(var i = 0; i < $("#body .page").length; i++) {
		
			var pageName = $("#body .page").eq(i).attr("page");
		
			getPage(i);
	
		}
		
		function getPage(index) {
		
			$.ajax({
				type: "POST",
				url: (page["rootPath"] + "templates/pages/" + pageName + ".php"),
				data: {},
				success: function(response) {
				
			//		loader.hide();
				
					$("#body .page").eq(index).html(response);
				
				},
				error: function(response) {
		//		alert(  JSON.stringify( response ) );
				}
			});
		
		}
		
	}
	
	function loadPage(pageName, callBackFunction) {
	
		if(website["currentPage"] !== pageName) {
		
			$("#body .page").attr("id", "");
		
			$("#body [page=" + pageName + "]").attr("id", "mainContent");
		
		}
		
		else {
		
			loader.show();
		
			$.ajax({
				type: "POST",
				url: (page["rootPath"] + "templates/pages/" + pageName + ".php"),
				data: {},
				success: function(response) {
				
					loader.hide();
				
					$("#body [page=" + pageName + "]").html(response);
				
				},
				error: function(response) {
		//		alert(  JSON.stringify( response ) );
				}
			});
		
		}
	
		if(callBackFunction !== undefined) {
		
			callBackFunction();
			
		}
			
		website["currentPage"] = pageName;
		
	}
	
	function toast(text) {
	
		$("#toast").css({
			display: "block",
			bottom: "4cm",
			opacity: "1"
		}).html(text);
		
		setTimeout(function() {
		
			$("#toast").css({
				display: "none",
				bottom: "2cm",
				opacity: "0"
			}).html(text);
		
		}, 2000);
	
	}
	
	function showFooterDownload(number) {
	
		$("footer #cinema #downloadIcon").show();
		
		$("footer #cinema #downloadIcon #number").html(number);
		
	}
	
	function showFooterCompacted(number) {
	
		$("footer #cinema #compactedIcon").show();
		
		$("footer #cinema #compactedIcon #number").html(number);
		
	}
	
	function getWebsiteData() {
		
		$.ajax({
			type: "POST",
			url: (page["rootPath"] + "backend/ajax-handler.php"),
			dataType: "JSON",
			data: {
				"request": "websiteData"
			},
			success: function(response) {
				
		//		alert(  JSON.stringify( response ) );
				
				website["data"] = response
	
			},
			error: function(response) {
	
				alert(  JSON.stringify( response ) );
				
			},
		});
		
	}
	
	function searchYouTube(input) {
	
		selectNav("youtube");

 		loadPage("youtube", 
 		
 			setTimeout(function() { 
 		
 				$("#head #url").val(input);
 			
 				$("#mainIframe").attr("src", "youtube.com/search?q=" + input)
 			
 			}, 1000)
 			
 		);
		
	}
	
	setInterval(function() {
		
		getWebsiteData();
	
		
		showFooterDownload(website["data"]["downloads"]["pending"]["number"]);
				
		showFooterCompacted(website["data"]["downloads"]["ready"]["number"]);
				
		$("[special=creditsNumber]").html(website["data"]["accountDetails"]["credits"]);
		
	}, 500);
	
	website["templates"] = [];
	
	website["templates"]["bigDisplay"] = {
		show: function(content, topic) {
			
			var heading = '<label id="topic">' + (topic !== undefined ? topic : "") + '</label><br><br>';
		
			$("#bigDisplay").show(100);
			
			$("#bigDisplay #main").html(heading + content);
		
			$("#bigDisplay #background").click(function() {
				
				website["templates"]["bigDisplay"].hide();
			
			});
		
		},
		hide: function() {
			
			$("#bigDisplay").hide(100);
			
			$("#bigDisplay #main").html("");
		
		}
	}
	