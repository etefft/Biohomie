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
                $stmt->bind_result($username);
                $stmt->fetch();
                $dataFetched = $username;
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
            header("Location: ../dashboard/signup_verify.php");
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
                $user = [$userNames, $email];
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
        $columns = "username";
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


class Sessions
{

    public function startSession()
    {
        session_start();
    }

    public function stopSession()
    {
        $this->startSession();
        $_SESSION["level"] = "";
        session_destroy();
    }

    public function checkPermissions($level, $user)
    {
        $this->stopSession();
        $this->startSession();
        $_SESSION["username"] = $user[0];
        $_SESSION["email"] = $user[1];
        $_SESSION["level"] = $level;
    }
}

   


