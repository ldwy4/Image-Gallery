<?php


session_start();
$_SESSION["isEditor"] = true;
$isEditor = $_SESSION["isEditor"];
$dirname = "images/";
$images = array_slice(scandir($dirname), 2);
// read json file into array of strings
$file = "galleryinfo.json";
$filearray = file($file);
$display = "";
// create one string from the file
$jsonstring = "";
foreach ($filearray as $line) {
    $jsonstring .= $line;
}//foreach

// converts string to php array
$phparray = json_decode($jsonstring, true);

//saves the original order of the php array
$phparrayog = json_decode($jsonstring, true);

//creates zip file and downloads it
if (isset($_POST['download'])) {
    $zip = new ZipArchive();
    $filename = "./images.zip";
    
    if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
        exit("cannot open <$filename>\n");
    }//if
    foreach ($images as $image) {
        $zip->addFile($dirname . $image, $image);
    }//foreach
    /*echo "numfiles: " . $zip->numFiles . "\n";
    echo "status:" . $zip->status . "\n";
    */
    $zip->close();
    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=" . $filename);
    header("Content-length: " . filesize($filename));
    header("Expires: 0");
    readfile($filename);
    unlink($filename);
    die;
}//if

if (isset($_POST["display"])) {

	$display = ($_POST["display"]);

}//if

//submits the edited info and overwrites json info
if (isset($_POST["complete"])) {
	$phparray = json_decode($jsonstring, true);
    for ($x = 0; $x < count($phparray); $x++) {
        if ($phparray[$x]['approved'] == true) {
			//changes name to entered name if it is not empty
            if ($_POST['modname' . $phparray[$x]['UID']] != "") {
                $names = explode(" ", $_POST['modname' . $phparray[$x]['UID']]);
                $phparray[$x]['firstname'] = ucfirst(strtolower($names[0]));
                $phparray[$x]['lastname'] = ucfirst(strtolower($names[1]));
            }//if
			//changes description to entered description if it is not empty
            if ($_POST['moddesc' . $phparray[$x]['UID']] != "") {
                $phparray[$x]['comment'] = $_POST['moddesc' . $phparray[$x]['UID']];
            }//if
			//changes tags to entered tags if it is not empty
            if ($_POST['modtags' . $phparray[$x]['UID']] != "") {
                $phparray[$x]['tags'] = $_POST['modtags' . $phparray[$x]['UID']];
            }//if
        }//if
    }//for

    // encode the php array to formatted json
    $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
    
    // write the json to the file
    file_put_contents($file, $jsoncode);
}//if

//cycles through all the checked images and deletes them
if (isset($_POST["delete"])) {
	if (isset($_POST['file']) && is_array($_POST['file'])) {
		foreach ($_POST['file'] as $file) {
			if (isset($file)) {
				unlink("thumb" . "/" . $file);
				unlink("images" . "/" . $file);
				echo $file;
				$y = 0;
				for ($y = 0; $y < count($phparray); $y++) {
					if ($file == $phparray[$y]['fileName']) {
						$index = array_search($y, array_keys($phparray));
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

// get page from URL
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "home";
}//else

$heading = "Image Gallery: Editor";

include "header.inc";
include "moderator.inc";
echo "<br>";

//sorts array by first name
if (isset($_POST["sortlast"])) {
    usort($phparray, "sort_by_last");
}//if

//sorts array by last name
if (isset($_POST["sortfirst"])) {
    usort($phparray, "sort_by_first");
}//if

//sorts array by date uploaded
if (isset($_POST["sortdate"])) {
    $phparray = $phparrayog;
}//if

echo '<div class="container-fluid">';

//displays all approved images
for ($x = 0; $x < count($phparray); $x++) {
    if ($phparray[$x]['approved'] == true) {
        $description = $phparray[$x]['firstname'] . " " . $phparray[$x]['lastname'] . " | " . $phparray[$x]['comment'];
        
		//container for image and image info
        echo '<div id="d' . $phparray[$x]['UID'] . '" class="editor-grid" >';
		
		//displays image
        echo '<div class ="col-sm-4">';
        echo '<div class="edit-photo-container">';
        echo '<a id="a' . $phparray[$x]['UID'] . '" data-fancybox="gallery" data-caption="' . $description . '" href="images/' . $phparray[$x]['fileName'] . '"><img id="i' . $phparray[$x]['UID'] . '" class="thumb edit-photo" src="thumb/' . $phparray[$x]['fileName'] . '" alt="' . $phparray[$x]['UID'] . '"/></a>';
        echo '<div style="z-index:5;margin:5px;font-size:14px;" class="pretty p-icon p-curve p-tada"><input type="checkbox" id="c' . $phparray[$x]['UID'] . '" name="file[]" value="' . $phparray[$x]['fileName'] . '"> <div class="state p-primary-o"><i class="icon glyphicon glyphicon-ok"></i><label></label>
        </div></div>';
        echo '</div>';
        echo '</div>';
		
		//contains info about image that can be edited
        echo '<div class ="col-sm-8">';
        echo "<br><div class='form-group form-group-lg'><label class='col-sm-2 control-label' for='n".$phparray[$x]['UID']."'>Name:</label> <div class='col-sm-10'><input type='text' name='modname" . $phparray[$x]['UID'] . "' id='n".$phparray[$x]['UID']."' class='form-control'  value='" . $phparray[$x]['firstname'] . " " . $phparray[$x]['lastname'] . "'></div></div>\n";
        echo "<br><br><div class='form-group form-group-lg'><label class='col-sm-2 control-label' for='desc".$phparray[$x]['UID']."'>Description:</label><div class='col-sm-10'><input type='text' name='moddesc" . $phparray[$x]['UID'] . "' id='desc".$phparray[$x]['UID']."' class='form-control' value='" . $phparray[$x]['comment'] . "'></div></div>\n";
        
        echo "<br><br><div class='form-group form-group-lg'><label class='col-sm-2 control-label' for='tag".$phparray[$x]['UID']."'>Tags:</label><div class='col-sm-10'><input type='text' name='modtags" . $phparray[$x]['UID'] . "' id='tag".$phparray[$x]['UID']."' class='form-control' value='" . $phparray[$x]['tags'] . "'></div></div>\n<br>";
        echo '</div>';
        echo '</div>';
        //}//if
    }//if
} //for
echo '</form>';
echo '</div>';

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