<?php
	
	$page = array("rootPath" => "../../");
	
 ?>
 
 <style>
 
 	#mainIframe {
 		width: 100%;
 		height: 100%;
 		margin: 0;
 		border: 0px solid;
 	}
 	
 	#downloadButton {
 		background-color: darkgreen;
 		padding: 1cm 3cm;
 		border-radius: 10px;
 		box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5);
 		border: 0px solid;
 		color: white;
 		position: fixed;
 		bottom: -3.5cm;
 		left: 50%;
 		transform: translateX(-50%);
 		transition: bottom 0.3s;
 	}
 	
 	#downloadButton:active {
 		background-color: green;
 	}
 	
 	#head {
 		background-color: rgba(0, 0, 0, 0.2);
 		height: 2cm;
 		position: absolute;
 		top: 0;
 		left: 0;
 		width: 100%
 	}
 	
 	#head #url {
 		width: 96%;
 		margin: 0.25cm 2%;
 		line-height: 1.5cm;
 		background-color: rgba(0, 0, 0, 0);
 		border: 0px solid;
 		font-size: 30px;
 		color: rgba(255, 255, 255, 0.6);
 		transition: 0.3s;
 	}
 	
 	#head #url:focus {
 		border-bottom: 2px solid white;
 		font-size: 32px;
 		outline: none
 		color: white;
 	}
 	
 	#foot {
 		background-color: rgba(0, 0, 0, 0.2);
 		height: 2cm;
 		position: absolute;
 		bottom: 0;
 		left: 0;
 		width: 100%
 	}
 	
 	#foot table {
 		width: 100%;
 		color: white;
 		height: 100%;
 		font-size: 45px;
 		text-align: center;
 	}
 	
#foot table td {
	border-radius: 40px;
	transition: background-color 0.2s;
}

#foot table td:active {
	background-color:  rgba(0, 0, 0, 0.1);
}

 
 </style>
 
 <script>
 
 	var isTypingUrl = false;
 	
 	var downloadRequestSent = false;
 	
 	$(document).ready(function() {
 		
 		setInterval(function() {
 		
 			if(isTypingUrl == false) {
 			
 				$("#head #url").val($("#mainIframe").attr("src"));
 				
 			}
 			
 			if(downloadRequestSent == false) {
 		
 				if($("#mainIframe").attr("src").indexOf("youtube.com/watch") !== -1) {
 			
 					$("#downloadButton").css("bottom", "3.5cm");
 			
 				}
 			
 				else {
 			
 					$("#downloadButton").css("bottom", "-3.5cm");
 			
 				}
 				
 			}
 		
 		}, 1000);
 		
 		$("#head #url").focus(function() {
 		
 			isTypingUrl = true;
 		
 		});
 		
 		$("#head #url").blur(function() {
 		
 			isTypingUrl = false;
 		
 		});
 		
 		$("#urlForm").submit(function() {
 		
 			event.preventDefault();
 			
 			$("#head #url").blur();
 			
 			$("#mainIframe").attr("src", $("#head #url").val());
 		
 		});
 	
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
 					url: $("#mainIframe").attr("src")
 				},
 				success: function(response) {
 					
 					downloadRequestSent = false;
 			
 			//		alert(JSON.stringify(response));
 				
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
 			
 				//	alert(JSON.stringify(response));
 				
 				}
 			});
 	
 		});
 	
 	});
 

 					function startCompacting(pixel, url, originalSize, reducedSize) {
 					
 						website["templates"]["bigDisplay"].hide();
 					
 						toast("Processing request . . .");
 						
 						downloadRequestSent = false;
 			

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
 
 <iframe src="https://youtube.com/" id="mainIframe"></iframe>
 
 <div id="head">
 	
 	<form autocomplete="off" id="urlForm">
 
 		<input id="url" type="url">
 		
 	</form>
 
 </div>
 
 <div id="foot">
 	
 	<table>
 		
 		<tr>
 			
 			<td><</td>
 			
 			<td>></td>
 			
 			<td>x</td>
 			
 		</tr>
 		
 	</table>
 
 </div>
 
 <button id="downloadButton">&#95534;</button>
 
 </div>
 