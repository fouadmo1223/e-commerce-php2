<?php
include "connection.php";
$count = 0;
   if(isset($_COOKIE['username'])){
    $userName = $_COOKIE['username'];
    $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
    if($selectUser -> num_rows > 0){
        $user = $selectUser -> fetch_assoc();
        $userId = $user['id'];
        if(isset($_POST['cartId'])){
            $cartId = $_POST['cartId'];
            $inc = $_POST['inc'];
            $selectCart = $connection -> query("SELECT * FROM cart WHERE id = '$cartId'");
            if($selectCart -> num_rows > 0){
                $cart = $selectCart -> fetch_assoc();
                if($userId != $cart['user_id']){
                    die();
                }
                $productId = $cart['product_id'];
                $selectProduct = $connection -> query("SELECT * FROM products WHERE id = '$productId'");
                if($selectProduct -> num_rows > 0){
                    $product = $selectProduct -> fetch_assoc();
                    $count = $product['count'];
                }
                else{
                    http_response_code(500);
                    echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
                    die();
                }
                if(filter_var($inc, FILTER_VALIDATE_BOOL)){
                    if($count - 1 >= 0){
                        $cartQuery = "UPDATE cart SET quantity = quantity + 1 WHERE id = $cartId";
                        $productQuery = "UPDATE products SET count = count - 1 WHERE id = $productId";
                    }else{
                        http_response_code(400);
                        echo json_encode(array('status'=> 'error','message'=> "You have reached the max limit"));
                        die();
                    }
                }else{
                    $cartQuery = "UPDATE cart SET quantity = quantity - 1 WHERE id = $cartId";
                    $productQuery = "UPDATE products SET count = count + 1 WHERE id = $productId";
                }
                $updateCart = $connection -> query($cartQuery);
                if($updateCart){
                    $updateProduct = $connection -> query($productQuery);
                    if(filter_var($inc, FILTER_VALIDATE_BOOL)){
                        echo json_encode(array('status'=> 'success','message'=> "Product is added successfully"));
                    }else{
                        echo json_encode(array('status'=> 'success','message'=> "Product is minused successfully"));
                    }
                }
            }else{
                http_response_code(500);
                echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
            }
        }else{
            http_response_code(500);
            echo json_encode(array('status'=> 'error','message'=> "Something went wrong"));
        }
    }
   }
?>