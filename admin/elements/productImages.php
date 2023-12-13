
<?php
        if(isset($_GET['id'])){
            $productId = $_GET['id'];
            $selection = $connection -> query("SELECT * FROM product_images WHERE product_id = $productId ");
            $numOfImages =$selection ->num_rows; 
            if($numOfImages == 3){
                include "changeImage.php";
            }elseif($numOfImages == 0){
                include "addproductimages.php";
            }
        }else{
            header('Location:products.php');
        }
?>

