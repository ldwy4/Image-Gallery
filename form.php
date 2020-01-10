<?php
/*
Program: My first PHP website
Author: Liam Dwyer
Date: April, 25, 2018
Purpose: too learn to use PHP to serve dynamic sites
*/
session_start();

$nameFirstErr = $fileErr = $nameLastErr = $commentErr = $checkboxErr = $accessErr = $tagsErr = ""; //error messages for each section of form
$nameFirst = $nameLast = $comment = $checkbox = $access = $tags = ""; //saves info from each section of form
$isFilled = true; //checks that form is filled

//resets form info
if (isset($_POST["reset"])) {
    $nameFirst = $nameLast = $comment = $checkbox = $access = "";
    $isFilled = false;
}//if

//submits form info and image
if (isset($_POST["submit"])) {
    
    $imageFileType = strtolower(pathinfo("images/" . basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
    
	// checks if file is selected to upload
    if ($_FILES["fileToUpload"]['error'] != 0) {
        $fileErr = "* Image is required";
        $isFilled = false;
		
	// checks that file chosen is an image
    } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $fileErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $isFilled = false;
	
	// checks if file size is less than 4MB
    } else if ($_FILES["fileToUpload"]["size"] > 4000000) {
        $fileErr = "Sorry, your file is too large.";
        $isFilled = false;
    }//else if
    
    // Allow certain file formats
    
    //error checking for first name
    if (empty($_POST["firstname"])) {
        $nameFirstErr = "* Name is required";
        $isFilled = false;
    } else {
        $nameFirst = test_input($_POST["firstname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $nameFirst)) {
			$isFilled = false;
            $nameFirstErr = "* Only letters and white space allowed";
            $nameFirst = "";
        }//if
    }//else
    
	//checks if last name is filled
    if (empty($_POST["lastname"])) {
        $nameLastErr = "* Name is required";
        $isFilled = false;
    } else {
        $nameLast = test_input($_POST["lastname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $nameLast)) {
			$isFilled = false;
            $nameLastErr = "* Only letters and white space allowed";
            $nameLast = "";
        }//if
    }//else
    
	//checks if comment section is filled
    if (empty($_POST["comment"])) {
        $commentErr = "* Comments are required";
        $isFilled = false;
    } else {
        $comment = test_input($_POST["comment"]);
    }//else
    
	//checks if tags section is filled
    if (empty($_POST["tags"])) {
        $tagsErr = "* A tag is required";
        $isFilled = false;
    } else {
        $tags = test_input($_POST["tags"]);
    }//else
    
	//checks if checkbox is checked
    if (empty($_POST["copyright"])) {
        $checkboxErr = "* Checkbox is required";
        $isFilled = false;
    } else {
        $checkbox = test_input($_POST["copyright"]);
    }//else
    
	//checks if access/privacy if selected
    if (empty($_POST["access"])) {
        $accessErr = "* Access is required";
        $isFilled = false;
    } else {
        $access = test_input($_POST["access"]);
    }//else
}//if

// get page from URL
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "Upload";
}//else

$heading = "Image Gallery: " . $page;

/*-------Display HTML/CSS/JS-------*/
include "header.inc";
// show content of page
if (isset($_FILES["fileToUpload"]["error"]) && $_FILES["fileToUpload"]["error"] != 4) {
    if ($isFilled == true) {
        echo "	Form has been submitted";
        uploadImage();
        uploadFormData();
    } else {
        include "form.inc";
    }//else
} else {
    include "form.inc";
}//else
include "footer.inc";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}//test_input

//uploads form data to json file
function uploadFormData()
{
    array_splice($_POST, 3, 1);
    //$_POST["tags"] = explode(",", $_POST["tags"]);
    $file = "galleryinfo.json";
    $jsonarray = file($file);
    $jsonstring = "";
    foreach ($jsonarray as $line) {
        $jsonstring .= $line;
    }//foreach
    //decode the string from json to PHP array
    $phparray = json_decode($jsonstring, true);
    $phparray[] = $_POST;
    
    $jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
    
    file_put_contents($file, $jsoncode);
}//uploadFormData

//uploads image to images directory
function uploadImage()
{
    $target_dir = "images/";
    $file = "indentifier.txt";
    $number = file($file);
    $imageID = "";
    $UID = 0;
    foreach ($number as $line) {
        $imageID .= $line;
    }//foreach
    $UID = $imageID;
    $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
    $target_file = $target_dir . $UID . "." . $imageFileType;
    $_POST['UID'] = $UID;
    $_POST['fileName'] = $UID . "." . $imageFileType;
    $_POST['firstname'] = ucfirst(strtolower($_POST['firstname']));
    $_POST['lastname'] = ucfirst(strtolower($_POST['lastname']));
    $_POST['approved'] = false;
    $uploadOk = 1;
    
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            
            $uploadOk = 1;
        } else {
            $fileErr = "File is not an image.";
            $uploadOk = 0;
        }//else
    }//if
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            
            compress_image($target_file, "thumb/" . $UID . "." . $imageFileType, 50);
            $UID++;
        } else {
            
            $isFilled = false;
        }//else
    }//else
    file_put_contents($file, $UID);
}//uploadImage

//compresses the image and saves it as thumbnail
function compress_image($src, $dest, $quality)
{
    $info = getimagesize($src);
    
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($src);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($src);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($src);
    }
    imagejpeg($image, $dest, $quality);
}//compress_image
?>