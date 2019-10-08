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
                $query = "INSERT INTO $table ($columns) VALUES (?,?,?,?,?,?)";
                var_dump($values);
                $stmt = $conn->prepare($query);
                $stmt->bind_param($valueType, $values[0], $values[1], $values[2], $values[3], $values[4], $values[5]);
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
                $stmt->bind_result($passwordFetched);
                $stmt->fetch();
                return $passwordFetched;
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

class newUser
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $level;

    public function __construct($firstname, $lastname, $email, $password) {
        if($this->userExists($email)) {
            echo "yes";
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->password = $this->passwordHasher($password);
            
            $this->dbSignup($this->firstname, $this->lastname, $this->email, $this->password, 1);
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

    public function dbSignup($firstname, $lastname, $email, $password1, $level)
    {
        require("db/dbconnect.php");
        $values = [$firstname, $lastname, $email, $password1, 'no', $level];
        $columns =  "first_name, last_name, email, password, user_confirmed, user_level";
        $newUser = new SQL(1, "user", "sssssi", $columns, $values, false);
        if($newUser->checker()) {
            header("Location: ../dashboard.php");
        } else {
            # code...
        }
    }

    


}

class User extends newUser 
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $level;

    public function __construct($email, $password) {
        var_dump($this->userExists($email));
        if(!$this->userExists($email)) {
            if ($this->verifyPassword($email, $password)) {
                $this->email = $email;
                $this->password = $password;
                echo "you are logged in $email with password:$password";
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


