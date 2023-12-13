<?php
include "connection.php";
include "createOtp.php";
include "Sendotp.php";
$errors = [];
    $fullName = $_POST['fullname'];
    $userName=$_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'] ?? 1 ;
    $phone  = $_POST['phone'];

    if(strlen($fullName) < 6){
        $errors['fullname'] = 'full name must be at least 6 characters';
    }if(strlen($password) < 6){
        $errors['password'] = 'password must be at least 6 characters';
    }if(strlen($phone) == 0 || $phone == ''){

    }elseif(strlen($phone) > 0 && strlen($phone) < 11 ){
        $errors['phone'] = "enter valid phone number";
    }elseif(strlen($phone) > 11){
        $errors["phone"] = "enter valid phone number";
    }

    if(empty($errors)){
        $insert = $connection->prepare("INSERT INTO `wait_list` (fullname, username, email, password, gender_id) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("ssssi", $fullName, $userName, $email, $password, $gender);
        $insert->execute();
        if($insert->affected_rows > 0){
            $OTP = createOtp();
            $send= sendOtp($OTP,$email,"otp");
            if($send['status'] == "success"){
                $updateOtp = $connection -> query("UPDATE `wait_list` SET otp ='$OTP' WHERE email='$email'");
                setcookie("Wusername",$userName,strtotime("+1 day"),"/");
                setcookie("username","",strtotime("-1 day"),"/");
                echo json_encode(array('status'=> 'success','message'=> "Valid data"));
            }else{
                http_response_code(400);
                echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
            }
        }else{
            http_response_code(400);
            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
        }
        $insert->close();
    }else{
        http_response_code(400);
        echo json_encode(array('status'=>'error','errors'=> $errors));
    }

?>