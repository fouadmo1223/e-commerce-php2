<?php
include 'connection.php';
    if(isset($_COOKIE['username'])){
        $userName = $_COOKIE['username'];
        $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
        if($selectUser -> num_rows > 0){
            $user = $selectUser -> fetch_assoc();
            $userId = $user['id'];
            if(isset($_POST['cartId'])){
                $cartId = $_POST['cartId'];
                $selectCart = $connection -> query("SELECT * FROM cart WHERE id = $cartId");
                if($selectCart ->num_rows > 0){
                    $cart = $selectCart -> fetch_assoc();
                    $quantity = $cart['quantity'];
                    $productId = $cart['product_id'];
                    if($userId == $cart['user_id']){
                        $deleteCart = $connection -> query("DELETE FROM cart WHERE id = $cartId");
                        if($deleteCart){
                            $updateProduct = $connection -> query("UPDATE products SET count = count + $quantity WHERE id = $productId");
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