<?php
	
	$page = array("rootPath" => "../../");
	
	include_once($page["rootPath"] . "backend/general-info.php");
	
 ?>
 
 
 <style>
 
 	#profilePictureHolder {
 	
 	}
 	
 	#profilePictureHolder #profilePicture {
 		border-radius: 50%;
 		height: 5cm;
 		width: 5cm;
 		margin: 5mm;
 	}
 	
 	#profilePictureHolder #username {
 		font-size: 40px;
 		display: inline-block;
 		color: white;
 		line-height: 5cm;
 		transform: translateY(-2.5cm);
 	}
 	
 	#creditsHolder {
 		color: white;
 		font-size: 40px;
 		display: inline-block;
 		color: white;
 		margin: 5mm;
 	}
 	
 </style>
 
 
 <script>
 	
 	$(document).ready(function() {
 	
 		$("#username").html(website["data"]["accountDetails"]["username"]);
 	
 		$("#profilePicture").attr("src", website["data"]["accountDetails"]["profilePicture"]);
 		
 		$("#creditsHolder #rechargeButton").click(function() {
 		
 			website["templates"]["bigDisplay"].show('<label class="comment">Recharging of credits is done at a flat rate. <br>$1 - 50 credits</label> <br><br><br> <button id="proceedButton" class="bigButton">Proceed</button>', "Recharge Credits");
 		
 			$("#proceedButton").click(function() {
 			
 				website["templates"]["bigDisplay"].show('<label class="comment">Loading . . .</label>', "Recharge Credits");
 				
 				$.ajax({
 					url: "templates/card-payment-gateway.php",
 					success: function(response) {
 						
 						website["templates"]["bigDisplay"].show('<label class="comment">Amount: $1 <br> For: Purchase of 50 credits <br><br>Enter card details</label> <br><br><br> ' + response, "Recharge Credits");
 		
 					}
 				});
 			
 			});
 	
 		});
 		
 	});
 	
 </script>
 
 
 <div id="profilePictureHolder">
 
	 <img id="profilePicture"></img>
 
	 <label id="username"></label>
	 
</div>
 
 <br>
 
 <div id="creditsHolder">
 
	<span id="icon">C</span>
				
	<label id="number" special="creditsNumber"></label>
	
	<label id="statement"> credits</label>
	
	<br><br>
	
	<button id="rechargeButton" class="bigButton">Recharge</button>
	
</div>


 <br>
 
 <div id="linkedAccountsHolder">
 
 	<div id="facebook" class="accountDisplay">
 	
 		
 	
 	</div>
 
 </div>
 
 