<?php
	
	require_once("connection.php");
	
	include_once("general-info.php");
	
	include_once("methods.php");
	
	include_once("functions.php");
	
	
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
	
	
	if($request == "websiteData") {
		
		$pendingDownloadsNumber = accountDetails($website["user"]["account"]["usercode"])["downloads"]["pending"]["number"];
	
		$readyDownloadsNumber = accountDetails($website["user"]["account"]["usercode"])["downloads"]["ready"]["number"];
	
		$pendingDownloadsIds = accountDetails($website["user"]["account"]["usercode"])["downloads"]["pending"]["ids"];
	
		$readyDownloadsIds = accountDetails($website["user"]["account"]["usercode"])["downloads"]["ready"]["ids"];
		
		$accountDetails = accountDetails($website["user"]["account"]["usercode"]);
	
		$data = array(
			"downloads" => array(
				"pending" => array("details" => array(), "number" => $pendingDownloadsNumber),
				"ready" => array("details" => array(), "number" => $readyDownloadsNumber)
			),
			"accountDetails" => $accountDetails
		);
			
			foreach($pendingDownloadsIds as $eachId) {
				
				$data["downloads"]["pending"]["details"][] = downloadDetails($eachId);
			
			}
			
			foreach($readyDownloadsIds as $eachId) {
				
				$data["downloads"]["ready"]["details"][] = downloadDetails($eachId);
			
			}
			
		
		echo json_encode($data);
	
	}
	
	if($request == "youtubeVideos") {
	
		$data = array(
			
			"videos" => array(
			
			array(
				"name" => "Name of video"
			),
			array(
				"name" => "Name of video"
			),array(
				"name" => "Name of video"
			),array(
				"name" => "Name of video"
			),
			
			)
		);
		
		echo json_encode($data);
	
	}
	
	if($request == "login") {
	
		$type = $_POST["type"];
		
		
		$idToken = mysqli_real_escape_string($conn, $_POST["idToken"]);
		
		$name = mysqli_real_escape_string($conn, $_POST["name"]);
		
		$username = strtolower(str_replace(" ", "", $name));
		
		
		$usercode = mysqli_real_escape_string($conn, randomDigits(20));
		
		$cookieCode = mysqli_real_escape_string($conn, randomDigits(20));
		
		
		// check if user is registered
		
			$sql = "SELECT * FROM accounts WHERE type = '$type' AND social_account_id = '$idToken' ";
			
			if($result = mysqli_query($conn, $sql)) {
			
				if(mysqli_num_rows($result) == 0) {
				
					$isRegistered = false;
				
				}
				
				else {
				
					$isRegistered = true;
					
					$row = mysqli_fetch_aray($result);
					
					$registeredCookieCode = $row["cookie_code"];
				
				}
			
			}
			
		
		
		if($type == "google") {
		
			$imageUrl = mysqli_real_escape_string($conn, $_POST["imageUrl"]);
		
			$email = mysqli_real_escape_string($conn, $_POST["email"]);
			
			
			$registrationSql = "INSERT INTO accounts (usercode, username, cookie_code, type, social_account_id, date_registered) VALUES ('$usercode', '$username', '$cookieCode', '$type', '$idToken', '$date') ";
		
		
		}
		
		else if($type == "facebook") {
		
			$registrationSql = "INSERT INTO accounts (usercode, username, cookie_code, type, social_account_id, date_registered) VALUES ('$usercode', '$username', '$cookieCode', '$type', '$idToken', '$date') ";
		
		}
		
		else {}
		
		
		
		if($isRegistered) {
		
			setcookie("supertubeAccountCookieCode",  $registeredCookieCode, time() + (86400 * 30), "/");
		
			$data = array("status" => "success");
				
		}
		
		else {
		
			if(mysqli_query($conn, $registrationSql)) {
			
				$data = array("status" => "success");
				
				setcookie("supertubeAccountCookieCode",  $cookieCode, time() + (86400 * 30), "/");
		
			}
		
			else {
		
				$data = array("status" => "error", "error" => mysqli_error($conn));
	
			}
			
		}
		
		
		echo json_encode($data);
	
	}
	
	
 ?>