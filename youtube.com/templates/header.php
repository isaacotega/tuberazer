<?php
	
	include_once($page["rootPath"] . "backend/general-info.php");

?>

<!DOCTYPE html>

<html>

	<head>
  
		<title><?php echo ($page["title"] . " - " . $website["name"]); ?></title>
	
		<link rel="stylesheet" type="text/css" href="<?php echo $page["rootPath"]; ?>youtube.com/styles/index.css">
		
		<script>
		
			var page = JSON.parse('<?php echo json_encode($page); ?>');
		
		</script>

		<script src="<?php echo ($page["rootPath"]  . "scripts/js/JQuery.js"); ?>"></script>
	
		<script src="<?php echo ($page["rootPath"]  . "scripts/js/unsigned-main.js"); ?>"></script>
	
<script src="https://apis.google.com/js/api.js"></script>

 <script>
 	
 	try {
 	
		gapi.load("client", loadClient);
		
	}
	
	catch(err) {
	
		try {
		
			setTimeout(function() {
				
				gapiLoadError();
				
			}, 1000);
		
		}
		
		catch(err) {}
	
	}

	function loadClient() {
		
		gapi.client.setApiKey("AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8");
		
		return gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest").then(function() {
			
			try {
			
					apiLoaded();
					
			}
			
			catch(err) {
	
				try {
		
					gapiLoadError();
		
				}
		
				catch(err) {}
	
			}
			
	//		alert("GAPI client loaded for API");
			
		}, function(err) {
			
			alert("Error loading GAPI client for API", err);
			
		});
		
	} 
	
	var pageToken = "";
	
 	$(document).ready(function() {
 		
 		var previousScroll = 0;
 	
 		$(window).scroll(function() {
			
			var nowScroll = $(this).scrollTop();
			
			if (Math.abs(nowScroll) > previousScroll) {

				$("header").animate({
					height: "0"
				}, 300);
			
				$("#streamingVideoContainer").animate({
					top: "0"
				}, 300);
			
			}
			
			else {

				$("header").animate({
					height: "90px"
				}, 300);
			
				$("#streamingVideoContainer").animate({
					top: "90px"
				}, 300);
			
			}
			
			previousScroll = nowScroll;

		});
		
 		$("#videoSearcherForm [name=input]").blur(function() {
 			
  			$("#videoSearcherForm #searchResults").hide(200);

 		});
 		
 		$("#videoSearcherForm [name=input]").focus(function() {
 			
  			$("#videoSearcherForm #searchResults").show(200);

 		});
 		
 		$("#videoSearcherForm [name=input]").keyup(function() {
 			
 			var keyword = $(this).val();
 			
 		// orders  Date Rating Relevance Title and viewCount
 		
 			var arr_search = {
 				"part": 'snippet',
 				"type": 'video',
 				"order": "relevance",
 				"maxResults": 100,
 				"q": keyword
 			};



			if (pageToken != '') {

     		   arr_search.pageToken = pageToken;

    			}
			/*
			return gapi.client.youtube.search.list(arr_search).then(function(response) {

   			     // Handle the results here (response.result has the parsed body).

     			   var listItems = response.result.items;

     			   if (listItems) {

						var output = '';

          				listItems.forEach(item => {

							var videoId = item.id.videoId;

							var videoTitle = item.snippet.title;

							output += '<label id="' + videoId + '" class="result">' + videoTitle + '</label>';

          			  });

  					$("#videoSearcherForm #searchResults").html(output);


  					$("#videoSearcherForm #searchResults .result").click(function() {

						$("#videoSearcherForm [name=input]").val($(this).html());

 						window.location.href = ("<?php echo $page["rootPath"]; ?>youtube.com/results?search_query=" + $(this).html());
 			
});


     			   }

 			   },

  			  function(err) { alert("Execute error" + JSON.stringify(err) ); });
*/
 		});
 		
 		$("#videoSearcherForm").submit(function() {
 		
 			event.preventDefault();
 			
 			var input = $(this).children("[name=input]").val().trim();
 			
 			if(input == "") {
 			
 			}
 			
 			else {
 				
 				window.location.href = ("<?php echo $page["rootPath"]; ?>youtube.com/results?search_query=" + input);
 			
 			}
 		
 		});
 		
 	});
 	
 	
 	
	$.ajax({
		url: "<?php echo $page["rootPath"]; ?>templates/video-box.php",
		data: {},
		success: function(response) {
			
			website["templates"]["videoBox"] = response;
				
		},
		error: function(response) {
		alert(  JSON.stringify( response ) );
		}
	});
	
 	
	$.ajax({
		url: "<?php echo $page["rootPath"]; ?>templates/result-box.php",
		data: {},
		success: function(response) {
			
			website["templates"]["resultBox"] = response;
				
		},
		error: function(response) {
		alert(  JSON.stringify( response ) );
		}
	});
	
	$(document).ready(function() {
		
		$("header #iconHolder #searchIcon").click(function() {
		
			$("#searchHolder").show(100);
		
			$("#searchHolder [name=input]").focus();
		
		});
	
		$("#searchHolder form #back").click(function() {
		
			$("#searchHolder").hide(100);
		
		});
	
		$("#searchHolder #background").click(function() {
		
			$("#searchHolder").hide(100);
		
		});
	
	});

 	
 </script>
 
 
	</head>
	
	<body>
	
		
		<?php
	
			include_once($page["rootPath"] . "youtube.com/templates/head.php");
		
			include_once($page["rootPath"] . "youtube.com/templates/search-holder.php");

		?>