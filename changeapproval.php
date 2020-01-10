<?php
	$file = "galleryinfo.json";
	$jsonarray = file($file);
	$jsonstring = "";
    foreach ($jsonarray as $line) {
     $jsonstring .= $line;
    }
	 //decode the string from json to PHP array
    $phparray = json_decode($jsonstring, true);
	
	for($x = 0; $x < count($phparray); $x++){
		if($phparray[$x]['approved'] == false){
			$phparray[$x]['approved'] = true;
		} 
	}
	$jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
	
	file_put_contents($file, $jsoncode);
	?>