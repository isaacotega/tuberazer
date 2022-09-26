<?php
	
	require_once("connection.php");
	
	function accountDetails($usercode) {
		
		global $conn, $page;
		
		$sql = "SELECT * FROM accounts WHERE usercode = '$usercode' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			$row = mysqli_fetch_array($result);
			
			$accountDetails = array();
			
			$accountDetails["is"] = array();
			
			$accountDetails["usercode"] = $row["usercode"];
		
			$accountDetails["username"] = $row["username"];
		
			$accountDetails["profilePicture"] = "images/avatar.jpg";
		
			$accountDetails["credits"] = $row["credits"];
		
			$accountDetails["socialAccountId"] = $row["social_account_id"];
		
			$accountDetails["dateRegistered"] = $row["date_registered"];
		
		
			$sql = "SELECT * FROM downloads WHERE downloader_usercode = '$usercode' ";
		
			if($result = mysqli_query($conn, $sql)) {
		
				$accountDetails["downloads"]["pending"] = array();
			
				$accountDetails["downloads"]["ready"] = array();
			
				$accountDetails["downloads"]["pending"]["number"] = 0;
					
				$accountDetails["downloads"]["ready"]["number"] = 0;
					
				$accountDetails["downloads"]["pending"]["ids"] = array();
					
				$accountDetails["downloads"]["ready"]["ids"] = array();
					
				while($row = mysqli_fetch_array($result)) {
					
					if($row["status"] == "pending") {
			
						$accountDetails["downloads"]["pending"]["number"]++;
						
						$accountDetails["downloads"]["pending"]["ids"][] = $row["download_id"];
					
					}
					
					if($row["status"] == "ready") {
			
						$accountDetails["downloads"]["ready"]["number"]++;
						
						$accountDetails["downloads"]["ready"]["ids"][] = $row["download_id"];
					
					}
					
				}
				
			}
			
			return $accountDetails;
	
		}
		
	}
	 
	
	function downloadDetails($downloadId) {
		
		global $conn, $page;
		
		$sql = "SELECT * FROM downloads WHERE download_id = '$downloadId' ";
		
		if($result = mysqli_query($conn, $sql)) {
		
			$row = mysqli_fetch_array($result);
			
			$downloadDetails = array();
			
			$downloadDetails["downloadId"] = $row["download_id"];
		
			$downloadDetails["url"] = $row["url"];
		
			$downloadDetails["downloaderUsercode"] = $row["downloader_usercode"];
		
			$downloadDetails["pixel"] = $row["pixel"];
		
			$downloadDetails["status"] = $row["status"];
		
			$downloadDetails["pixel"] = $row["pixel"];
		
			$downloadDetails["originalSize"] = $row["original_size"];
		
			$downloadDetails["reducedSize"] = $row["reduced_size"];
		
		
			$downloadDetails["name"] = "Name of video goes here";
		
			$downloadDetails["downloadLink"] = "download-video/?id=" . $row["download_id"];
		
			return $downloadDetails;
	
		}
		
	}
	
	function youtubeVideoInfo($video_id){
		
		$url = "https://www.youtube.com/youtubei/v1/player?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8";
		
		$url = "http://localhost:8080/test-receiver.txt";
		
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
			
			
			$data = array("status" => "success", "pixels" => $pixels, "videoId" => $video_id, "name" => $videoName);
			
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