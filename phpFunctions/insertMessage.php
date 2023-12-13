<?php
include "connection.php";
    extract($_POST);
    $errors = [];
    if(strlen($name) <  5 ){
        $errors['name'] = "name must be at least 5 characters";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Enter a valid email address";
    }
    if(strlen($message) <  5 ){
        $errors['message'] = "messae must be at least 5 characters";
    }
    if(empty($errors)){
        $insert = $connection -> prepare("INSERT INTO messages (email,name,message) VALUES(?,?,?)");
        $insert -> bind_param('sss',$email,$name,$message);
        $insert -> execute();
        if($insert->affected_rows > 0){
            echo json_encode(array('status'=> 'success','message'=> "message is sent successfully"));
        }else{
            http_response_code(500);
            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
        }
    }else{
        http_response_code(400);
        echo json_encode(array('status'=> 'error','errors'=> $errors));
    }

?>