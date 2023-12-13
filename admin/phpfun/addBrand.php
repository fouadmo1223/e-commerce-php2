<?php
// 
include("connection.php");

if(isset($_POST['brandName'])){
    $brand = $_POST['brandName'];
    if(strlen($brand)<= 2){
        http_response_code(400);
        echo json_encode(array('status'=> 'error','message'=> 'Brand name must be provided'));
        die();
    }else{
        $checkBrand = $connection -> query("SELECT * FROM brands WHERE name='$brand'");
        if($checkBrand->num_rows > 0){
            http_response_code(400);
            echo json_encode(array('status'=> 'error','message'=> 'Brand name exists before'));
            die();
        }else{
            $insert = $connection -> query("INSERT INTO brands (name) VALUES ('$brand')");
            if($insert){
                echo json_encode(array('status'=> 'succsess','message'=> 'Brand is added successfully'));
                die();
            }else{
                http_response_code(400);
                echo json_encode(array('status'=> 'error','message'=> 'Something went wrong, please try again'));
                die();
            }
        }
    }
}else{
    http_response_code(400);
    echo json_encode(array('status'=> 'error','message'=> 'Brand name must be provided'));
}

?>