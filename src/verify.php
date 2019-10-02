<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //checks to see if its a login attempt or a sign-up. Login has a hidden input of login.
    if (isset($_POST["login"])) {
        if (!$_POST["email"] || !$_POST["password"]) {
            header("Location: ../?empty=true&input=login");
        } else {
            // validates the code if the variables are not empty
            $email = test_input($_POST["email"]);
            $password = test_input($_POST["password"]);
        }
        

    } else {
        if (isset($_POST["sign-up"])) {
            if (!$_POST["firstname"] || !$_POST["lastname"] || !$_POST["email"] || !$_POST["password"]) {
                header("Location: ../?empty=true&input=sign-up");
        } else {
            $firstname = test_input($_POST['firstname']);
            $lastname = test_input($_POST['lastname']);
            $email = test_input($_POST['email']);
            $password = test_input($_POST['password']);
    }
    
}

?>