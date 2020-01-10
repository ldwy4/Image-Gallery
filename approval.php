<?php
/*
Program: My first PHP website
Author: Liam Dwyer
Date: April, 25, 2018
Purpose: too learn to use PHP to serve dynamic sites
*/
session_start();

$_SESSION["isEditor"] = true;
$isEditor = $_SESSION["isEditor"];

// get page from URL
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "Approval";
}//else

$heading = "Image Gallery: " . $page;

/*-------Display HTML/CSS/JS-------*/
include "header.inc";
if ($isEditor == true) {
    include "approval.inc";
    
    // show content of page
    echo "<br>";
    
    // read json file into array of strings
    $file = "galleryinfo.json";
    $filearray = file($file);
    
    // create one string from the file
    $jsonstring = "";
    foreach ($filearray as $line) {
        $jsonstring .= $line;
    }//foreach
    
    //decode the string from json to PHP array
    $phparray = json_decode($jsonstring, true);
	
	// saves original copy of array
	$phparrayog = json_decode($jsonstring, true);

	//sorts array by last name
	if (isset($_POST["sortlast"])) {
		usort($phparray, "sort_by_last");
	}//if
	//sorts array by first name
	if (isset($_POST["sortfirst"])) {
		usort($phparray, "sort_by_first");
	}//if
	//sorts array by date uploaded
	if (isset($_POST["sortdate"])) {
		$phparray = $phparrayog;
	}//if
    
	//approves the selected images
    if (isset($_POST['approve'])) {
        if (isset($_POST['file']) && is_array($_POST['file'])) {
            foreach ($_POST['file'] as $filename) {
                for ($x = 0; $x < count($phparray); $x++) {
                    if ($filename == $phparray[$x]['fileName']) {
                        echo '<script>';
                        echo 'console.log(' . json_encode($phparray[$x]['fileName']) . ')';
                        echo '</script>';
                        $phparray[$x]['approved'] = true;
                    }//if
                }//for
            }//foreach
            $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
            
            file_put_contents("galleryinfo.json", $jsoncode);
        }//if
    }//if
	
	//deletes the selected images
    if (isset($_POST['delete'])) {
        if (isset($_POST['file']) && is_array($_POST['file'])) {
            foreach ($_POST['file'] as $file) {
                if (isset($file)) {
                    echo '<script>';
                    echo 'console.log(' . json_encode($file) . ')';
                    echo '</script>';
                    unlink("thumb" . "/" . $file);
                    unlink("images" . "/" . $file);
                    echo $file;
                    $y = 0;
                    for ($y = 0; $y < count($phparray); $y++) {
                        if ($file == $phparray[$y]['fileName']) {
                            $index = array_search($y, array_keys($phparray));
                            echo '<script>';
                            echo 'console.log(' . json_encode($index) . ')';
                            echo '</script>';
                            unset($phparray[$index]);
                            $phparray = array_values($phparray);
                        }//if
                    }//for
                }//if
            }//foreach
            $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
            file_put_contents("galleryinfo.json", $jsoncode);
        }//if
    }//if
    
    $notapproved = 0; // number of images that are not approved
	
	//displays images that are not approved
    for ($x = 0; $x < count($phparray); $x++) {
        if ($phparray[$x]['approved'] == false) {
            echo '<a id="a' . $phparray[$x]['fileName'] . '" data-fancybox="gallery" href="images/' . $phparray[$x]['fileName'] . '"><img id="i' . $phparray[$x]['fileName'] . '" class="thumb" src="thumb/' . $phparray[$x]['fileName'] . '" alt="' . $phparray[$x]['fileName'] . '"/></a>';
            echo '<input type="checkbox" name="file[]" value="' . $phparray[$x]['fileName'] . '">';
            $notapproved++;
        }//if
    }//for
    
	//if there are no images to approve, displays message
    if ($notapproved == 0) {
        echo "All images have been approved";
    }//if
    echo '</form>';
	echo '</div>';
   
// if user is not editor, displays message   
} else {
    echo "Please Log in to access this page";
}//else

//sort photos by last name
function sort_by_last($a, $b)
{
    if ($a['lastname'] == $b['lastname']) {
        return 0;
    } // if
    return ($a['lastname'] < $b['lastname']) ? -1 : 1;
} // sort_by_last

//sort photos by first name
function sort_by_first($a, $b)
{
    if ($a['firstname'] == $b['firstname']) {
        return 0;
    } // if
    return ($a['firstname'] < $b['firstname']) ? -1 : 1;
} // sort_by_last

include "footer.inc";

?>