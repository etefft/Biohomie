<?php
require('../config/config.php' );
require("classes.php");

$usernameExists;

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        if (!$_POST["email"] || !$_POST["password"]) {
            header("Location: ../index.php?empty=true&input=login");
        } else {
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
        header("Location: ../index.php?input=login");
    } elseif (isset($_POST['new-post'])) {
        $uploadOk = 0;
        $errorMsg = "";
        $url_images = ["none"];
        $images = 0;
        $tags = [];
        
        if ($_FILES['fileToUpload']['name'][0] !== '') {
            $images = 1;
            require('image-check.php');
            $url_images = array_unique($url_images);
        } else {

            $url = "none";
            $uploadOk = 1;
        }

        if (isset($_POST['tag'])) {
            $tags = explode(',', $_POST['tag']);
        }
        if ($uploadOk) {
            if (!empty($_POST['subject-post']) && !empty($_POST['body-post'])) {
                $post = new Posting();
                $discussionID = $post->newPost($_POST['subject-post'], $_POST['body-post'], $images);
                $tagUpload = new Posting();
                $tagUpload->addTags($discussionID, $tags);
                if ($images) {
                    $addImageDb = new Posting;
                    $addImageDb->addImages($discussionID, $url_images, false);
                }
            } else {
                $errorMsg = 5;
            }
        }
                
        if ($post) {
            header("Location: ../dashboard/index.php?dash=post-success");
        } else {
            header("Location: ../dashboard/index.php?dash=post-failure&failure-code=". $errorMsg);
        }
    } elseif (isset($_POST['comment'])) {
        session_start();
        $comment = new Posting();
        $comment->postComment($_POST['comment'], $_SESSION['discussion_ID'], $_SESSION['userID']);
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
        $user_id = $_SESSION['userID']; 
        $edit_submit = new Posting();
        $edit_submit->deleteComment($post_id, $comment_id, $user_id);
    }  elseif (isset($_POST['delete_post'])) {
        // test for posts
        session_start();
        $post_id = preg_replace("/[^0-9]/", "", test_input($_POST['post_id']));
        $user_id = $_SESSION['userID'];
        $edit_submit = new Posting();
        $edit_submit->deletePost($post_id, $user_id);
    } elseif (isset($_POST['profile-picture-upload'])) {
        $errorMsg = "";
        $uploadOk = "";
        if ($_FILES['fileToUpload']['name'][0] !== '') {
            $images = 1;
            require('profile-check.php');
            // $url_images = array_unique($url_images);
        } else {
            $uploadOk = 0;
            $errorMsg = 6;
            
        }

        if ($uploadOk) {
            $addImageDb = new Posting;
            $addImageDb->addImages(0, $url_images, 1);
            header("Location: ../dashboard/index.php?dash=preferences&success=true");
        } else {
            header("Location: ../dashboard/index.php?dash=preferences&failure-code=". $errorMsg);
        }

    } elseif (isset($_POST["change-pass"])) {
        session_start();
        $passUpdate = new Options;
        $passUpdate->changePassword($_SESSION["userID"], $_POST["current-password"], $_POST["password-verify"]);

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