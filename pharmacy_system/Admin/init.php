<?php
// Variables
$temp = "includes/temps/";
$js = "layout/js/";
$css = "layout/css/";
$func = "includes/functions/";


// Includes Files
include "connection.php";
include $func . "functions.php";
include $temp . "header.php";

if(isset($setNav)) {
    include $temp . "navbar.php";
} else {
    return 0;
}

?>
