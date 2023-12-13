<?php
session_start();
    include 'connection.php';
    if(isset($_GET['id'])){
        $adminId = $_GET['id'];
        $selectAdmin  =$connection -> query("SELECT * FROM admins WHERE id = $adminId");
        if($selectAdmin -> num_rows > 0){
            $admin = $selectAdmin -> fetch_assoc();
            $adminName = $admin['fullname'];
            if($admin['permission_id'] != 1){
                $deleteAdmin = $connection -> query("DELETE FROM admins WHERE id = $adminId");
                $_SESSION['success'] ="$adminName is deleted";
                header("Location:../admins.php");
                exit();
            }else{
                $_SESSION['error'] = "You can not delete $adminName";
                header("Location:../admins.php");
                exit();
               
            }
        }else{
            header("Location:../admins.php");
            exit();
        }
        
    }
?>