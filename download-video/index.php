<?php
	
	require_once("../backend/connection.php");
	
	include_once("../backend/general-info.php");
	
	include_once("../backend/methods.php");
	
	
	$downloadId = $_GET["id"];
	
	
	$downloadDetails = downloadDetails($downloadId);
	
	
	if($downloadDetails["status"] == "ready") {
	
		$sql = "UPDATE downloads SET status = 'downloaded' WHERE download_id = '$downloadId' ";
			
		if(mysqli_query($conn, $sql)) {
		
		
		
		}
	
	}
	
	else if($downloadDetails["status"] == "downloaded") {
	
		// remove two credits
	
	}
	
	else {}
	
	
	header("Content-type: application/" . $website["constants"]["compactedVideosExtension"]);
	
//	header('Content-Disposition: attachment; filename="' . $name . '"');
	
	readfile("../files/compacted-videos/" . $downloadId . "." . $website["constants"]["compactedVideosExtension"]);
	
	die();
	
 ?>