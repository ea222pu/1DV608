<?php

//Initialize session
session_start();

class LoginModel {

    private static $loggedIn = 'LoginModel::LoggedIn';
    private $userList;

    private $message = 0;

    /**
    * Constructor
    *
    * @param UserList
    */
    public function __construct(UserList $userList) {
        if(!isset($_SESSION[self::$loggedIn]))
            $_SESSION[self::$loggedIn] = false;
        $this->userList = $userList;
    }

    /**
    * @param String $username
    * @param String $password
    * @return boolean
    */
    public function verifyLoginCredentials($username, $password) {
        if(empty($username)) {
            $this->message = 3;
            return false;
        }

        else if(empty($password)) {
            $this->message = 4;
            return false;
        }
        else {
            if(!$this->userList->findUserByUsername($username)) {
                $this->message = 5;
                return false;
            }
            else {
                $user = $this->userList->findUserByUsername($username);
                if($user->getPassword() == $password) {
                    $this->message = 1;
                    $_SESSION[self::$loggedIn] = true;
                    return true;
                }
                else {
                    $this->message = 5;
                    return false;
                }
            }
        }
    }

    /**
    * Logout user, destroy session
    */
    public function logout() {
        if(isset($_SESSION[self::$loggedIn]))
            if($_SESSION[self::$loggedIn])
                $_SESSION[self::$loggedIn] = false;
        $this->message = 2;
        session_destroy();
    }

    /**
    * Login user, set session = true
    */
    public function isLoggedIn() {
        if(isset($_SESSION[self::$loggedIn]))
            if($_SESSION[self::$loggedIn])
                return true;
        return false;
    }

    /**
    * @return Int Integer representing a message
    */
    public function getMessage() {
        return $this->message;
    }
}