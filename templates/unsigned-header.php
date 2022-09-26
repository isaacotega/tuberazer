<?php
	
	include_once($page["rootPath"] . "backend/general-info.php");

?>

<!DOCTYPE html>

<html>

	<head>
  
		<title><?php echo ($page["title"] . " - " . $website["name"]); ?></title>
	
		<link rel="stylesheet" type="text/css" href="<?php echo $page["rootPath"]; ?>styles/index.css">
		
		<script>
		
			var page = JSON.parse('<?php echo json_encode($page); ?>');
		
		</script>

		<script src="<?php echo ($page["rootPath"]  . "scripts/js/JQuery.js"); ?>"></script>
	
		<script src="<?php echo ($page["rootPath"]  . "scripts/js/unsigned-main.js"); ?>"></script>
		
		<meta name="google-signin-client_id" content="142012018191-h9f2d8qmjlj5qvadef8ian1bj4k3nqh8.apps.googleusercontent.com">
	
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<script>
		
 	function onSignIn(googleUser) {
//alert(googleUser.getAuthResponse().id_token);
 	
 		loader.show();
 
 	
		var idToken = googleUser.getAuthResponse().id_token;

 		var profile = googleUser.getBasicProfile();
 		
 		//console.log('ID: ' + profile.getId());
 		
 		$.ajax({
 			type: "POST",
 			url: "../backend/ajax-handler.php",
 			data: {
 				request: "login",
 				type: "google",
 				idToken: idToken,
 				name: profile.getName(),
 				imageUrl: profile.getImageUrl(),
 				email: profile.getEmail()
 			},
 			success: function(response) {
 			
 				alert(JSON.stringify(response));
 				
 				window.location.href = "../";
 			
 			},
 			error: function(response) {
 			
 				alert(JSON.stringify(response));
 			
 			},
 			cache: false
 		});
 		
 	}
 	
 		</script>
		
	</head>
	
	<body>

		<header>
			
			<span id="navIcon"></span>
      
			<label id="websiteName"><?php echo $website["name"]; ?></label>
      
		</header>
		
	<div id="loader">
	
		<div id="background"></div>
		
		<div id="roller"></div>
	
	</div>

		