<?php
	
	include_once($page["rootPath"] . "templates/header.php");
	
?>

<div id="body">
	
	<div class="page" page="home"></div>

	<div class="page" page="youtube"></div>

	<div class="page" page="me"></div>

	<div class="page" page="cinema"></div>

	<div id="loader">
	
		<div id="background"></div>
		
		<div id="roller"></div>
	
	</div>

</div>

<?php
	
	include($page["rootPath"] . "templates/footer.php");
	
?>