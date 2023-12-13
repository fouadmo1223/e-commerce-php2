<?php
include "connection.php";
    if(isset($_POST['messageId'])){
        $messsageId = $_POST['messageId'];
        $selectMessage = $connection -> query("SELECT * FROM messages WHERE id =$messsageId");
        if($selectMessage->num_rows > 0){
            $message = $selectMessage->fetch_assoc();
            $messageBody = $message["message"];
            $seen = $message['view'] == 0 ? false : true;
            $updateMessage = $connection -> query("UPDATE messages SET view='1' WHERE id = $messsageId");
            if($updateMessage){
                $response = array("status" => "success", "message" => $messageBody, "seen" => $seen);
                echo json_encode($response);
            }else{
                http_response_code(500);
                $response = array("status" => "error", "message" => "Something went wrong,Try again later");
                echo json_encode($response);
            }
        }else{
            http_response_code(400);
            $response = array("status" => "error", "message" => "Something went wrong");
            echo json_encode($response);
        }
    }else{
        http_response_code(400);
        $response = array("status" => "error", "message" => "Something went wrong");
        echo json_encode($response);
    }
?>