<?php
 include("connection.php");


 $selectCoupon = $connection -> query("SELECT * FROM coupons");
 if($selectCoupon -> num_rows == 0) {
    $number = 1;
 }
 else{
  $number =   $selectCoupon -> num_rows + 1;
 }

 $selectLastCoupon = $connection -> query("SELECT * FROM coupons ORDER BY id DESC LIMIT 1");
 $lastCoupon = $selectLastCoupon -> fetch_assoc();
 $lastId = $lastCoupon['id'];
 $id = $lastId +1;



$charac = "1234567890qwertyuioplkjhgfdsazxcvbnnmQWERTYUIOPLKJHGFDSAZXCVBNM";
$serial="";
for($i=0;$i< 8;$i++){
    $serial .= $charac[rand(0, strlen($charac) - 1)];
}

if($_POST["value"] != ""){
    if (is_numeric($_POST["value"])) {
        $value = intval($_POST["value"]);
        if($value < 0 || $value > 100){
           
            $response = array("status" => "error", "message" => "Value must be greater than 0 and lower than 100",);
            echo json_encode($response);
        }else{
            $insertCoupon = $connection -> query("INSERT INTO `coupons` (serial, discount) VALUES ('$serial', '$value')");
            if($insertCoupon){
                $response = array("status" => "succses", "message" => "Coupon is Generated","value" => $value,"string" => $serial,"id" => $id,"number" => $number);
                echo json_encode($response);
            }else{
                
                $response = array("status" => "error", "message" => "Process failed ,TRY again later");
                echo json_encode($response);
            }
        }
       
        
    }else{
       
        $response = array("status" => "error", "message" => "Discount Value must be Number");
        echo json_encode($response);
    }
   
    // 
}else{
   
    $response = array("status" => "error", "message" => "Discount Value must be set");
    echo json_encode($response);
}
    //  $response = array("status" => "error", "message" => "you must upload the First Image","image1" => true);
    //     echo json_encode($response);
?>