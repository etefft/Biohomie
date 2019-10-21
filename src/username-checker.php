<?php
require("classes.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['usercheck'])) {
        $value = $_POST['username'];
        $usercheck = new SQL(5, "user", "s", "username", $value, false);
        $sender = $usercheck->checker();

        // header('Content-Type: application/json');
        echo $sender;

        
        
        // if($usercheck->checker()) {
        //     $data = true;
        //     echo json_encode($data);
        //     echo "username exists";
        // } else {
        //     $data = true;
        //     echo json_encode($data);
        //     echo "username available";
        // }
    }

}
?>