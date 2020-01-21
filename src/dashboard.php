<?php
    require("../includes/session.php");
    if (!isset($_SESSION["level"])) {
        header("Location: ../index.php");
    } else {

        require("../src/classes.php");




    }
?>