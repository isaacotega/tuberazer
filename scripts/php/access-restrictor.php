<?php
	
	if(isset($page["restriction"])) {
	
		include_once($page["rootPath"] . "backend/general-info.php");

		include_once($page["rootPath"] . "scripts/php/functions.php");

		$restriction = $page["restriction"];
	
		if(in_array("account", $restriction)) {
		
			($website["user"]["is"]["signedIn"] or die(redirect($page["rootPath"] . "welcome")));
		
		}
	
	}
	
?>