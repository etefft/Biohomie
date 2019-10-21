<?php 

   //Live connection 
//$servername = "";
//$username = "";
//$password = "";

//Localhost connection
$servername = "localhost";
$dbusername = "root";
$password = "";

//DB name
$dbname = "biohomie"; 

$conn = new mysqli($servername, $dbusername, $password, $dbname);

?>