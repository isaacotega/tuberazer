<?php
	//   	https://youtube.com/watch/12345
	//temporary login
	
	
				//	setcookie("supertubeAccountCookieCode",  "54873482272942294518", time() + (86400 * 30), "/");
		
	
	date_default_timezone_set("Africa/Lagos");
	
	$date = date("Y m d");
	
	$time = date("h:i");
	
	require_once("connection.php");
	
//	include_once("functions.php");
	
	$website = array(
		"name"=> "TubeRazer",
		"description" => "Super fast youtube downloader",
		"url" => array(
			"scheme" => "https://",
			"domain" => "tuberazer",
			"extension" => ".com"
		),
		"email" => array(
		/*	"headers" => "From: mail@theshowglass.com \r\n To: [receiversMail] \r\n MIME-Version: 1.0\r\n Content-Type: text/html; charset=ISO-8859-1\r\n",
			"sender" => "mail@theshowglass.com",
			"maximumSendsNo" => array(
				"emailConfirmation" => 3
			)*/
		),
		"cookies" => array(
			"account" => array(
				"name" => "supertubeAccountCookieCode",
				"lifetime" => 30
			)
		),
		"user" => array(),
		"constants" => array(
			"compactedVideosExtension" => "spt"
		)
	);
	
	$user = array(
		"account" => array(
			
		),
		"is" => array(
			"signedIn" => isset($_COOKIE[$website["cookies"]["account"]["name"]])
		)
	);
	
	if($user["is"]["signedIn"]) {
	
		$sql = "SELECT * FROM accounts WHERE cookie_code = '" . mysqli_real_escape_string($conn, $_COOKIE[$website["cookies"]["account"]["name"]]) . "' ";
		
		if($result = mysqli_query($conn, $sql)) {
			
			(mysqli_num_rows($result) > 0) or die( setcookie($website["cookies"]["account"]["name"], "", time() - 1, "/") );
		
			$row = mysqli_fetch_array($result);
			
			$user["account"]["usercode"] = $row["usercode"];
			
		}
		
	}
	
	$website["user"] = $user;
	
 ?>