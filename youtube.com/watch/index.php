<?php
	
	$page = array("rootPath" => "../../");
	
	include_once($page["rootPath"] . "scripts/php/functions.php");
		
	isset($_GET["v"]) or die(redirect("../"));
	
	
	$videoId = $_GET["v"];
	
	$page["title"] = "Video";
	
	
	include_once($page["rootPath"] . "youtube.com/templates/header.php");
	
?>

<style>

	#streamingVideoContainer {
		height: 50vw;
		width: 100vw;
		position: fixed;
		top: 89px;
		left: 0;
		background-color: black;
		box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.8);
	}
	
	#streamingVideoContainer #videoFrame {
		width: 100%;
		height: 100%;
		margin: 0;
		border: none;
	}

	#videoContainer {
		
	}
	
	#contentHolder {
		margin-top: 50vw;
		text-indent: 5px;
	}

#contentHolder #videoTitle {
	font-size: 30px;
	height: 3vw;
	font-weight: 700;
	overflow: hidden;
	display: inline-block;
	color: white;
}

#contentHolder #detailsHolder {
	height: 8vw;
	overflow: hidden;
	display: block;
	color: rgba(255, 255, 255, 0.6);
	text-indent: 10px;
}

#contentHolder #detailsHolder label {
	font-size: 22px;
	font-weight: 100;
	display: inline-block;
}

#contentHolder #detailsHolder ul {
	display: inline-block;
	margin: 0;
	padding: 0;
	
}

#contentHolder #detailsHolder ul li {
	display: inline-block;
	margin: 0 3px;
}

	#upNext {
		font-size: 25px;
		line-height: 100px;
		border-top: 1px solid white;
	}

</style>

<script>
	
	var videoId = "<?php echo $videoId; ?>";
	
	var keyword = "";
		
	
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
	
	$(document).ready(function() {
		
		$("#errorHolder #reload").click(function() {
	
			$("#moreLoader").show(0);
	
			$("#errorHolder").hide(0);
			
			setTimeout(function() {
		
				loadRelated();
				
			}, 500);
	
		});
	
	});
	
	
	$(document).ready(function() {
	
		try {
		
		$.ajax({
			type: "GET",
			url: "https://www.googleapis.com/youtube/v3/videos",
			dataType: "JSON",
			data: {
				part: "snippet",
				id: videoId,
				key: website["youtube"]["apiKey"]
			},
			success: function(response) {
			
				//alert(JSON.stringify(response));
				
				$("head title").html(response["items"][0]["snippet"]["title"] + " - YouTube");
				
				
		 		$("#contentHolder #videoTitle").html(response["items"][0]["snippet"]["title"]);
			
		 		keyword = response["items"][0]["snippet"]["title"];
		 		
				loadRelated();
	
			},
			error: function(response) {
			
		//		alert(JSON.stringify(response));
			
			}
		});
		
		}
		
		catch(err) {
			
			//alert(err.message);
			
		}
		
	});
	
	}
	
	var pageToken = "";
	
	function loadRelated() {
	
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
							
							var link = "<?php echo $page["rootPath"]; ?>youtube.com/watch?v=" + videoId;
							
							var channelImageSrc = "https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id=" + channelId + "&key=AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8";

							output += website["templates"]["videoBox"].replaceAll("[videoId]", videoId).replaceAll("[videoName]", videoTitle).replaceAll("[videoImageSrc]", videoImageSrc).replaceAll("[channelName]", channelTitle).replaceAll("[dateDuration]", dateDuration).replaceAll("[views]", viewCount).replaceAll("[channelImageSrc]", channelImageSrc).replaceAll("[link]", link);
							
						//	alert( JSON.stringify(item) );

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

<div id="streamingVideoContainer">

	<iframe id="videoFrame" src="https://youtube.com/embed/<?php echo $videoId; ?>?autoplay=true"></iframe>

</div>

<div id="contentHolder">

	<p id="videoTitle"></p>

	<div id="detailsHolder">

		<ul>
		<!--
			<li><label id="dateDuration"></label> ago</li>
		-->
		</ul>
	
	</div>

</div>

<p id="upNext">Up next</p>

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