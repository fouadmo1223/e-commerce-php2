<?php
include_once('phpfun/connection.php');
    if(isset($_COOKIE['username'])){
        $username = $_COOKIE['username'];
        $selectUser = $connection -> query("SELECT * FROM admins WHERE username = '$username'");
        if($selectUser->num_rows == 0){
            header("location:login.php");
            setcookie("username","", time() - 1 ,"/");
            exit();
        }
    }else{
        header("location:login.php");
        exit();
    }
?>