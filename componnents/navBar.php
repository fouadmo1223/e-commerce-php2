
<?php

$currentURL =  $_SERVER['REQUEST_URI'];
$currentURL  =explode('/', $currentURL);
$currentURL = end($currentURL);
$currentURL = explode('.', $currentURL);
$page = $currentURL[0];

// $selection = $connection-> query("SELECT * FROM admins WHERE password not in ('abdo20','salwa200')");
//  $selection = $connection-> query("SELECT * FROM admins WHERE username LIKE 'a%'");

// foreach($selection as $admin){
//   print_r($admin);
//   echo "<br>";
// }
// die();

$numOfFav = 0;
$numOfProInCart = 0;
  if(isset($_COOKIE['username'])){
  $userName = $_COOKIE['username'];
  $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
  if($selectUser->num_rows > 0){
    $user = $selectUser->fetch_assoc();
    $userId = $user['id'];
    $selectFav = $connection-> query("SELECT * FROM favorites WHERE user_id = $userId ");
    $numOfFav = $selectFav -> num_rows;
    $selectCart= $connection-> query("SELECT * FROM cart WHERE user_id = $userId AND order_id = 0");
    $numOfProInCart = $selectCart -> num_rows;
  }else{
    $userId = false;
  } 
  }else{
    $userId = false;
  }
?>

<header class="header bg-white">
        <div class="container px-0 px-lg-3">
          <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="index.php"><span class="font-weight-bold text-uppercase text-dark">Boutique</span></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <!-- Link--><a class="nav-link <?php
                      if($page  == "index"){
                        echo "active";
                      }
                  ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <!-- Link--><a class="nav-link <?php
                      if($page  == "shop"){
                        echo "active";
                      }
                  ?>" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                  <!-- Link--><a class="nav-link <?php
                      if($page  == "detail"){
                        echo "active";
                      }
                  ?>" href="detail.php">Product detail</a>
                </li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                  <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown"><a class="dropdown-item border-0 transition-link" href="index.php">Homepage</a><a class="dropdown-item border-0 transition-link" href="shop.php">Category</a><a class="dropdown-item border-0 transition-link" href="detail.php">Product detail</a><a class="dropdown-item border-0 transition-link" href="cart.php">Shopping cart</a><a class="dropdown-item border-0 transition-link" href="checkout.php">Checkout</a><a class="dropdown-item border-0 transition-link" href="contact.php">Contact</a></div>
                </li>
              </ul>
              <ul class="navbar-nav ml-auto">               
                <li class="nav-item"><a class="nav-link <?php
                      if($page  == "cart"){
                        echo "active";
                      }
                  ?>" href="cart.php"> <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>Cart<small class="text-gray">(<span class="num-of-products"><?= $numOfProInCart ?></span>)</small></a></li>
                <li class="nav-item"><a class="nav-link <?php
                      if($page  == "favorite"){
                        echo "active";
                      }
                  ?>" href="favorite.php"> <i class="far fa-heart mr-1"></i><small class="text-gray"> (<span class=" num-of-favs"><?= $numOfFav ?></span>)</small></a></li>
                <?php
                    if($userId){
                ?>
                 <li class="nav-item"><button class="nav-link log-out " style="border: none; background-color: transparent;" > <i class="fas fa-user-alt mr-1 text-gray"></i>Logout</button></li>
                <?php
                    }else{
                ?>
                 <li class="nav-item"><a class="nav-link" href="login.php"> <i class="fas fa-user-alt mr-1 text-gray"></i>Login</a></li>
                <?php
                    }
                ?>
              </ul>
            </div>
          </nav>
        </div>
      </header>

      