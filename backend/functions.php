<?php
	
	require_once("connection.php");
	
	include_once("general-info.php");
	
	
	function relocate($url) {
	
		die('<script> document.location.replace("' . $url . '"); </script>');
	
	}
	
 ?>