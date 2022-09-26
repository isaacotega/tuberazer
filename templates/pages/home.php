<?php
	
	$page = array("rootPath" => "../../");
	
 ?>


<style>

	#videoSearcherForm {
		text-align: center;
		width: 100%;
		padding: 2cm 0;
	}
	
	#videoSearcherForm [name=input] {
		width: 85%;
		height: 3cm;
		background-color: rgba(255, 255, 255, 0.1);
		font-size: 35px;
		border-radius: 10px 0 0 10px;
		box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.7);
		border: 0px solid;
		padding: 0 5mm;
		margin: 0;
		color: white;
	}

	#videoSearcherForm #pasteButton {
		width: 10%;
		height: 3cm;
		background-color: rgba(0, 0, 0, 0.2);
		font-size: 35px;
		border-radius: 0 10px 10px 0;
		box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.7);
		border: 0px solid;
		margin: 0;
		transform: translateX(-2mm) translateY(-1mm);
		color: white;
	}

	#videoSearcherForm [type=submit] {
		width: 96%;
		height: 3cm;
		background-color: rgba(0, 0, 0, 1);
		font-size: 35px;
		border-radius: 10px;
		box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.7);
		border: 0px solid;
		margin: 1cm 0;
		color: white;
		transition: background-color 0.2s;
	}

	#videoSearcherForm [type=submit]:active {
		background-color:  rgba(255, 255, 255, 0.2);
	}
	
	#videoSearcherForm #searchResults {
		width: 95%;
		margin: 0 1.8%;
		text-align: left;
		box-shadow: 0 0 10px 0 black;
		border-radius: 0 0 10px 10px;
		overflow: hidden;
		background-color: white;
		max-height: 10cm;
		overflow-y: scroll;
	}
	
	#videoSearcherForm #searchResults .result {
		width: 100%;
		line-height: 1.5cm;
		max-height: 1.5cm;
		display: block;
		font-size: 25px;
		color: black;
		text-indent: 3mm;
		transition: background-color 0.2s;
		overflow: hidden;
	}

	#videoSearcherForm #searchResults .result:active {
		background-color: rgba(0, 0, 0, 0.2);
	}
</style>


<script src="https://apis.google.com/js/api.js"></script>

 <script>
 	
	gapi.load("client", loadClient);
	
	function loadClient() {
		
		gapi.client.setApiKey("AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8");
		
		return gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest").then(function() {
			
	//		alert("GAPI client loaded for API");
			
		}, function(err) {
			
	//		alert("Error loading GAPI client for API", err);
			
		});
		
	} 
	
	var pageToken = "";
	
	function paginate(e, obj) {

    		e.preventDefault();

    		pageToken = obj.getAttribute('data-id');

    		execute();

	}

 	$(document).ready(function() {
 		
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

				//			output += '<label id="' + videoId + '" class="result">' + videoTitle + '</label>';

          			  });
*/
  /*
        				    if (response.result.prevPageToken) {

         				       output += `<br><a class="paginate" href="#" data-id="${response.result.prevPageToken}" onclick="paginate(event, this)">Prev</a>`;

    				        }

						if (response.result.nextPageToken) {

                				output += `<a href="#" class="paginate" data-id="${response.result.nextPageToken}" onclick="paginate(event, this)">Next</a>`;

        				    }
*/
/*
  						$("#videoSearcherForm #searchResults").html(output);

     			   }

 			   },

  			  function(err) { alert("Execute error" + JSON.stringify(err) ); });
*/
 		});
 		
 		$("#videoSearcherForm").submit(function() {
 		
 			event.preventDefault();
 			
 			var input = $(this).children("[name=input]").val().trim();
 			
 			if(input == "") {
 			
 				toast("Please type in a url or search word");
 			
 			}
 			
 			else {
 			
 				if(input.indexOf(" ") == -1 && $(this).children("[name=input]").val().indexOf("youtube.com/watch") !== -1) {
 				
 					
 					toast("Fetching video formats . . .");
 		
 					$.ajax({
 						type: "POST",
 						url: "backend/ajax-handler.php",
 						dataType: "JSON",
 						data: {
 							request: "videoFormats",
 							url: input
 						},
 						success: function(response) {
 					
 							downloadRequestSent = false;
 			
 			//				alert(JSON.stringify(response));
 				
 							var url = response["url"];
 					
 							var videoName = response["name"];
 					
 							var content = "";
 					
 							for(var i = 0; i < response["pixels"].length; i++) {
 						
 								var video = response["pixels"][i];
 					
 								content += ('<div class="option" pixel="' + video["pixel"] + '" onclick=\'startCompacting("' + video["pixel"] + '", "' + url + '", "' + video["originalSize"] + '", "' + video["reducedSize"] + '");\'> <video src="" autoplay></video> <div id="content"> <div id="pixelHolder"> <label id="pixel">' + video["pixel"] + 'px</label> </div> <div id="sizeHolder"> <label id="originalSize"><strike>' + video["originalSize"] + '</strike></label> <br> <label id="reducedSize">' + video["reducedSize"] + '</label> </div> <div id="priceHolder"> <span id="coin">C</span> <label id="price">' + video["price"] + '</label> </div> </div> </div>');
 						
 							}
 					
 							website["templates"]["bigDisplay"].show(content, videoName);
 					
 						},
 						error: function(response) {
 					
 							downloadRequestSent = false;
 			
 				//			alert(JSON.stringify(response));
 				
 						}
 					});
 	
 				
 				}
 				
 				else {
 				
 					searchYouTube(input);
 				
 				}
 			
 			}
 		
 		});
 		
 	});
 	
 					function startCompacting(pixel, url, originalSize, reducedSize) {
 					
 						website["templates"]["bigDisplay"].hide();
 					
 						toast("Processing request . . .");
 						
 						$.ajax({
 							type: "POST",
 							url: "backend/ajax-handler.php",
 							dataType: "JSON",
 							data: {
 								request: "downloadVideo",
 								pixel: pixel,
 								url: url,
 								originalSize: originalSize,
 								reducedSize: reducedSize
 							},
 							success: function(response) {
 								
 								if(response.status == "success") {
 								
 									toast("Compacting video . . .");
 									
 								}
 								
 								else {
 								
 									alert(JSON.stringify(response));
 								
 								}
 								
 							},
 							error: function(response) {
 								
 								alert(JSON.stringify(response));
 								
 							}
 						});
 					
 					}
 				
 </script>
 
 
<div class="heading">

	<label id="text">Search YouTube videos now!</label>
	
</div>

<form id="videoSearcherForm" autocomplete="off">

	<input name="input" type="search" placeholder="Search videos by link or name">
	
	<button type="button" id="pasteButton">&#3437;</button>
	
	<br>
	
	<div id="searchResults"></div>
	
	<button type="submit">Search YouTube</button>
	
</form>