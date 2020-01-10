<?php

/*
PHP Sessions Example
*/

// uncomment this part of the code to see the results of not using sessions
/*
if(isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views'] + 1;
else
    $_SESSION['views'] = 1;
echo "Views=". $_SESSION['views'];
*/


// uncomment this part of the code to see the results of using sessions
session_start();

if(isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views'] + 1;
else
    $_SESSION['views'] = 1;
echo "Views=". $_SESSION['views'];

// how to unset a session variable
/*
if(isset($_SESSION['views']))
  unset($_SESSION['views']);
*/
  
// how to completely destroy a session
/* session_destroy();  */
  
?>