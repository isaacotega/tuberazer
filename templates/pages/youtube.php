<?php
	
	$page = array("rootPath" => "../../");
	
 ?>
 
 <style>
 
 	#mainIframe {
 		width: 100%;
 		height: 94%;
 		margin: -2px 0 0 0;
 		border: 0px solid;
 	}
 	
 	#downloadButton {
 		background-color: rgba(0, 0, 0, 0.8);
 		padding: 1cm 3cm;
 		border-radius: 10px;
 		box-shadow: 0 0 20px 0 rgba(255, 255, 255, 0.5);
 		border: 0px solid;
 		color: white;
 		position: fixed;
 		bottom: -3.5cm;
 		left: 50%;
 		transform: translateX(-50%);
 		transition: bottom 0.3s;
 	}
 	
 	#downloadButton svg {
 		height: 1.5cm;
 		width: 1.5cm;
 	}
 	
 	#downloadButton:active {
 		background-color: rgba(255, 255, 255, 0.2);
 	}
 	
 </style>
 
 <script>
 
 	var downloadRequestSent = false;
 	
 	var downloadVideoId;
 	
 	$(document).ready(function() {
 		
 		setInterval(function() {
 		
 			if(downloadRequestSent == false) {
 				
 				var iframeUrl = document.getElementById("mainIframe").contentWindow.location.href;
 		
 				if(iframeUrl.indexOf("youtube.com/watch") !== -1) {
 					
 					downloadVideoId = iframeUrl.substr(iframeUrl.indexOf("v=") + 2 , 11);
 			
 					$("#downloadButton").css("bottom", "3.5cm");
 			
 				}
 			
 				else {
 			
 					$("#downloadButton").css("bottom", "-3.5cm");
 			
 				}
 				
 			}
 		
 		}, 1000);
 		
 		$("#downloadButton").click(function() {
 	
 			$(this).css({
 				bottom: "-3.5cm"
 			});
 			
 			toast("Fetching video formats . . .");
 		
 			downloadRequestSent = true;
 			
 			$.ajax({
 				type: "POST",
 				url: "backend/ajax-handler.php",
 				dataType: "JSON",
 				data: {
 					request: "videoFormats",
 					videoId: downloadVideoId
 				},
 				success: function(response) {
 					
 					downloadRequestSent = false;
 			
 				//	alert(JSON.stringify(response));
 					
 					try {
 					
 						if(response["status"] == "success") {
 				
 							var videoId = response["videoId"];
 					
 							var videoName = response["name"];
 					
 							var content = "";
 					
 							for(var i = 0; i < response["pixels"].length; i++) {
 						
 								var video = response["pixels"][i];
 					
 								content += ('<div class="option" pixel="' + video["pixel"] + '" onclick=\'startCompacting("' + videoId + '", "' + videoName + '", "' + video["pixel"] + '", "' + video["url"] + '", "' + video["originalSize"] + '", "' + video["reducedSize"] + '");\'> <video src="" autoplay></video> <div id="content"> <div id="pixelHolder"> <label id="pixel">' + video["pixel"] + 'px</label> </div> <div id="sizeHolder"> <label id="originalSize"><strike>' + video["originalSize"] + '</strike></label> <br> <label id="reducedSize">' + video["reducedSize"] + '</label> </div> <div id="priceHolder"> <span id="coin">C</span> <label id="price">' + video["price"] + '</label> </div> </div> </div>');
 						
 							}
 					
 							website["templates"]["bigDisplay"].show(content, videoName);
 					
 							}
 					
 							} catch(err) { alert(err.message); }
 					
 						},
 						error: function(response) {
 					
 							downloadRequestSent = false;
 			
 							alert(JSON.stringify(response));
 				
 						}
 					});
 	
 				});
 	
		 	});
 

 					function startCompacting(videoId, videoName, pixel, url, originalSize, reducedSize) {
 					
 						website["templates"]["bigDisplay"].hide();
 					
 						toast("Processing request . . .");
 						
 						downloadRequestSent = false;
 			

 						$.ajax({
 							type: "POST",
 							url: "backend/ajax-handler.php",
 							dataType: "JSON",
 							data: {
 								request: "downloadVideo",
 								videoId: videoId,
 								videoName: videoName,
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
 
 <iframe src="http://localhost:8080/tuberazer/youtube.com/watch/?v=OfEwj9zAfnk" id="mainIframe"></iframe>
 
 </div>
 
 </div>
 
 <button id="downloadButton">
 	
 	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 21l-8-9h6v-12h4v12h6l-8 9zm9-1v2h-18v-2h-2v4h22v-4h-2z"/></svg>
 
 </button>
 
 </div>
 