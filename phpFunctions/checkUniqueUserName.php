<?php
$uniqeUser = true;
$uniqueAdmin = true;
$uniqeWait = true;
    include "connection.php";
    $userName  = $_POST['username'];
    if(strlen($userName)  == 0){
        http_response_code(400);
        echo json_encode(array('status'=> "error",'message'=> 'User Name must be at least 1 char'));
        die();
    }else{
        $selectUser  = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
        if($selectUser->num_rows > 0){
            $uniqeUser = false;
        }
        $selectAdmin = $connection -> query("SELECT * FROM admins WHERE username = '$userName'");
        if($selectAdmin->num_rows > 0){
            $uniqueAdmin = false;
        }
        $selectWaitList= $connection -> query("SELECT * FROM wait_list WHERE username = '$userName'");
        if($selectWaitList->num_rows > 0){
            $uniqeWait = false;
        }
    }
if($uniqueAdmin && $uniqeUser && $uniqeWait){
    echo json_encode(array('status'=> "success",'message'=> 'Valid Username'));
    die();
}else{
    http_response_code(400);
    echo json_encode(array('status'=> "error",'message'=> 'UserName Exists,write another one'));
    die();
}
?>