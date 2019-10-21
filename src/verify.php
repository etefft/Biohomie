<!-- PAGE INFO -->

<!-- This page does NOT correlate with a landing page, it is for verifying any code that is put into an input box and then sending the User to the appropriate page -->

<?php
require(realpath( dirname( __FILE__ ) ) . '\..\config\config.php' );
require("classes.php");

$usernameExists;

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
            header("Location: ../index.php?empty=true&input=login");
        } else {
            // validates the code if the variables are not empty
            $email = test_input($_POST["email"]);
            $password = test_input($_POST["password"]);

            $user = new User($email, $password);


        }
        unset($_POST);

    } elseif (isset($_POST["logout"])) {
        $loggedOut = new Sessions();
        $loggedOut->stopSession();
        header("Location: ../index.php?input=login");
    } else {
        if (isset($_POST["sign-up"])) {
            if (!$_POST["username"] || !$_POST["email"] || !$_POST["password"]) {
                header("Location: ../index.php?empty=true&input=signup");
            } else {
                $username = test_input($_POST['username']);
                $email = test_input($_POST['email']);
                $password = test_input($_POST['password']);

                $user = new newUser($username, $email, $password);
            }
    
        }
        unset($_POST);
    }
}

?>