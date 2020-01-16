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
                $query = "INSERT INTO $table ($columns) VALUES (?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0], $values[1], $values[2]);
                $stmt->execute();
                return true;
                break;

            case 7: 
                $a = $values[0];
                $b = $values[1];
                $query = "SELECT $columns FROM $table JOIN user ON discussion.user_ID = user.user_ID LIMIT $a, $b";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID, $dbuser_ID, $dbusername, $dbsubject, $dbpost, $dbcomment_ID, $dbtimestamp);
                echo "<div id='forum-whole'>";
                while ($stmt->fetch()) {
                    echo "<p class='forum-posts'>$dbusername: <a href='". APP_ROOT . '/dashboard/?post='. $dbdiscussion_ID . "' class='forum-subject'>$dbsubject</a> <span class='forum-body'>$dbpost</span> <br>Date: $dbtimestamp</p> <br>";     
              }
              echo "</div>";
              break;

              case 8:
                $query = "SELECT $columns FROM $table JOIN user ON discussion.user_ID = user.user_ID WHERE discussion.discussion_ID = $values";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $stmt->bind_result($dbdiscussion_ID, $dbuser_ID, $dbusername, $dbsubject, $dbpost, $dbcomment_ID, $dbtimestamp);
                echo "<div id='forum-whole'>";
                while ($stmt->fetch()) {
                    $_SESSION['discussion_ID'] = $dbdiscussion_ID;
                    echo "<div class='forum-posts'><p>$dbusername: <span class='forum-subject'>$dbsubject</span> <span class='post-body'>$dbpost</span> <br>Date: $dbtimestamp</p>". ($dbuser_ID === $_SESSION['userID'] ? "<button class='edit-post' id='discussion-$dbdiscussion_ID'>Edit</button><button id='delete'>Delete</button>" : "<button>Flag</button>" ). "</div> <br>
                    <div class='forum-comments'>";
                    $stmt->close();
                    $query = "SELECT comment.comment_ID, comment.comments, user.username, comment.date_created, user.user_ID  FROM comment JOIN user ON comment.user_ID = user.user_ID WHERE comment.discussion_ID = $dbdiscussion_ID ORDER BY comment.date_created ASC";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($dbcommentID, $dbcomments, $dbusername, $dbcommentDate, $dbcommentUserID);
                    while ($stmt->fetch()) {
                        echo "<div class='forum-posts'<p>$dbusername: $dbcomments <br>Date: $dbcommentDate</p>" . ($dbcommentUserID === $_SESSION['userID']? " <button class='edit-post' id='comment-$dbcommentID'>Edit</button><button id='delete'>Delete</button>" : "<button>Flag</button>" ) . " </div> <br>";     
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
    public function newPost($subject, $body)
    {
        session_start();
        echo $_SESSION['userID'];
        $values =  [$_SESSION["userID"], $subject, $body];
        $columns = "user_ID, subject, post";
        $writePost = new SQL(6, "discussion", "iss", $columns, $values, false);
        $writePost->checker();
        if ($writePost) {
            return true;
        } else {
            return false;
        }
    }


    public function getPublicPosts($a, $b)
    {
        $limits = [$a, $b];
        $columns = 'discussion.discussion_ID, discussion.user_ID, user.username, discussion.subject, discussion.post, discussion.comment_ID, discussion.timestamp';
        $getPost = new SQL(7, 'discussion', '', $columns, $limits, false);
        $getPost->checker();
    }

    public function getSinglePost($post_ID)
    {
        $columns = 'discussion.discussion_ID, discussion.user_ID, user.username, discussion.subject, discussion.post, discussion.comment_ID, discussion.timestamp';
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

    // public function getUserPosts()
    // {
        
    // }
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
        session_destroy();
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
    }
}