<?php
include "connection.php";
    if(isset($_COOKIE['username'])){
        $userName = $_COOKIE['username'];
        $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
        if($selectUser -> num_rows > 0){
            $user = $selectUser -> fetch_assoc();
            if(isset($_POST['serial'])){
                $serial = $_POST['serial'];
                $selectCoupon = $connection -> query("SELECT * FROM coupons WHERE serial = '$serial'");
                if($selectCoupon -> num_rows > 0){
                    $coupon = $selectCoupon -> fetch_assoc();
                    $couponId = $coupon['id'];
                    $discount = $coupon['discount'];
                    $updateUser = $connection -> query("UPDATE users SET coupon_id = '$couponId' WHERE username = '$userName'");
                    if($updateUser){
                        echo json_encode(array('status'=> "success",'message'=> 'Discount Card is activated successfully','discount'=>$discount));
                    }else{
                        http_response_code(500);
                        echo json_encode(array('status'=> "error",'message'=> 'Something went wrong'));
                    }
                }else{
                    http_response_code(400);
                    echo json_encode(array('status'=> "error",'message'=> 'Wrong discount cart serial number'));
                }
            }else{
                http_response_code(400);
                echo json_encode(array('status'=> "error",'message'=> 'Something went wrong'));
            }
        }else{
            http_response_code(401);
            echo json_encode(array('status'=> "error",'message'=> 'you must login first'));
        }
    }else{
        http_response_code(401);
        echo json_encode(array('status'=> "error",'message'=> 'you must login first'));
    }
?>