<?php
	
	require_once("connection.php");
	
	include_once("general-info.php");
	
	include_once("functions.php");
	
	include_once("methods.php");
	
	
	$request = $_POST["request"];
	
	
	if($request == "videoFormats") {
	
		$videoId = $_POST["videoId"];
		
		$data = youtubeVideoInfo($videoId);
	
	/* 185.209.228.204
		$data = file_get_contents("http://ovolisky.com.ng/yd5.php?video_id=" . $videoId);
						*/
		echo json_encode($data);
	
	}
	
	if($request == "downloadVideo") {
	
		$videoId = mysqli_real_escape_string($conn, $_POST["videoId"]);
		
		$videoName = mysqli_real_escape_string($conn, $_POST["videoName"]);
		
		$url = mysqli_real_escape_string($conn, $_POST["url"]);
		
		$pixel = mysqli_real_escape_string($conn, $_POST["pixel"]);
		
		$originalSize = mysqli_real_escape_string($conn, $_POST["originalSize"]);
		
		$reducedSize = mysqli_real_escape_string($conn, $_POST["reducedSize"]);
		
		
		$downloadId = mysqli_real_escape_string($conn, randomDigits(20));
		
		$downloaderUsercode = mysqli_real_escape_string($conn, $website["user"]["account"]["usercode"]);
		
		$status = "pending";
		
		$sql = "INSERT INTO downloads (download_id, url, downloader_usercode, pixel, status, original_size, reduced_size, date_downloaded, time_downloaded) VALUES ('$downloadId', '$url', '$downloaderUsercode', '$pixel', '$status', '$originalSize', '$reducedSize', '$date', '$time') ";
		
		if(mysqli_query($conn, $sql)) {
			
			$originalVideoPath = ("../videos/original/" . $videoId . ".mp4");
			
			if(file_put_contents($originalVideoPath, file_get_contents($url))) {
				
				deductCredits(2);
		
				if(squeeze($originalVideoPath, ($videoName . "_" . $pixel . "px" . "_" . $website["url"]["domain"] . $website["url"]["extension"]))) {
			
					$data = array("status" => "success");
					
				}
				
			}
		
		}
		
		else {
		
			$data = array("status" => "error", "error" => mysqli_error($conn));
	
		}
		
		
		echo json_encode($data);
	
	}
	
	
 ?>