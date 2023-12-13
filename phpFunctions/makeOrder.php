<?php
include "connection.php";
include "createOtp.php";
include "Sendotp.php";
$errors=[];
$productNames=[];
$producsQuantity=[];

// print_r($_POST);
// die();
extract($_POST);
if(isset($_COOKIE['username'])){
  $userName  = $_COOKIE['username'];
  $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
  if($selectUser -> num_rows > 0){
    $user = $selectUser -> fetch_assoc();
    $userId = $user['id'];
    if($user['coupon_id'] != 0){
        $couponId = $user['coupon_id'];
        $selectCoupon = $connection -> query("SELECT * FROM coupons WHERE id = $couponId");
        if($selectCoupon -> num_rows > 0){
            $coupon = $selectCoupon -> fetch_assoc();
            $discount = $coupon['discount'];
        }else{
            $discount = 0;
        }
    }else{
        $discount = 0;
    }

    $getCartElem = $connection -> query ("SELECT * FROM cart WHERE order_id = 0 AND user_id = $userId");
if($getCartElem -> num_rows == 0){
    http_response_code(402);
    echo json_encode(array('status'=> 'error','message'=> "there is no products in the cart"));
    die();
}


    if(strlen($firstname) < 2 ){
        $errors['firstname'] = "First Name must be at least 2 characters";
    }
    if(strlen($lastname) < 2 ){
        $errors['lastname'] = "Last Name must be at least 2 characters";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "please enter a valid email address";
    }

    if (!is_numeric((int)$phone) && strlen($phone) > 0) {
        $errors['phone'] = "Please enter a valid phone number";
    } elseif (strlen($phone) > 0 && strlen($phone) < 11) {
        $errors['phone'] = "Please enter a valid phone number";
    } elseif (strlen($phone) > 11) {
        $errors['phone'] = "Please enter a valid phone number";
    }elseif (!preg_match('/^\d{11}$/', $phone) && $phone != '') {
        $errors['phone'] = "Please enter a valid 11-digit phone number";
    }
    
    if( strlen($company) > 0 && strlen($company) < 2  ){
        $errors['company'] = "Company must be at least 2 characters";
    }
    elseif(strlen($company) == 0){
        $company = "";
    }
    if( strlen($country) < 1 ){
        $errors['countryy'] = "You mist choose country";
    }
    if( strlen($address1) < 3 ){
        $errors['address1'] = "Enter a valid address";
    }
    if(strlen($address2) > 0 && strlen($address2) < 3 ){
        $errors['address2'] = "Enter a valid address";
    } elseif(strlen($address2) == 0){
        $address2 = "";
    }
    if( strlen($town) < 2 ){
        $errors['town'] = "Enter a valid town";
    }
    if( strlen($county) < 2 ){
        $errors['county'] = "Enter a valid county";
    }
    
    
    if(empty($errors)){
        $total = 0;
        $getcart = $connection -> query("SELECT cart.*,products.price as price,products.sale as sale,products.name as name  FROM cart JOIN products ON cart.product_id = products.id WHERE user_id = $userId AND order_id = 0");
        foreach($getcart as $cart){
            $total += $cart['quantity'] * ($cart['price'] - $cart['price'] *($cart['sale'] / 100));
            $productNames[] = $cart['name'];
            $producsQuantity[]= $cart['quantity'];
        }
        $priceAfterDiscount  = $total - ($total *($discount / 100));

        $insert = "INSERT INTO orders (first_name, last_name,email,company,country,address1,address2,town,county,total_price,discount,price_after_discount) VALUES ('$firstname','$lastname','$email','$company','$country','$address1','$address2','$town','$county','$total','$discount','$priceAfterDiscount')";
        $insertQuery = $connection -> query($insert);
        if($insertQuery){
            $getLastOrder = $connection -> query("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
            $order = $getLastOrder -> fetch_assoc();
            $orderId = $order['id'];
            $UpdateCart = $connection -> query("UPDATE cart SET order_id = $orderId WHERE order_id = 0 AND user_id = $userId ");
            if($UpdateCart){
                $message = "You have ordered:";
                for ($i = 0; $i < count($productNames); $i++) {
                    $message .= "\n{$productNames[$i]} - Quantity: {$producsQuantity[$i]}";
                }

                $send= sendOtp(0,$email,$message);
                $deleteCoupon = $connection -> query("DELETE FROM coupons WHERE id = $couponId");
                echo json_encode(array('status'=> 'success','message'=> "Your order is made successfully"));
            }
        }


    }else{
        http_response_code(400);
        echo json_encode(array('status'=> 'error','errors'=> $errors));
    }
  }else{
    http_response_code(401);
    echo json_encode(array('status'=> 'error','message'=> "You must login first"));
  }
 
}else{
    http_response_code(401);
    echo json_encode(array('status'=> 'error','message'=> "You must login first"));

}
?>