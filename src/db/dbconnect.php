<?php 

   //Live connection 
//$servername = "";
//$username = "";
//$password = "";

//Localhost connection
$servernameMain = "localhost";
$dbusernameMain = "root";
$passwordMain = "";

//DB name
$dbnameMain = "biohomie"; 

$conn = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);

?>