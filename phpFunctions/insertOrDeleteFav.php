<?php
include 'connection.php';
    if(isset($_COOKIE['username'])){
        $username = $_COOKIE['username'];
        $checkUser = $connection -> query("SELECT * FROM users WHERE username='$username'");
        if($checkUser -> num_rows > 0){
            $user = $checkUser -> fetch_assoc();
            $userId = $user['id'];
            $productId = $_POST['productid'];
            $selectProduct = $connection -> query("SELECT * FROM products WHERE id= $productId");
            if($selectProduct -> num_rows == 0){
                http_response_code(500);
                echo json_encode(array('status'=> 'error','message'=> 'Something went wrong'));
                die();
            }else{
                $product = $selectProduct -> fetch_assoc();
                $productName = $product['name'];
            }
            $selectProFav = $connection -> query("SELECT * FROM favorites WHERE product_id='$productId' AND user_id='$userId'");
            if($selectProFav -> num_rows > 0){
                $deleteFavProduct = $connection -> query("DELETE FROM favorites WHERE product_id='$productId' AND user_id='$userId'");
                if($deleteFavProduct){
                    echo json_encode(array('status'=> 'success','message'=> "$productName is Removed from favorites",'fav'=>false));
                    die();
                }else{
                    http_response_code(500);
                    echo json_encode(array('status'=> 'error','message'=> 'Something went wrong,Try again later'));
                    die();
                }
            }
            else{
                $insertFavProduct = $connection -> query("INSERT INTO favorites (product_id,user_id) VALUES ('$productId','$userId') ");
                if($insertFavProduct){
                    echo json_encode(array('status'=> 'success','message'=> "$productName is Added to favorites",'fav'=>true));
                    die();
                }else{
                    http_response_code(500);
                    echo json_encode(array('status'=> 'error','message'=> 'Something went wrong,Try again later'));
                    die();
                }
            }
        }else{
            http_response_code(401);
            echo json_encode(array('status'=> 'error','message'=> 'Something went wrong'));
            die();
        }
    }else{
        http_response_code(401);
        echo json_encode(array('status'=> 'error','message'=> 'You Must Have an account first'));
        die();
    }
?>