<?php
include_once '../connection.php';

class User{
    private $username;
    private $password;
    private $email;
    private $loggedin;
    
    function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
        $this->loggedin = false;
    }
    
    function getUsername() {
        return $this->username;
    }

    function login(){
        $db = Db::getInstance();
        
        $statement = 'SELECT * FROM users WHERE username =\'' . $this->username . '\' AND  password = \'' . $this->password . '\'';
        $req = $db->prepare($statement);
        $req->execute();
        
        if ($req->rowCount() != 1){
            $this->loggedin = false;
            echo "Ohhh ! Wrong Credential.";
        }else{
            $details = $req->fetch();
            $_SESSION["username"] = $this->getUsername();
            $this->loggedin = true;                 
        }        
        return $this->loggedin;
    }
        
    function logout() {
        $this->username = "";
        $this->password = "";
        $this->loggedin = false;
        unset($_SESSION['user_session']);
        //if session_destory = true then go to login.php
        if(session_destroy()) {
            header("Location: ../views/pages/login.php");
        }
    }
}

