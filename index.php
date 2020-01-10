<?php
session_start();
$_SESSION["isEditor"] = false;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "Home";
}//else

//changes heading of the website
$heading = "Image Gallery: " . $page;


include "header.inc";
include "lightbox.inc";
echo "<br>";

// read json file into array of strings
$file = "galleryinfo.json";
$filearray = file($file);

// create one string from the file
$jsonstring = "";
foreach ($filearray as $line) {
    $jsonstring .= $line;
}//foreach

// converts string to php array
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

//cycles through array and displays approved, public images
for ($x = 0; $x < count($phparray); $x++) {
    $description = $phparray[$x]['firstname'] . " " . $phparray[$x]['lastname'] . " | " . $phparray[$x]['comment'];
    if ($phparray[$x]['access'] == "public" && $phparray[$x]['approved'] == true) {
        echo '<a id="a' . $phparray[$x]['UID'] . '" data-fancybox="gallery" data-caption="' . $description . '" href="images/' . $phparray[$x]['fileName'] . '"><img alt="gallery photo" id="i' . $phparray[$x]['UID'] . '" class="thumb" src="thumb/' . $phparray[$x]['fileName'] . '" /></a>';
    }//if
}//for

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
