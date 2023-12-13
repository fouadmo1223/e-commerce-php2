<?php
session_start();
include 'connection.php';

    if(isset($_GET['id'])){
        $userId = $_GET['id'];
        $selectUser = $connection -> query("SELECT * FROM users WHERE id = '$userId'");
        if($selectUser -> num_rows > 0){
            $update = $connection -> query("UPDATE users SET permission_id ='4' WHERE id = '$userId'");
            if($update){
                $_SESSION['blocked'] = true;
                header('Location:../users.php');
                exit();
            }else{
                header('Location:../users.php');
                exit();
            }
        }else{
            header('Location:../users.php');
            exit();
        }
        
    }
?>