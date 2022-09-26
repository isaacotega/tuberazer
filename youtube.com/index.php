<?php
	
	$page = array("rootPath" => "../", "title" => "Home");
	
	include_once($page["rootPath"] . "scripts/php/functions.php");
		
	
	$input = "";
	
	
	include_once($page["rootPath"] . "youtube.com/templates/header.php");
	
?>
	

<script>
	
	$(document).ready(function() {
		
		$("#errorHolder #reload").click(function() {
	
			$("#moreLoader").show(0);
	
			$("#errorHolder").hide(0);
			
			setTimeout(function() {
		
				loadResults();
				
			}, 500);
	
		});
	
	});
	
	
	function gapiLoadError() {
	
		$("#moreLoader").hide(0);
	
		$("#errorHolder").show(0);
	
	}
	
	function paginate(e, newPageToken) {
	
    		e.preventDefault();

    		pageToken = newPageToken;

    		apiLoaded();

	}

	function apiLoaded() {
	
		loadResults();
	
	}
	
	var pageToken = "";
	
	function loadResults() {
	
		var keyword = '<?php echo $input; ?>';
	
	
 		// orders  Date Rating Relevance Title and viewCount
 		
 			var arr_search = {
 				"part": 'snippet',
 				"type": 'video',
 				"order": "relevance",
 				"maxResults": 50,
 				"q": keyword
 			};



			if (pageToken != '') {

     		   arr_search.pageToken = pageToken;

    			}
			
			try {
			
				return gapi.client.youtube.search.list(arr_search).then(function(response) {

   			     // Handle the results here (response.result has the parsed body).

     			   var listItems = response.result.items;

     			   if (listItems) {

						var output = '';

          				listItems.forEach(item => {

							var videoId = item.id.videoId;

							var videoTitle = item.snippet.title;

							var videoImageSrc = item.snippet.thumbnails.medium.url;

							var channelId = item.snippet.channelId;

							var channelTitle = item.snippet.channelTitle;

							var currentDate = new Date();

							var publishTime = Number(currentDate) - Number(Date.parse(item.snippet.publishedAt));
							
							var days = (publishTime/1000/60/24);
							
							if(days > 365) {
							
								var amount = days/365;
							
								var duration = "years";
								
							}
							
							else if(days > 30) {
							
								var amount = days/60;
							
								var duration = "months";
								
							}
							
							else if(days > 7) {
							
								var amount = days/7;
							
								var duration = "weeks";
								
							}
							
							else {
							
								var amount = days;
							
								var duration = "days";
								
							}
							
							var dateDuration = (Math.round(amount) + " " + duration);
							
							var viewCount = "";
							
				/*			$.ajax(
							https://www.googleapis.com/youtube/v3/videos?part=statistics&id=JtuGIzodT-M&key=AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8
							*/
							var link = "<?php echo $page["rootPath"]; ?>youtube.com/watch?v=" + videoId;
							
							var channelImageSrc = "https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id=" + channelId + "&key=AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8";

							output += website["templates"]["videoBox"].replaceAll("[videoId]", videoId).replaceAll("[videoName]", videoTitle).replaceAll("[videoImageSrc]", videoImageSrc).replaceAll("[channelName]", channelTitle).replaceAll("[dateDuration]", dateDuration).replaceAll("[views]", viewCount).replaceAll("[channelImageSrc]", channelImageSrc).replaceAll("[link]", link);
							
					//		alert( JSON.stringify(item) );

          			  });

						$("#videoContainer").append(output);
					
						$(window).on('scroll', function(e){
						
							if( (window.innerHeight + window.scrollY) >= document.body.scrollHeight ) {
							
								paginate(event, response.result.nextPageToken);
								
							}
							
						});
						
					}

 			   },

  			  function(err) {
				
					try {
		
					gapiLoadError();
		
				}
		
				catch(err) {}
	
				alert("Execute error" + JSON.stringify(err));
					
					
			});

		}

		catch(err) {

	//		alert(err.message);

			try {
		
				gapiLoadError();
		
			}
		
			catch(err) {}
	
		}

	}
		
</script>

<br><br><br><br><br>

<div id="videoContainer"></div>

<div id="moreLoader">

	<div id="loader"></div>
	
</div>

	<div id="errorHolder">
		
		<h2>Unable to load</h2>
		
		<p>Please check your internet connection and try again</p>
		
		<button id="reload">Reload</button>
		
	</div>
	
<?php
	
	include($page["rootPath"] . "youtube.com/templates/footer.php");
	
?>