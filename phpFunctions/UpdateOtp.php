<?php
    include "connection.php";
    include "createOtp.php";
    include "Sendotp.php";
   
    if(isset($_COOKIE['Wusername'])){
        $userName = $_COOKIE['Wusername'];
        $selectUser = $connection -> query("SELECT * FROM `wait_list` WHERE username = '$userName'") ;
        if($selectUser -> num_rows > 0){
            $user = $selectUser -> fetch_assoc();
            $email = $user['email'];
            $OTP = createOtp();
            $send= sendOtp($OTP,$email,"otp");
            if($send['status'] == "success"){
                $updateOtp = $connection -> query("UPDATE `wait_list` SET otp ='$OTP' WHERE email='$email'");
                setcookie("username","",strtotime("-1 day"),"/");
                echo json_encode(array('status'=> 'success','message'=> "Otp sent successfully"));
            }else{
                http_response_code(400);
                echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
            }

        }else{
            http_response_code(400);
            echo json_encode(array('status'=>'error','message'=> "You Must register first"));
        }
    }else{
        http_response_code(400);
        echo json_encode(array('status'=>'error','message'=> "You Must register first"));
    }

     
?>