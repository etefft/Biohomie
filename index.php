<?php
    require("includes/session.php");
    require("src/home.php"); 
    require("includes/header.php"); 
?>
<h3>Our content will go here</h3>

<?php
if(!empty($_GET)) {
    if ($_GET["input"] == "login") {
        require("includes/login.php");
    } elseif ($_GET["input"] == "signup") {
        require("includes/sign-up.php");
    }
} else {
    require("includes/sign-up.php");
}


?>

<?php require("includes/footer.php"); ?>