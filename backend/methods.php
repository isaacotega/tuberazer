<?php
	
	require_once("connection.php");
	
	
	function youtubeVideoInfo($video_id){
		
		//normal 
		$url = "https://www.youtube.com/youtubei/v1/player?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8";
		
	// my key
	//	$url = "https://www.youtube.com/youtubei/v1/player?key=AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8";
		
		$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_POST, 1); curl_setopt($ch, CURLOPT_POSTFIELDS, '{ "context": { "client": { "hl": "en", "clientName": "WEB", "clientVersion": "2.20210721.00.00", "clientFormFactor": ";UNKNOWN_FORM_FACTOR", "clientScreen": "WATCH", "mainAppWebInfo": { "graftUrl": "/watch?v='.$video_id.'", } }, "user": { "lockedSafetyMode": false }, "request": { "useSsl": true, "internalExperimentFlags": [], "consistencyTokenJars": [] } }, "videoId": "'.$video_id.'", "playbackContext": { "contentPlaybackContext": { "vis": 0, "splay": false, "autoCaptionsDefaultOn": false, "autonavState": "STATE_NONE", "html5Preference": "HTML5_PREF_WANTS", "lactMilliseconds": "-1" } }, "racyCheckOk": false, "contentCheckOk": false}'); curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate'); $headers = array(); $headers[] = 'Content-Type: application/json'; curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); $result = curl_exec($ch);
		
		if (curl_errno($ch)) {
		
			$data = json_encode( array("status" => "error", "error" => curl_error($ch)));
			
			curl_close($ch); 
		
		}
		
		else {
		
			$rawInformation = json_decode($result, true);
			
			$pixels = array();
			
		//	echo json_encode( $rawInformation["streamingData"] );
			
			foreach( $rawInformation["streamingData"]["formats"] as $eachFormat) {

				$format = array();
	
				$format["pixel"] = substr($eachFormat["qualityLabel"], 0, (strlen($eachFormat["qualityLabel"]) - 1));

				$format["originalSize"] = 0;

				$format["reducedSize"] = ($format["originalSize"] / 6);

				$format["price"] = 1;
				
				$format["url"] = $eachFormat["url"];

				$pixels[] = $format;
	
			}
			
			$videoName = $rawInformation["videoDetails"]["title"];
			
			
			$data = array("status" => "success", "pixels" => $pixels, "videoId" => $video_id, "name" => $videoName, "rawInfo" => $rawInformation);
			
		}
		
		return $data;
		
	}

/*
	function icon($name, $type = "svg") {
		
		global $page;
	
		switch($type) {
		
			case "svg" :
			
				return file_get_contents($page["rootPath"] . "icons/" . $name . ".svg");
				
				break;
				
			case "image" :
			
				return file_get_contents($page["rootPath"] . "icons/" . $name . ".jpg");
				
				break;
				
			default :
			
				return file_get_contents($page["rootPath"] . "icons/" . $name . ".svg");
				
				
		}
	
	}
	*/
	function randomDigits($length) {
	
		$digits = "";						
						
		for($i = 0; $i < $length; $i++) {
						
			$digits .= rand(0, 9);
						
		}
		
		return $digits;
		
	}
					
 ?>