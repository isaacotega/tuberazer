<?php

	$uniqueCharacter = "^";
	
	$uniqueCharacter2 = "~";
	
	$squeezedExtension = "sfd";
	
	
//	squeeze("original.txt");
	
	stretch("original.txt.sfd");
	
	function squeeze($filename) {
		
		global $uniqueCharacter, $uniqueCharacter2, $squeezedExtension;

//		$originalFile = file_get_contents($filename);
	
		$originalFile = substr(file_get_contents($filename), 0, 1000);
	
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
		
		
		
		$newFilename = $filename . "." . $squeezedExtension;
		
		file_put_contents(($newFilename), $newFile);
		
	}
	
	
	function stretch($filename) {
		
		global $uniqueCharacter, $uniqueCharacter2, $squeezedExtension;

		$squeezedFile = file_get_contents($filename);
	
		$newFile = "";
	
	
		$originalStringNumber = strlen($squeezedFile);

	// 	-1 to prevent string offset error 
	
		for($i = 0; $i < $originalStringNumber - 1; $i++) {
	
			$currentCharacter = $squeezedFile[$i];
		
			$nextCharacter = $squeezedFile[($i + 1)];
		
			$remainingStringNumber = ($originalStringNumber - ($i + 1));
		
		
			if($currentCharacter !== $uniqueCharacter) {

				$newFile .= $currentCharacter;
			
			}
			// got first cover
			else {
			
		
				 for($i2 = 0; $i2 < $remainingStringNumber; $i2++) {
			 		
			 		$currentCharacter2 = $squeezedFile[($i + $i2 + 1)];
			 		
			 		
			 		if($currentCharacter2 == $uniqueCharacter2) {
				 		
				 		$dividingCharacterIndex = ($i + $i2);
				 		
				 	}
			 		
			 		
			 		// finding second cover
			 		
				 	if($currentCharacter2 == $uniqueCharacter) {
				 		
				 		$index1 = $i;
				 		
			 			$index2 = ($i + $i2 + 1);
			 		
			 		
			 			$multipleCharacter = $squeezedFile[($index2 - 1)];
			 			
			 			// I think there should be a -1 but it works well without it
			 		
			 			$number = substr($squeezedFile, ($index1 + 1), ($dividingCharacterIndex - $index1/* - 1*/));
			 			
			 			for($i3 = 0; $i3 < $number; $i3++) {
			 			
			 				$newFile .= $multipleCharacter;
			 				
			 			}
			 			
			 			
			 			// fastforward first iteration
			 			
			 			$i += ($index2 - $index1);
			 			
				 		break;
			 	
				 	}
			 	
				}
			
			}
			
		}
		
		$newFilename = ("Stretched-" . substr($filename, 0, (strlen($filename) - 4)));
		
		file_put_contents(($newFilename), $newFile);
				
	}
	
	

?>