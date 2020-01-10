<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo $heading ;?></title>
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
      <link rel="stylesheet" href="fancybox/jquery.fancybox.css" />
      <!-- Latest compiled and minified CSS -->
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

	  <!-- jQuery library -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	  <!-- Popper JS -->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

	  <!-- Latest compiled JavaScript -->
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
      <script src="fancybox/jquery.fancybox.js"></script>
      <script src="lightbox.js"></script>	
   </head>
   <body>
      <nav class="navbar navbar-inverse navbar-fixed-top">
         <div class="container-fluid">
            <div class="navbar-header">
               <a href="index.php" class="navbar-brand">
               <span class="nav"><span class="glyphicon glyphicon-picture"></span> Image Gallery</span></a>
            </div>
            <ul style="width:35%;margin-right:5px;" class="nav navbar-nav navbar-right">
               <li class="dropdown" >
                  <a class="dropdown-toggle" data-toggle="dropdown" style="font-size:15px;color:white;">
                  <span class="glyphicon glyphicon-sort"></span> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                     <form  name = "sortlast" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <li class="sorts" ><input type="submit" class="sorts" name="sortdate" value="sortdate"></li>
                        <li class="sorts" ><input type="submit" class="sorts" name="sortfirst" value="sortfirst"></li>
                        <li class="sorts" ><input type="submit" class="sorts" name="sortlast" value="sortlast"></li>
                     </form>
                  </ul>
               </li>
               <form style="margin-top:6px;" id="searchbar" oninput="searching()" name="searchbar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                  <li>
                     <div class="form-group">
                        <div class="input-group">
                           <input type="text" class="form-control"  placeholder="Search" name="search">
                           <span class="input-group-btn">
                           <span class="btn btn-default"><i class="glyphicon glyphicon-search"></i></span>
                           </span>
                        </div>
                     </div>
                     <!-- <input type="text" placeholder="Search.." name="search">
                        <span style="font-size:15px;color:white" class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;  -->
                  </li>
               </form>
            </ul>
         </div>
      </nav>
      <div id="allbutnavbar">
      <div id="topofpage">
         <div class="container">	
            <span class=".col-md-3" style="font-size:18px;">
            <a id="pubgallery" href="index.php">Public Gallery</a> &nbsp;&nbsp;&nbsp; 
            </span>
            <span class=".col-md-3" style="font-size:18px;">
            <a id="form"  href="form.php">Upload an Image</a> &nbsp;&nbsp;&nbsp; 
            </span>
            <span class=".col-md-3"  style="font-size:18px;">
            <a id="approve" href="approval.php">Waiting Approval</a> &nbsp;&nbsp;&nbsp; 
            </span>
            <span class=".col-md-3"  style="font-size:18px;">
            <a id="mod" href="moderator.php">Moderator Log in</a>
            </span>
         </div>
      </div>