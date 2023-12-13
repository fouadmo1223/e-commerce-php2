<?php
session_start();

$productsIdArr =[];
include 'connection.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $selectBrand = $connection -> query("SELECT * FROM brands WHERE id = '$id'");
    if($selectBrand->num_rows > 0){
        $selectproducts = $connection -> query("SELECT * FROM products WHERE brand_id= '$id'");
        if($selectproducts->num_rows > 0){
            foreach($selectproducts as $product){
               unlink("../img/{$product['image']}");
               $productsIdArr[]= $product['id'];
            }
            foreach($productsIdArr as $id){
                $selectImages = $connection -> query("SELECT * FROM `product_images` WHERE product_id = $id");
                if($selectImages->num_rows > 0){
                    foreach($selectImages as $image){
                        unlink("../img/{$image['image']}");
                    }
                }
            }
            // $deleteCatsProducts = $connection -> query("DELETE FROM products WHERE brand_id=$id");
        }
        $deleteBrand = $connection -> query("DELETE FROM brands WHERE id = '$id'");
        if($deleteBrand){
            $_SESSION['deleteBSucceeded'] = true;
            header("Location:../categories.php");
            exit();
        }else{
            $_SESSION['deleteBfailed'] = true;
            header("Location:../categories.php");
            exit();
        }
    }else{
        header("Location:../categories.php");
        exit();
    }
}else{
    header("Location:../categories.php");
    exit();
}

?>