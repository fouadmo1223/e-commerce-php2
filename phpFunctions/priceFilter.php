<?php
    include "connection.php";

    include "Filters.php";

    
    extract($_POST);
    $filter = new Filter;
    $products =[];
    $minprice =$filter -> getNumber($minprice);
    $maxprice =$filter -> getNumber($maxprice);
    if(isset($_POST['main_catid'])){
        $mainCatId = $_POST['main_catid'];
        $query = "SELECT * FROM products WHERE main_cat_id = $mainCatId AND (price - price * ( sale / 100 ))  BETWEEN $minprice AND $maxprice";
    }elseif(isset($_POST['catid'])){
        $cartId = $_POST['catid'];
        $query = "SELECT * FROM products WHERE category_id = $catId AND (price - price * ( sale / 100 ))  BETWEEN $minprice AND $maxprice";
    }else{
        $query = "SELECT * FROM products WHERE (price - price * ( sale / 100 )) BETWEEN $minprice AND $maxprice";
    }
    $slectProducts = $connection -> query($query);
    if($slectProducts -> num_rows > 0){
        if(isset($_COOKIE['username'])){
            $username = $_COOKIE['username'];
            $GetUser = $connection -> query("SELECT * from users WHERE username = '$username'");
            if($GetUser -> num_rows > 0){
                $user = $GetUser->fetch_assoc();
                $userId= $user['id'];
                foreach($slectProducts as $product){
                    $price = $product['price'] - ($product['sale'] / 100) * $product['price'];
                    $product['finalPrice'] = $price;
                    $productId = $product['id'];
                    $getFavPro = $connection -> query("SELECT * FROM favorites WHERE product_id = $productId AND user_id = $userId");
                    if($getFavPro->num_rows > 0){
                        $product['fav'] = true;
                    }else{
                        $product['fav'] = false;
                    }
                    $products[]= $product;
                }
                echo json_encode(array('status'=> 'success','products'=> $products));
            }else{
                $products = $slectProducts -> fetch_all();
                echo json_encode(array('status'=> 'success','products'=> $products));
            }
        }else{
            $products = $slectProducts -> fetch_all();
            echo json_encode(array('status'=> 'success','products'=> $products));
        }
    }else{
        echo json_encode(array('status'=> 'success','products'=> $products));
    }


?>