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

// test to see if page is correct


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
        $loggedOut->startSession();
        $loggedOut->stopSession();
        $_SESSION = [];
        var_dump($_SESSION);
        header("Location: ../index.php?input=login");
    } elseif (isset($_POST['new-post'])) {
        $post = new Posting();
        $post->newPost($_POST['subject-post'], $_POST['body-post']);
        if ($post) {
            header("Location: ../dashboard/index.php?dash=post-success");
        } else {
            header("Location: ../dashboard/index.php?dash=post-failure");
        }
    } elseif (isset($_POST['comment'])) {
        session_start();
        $comment = new Posting();
        $comment->postComment($_POST['comment'], $_SESSION['discussion_ID'], $_SESSION['userID']);
        var_dump($_POST['comment'], $_SESSION['discussion_ID'], $_SESSION['userID']);
        $id = $_SESSION['discussion_ID'];
        header("Location: ../dashboard/?post=$id");

    } elseif (isset($_POST['edit-post'])) {
        session_start();
        $edit_post = test_input($_POST['edit-post']);
        $post_id = preg_replace("/[^0-9]/", "", test_input($_POST['post-id']));
        $user_id = $_SESSION['userID'];
        $edit_submit = new Posting();
        $edit_submit->editPost($edit_post, $post_id, $user_id);
        header("Location: ../dashboard/?post=$post_id");

    } elseif (isset($_POST['edit-comment'])) {
        session_start();
        $edit_comment = test_input($_POST['edit-comment']);
        $post_id = preg_replace("/[^0-9]/", "", test_input($_POST['post-id']));
        $comment_id = preg_replace("/[^0-9]/", "", test_input($_POST['comment-id']));
        $user_id = $_SESSION['userID'];
        $edit_submit = new Posting();
        $edit_submit->editComment($edit_comment, $post_id, $comment_id, $user_id);
        header("Location: ../dashboard/?post=$post_id");

    } elseif (isset($_POST['delete_comment'])) { 
        // comments
        session_start();
        $post_id = preg_replace("/[^0-9]/", "", test_input($_POST['post_id']));
        $comment_id = preg_replace("/[^0-9]/", "", test_input($_POST['comment_id']));
        echo $comment_id;
        echo $post_id;
        $user_id = $_SESSION['userID']; 
        $edit_submit = new Posting();
        $edit_submit->deleteComment($post_id, $comment_id, $user_id);
    }  elseif (isset($_POST['delete_post'])) {
        // test for posts
        session_start();
        $post_id = preg_replace("/[^0-9]/", "", test_input($_POST['post_id']));
        echo $post_id;
        $user_id = $_SESSION['userID'];
        $edit_submit = new Posting();
        $edit_submit->deletePost($post_id, $user_id);
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