<?php
	
	$page = array("rootPath" => "../", "title" => "Login");
	
	include_once($page["rootPath"] . "templates/unsigned-header.php");
	
	include_once($page["rootPath"] . "backend/general-info.php");

?>

		<div id="fb-root"></div> <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v15.0&appId=627634718537567&autoLogAppEvents=1" nonce="yaIxmbMX"></script>


 <script>
 
	function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus(). 
	
 		if (response.status === 'connected') { // Logged into your webpage and Facebook.
 		
 			testAPI();
 		
 		}
 	
 		else { // Not logged into your webpage or we are unable to tell. 
 	
 		//	alert = 'Please log ' + 'into this webpage.';
 
		}
		
	}
	
	function checkLoginState() { // Called when a person is finished with the Login Button.
		
		FB.getLoginStatus(function(response) { // See the onlogin handler
			
			statusChangeCallback(response);
		
		});
		
	}
	
	window.fbAsyncInit = function() {
		
		FB.init({
			appId : '627634718537567',
			cookie : true, // Enable cookies to allow the server to access the session.
			xfbml : true, // Parse social plugins on this webpage.
			version : 'v15.0' // Use this Graph API version for this call.
		});
		
		FB.getLoginStatus(function(response) { // Called after the JS SDK has been initialized.
		
			statusChangeCallback(response); // Returns the login status.
			
		});
		
	}; 
 		
 	function testAPI() { // Testing Graph API after login. See statusChangeCallback() for when this call is made.
 		
 		loader.show();
 		
 		FB.api('/me', function(response) {
 			
 		$.ajax({
 			type: "POST",
 			url: "../backend/ajax-handler.php",
 			data: {
 				request: "login",
 				type: "facebook",
 				idToken: response["id"],
 				name: response["name"]
 			},
 			success: function(response) {
 			
 			//	alert(JSON.stringify(response));
 				// no array comes from the request when user tries to login (dont know why)
 		//		if(response["status"] == "success") {
 				
 					window.location.href = "../";
 				
 		//		}
 			
 			},
 			error: function(response) {
 			
 	//			alert("Error " + JSON.stringify(response));
 			
 			},
 			cache: false
 		});
 			
 		});
 			
 	}
 
 </script>
 
 <br><br><br><br><br><br>
 
 
<div class="centerHolder">

	<div class="g-signin2" data-onsuccess="onSignIn" data-width="00" data-height="100" data-longtitle="true"></div>

	<br>

	<div class="fb-login-button" data-width="00" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true"></div>
</div>

<br>
 <!--
 <a href="#" onclick="signOut();">Sign out</a> <script> function signOut() { var auth2 = gapi.auth2.getAuthInstance(); auth2.signOut().then(function () { alert('User signed out.'); }); } </script>
 
 <button onclick="FB.logout(function(response) { window.location.href = ""; });">fbLogout</button>
 -->