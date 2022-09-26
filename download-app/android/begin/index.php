<?php
	
	$page = array("rootPath" => "../../../");
	
	
	header("Content-type: application/apk");
	
	header('Content-Disposition: attachment; filename="TubeRazer_YouTube Video Downloader.apk"');
	
	header('Content-Description: File Transfer');
	
	header('Content-Transfer-Encoding: binary');
	
	header('Expires: 0');
	
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	
	header('Pragma: public');
	
	ob_clean();
	
	flush();
	
	
	$downloadUrl = $page["rootPath"] . "contents/apps/android.apk";
	
	echo file_get_contents($downloadUrl);
	
	
	exit();
	
 ?>