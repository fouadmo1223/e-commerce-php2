<?php
    $getUserSucc = true;
    include 'connection.php';
    $productId  = $_GET['productId'];
    $reviews = [];
    $getRsetOfRev = $connection -> query("SELECT * FROM reviews WHERE product_id = $productId  LIMIT 4,1000000");
    if($getRsetOfRev -> num_rows> 0){
        foreach($getRsetOfRev as $review){
            $userId = $review['user_id'];
            $getUser = $connection -> query("SELECT * FROM users WHERE id = $userId");
            if($getUser -> num_rows > 0){
                $user = $getUser -> fetch_assoc();
                $fullName = $user['fullname'];
                $review['fullname'] = $fullName; 
                $reviews[] = $review;
            }else{
                $getUserSucc = false;
            }
        }
       if($getUser){
        echo json_encode(array('status'=> 'success','reviews'=> $reviews));
       }
    }
?>