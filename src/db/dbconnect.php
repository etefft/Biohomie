<!-- PAGE INFO -->

<!-- This page contains code relating to connecting to the DB -->

<?php 

   //Live connection 
//$servername = "";
//$username = "";
//$password = "";

//Localhost connection
$servername = "localhost";
$username = "root";
$password = "";

//DB name
$dbname = "biohomie"; 

$conn = new mysqli($servername, $username, $password, $dbname);

?>