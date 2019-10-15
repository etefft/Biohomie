<?php

    require("../src/dashboard.php");
    require("../includes/header.php");
?>
    <?php 
        $firstnameUser = $_SESSION["firstname"];
        echo "<h3>Hello, $firstnameUser!</h3>";
    ?>
    <p>You are logged in.</p>

<?php
require("../includes/footer.php");

?>