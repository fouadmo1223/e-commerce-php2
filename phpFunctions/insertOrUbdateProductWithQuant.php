<?php
include 'connection.php';
$existBefore = false;
$productId=$_POST['productid'];
$productAddedQuantity =(int)$_POST['productquantity'];
if(!is_numeric($productAddedQuantity) || $productAddedQuantity <= 0){
    http_response_code(400);
    echo json_encode(array('status'=> 'error','message'=> 'quntity must be a number and more than zero'));
    die();
}

$getProduct = $connection -> query("SELECT * FROM products WHERE id= $productId");
if($getProduct->num_rows > 0){
$product = $getProduct -> fetch_assoc();
}else{
    http_response_code(400);
    echo json_encode(array('status'=> 'error','message'=> 'Something went wrong,Try again later'));
    die();
}

$productName = $product['name'];
$productCount = $product['count'];

if($productCount > 0){
$newProductCount = $productCount -$productAddedQuantity;
if($newProductCount >= 0){
    $minusProductCount = "Update products SET count=$newProductCount WHERE id=$productId";

}else{
    http_response_code(400);
    echo json_encode(array('status'=> 'error','message'=> "The quantity is to large, the max provided quantity is $productCount"));
    die();
}
}else{
    http_response_code(400);
    echo json_encode(array('status'=> 'error','message'=> 'Product is sold out'));
    die();
}

    if(isset($_COOKIE['username'])){
        $username = $_COOKIE['username'];
        $getUser = $connection -> query("SELECT * FROM users WHERE username='$username'");
        if($getUser -> num_rows > 0){
            $user = $getUser -> fetch_assoc();
            $userId = $user['id'];
            $checkProduct = $connection ->query("SELECT * FROM cart WHERE user_id = $userId && product_id = $productId");
            if($checkProduct -> num_rows > 0){
                $cart = $checkProduct ->fetch_assoc();
                $quantity= $cart["quantity"] + $productAddedQuantity ;
                $query = "UPDATE cart SET quantity=$quantity WHERE user_id = '$userId' AND product_id ='$productId'";
                $existBefore = true;
            }else{
                $query = "INSERT INTO cart (user_id, product_id,quantity) VALUES ('$userId', '$productId','$productAddedQuantity')";
                $existBefore = false;
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
   

    $insertOrUpdateCart = $connection -> query($query);
    if($insertOrUpdateCart){
        $update = $connection -> query($minusProductCount);
        if($update){
            echo json_encode(array('status'=> 'success','message'=> "$productAddedQuantity $productName is added to cart", "existBefore"=>$existBefore));
        }else{
            http_response_code(500);
            echo json_encode(array('status'=> 'error','message'=> 'Something went wrong,Try again later'));
            die(); 
        }
       
    }else{
        http_response_code(500);
        echo json_encode(array('status'=> 'error','message'=> 'Something went wrong,Try again later'));
        die();
    }
?>