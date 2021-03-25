<?php

class UserHelper{

    function startSessionFixed(){
        if(session_status() !== PHP_SESSION_ACTIVE)
            session_start();
    }

    function isLogged(){
        $this->startSessionFixed();
        if(isset($_SESSION['user'])){
            return true;
        }else{
            header("Location: " .LOGIN);
            die();
        }
    }

    function isAdmin(){
        $this->startSessionFixed();
        if($this->isLogged() && $_SESSION['admin'] == 1){
            return true;
        }else{
            header("Location: " .LOGIN);
            die();
        }
    }

}