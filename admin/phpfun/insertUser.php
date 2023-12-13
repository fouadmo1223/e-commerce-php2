<?php
    session_start();
    include_once('connection.php');

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'] ?? 1;


    if(strlen($fullname) < 5 || strlen($fullname) > 20 ){
        unset($_SESSION['fullnamesuccess']);
        $_SESSION['fullnameerror'] = "Username must be at least 5 characters and less than 20 characters";
        $_SESSION['fullnameValue'] = $fullname;
        $fullNamesucc = false;
    }else{
        unset($_SESSION['fullnameerror']);
        $_SESSION['fullnamesuccess'] = "ok";
        $_SESSION['fullnameValue'] = $fullname;
        $fullNamesucc = true;
    }

    if( strlen($username) > 20 ){
        unset($_SESSION['usernamesuccess']);
        $_SESSION['usernameerror'] = "Username must be at least 5 characters and less than 20 characters";
        $userNamesucc = false;
        $_SESSION['usernameValue'] = $username;
    }else{
        $selectUserName = $connection -> query("SELECT * FROM users WHERE username = '$username'");
        if($selectUserName->num_rows > 0){
            unset($_SESSION['usernamesuccess']);
            $_SESSION['usernameerror'] = "Username exists before , Write unique username";
            $_SESSION['usernameValue'] = $username;
            $userNamesucc = false;
        }else{
            unset($_SESSION['usernameerror']);
            $_SESSION['usernamesuccess'] = "ok";
            $_SESSION['usernameValue'] = $username;
            $userNamesucc = true;
        }
    }

    if( strlen($email) < 5 ){
        unset($_SESSION['emailsuccess']);
        $_SESSION['emailerror'] = "Enter a valid email";
        $_SESSION['emailValue'] = $email;
        $emailsucc = false;
    }else{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $selectEmail= $connection -> query("SELECT * FROM users WHERE email = '$email'");
            if($selectEmail->num_rows > 0){
                unset($_SESSION['emailsuccess']);
                $_SESSION['emailerror'] = "E-Mail exists before , Write unique E-Mail";
                $_SESSION['emailValue'] = $email;
                $emailsucc = false;
            }else{
                unset($_SESSION['emailerror']);
                $_SESSION['emailsuccess'] = "ok";
                $_SESSION['emailValue'] = $email;
                $emailsucc = true;
            }
        }else{
            unset($_SESSION['emailsuccess']);
            $_SESSION['emailerror'] = "Enter a valid E-Mail";
            $_SESSION['emailValue'] = $email;
            $emailsucc = false;
        }
    }

    if(strlen($password) < 5 || strlen($password) > 15 ){
        unset($_SESSION['passwordsuccess']);
        $_SESSION['passworderror'] = "Password must be at least 5 characters and less than 15 characters";
        $passwordsucc = false;
    }else{
        unset($_SESSION['passworderror']);
        $_SESSION['passwordsuccess'] = "ok";
        $passwordsucc = true;
    }

    if($passwordsucc && $userNamesucc && $fullNamesucc && $emailsucc){

        $insertAdmin = "INSERT INTO users (fullname,username, email,password,permission_id,gender_id) VALUES ('$fullname','$username', '$email', '$password','3','$gender')";
        $insertion = $connection ->query($insertAdmin);
        if($insertion ){
            $_SESSION["formValid"] = true;
            header("Location:../users.php?action=addUser");
            exit();
        }else{
            $_SESSION['fullnameerror'] = "Some thing went wrong, please try again later";
            header("Location:../users.php?action=addUser");
            exit();
        }
       
    }else{
        header("Location:../users.php?action=addUser");
        exit();
    }
?>