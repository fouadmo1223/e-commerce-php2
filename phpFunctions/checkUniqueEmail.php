<?php
$uniqeUser = true;
$uniqueAdmin = true;
$uniqeWait = true;
    include "connection.php";
    $email  = $_POST['email'];
    if(strlen($email) < 5 ){
        http_response_code(400);
        echo json_encode(array('status'=> "error",'message'=> 'Enter valid E-mail'));
        die();
    }else{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $selectUser  = $connection -> query("SELECT * FROM users WHERE email = '$email'");
            if($selectUser->num_rows > 0){
                $uniqeUser = false;
            }
            $selectAdmin = $connection -> query("SELECT * FROM admins WHERE email = '$email'");
            if($selectAdmin->num_rows > 0){
                $uniqueAdmin = false;
            }
            $selectWaitList= $connection -> query("SELECT * FROM wait_list WHERE email = '$email'");
            if($selectWaitList->num_rows > 0){
                $uniqeWait = false;
            }
        }else{
            http_response_code(400);
        echo json_encode(array('status'=> "error",'message'=> 'Enter valid E-mail'));
        die();
        }
    }
if($uniqueAdmin && $uniqeUser && $uniqeWait){
    echo json_encode(array('status'=> "success",'message'=> 'Valid E-mail'));
    die();
}else{
    http_response_code(400);
    echo json_encode(array('status'=> "error",'message'=> 'E-mail Exists,write another one'));
    die();
}
?>