<?php
include_once("connection.php");
$favProductsId=[];
if(isset($_COOKIE['username'])){
    $userName = $_COOKIE['username'];
    $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
    if($selectUser->num_rows > 0){
      $user = $selectUser->fetch_assoc();
      $userId = $user["id"];
      $getFavProducts = $connection -> query("SELECT product_id  FROM favorites WHERE user_id = '$userId'");
      foreach($getFavProducts as $favProduct){
        $favProductsId[]= $favProduct['product_id'];
      }
    } 
  }
$products = [];
$sort = $_POST['sort'];
if(isset($_POST['page'])){
    $page = $_POST['page'] - 1;
    if($page <= 0){
        $page = 0;
    }
}else{
    $page=0;
}
$lastPro = $page *7;
   if(isset($_POST['main_catid'])){
    $mainCatId = $_POST['main_catid'];
    if($sort  == 'default'){
        $query = "SELECT * FROM products WHERE main_cat_id = $mainCatId";
        $realQuery = "SELECT * FROM products WHERE main_cat_id = $mainCatId LIMIT $lastPro ,  7";
    }elseif($sort  == 'popularity'){
        $query = "SELECT * FROM products WHERE main_cat_id = $mainCatId ORDER BY rate DESC";
        $realQuery = "SELECT * FROM products WHERE main_cat_id = $mainCatId ORDER BY rate DESC LIMIT $lastPro , 7";
    }elseif($sort  == 'low-high'){
        $query = "SELECT * FROM products WHERE main_cat_id = $mainCatId ORDER BY (price - (price * (sale / 100))) ASC";
        $realQuery = "SELECT * FROM products WHERE main_cat_id = $mainCatId ORDER BY (price - (price * (sale / 100))) ASC LIMIT $lastPro , 7";
    }elseif($sort  == 'high-low'){
        $query = "SELECT * FROM products WHERE main_cat_id = $mainCatId ORDER BY (price - (price * (sale / 100))) DESC";
        $realQuery = "SELECT * FROM products WHERE main_cat_id = $mainCatId ORDER BY (price - (price * (sale / 100))) DESC LIMIT $lastPro , 7";
    }
   }elseif(isset($_POST['catid'])){
    $categoryId = $_POST['catid'];
    if($sort  == 'default'){
        $query = "SELECT * FROM products WHERE category_id = $categoryId";
        $realQuery = "SELECT * FROM products WHERE category_id = $categoryId LIMIT $lastPro , 7";
    }elseif($sort  == 'popularity'){
        $query = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY rate DESC";
        $realQuery = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY rate DESC LIMIT $lastPro , 7";
    }elseif($sort  == 'low-high'){
        $query = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY (price - (price * (sale / 100))) ASC";
        $realQuery = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY (price - (price * (sale / 100))) ASC LIMIT $lastPro , 7";
    }elseif($sort  == 'high-low'){
        $query = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY (price - (price * (sale / 100))) DESC";
        $realQuery = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY (price - (price * (sale / 100))) DESC LIMIT $lastPro , 7";
    }
   }else{
    if($sort  == 'default'){
        $query = "SELECT * FROM products ";
        $realQuery = "SELECT * FROM products LIMIT $lastPro , 7";
    }elseif($sort  == 'popularity'){
        $query = "SELECT * FROM products ORDER BY rate DESC";
        $realQuery = "SELECT * FROM products ORDER BY rate DESC LIMIT $lastPro , 7";
    }elseif($sort  == 'low-high'){
        $query = "SELECT * FROM products ORDER BY (price - (price * (sale / 100))) ASC";
        $realQuery = "SELECT * FROM products ORDER BY (price - (price * (sale / 100))) ASC LIMIT $lastPro , 7";
    }elseif($sort  == 'high-low'){
        $query = "SELECT * FROM products ORDER BY (price - (price * (sale / 100))) DESC";
        $realQuery = "SELECT * FROM products ORDER BY (price - (price * (sale / 100))) DESC LIMIT $lastPro , 7";
    }
   }

   $getNumOfPro = $connection -> query($query);
   $numOfPro = $getNumOfPro -> num_rows;
   $numOfpages = ceil($numOfPro / 7);

   $getProducts = $connection -> query($realQuery);
   foreach($getProducts as $product){
    if(in_array($product['id'],$favProductsId)){
        $product['fav'] = true;
    }else{
        $product['fav'] = false;
    }
    $products[] = $product;
   }

   $response = array("status" => "success", "products" => $products,"numOfProducts" =>$numOfPro ,"numOfPages" =>$numOfpages,"currentPage" =>$page + 1);
   echo json_encode($response);
   
?>