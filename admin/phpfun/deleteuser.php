<?php
session_start();
    include 'connection.php';
    if(isset($_GET['id'])){
        $userId = $_GET['id'];
        $selectUser  =$connection -> query("SELECT * FROM users WHERE id = $userId");
        if($selectUser -> num_rows > 0){
                $deleteAdmin = $connection -> query("DELETE FROM users WHERE id = $userId");
                if($deleteAdmin){
                    $_SESSION['success'] ="$adminName is deleted";
                    header("Location:../users.php");
                    exit();
                }else{
                    $_SESSION['error'] ="Something went wrong , please try again";
                    header("Location:../users.php");
                    exit();
                }
            
        }else{
            $_SESSION['error'] ="User dose not exists";
            header("Location:../users.php");
            exit();
        }
        
    }
?>