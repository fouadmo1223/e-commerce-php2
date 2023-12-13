<?php
include "connection.php";

$errors = [];
$passwordd = true;
$emaill = true;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];

    if(strlen($email) < 6){
    $errors["emailError"] ="Please enter a valid email";
    $emaill = false;
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors["emailError"] ="Please enter a valid email";
            $emaill = false;
        }
    }

    if(strlen($password) < 6){
        $errors["passwordError"] ="Password must be at least 6 characters";
        $passwordd = false;
    }

    if($emaill && $passwordd){
        $selectUser = $connection -> query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        if($selectUser->num_rows > 0){
            $user = $selectUser->fetch_assoc();
            $userName = $user['username'];
            if($remember == 1){
                setcookie("username",$userName,strtotime("+2 days"),"/");
            }else{
                setcookie("username",$userName,0,"/");
            }
        }else{
            $errors["serverError"] = "Username or password is incorrect";
            setcookie("username","",time() - 1 ,"/");
        }
    }


    if(empty($errors)){
        $response = array("status" => "success", "message" => "User is found successfuly");
        echo json_encode($response);
    }else{
        http_response_code(400);
        $response = array("status" => "error", "errors" => $errors);
        echo json_encode($response);
    }
?>