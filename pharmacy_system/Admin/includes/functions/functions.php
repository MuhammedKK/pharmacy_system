<?php

// Function To get The Title
function pageName() {
    global $pageName;
    if(isset($pageName)) {
        echo $pageName;
    } else {
        echo "Adminstrator";
    }
}

?>