<?php
include("connection.php");
    $couponId = $_POST['id'];
    $deletCoupon = $connection -> query("DELETE FROM coupons WHERE id = $couponId");
    if($deletCoupon){
        $response = array("status" => "succses", "message" => "Coupon is Deleted");
            echo json_encode($response);
    }else{
        $response = array("status" => "error", "message" => "Process Failed ,Please try again");
        echo json_encode($response);
    }
    
?>