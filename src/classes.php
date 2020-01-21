<?php

class SQL 
{
    public $type;
    public $table;
    public $valueType;
    public $columns;
    public $values;
    public $list;

    public function __construct($type, $table, $valueType, $columns, $values, $list)
    {
        $this->type = $type;
        $this->table = $table;
        $this->valueType = $valueType;
        $this->columns = $columns;
        $this->values = $values;
        $this->list = $list;
    }

    public function checker()
    {
        return $this->sqlStatement($this->type, $this->table, $this->valueType, $this->columns, $this->values, $this->list);
    }

    public function sqlStatement($type, $table, $valueType, $columns, $values, $list)
    {
        require('db/dbconnect.php'); 
        $query;

        switch ($type) {
            case 1:
                $query = "INSERT INTO $table ($columns) VALUES (?,?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0], $values[1], $values[2], $values[3], $values[4]);
                $stmt->execute();
                break;

            case 2: 
                $query = "SELECT $columns FROM $table WHERE $columns=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return false;
                } else {
                    return true;
                }
            case 3:
                $email = $values;
                $query = "SELECT $columns FROM $table WHERE email =?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $email);
                $stmt->execute();
                $stmt->bind_result($dataFetched);
                $stmt->fetch();
                var_dump($dataFetched);
                return $dataFetched;
            case 4:
                $email = $values;
                $query = "SELECT $columns FROM $table WHERE email =?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $email);
                $stmt->execute();
                $stmt->bind_result($username, $userID);
                $stmt->fetch();
                $dataFetched = [$username, $userID];
                return $dataFetched;

            case 5:
                $usernameSet = $values;
                $query = "SELECT $columns FROM $table WHERE $columns = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $usernameSet);
                $stmt->execute();
                $stmt->bind_result($fetchedUsername);
                $stmt->fetch();
                if (empty($fetchedUsername)) {
                   return "true";
                } else {
                    return "false";
                }

            case 6:
                $query = "INSERT INTO $table ($columns) VALUES (?,?,?,?)";
                echo $query;
                var_dump($values);
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0], $values[1], $values[2], $values[3]);
                $stmt->execute();

                $query = "SELECT discussion_ID FROM discussion WHERE user_ID = ? AND subject = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('is', $values[0], $values[1]);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID);
                $stmt->fetch();
                return $dbdiscussion_ID;
                break;

            case 7: 
                $a = $values[0];
                $b = $values[1];
                $discussion_ID = $values[2];
                $query = "SELECT $columns FROM $table JOIN user ON discussion.user_ID = user.user_ID". ($discussion_ID ? " WHERE discussion.discussion_ID = $discussion_ID ": '') ." ORDER BY timestamp DESC LIMIT $b";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID, $dbuser_ID, $dbusername, $dbsubject, $dbpost, $dbcomment_ID, $dbtimestamp, $dbimgURL);
                echo "<div id='forum-whole'>";
                include('../includes/search.php');
                $i = 0;
                while ($stmt->fetch()) {
                    $i++;
                    echo "<div class='forum-posts' id='post-$i'>$dbusername: <a href='". APP_ROOT . '/dashboard/?post='. $dbdiscussion_ID . "' class='forum-subject'>$dbsubject</a> <span class='forum-body'>$dbpost</span> <br>Date: $dbtimestamp <br><span>Tags: ";
                    $query2 = "SELECT tag.tag_word FROM tag JOIN discussion ON discussion.discussion_ID = tag.discussion_ID WHERE discussion.discussion_ID = $dbdiscussion_ID";
                    // echo $dbdiscussion_ID;
                    $conn2 = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);
                    $stmt2 = $conn2->prepare($query2);
                    $stmt2->execute();
                    $stmt2->bind_result($dbtabwords);
                    $tags_used = "";
                    while ($stmt2->fetch()) {
                        $tags_used = $tags_used . $dbtabwords . ", ";
                    }  
                    echo rtrim($tags_used, ', ') . "</span><div class='images-post gallery'>";
                    $query3 = "SELECT image.image_url FROM image JOIN discussion ON discussion.discussion_ID = image.discussion_ID WHERE discussion.discussion_ID = $dbdiscussion_ID";
                    $conn3 = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);
                    $stmt3 = $conn3->prepare($query3);
                    $stmt3->execute();
                    $stmt3->bind_result($dbimages);
                    while ($stmt3->fetch()) {
                        echo "<a href='$dbimages'><img src='$dbimages'/></a>";
                    }
                    echo "</div></div><br>";
                    //  if ($dbimgURL !== "none") {
                    //      foreach ($dbimgURL as $key => $value) {
                    //          echo "<img src='$value' />";
                    //      }
                         
                    //  }     
              }
              break;

              case 8:
                $query = "SELECT $columns FROM $table JOIN user ON discussion.user_ID = user.user_ID WHERE discussion.discussion_ID = $values";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID, $dbuser_ID, $dbusername, $dbsubject, $dbpost, $dbcomment_ID, $dbtimestamp, $dbpostEdited);
                echo "<div id='forum-whole'>";
                $i = 0;
                while ($stmt->fetch()) {
                    $i++;
                    $_SESSION['discussion_ID'] = $dbdiscussion_ID;
                    echo "<div class='forum-posts' id='post-$i'><div>$dbusername: <span class='forum-subject'>$dbsubject</span> <span class='post-body'>$dbpost</span> <br>Date: $dbtimestamp " . ($dbpostEdited === NULL ? "" : "<br>Edited on: $dbpostEdited") . "</div>";
                    
                    echo "<div class='images-comments gallery'>";
                    $query3 = "SELECT image.image_url FROM image JOIN discussion ON discussion.discussion_ID = image.discussion_ID WHERE discussion.discussion_ID = $dbdiscussion_ID";
                    $conn3 = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);
                    $stmt3 = $conn3->prepare($query3);
                    $stmt3->execute();
                    $stmt3->bind_result($dbimages);
                    while ($stmt3->fetch()) {
                        echo "<a href='$dbimages'><img src='$dbimages'/></a>";
                    }
                    echo "</div><br>";
                    
                    echo ($dbuser_ID === $_SESSION['userID'] ? "<button class='edit-post' id='discussion-$dbdiscussion_ID'>Edit</button><button id='delete-discussion-$dbdiscussion_ID' class='delete-post'>Delete</button>" : "" ). "</div> <br>
                    <div class='forum-comments'>";
                    $stmt->close();
                    $query = "SELECT comment.comment_ID, comment.comments, user.username, comment.date_created, user.user_ID, comment.comment_edited  FROM comment JOIN user ON comment.user_ID = user.user_ID WHERE comment.discussion_ID = $dbdiscussion_ID ORDER BY comment.date_created ASC";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($dbcommentID, $dbcomments, $dbusername, $dbcommentDate, $dbcommentUserID, $dbcommentEdited);
                    while ($stmt->fetch()) {
                        echo "<div class='forum-posts-comments'><div>$dbusername: <span class='comment-body'>$dbcomments</span> <br>Date: $dbcommentDate" . ($dbcommentEdited === NULL ? "" : "<br>Edited on: $dbcommentEdited") . "</div>" . ($dbcommentUserID === $_SESSION['userID']? " <button class='edit-post discussion-$dbdiscussion_ID' id='comment-$dbcommentID'>Edit</button><button id='delete-comment-$dbcommentID' class='delete-comment delete-discussion-$dbdiscussion_ID'>Delete</button>" : "<button>Flag</button>" ) . " </div> <br>";      
                    }
                    echo "
                    </div>
                    <div class='forum-comment'>
                    <p>Add a comment</p>
                    <form action='". APP_ROOT . "/src/verify.php' method='post'>
                    <input type='text' name='comment' class='forum-comment-input'>
                    <button>Submit</button>
                    </form>
                    </div>
                    ";  
                       
                }
                echo "</div>";
                break;

              case 9:
                $query = "INSERT INTO $table ($columns) VALUES (?,?,?)";
                echo $query;
                $text = $values[2];
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0], $values[1], $values[2]);
                $stmt->execute();
                break;

            case 10:
                $query = "UPDATE $table SET $columns = ?, discussion_edited = CURRENT_TIMESTAMP WHERE discussion_ID = ? AND user_ID = ?";
                echo $query;
                var_dump($values);
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[2], $values[1], $values[0]);
                $stmt->execute();

                break;

                // $values = [$user_ID, $discussion_ID, $comment_ID, $edit_comment]
            case 11:
                $query = "UPDATE $table SET $columns = ?, comment_edited = CURRENT_TIMESTAMP WHERE discussion_ID = ? AND comment_ID = ? AND user_ID = ?";
                echo $query;
                var_dump($values);
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[3], $values[1], $values[2], $values[0]);
                $stmt->execute();
    
                break;

            case 12:
                $query = "DELETE FROM $table WHERE user_ID = ? AND discussion_ID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[1], $values[0]); 
                $stmt->execute();
            break;

            case 13:
                $query = "DELETE FROM $table WHERE user_ID = ? AND discussion_ID = ? AND comment_ID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[2], $values[0], $values[1]);
                $stmt->execute();
            break;

            case 14: 
                $a = $values[0];
                $b = $values[1];
                $userID = $values[2];
                $query = "SELECT $columns FROM $table JOIN user ON discussion.user_ID = user.user_ID WHERE discussion.user_ID = $userID ORDER BY timestamp DESC LIMIT $b";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID, $dbuser_ID, $dbusername, $dbsubject, $dbpost, $dbcomment_ID, $dbtimestamp);
                echo "<div id='forum-whole'>";
                $i = 0;
                while ($stmt->fetch()) {
                    $i++;
                    echo "<div class='forum-posts' id='post-$i'>$dbusername: <a href='". APP_ROOT . '/dashboard/?post='. $dbdiscussion_ID . "' class='forum-subject'>$dbsubject</a> <span class='forum-body'>$dbpost</span> <br>Date: $dbtimestamp <br><span>Tags: ";
                    $query2 = "SELECT tag.tag_word FROM tag JOIN discussion ON discussion.discussion_ID = tag.discussion_ID WHERE discussion.discussion_ID = $dbdiscussion_ID";
                    // echo $dbdiscussion_ID;
                    $conn2 = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);
                    $stmt2 = $conn2->prepare($query2);
                    $stmt2->execute();
                    $stmt2->bind_result($dbtabwords);
                    $tags_used = "";
                    while ($stmt2->fetch()) {
                        $tags_used = $tags_used . $dbtabwords . ", ";
                    }  
                    echo rtrim($tags_used, ', ') . "</span><div class='images-post gallery'>";
                    $query3 = "SELECT image.image_url FROM image JOIN discussion ON discussion.discussion_ID = image.discussion_ID WHERE discussion.discussion_ID = $dbdiscussion_ID";
                    $conn3 = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);
                    $stmt3 = $conn3->prepare($query3);
                    $stmt3->execute();
                    $stmt3->bind_result($dbimages);
                    while ($stmt3->fetch()) {
                        echo "<a href='$dbimages'><img src='$dbimages'/></a>";
                    }
                    echo "</div></div><br>";
                }
              break;

              case 15:
                $query = "INSERT INTO $table ($columns) VALUES (?,?,?,?)";
                echo $query;
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0], $values[1], $values[2], $values[3]);
                $stmt->execute();
                break;

            case 16:
                $values[0] = "%". $values[0] ."%";
                $query = "SELECT discussion_ID FROM `tag` WHERE tag_word LIKE ?";
                $conn = new mysqli($servernameMain, $dbusernameMain, $passwordMain, $dbnameMain);
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0]);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID);
                $result ="";
                while ($stmt->fetch()) {
                    $discussion_search = new Posting();
                    $discussion_search->getPublicPosts(1, 100, $dbdiscussion_ID);
                }
            break;

            case 17:
                $query = "UPDATE $table SET $columns = ? WHERE user_ID = ?";
                echo $query;
                var_dump($values);
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[1], $values[0]);
                $stmt->execute();
                break;

                case 18:
                    $query = "SELECT $columns FROM $table WHERE user_ID = ?";
                    echo $query;
                    echo $values;
                    echo $valueType;
                    $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values);
                $stmt->execute();
                $stmt->bind_result($url_image);
                $stmt->fetch();
                $_SESSION['profile-picture'] = $url_image;
                break;

                
            default:
                # code...
                break;
        }
        

        // if ($list) {
        //     $i=0;
        //     while ($stmt->fetch()){
        //         $stmt->bind_result($row[$i]);
        //         $i++;
        //     } 
        // }
        $stmt->close();
        $conn->close();
        // return true;
    }


}

class newUser extends Sessions
{
    public $username;
    public $email;
    public $password;
    public $level;

    public function __construct($username, $email, $password) {
        if($this->userExists($email)) {
            $this->username = $username;
            $this->email = $email;
            $this->password = $this->passwordHasher($password);
            
            $this->dbSignup($this->username, $this->email, $this->password, 1);
            $userSessions = [$username, $email];
            $this->startSession();
            $this->checkPermissions(100, $userSessions);
            // header("Location: ../dashboard/signup_verify.php");
            $addTempProfile = new Posting();
            $addTempProfile->addImages(0,'../images/TempProfile.jpg', 2);
            header("Location: ../dashboard/");
        } else {
            header("Location: ../index.php?exist=true&input=signup");
        }  
    }

    public function userExists($email)
    {
        $exists = new SQL(2, "user", "s", "email", $email, false);
        return $exists->checker();
    }

    public function passwordHasher($password)
    {
        $passHashed = password_hash($password, PASSWORD_DEFAULT);
        return $passHashed;
    }

    public function dbSignup($username, $email, $password1, $level)
    {
        require("db/dbconnect.php");
        $values = [$username, $email, $password1, 'no', $level];
        $columns =  "username, email, password, user_confirmed, user_level";
        $newUser = new SQL(1, "user", "ssssi", $columns, $values, false);
        if($newUser->checker()) {
            header("Location: ../dashboard.php");
        } else {
            # code...
        }
    }

    


}

class User extends newUser 
{
    public $username;
    public $email;
    public $password;
    public $level;

    public function __construct($email, $password) {
        var_dump($this->userExists($email));
        if(!$this->userExists($email)) {
            if ($this->verifyPassword($email, $password)) {
                $userNames = $this->getUserInfo($email);
                $this->email = $email;
                $this->password = $password;
                $user = [$userNames[0], $userNames[1], $email];
                $this->checkPermissions(200, $user);
                header("Location: ../dashboard/");
            } else {
                header("Location: ../index.php?loginFail=true&input=login");
            }
        } else {
            header("Location: ../index.php?exist=true&input=signup");
        }
        
       
    }

    public function verifyPassword($email, $password)
    {
        $passCheck = new SQL(3, "user", "s", 'password', $email, false);
        $userPassword = $passCheck->checker();
        $correct = password_verify($password, $userPassword);
        return $correct;
    }

    public function loginUser($email, $password)
    {
        # code...
    }

    public function getUserInfo($email)
    {
        $columns = "username, user_ID";
        $retrieve = new SQL(4, "user", "s", $columns, $email, false);
        $names = $retrieve->checker();
        return $names;
    }

    

    // public function forgotPassword()
    // {
    //     # code...
    // }

    // public function changePassword(Type $var = null)
    // {
    //     # code...
    // }

    // public function forgotUsername()
    // {
    //     # code...
    // }

    // public function getUserInfo()
    // {
    //     # code...
    // }
}

class Posting
{
    public function newPost($subject, $body, $url)
    {
        session_start();
        $values =  [$_SESSION["userID"], $subject, $body, $url];
        $columns = "user_ID, subject, post, images";
        $writePost = new SQL(6, "discussion", "isss", $columns, $values, false);
        return $writePost->checker();
        // if ($writePost) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

    public function addTags($discussion_ID, $tags)
    {

        foreach ($tags as $key => $value) {
            $values =  [$discussion_ID, $tags[$key]];
            $columns = "discussion_ID, tag_word";
            $addTags = new SQL(15, "tag", "is", $columns, $values, false);
            $addTags->checker();
        }
    }

    public function getUrl($userID)
    {
        $url = new SQL(18, "image", "i", "image_url", $userID, false);
        $url->checker();
        
    }

    public function addImages($discussion_ID, $url_images, $profile_picture)
    {
        if ($profile_picture === 1) {
            session_start();
            $values =  [$_SESSION['userID'], $url_images];
            $columns = "image_url";
            $addTags = new SQL(17, "image", "si", $columns, $values, false);
            $addTags->checker();
            $_SESSION['profile-picture'] = $url_images;
        } elseif ($profile_picture === 2) {
            session_start();
            $values =  [$_SESSION['userID'], $discussion_ID, $url_images, true];
            $columns = "user_ID, discussion_ID, image_url, profile";
            $addTags = new SQL(15, "image", "iisi", $columns, $values, false);
            $addTags->checker();
        } else {
            foreach ($url_images as $key => $value) {
                $values =  [0, $discussion_ID, $url_images[$key], false];
                $columns = "user_ID, discussion_ID, image_url, profile";
                $addTags = new SQL(15, "image", "iisi", $columns, $values, false);
                $addTags->checker();
            }
        }
        
    }


    public function getPublicPosts($a, $b, $discussion_ID)
    {
        $limits = [$a, $b, $discussion_ID];
        $columns = 'discussion.discussion_ID, discussion.user_ID, user.username, discussion.subject, discussion.post, discussion.comment_ID, discussion.timestamp, discussion.images';
        $getPost = new SQL(7, 'discussion', '', $columns, $limits, false);
        $getPost->checker();
    }

    public function getSinglePost($post_ID)
    {
        $columns = 'discussion.discussion_ID, discussion.user_ID, user.username, discussion.subject, discussion.post, discussion.comment_ID, discussion.timestamp, discussion.discussion_edited';
        $getPost = new SQL(8, 'discussion', '', $columns, $post_ID, false);
        $getPost->checker();
    }

    public function postComment($comment, $discussion_ID, $user_ID)
    {
        $columns = 'user_ID, discussion_ID, comments';
        $values = [$user_ID, $discussion_ID, $comment];
        $postComment = new SQL(9, 'comment', 'iis', $columns, $values, false);
        $postComment->checker();
    }

    public function editPost($edit_post, $discussion_ID, $user_ID)
    {
        $columns = 'post';
        $values = [$user_ID, $discussion_ID, $edit_post];
        $editPost = new SQL(10, 'discussion', 'ssi', $columns, $values, false);
        $editPost->checker();
    }

    public function editComment($edit_comment, $discussion_ID, $comment_ID, $user_ID)
    {
        $columns = 'comments';
        $values = [$user_ID, $discussion_ID, $comment_ID, $edit_comment];
        $editPost = new SQL(11, 'comment', 'sssi', $columns, $values, false);
        $editPost->checker();
    }
    
    public function deletePost($discussion_ID, $user_ID)
    {
        $columns = "";
        $values = [$discussion_ID, $user_ID];
        $deletePost = new SQL(12, 'discussion', 'is', $columns, $values, false);
        $deletePost->checker();
    }

    public function deleteComment($discussion_ID, $comment_ID, $user_ID)
    {
        $columns = "";
        $values = [$discussion_ID, $comment_ID, $user_ID];
        $deleteComment = new SQL(13, 'comment', 'iss', $columns, $values, false);
        $deleteComment->checker();
    }

    public function getUserPosts($a, $b)
    {
        $values = [$a, $b, $_SESSION['userID']];
        $columns = 'discussion.discussion_ID, discussion.user_ID, user.username, discussion.subject, discussion.post, discussion.comment_ID, discussion.timestamp';
        $getPost = new SQL(14, 'discussion', '', $columns, $values, false);
        $getPost->checker();
    }
}

class Search {
    public function searchDB($query)
    {
        $values = [trim($query)];
        $columns = 'discussion_ID';
        $getPost = new SQL(16, 'tag', 's', $columns, $values, false);
        $getPost->checker();
    }
}


class Sessions
{

    public function startSession()
    {
        session_start();
    }

    public function stopSession()
    {
        // $this->startSession();
        $_SESSION["level"] = "";
        // session_destroy();
        $_SESSION = [];
    }

    public function checkPermissions($level, $user)
    {
        $this->stopSession();
        $this->startSession();
        $_SESSION["username"] = $user[0];
        $_SESSION["userID"] = $user[1];
        $_SESSION["email"] = $user[2];
        $_SESSION["level"] = $level;
        $getProfilePicture = new Posting();
        $getProfilePicture->getUrl($user[1]);
    }
}