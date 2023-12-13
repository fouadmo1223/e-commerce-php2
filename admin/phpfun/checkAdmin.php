<?php
session_start();
include "connection.php";
if(isset($_POST['email'])){
    $email = $_POST['email'];
    if(strlen($email) < 6){
        $_SESSION['emailerror'] = 'Enter a valid E-Mail';
        header("location:../login.php");
        exit();
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['emailerror'] = 'Enter a valid E-Mail';
            header("location:../login.php");
            exit();
        }else{
            $_SESSION['emailValue'] = $email;
            $_SESSION['emailsuccses'] = true;
        }
    }
}else{
    $_SESSION['emailerror'] = 'E-Mail is required';
    header("location:../login.php");
    exit();
}

if(isset($_POST['password'])){
    $password = $_POST['password'];
    if(strlen($password) < 6){
        $_SESSION['passworderror'] = 'Password must be at least 6 char';
        header("location:../login.php");
        exit();
    }
}else{
        $_SESSION['passworderror'] = 'Password must be at least 6 char';
        header("location:../login.php");
        exit();
}

$selectAdmin = $connection -> query("SELECT * FROM admins WHERE email ='$email' AND password ='$password'");
if($selectAdmin -> num_rows > 0 ){
    $admin = $selectAdmin -> fetch_assoc();
    $userName = $admin['username'];
    $_SESSION['adminFound'] = 'found';
    if(isset($_POST['remeber'])){
        setcookie("username",$userName ,strtotime("+1 day"),"/");
        header("location:../login.php");
        exit();
    }else{
        setcookie("username",$userName ,0,"/");
        header("location:../login.php");
        exit();
    }
    
}
else{
    $_SESSION['adminFound'] ='not found';
    setcookie("username","" ,time() - 5,"/");
    header("location:../login.php");
    exit();
    
}



?>