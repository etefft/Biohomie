<!-- PAGE INFO -->

<!-- This page correlates with anything that is being sent to INDEX.php IF you are writing here it will be be evalutated by this page  -->

<?php 
$formErr = "";

if (isset($_GET['empty'])) {
    if ($_GET["empty"] === "true") {
        $formErr = "You need to fill out all the forms";
    } 
    unset($_GET);
} elseif (isset($_GET['exist'])) {
    if ($_GET["exist"] === "true") {
        $formErr = "This user already exists";
    }
    unset($_GET);
}



?>