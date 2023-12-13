<?php
include 'connection.php';
    if(isset($_POST['reviewId'])){
        $reviewId = $_POST['reviewId'];
        if(isset($_COOKIE['username'])){
            $username = $_COOKIE['username'];
            $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$username'");
            if($selectUser -> num_rows > 0){
                $user = $selectUser ->fetch_assoc();
                $userId = $user['id'];
                $selectReview = $connection -> query("SELECT * FROM reviews WHERE id = '$reviewId'");
                if($selectReview -> num_rows > 0){
                    $review = $selectReview ->fetch_assoc();
                    if($review['user_id'] == $userId){
                        $deleteRev = $connection -> query("DELETE FROM reviews WHERE id = '$reviewId'");
                        if($deleteRev){
                            
                            echo json_encode(array('status'=> 'success','message'=> "Your comment is deleted successfully"));
                        }else{
                            http_response_code(500);
                            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
                        }
                    }else{
                        http_response_code(400);
                        echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
                    }
                }else{
                    http_response_code(400);
                    echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
                }
            }else{
                http_response_code(401);
                echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
            }
        }else{
            http_response_code(401);
            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
        }
    }else{
        http_response_code(400);
        echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
    }
?>