<?php
include 'connection.php';
    if(isset($_COOKIE['username'])){
        $userName = $_COOKIE['username'];
        $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
        if($selectUser -> num_rows > 0){
            $user = $selectUser -> fetch_assoc();
            $userId = $user['id'];
            if(isset($_POST['favId'])){
                $favId = $_POST['favId'];
                $selectfav = $connection -> query("SELECT * FROM favorites WHERE id = $favId");
                if($selectfav ->num_rows > 0){
                    $fav = $selectfav -> fetch_assoc();
                    $productId = $fav['product_id'];
                    if($userId == $fav['user_id']){
                        $deletefav = $connection -> query("DELETE FROM favorites WHERE id = $favId");
                        if($deletefav){
                            echo json_encode(array('status'=> 'success','message'=> "Product is deleted successfully"));
                        }else{
                            http_response_code(500);
                            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
                        }
                    }
                }
            }
        }
    }
?>