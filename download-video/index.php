<?php
	
	$page = array("rootPath" => "../");
	
	
	$url = $_GET["url"];
	
	$name = $_GET["name"];
	
	$pixel = $_GET["pixel"];
	
	
	header("Content-type: video/mp4");
	
	header('Content-Disposition: attachment; filename="' . $name . '"');
	
	header('Content-Description: File Transfer');
	
	header('Content-Transfer-Encoding: binary');
	
	header('Expires: 0');
	
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	
	header('Pragma: public');
	
	ob_clean();
	
	flush();
	
	
	echo file_get_contents($url);
	
	
	exit();
	
 ?>