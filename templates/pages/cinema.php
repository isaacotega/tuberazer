<?php
	
	$page = array("rootPath" => "../../");
	
	include_once($page["rootPath"] . "backend/general-info.php");
	
 ?>

<style>

#videoDisplay {
}

 	#videoDisplay .option {
 		position: relative;
 		box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.5);
 		width: 7cm;
 		height: 4.5cm;
 		background-color: rgba(255, 255, 255, 0.1);
 		color: white;
 		display: inline-block;
 		margin: 3mm;
 	}
 	
 	#videoDisplay .option video {
 		width: 100%;
 		height: 100%;
 	}
 
 	#videoDisplay .option #content {
 		width: 100%;
 		height: 30%;
 		position: absolute;
 		bottom: 0;
		background-color:  rgba(0, 0, 0, 0.5);
		text-align: left
 		
 	}

 	#videoDisplay .option #content div {
 		display: inline-block;
 		margin: 0 2mm;
 		
 	}

 	#videoDisplay .option #content #pixelHolder {
 		position: absolute;
 		top: 0;
 		left: 0;
 	}

 	#videoDisplay .option #content #sizeHolder {
 		position: absolute;
 		top: 0;
 		left: 3.3cm;
 	}

 	#videoDisplay .option #content #priceHolder {
 		position: absolute;
 		top: 0;
 		right: 0;l
 	}

 	#videoDisplay .option  #pixel {
 		font-size: 40px;
 	}

 	#videoDisplay .option  #originalSize {
 		font-size: 15px;
 	}

 	#videoDisplay .option  #reducedSize {
 		font-size: 20px;
 	}

 	#videoDisplay .option  #price {
 		line-height: 1.5cm; 	
 	}
	
	
	#bigDisplay #videoDisplay .option {
		width: 15cm;
		height: 8cm;
	}
	
	#bigDisplay #downloadIcon {
		font-size: 40px;
		font-weight: 700;
		padding: 1cm 3cm;
 		border-radius: 10px;
 		box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5);
 		border: 0px solid;
 		color: white;
 		transition: background-color 0.3s;
 	}
 	
 	#bigDisplay #downloadIcon:active {
 		background-color: rgba(0, 0, 0, 0.2);
 	}
 	
	
	#bigDisplay #formatNotice {
		display: none;
	}
 
	#bigDisplay #downloadIframe {
		display: none;
	}
	
</style>


<script>


 	$(document).ready(function() {
 	
 		setInterval(function() {
 		
 					$("[for=compactingVideosNumber]").html( website["data"]["downloads"]["pending"]["number"] );
 				
 					$("[for=compactingVideosDisplay]").html("");
 						
 					for(var i = 0; i < website["data"]["downloads"]["pending"]["number"]; i++) {
 						
 						var video = website["data"]["downloads"]["pending"]["details"][i];
 					
 						$("[for=compactingVideosDisplay]").append('<div class="option" pixel="' + video["pixel"] + '" downloadId="' + video["downloadId"] + '"> <video src="" autoplay></video> <div id="content"> <div id="pixelHolder"> <label id="pixel">' + video["pixel"] + 'px</label> </div> <div id="sizeHolder"> <label id="originalSize"><strike>' + video["originalSize"] + '</strike></label> <br> <label id="reducedSize">' + video["reducedSize"] + '</label> </div> </div>');
 						
 					}
 					
 					$("[for=compactedVideosNumber]").html( website["data"]["downloads"]["ready"]["number"] );
 				
 					$("[for=compactedVideosDisplay]").html("");
 						
 					for(var i = 0; i < website["data"]["downloads"]["ready"]["number"]; i++) {
 						
 						var video = website["data"]["downloads"]["ready"]["details"][i];
 					
 						$("[for=compactedVideosDisplay]").append('<div class="option" pixel="' + video["pixel"] + '" downloadId="' + video["downloadId"] + '"> <video src="" autoplay></video> <div id="content"> <div id="pixelHolder"> <label id="pixel">' + video["pixel"] + 'px</label> </div> <div id="sizeHolder"> <label id="originalSize"><strike>' + video["originalSize"] + '</strike></label> <br> <label id="reducedSize">' + video["reducedSize"] + '</label> </div> </div>');
 						
 					}
 					
 			$("[for=compactedVideosDisplay]").children(".option").click(function() {
 				
 				var downloadId = $(this).attr("downloadId");
 				
 				for(var i = 0; i < website["data"]["downloads"]["ready"]["number"]; i++) {
 					
 					if(website["data"]["downloads"]["ready"]["details"][i]["downloadId"] == downloadId) {
 						
 						video = website["data"]["downloads"]["ready"]["details"][i]
 					
 						website["templates"]["bigDisplay"].show('<label class="comment">Compacted <br> Your video has been compacted successfully and is ready for download</label> <label class="comment" id="formatNotice">Download in progress . . .<br> Please note that the compacted video you\'re downloading is in <em><b><?php echo $website["constants"]["compactedVideosExtension"]; ?></b></em> format can only be opened with the <?php echo $website["name"]; ?> app. If you don\'t have it, you can download it <a href="download-app" target="_blank">here</a></label> <br> <div id="videoDisplay"> <div class="option" pixel="' + video["pixel"] + '"> <video src="" autoplay></video> <div id="content"> <div id="pixelHolder"> <label id="pixel">' + video["pixel"] + 'px</label> </div> <div id="sizeHolder"> <label id="originalSize"><strike>' + video["originalSize"] + '</strike></label> <br> <label id="reducedSize">' + video["reducedSize"] + '</label> </div> </div> <br><br><br> <label class="comment" id="downloadIcon">&#5137;</label> <iframe id="downloadIframe"></iframe> </div>', video["name"]);
 						
 						$("#bigDisplay #downloadIcon").click(function() {
 						
 							$(this).hide();
 							
 							$("#formatNotice").show(100);
 							
 							$("#downloadIframe").attr("src", video["downloadLink"]);
 						
 						});
 						
 					}
 					
 				}
 			
 			});
 			
 			
 			$("[for=compactingVideosDisplay]").children(".option").click(function() {
 				
 				var downloadId = $(this).attr("downloadId");
 				
 				for(var i = 0; i < website["data"]["downloads"]["pending"]["number"]; i++) {
 					
 					if(website["data"]["downloads"]["pending"]["details"][i]["downloadId"] == downloadId) {
 						
 						video = website["data"]["downloads"]["pending"]["details"][i]
 					
 						website["templates"]["bigDisplay"].show('<label class="comment">Compacting . . . <br>Please be patient as your video is being compacted to one of a smaller size to save your data and memory. Once it\'s ready, it will appear below <em><b>Compacted videos</b></em> where you can download it.</label> <br> <div id="videoDisplay"> <div class="option" pixel="' + video["pixel"] + '"> <video src="" autoplay></video> <div id="content"> <div id="pixelHolder"> <label id="pixel">' + video["pixel"] + 'px</label> </div> <div id="sizeHolder"> <label id="originalSize"><strike>' + video["originalSize"] + '</strike></label> <br> <label id="reducedSize">' + video["reducedSize"] + '</label> </div> </div> </div>', video["name"]);
 						
 					}
 					
 				}
 			
 			});
 			
 		}, 1000);
 			
 	});
 			
 </script>


<div class="heading">

	<label id="text">Compacted videos</label>
	
	<div id="number" for="compactedVideosNumber" style="background-color: green;">0</div>
	
</div>

	<div id="videoDisplay" for="compactedVideosDisplay"></div>
	
	<br><br>

<div class="heading">
	
	<label id="text">Compacting videos</label>
	
	<div id="number" for="compactingVideosNumber">0</div>
	
</div>

	<div id="videoDisplay" for="compactingVideosDisplay"></div>
	