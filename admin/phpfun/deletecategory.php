<?php
session_start();

$productsIdArr =[];
include 'connection.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $selectCat = $connection -> query("SELECT * FROM categories WHERE id = '$id'");
    if($selectCat->num_rows > 0){
        $selectproducts = $connection -> query("SELECT * FROM products WHERE category_id = '$id'");
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
            // $deleteCatsProducts = $connection -> query("DELETE FROM products WHERE category_id =$id");
        }
        $deleteCat = $connection -> query("DELETE FROM categories WHERE id = '$id'");
        if($deleteCat){
            $_SESSION['deleteSucceeded'] = true;
            header("Location:../categories.php");
            exit();
        }else{
            $_SESSION['deletefailed'] = true;
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