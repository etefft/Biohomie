<?php 
$formErr = "";

if (isset($_GET["empty"])) {
    if ($_GET["empty"] === "true") {
        $formErr = "You need to fill out all the forms";
    }
    
} 

?>