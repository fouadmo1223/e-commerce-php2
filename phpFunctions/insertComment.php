<?php
$errors =[];
$newRate=0;
include 'connection.php';
$getLastReview = $connection -> query("SELECT * FROM reviews ORDER BY id DESC LIMIT 1");
$lastReview = $getLastReview -> fetch_assoc();
$lastReviewId = $lastReview['id'];
    extract($_POST);
    $rate = (float)$rate;
    if(isset($_COOKIE['username'])){
        $username = $_COOKIE['username'];
        $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$username'");
        if($selectUser -> num_rows > 0){
            $user = $selectUser ->fetch_assoc();
            $userId  = $user['id'];
            if(strlen($comment) < 5){
                $errors['comment'] = "comment must be less than 5 characters";
            }
            if($rate > 5 || $rate <= 0){
                $errors['rate'] = "rate must be between 0 and 5";
            }
        }else{
            http_response_code(401);
            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
            die();
        }
    }else{
        http_response_code(401);
        echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
        die();
    }

    if(empty($errors)){
        $insertComment = $connection -> prepare("INSERT INTO reviews(product_id,comment,user_id,rate) VALUES (?,?,?,?)");
        $insertComment -> bind_param('isid',$productId,$comment,$userId,$rate);
        $insertComment -> execute();
        if($insertComment -> affected_rows > 0){
            $selectProductReviews = $connection -> query("SELECT * FROM reviews WHERE product_id = $productId");
            $numberOfreviews = $selectProductReviews -> num_rows;
            foreach($selectProductReviews as $review){
                $newRate +=$review['rate']; 
            }
            $newRate = $newRate / $numberOfreviews;
            $updatePro = $connection -> query("UPDATE products SET rate = '$newRate' WHERE id = $productId");
            echo json_encode(array('status'=> 'success','message'=>"Comment is added successfuly",'id'=>$lastReviewId + 1));

        }else{
            http_response_code(500);
            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
            die();
        }
    }else{
        http_response_code(400);
        echo json_encode(array('status'=> 'error','errors'=>$errors ));
    }
?>