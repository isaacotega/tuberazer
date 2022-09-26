<?php
	
	require_once("connection.php");
	
	include_once("general-info.php");
	
	include_once("methods.php");
	
	
	function deductCredits($amount) {
		
		global $conn, $website;
		
		$amount = mysqli_real_escape_string($conn, $amount);
	
		$usercode = mysqli_real_escape_string($conn, $website["user"]["account"]["usercode"]);
	
		$sql = "UPDATE accounts SET credits = (credits - $amount) WHERE usercode = '$usercode' ";
		
		if(mysqli_query($conn, $sql)) {
		
			return true;
		
		}
		
		else {
		
			return false;
		
		}
	
	}
	
	
	function squeeze($filename, $finalName) {
		
		$uniqueCharacter = "^";
	
		$uniqueCharacter2 = "~";
	
		$squeezedExtension = "trz";
	
		$originalFile = file_get_contents($filename);
	
	//	$originalFile = substr(file_get_contents($filename), 0, 1000);
	
//		echo $originalFile;
	
		$newFile = "";
	
	
		$originalStringNumber = strlen($originalFile);
	
	// 	-1 to prevent string offset error 
	
		for($i = 0; $i < $originalStringNumber - 1; $i++) {
	
//		echo $i;
		
			$currentCharacter = $originalFile[$i];
		
			$nextCharacter = $originalFile[($i + 1)];
		
			$remainingStringNumber = ($originalStringNumber - ($i - 1));
		
		
		
			if($currentCharacter != $nextCharacter) {
	
				$newFile .= $currentCharacter;
			
			}
		
			else {
		
				$newFile .= $uniqueCharacter;
		
			
				 for($i2 = 0; $i2 < $remainingStringNumber; $i2++) {
			 
			 		$currentCharacter2 = $originalFile[($i + $i2 + 1)];
			 	
				 	if($currentCharacter2 == $currentCharacter) {
			 	
				 	}
			 	
			 		else {
			 		
			 			// dont know exactly why but i need to add 1 to make it work well
			 	
						$newFile .= ($i2 + 1);
		
						$newFile .= $uniqueCharacter2;
		
						$i = ($i + $i2);
		
			 			break;
			 	
				 	}
			 
				 }
			 
				 $newFile .= $currentCharacter;
			 
		
				$newFile .= $uniqueCharacter;
		
			}
		
	
		}
		
		
		
		$newFilename = "../videos/compacted/" . $finalName . "." . $squeezedExtension;
		
		if(file_put_contents(($newFilename), $newFile)) {
		
			return true;
		
		}
		
		else {
			
			return false;
		
		}
		
	}
	
 ?>