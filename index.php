<?php
	
	$page = array("rootPath" => "", "title" => "", "restriction" => array("account"));
	
	include_once($page["rootPath"] . "backend/general-info.php");
	
	include_once($page["rootPath"] . "scripts/php/access-restrictor.php");
		
	$page["title"] = $website["name"];
	
	include_once($page["rootPath"] . "templates/main-page.php");
	
 ?>