<?php

session_start();
$imagesArr=[];
include_once("connection.php");
   if(isset($_GET['id'])){
        $productId = $_GET['id'];
        $selectProduct = $connection -> query("SELECT * FROM products WHERE id = $productId");
        if($selectProduct->num_rows > 0){
            $product = $selectProduct->fetch_assoc();
            $productImage = $product['image'];
            $selectImages = $connection -> query("SELECT * FROM product_images WHERE product_id = $productId");
            if($selectImages->num_rows > 0){
                foreach($selectImages as $image){
                    $imagesArr[] = $image['image'];
                }
                $deleteIMages = $connection -> query("DELETE FROM product_images WHERE product_id =$productId");
                foreach($imagesArr as $image){
                    unlink("../img/$image");
                }
            }
            $deleteProduct = $connection -> query("DELETE FROM products WHERE id = $productId");
            if($deleteProduct){
                unlink("../img/$productImage");
                $_SESSION['success'] = 'product deleted successfully';
                header('Location:../products.php');
                exit();
            }else{
                $_SESSION['error'] = 'somthing went wrong, please try again'; 
                header('Location:../products.php');
                exit();
            }
        }else{
            $_SESSION['error'] = 'Product not found';
            header('Location:../products.php');
            exit();
        }

   }

?>