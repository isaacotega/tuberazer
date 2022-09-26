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
	
		<script src="<?php echo ($page["rootPath"]  . "scripts/js/main.js"); ?>"></script>
		
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<meta name="google-signin-client_id" content="142012018191-mceel3mfclt88dj08qdp68vguq2foc5p.apps.googleusercontent.com">
	
	</head>
	
	<body>
	
		<header>
			
			<span id="navIcon"></span>
      
			<label id="websiteName"><?php echo $website["name"]; ?></label>
      
			<label id="credits">
				
				<span class="coinHolder">
					
					<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle cx="11.998" cy="11.998" fill-rule="nonzero" r="9.998"/></svg>
				
					<label id="number" special="creditsNumber"></label>
				
				</span>
				
			</label>
      
		</header>
		
		
		
		<?php
	
			include_once($page["rootPath"] . "templates/big-display.php");
		
			include_once($page["rootPath"] . "templates/toast.php");

		?>