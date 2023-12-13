<?php
include "connection.php";
$OTP = $_POST['otp'];
    if(isset($_COOKIE['Wusername'])){
        $userName = $_COOKIE['Wusername'];
        $selectUser = $connection -> query("SELECT * FROM `wait_list` WHERE username = '$userName' ");
        if($selectUser -> num_rows > 0){
            $user = $selectUser -> fetch_assoc();
            $userOtp = $user['otp'];
            $userName = $user['username'];
            $fullName = $user['fullname'];
            $password = $user['password'];
            $gender = $user['gender_id'];
            $email = $user['email'];
            $permissionId =3;
            if($userOtp === $OTP){
                $insert = $connection->prepare("INSERT INTO users (fullname, username, email, password, gender_id,permission_id) VALUES (?, ?,?, ?, ?,?)");
                $insert->bind_param("ssssii", $fullName, $userName, $email, $password, $gender,$permissionId);
                $insert->execute();
                if($insert->affected_rows > 0){
                    $deleteWait = $connection -> query("DELETE FROM `wait_list` WHERE username ='$userName' AND email ='$email'");
                    if($deleteWait){
                        setcookie("username",$userName,strtotime("+1 day"),"/");
                        setcookie("Wusername","",strtotime("-1 day"),"/");
                        echo json_encode(array('status'=> "success",'message'=> 'The OTP is correct,you have singned up successfully'));
                    }    
                }else{
                    http_response_code(500);
                    echo json_encode(array('status'=> "error",'message'=> 'SomeThing went wrong, please try again later'));
                }
            }else{
                http_response_code(400);
                echo json_encode(array('status'=> "error",'message'=> 'Wrong OTP ,Try again'));
            }
        }else{
            http_response_code(401);
            echo json_encode(array('status'=> "error",'message'=> 'you are not authorized'));
        }
    }else{
        http_response_code(401);
        echo json_encode(array('status'=> "error",'message'=> 'you are not authorized'));
    }
?>