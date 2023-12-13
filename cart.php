<!DOCTYPE html>
<html>
<?php
  include 'phpFunctions/connection.php';
  include "componnents/head.php";

  if(isset($_COOKIE['username'])){
    $userName = $_COOKIE['username'];
    $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
    if($selectUser->num_rows > 0){
      $user = $selectUser->fetch_assoc();
      $userId = $user['id'];
     
    } else{
      header("Location:index.php");
    }
  }else{
    header("Location:index.php");
  }
  ?>
  <body>
    <div class="page-holder">
      <!-- navbar-->
      <?php
          include "componnents/navBar.php";
      ?>
      
      <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Cart</h1>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <h2 class="h5 text-uppercase mb-4">Shopping cart</h2>
          <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
              <!-- CART TABLE-->
              <div class="table-responsive mb-4">
                <table class="table">
                  <thead class="bg-light">
                    <tr>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Product</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Price</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Quantity</strong></th>
                      <th class="border-0" scope="col"> <strong class="text-small text-uppercase">Total</strong></th>
                      <th class="border-0" scope="col"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $selectCart = $connection -> query("SELECT cart.*,products.*,cart.id AS cartId FROM cart JOIN products ON cart.product_id = products.id WHERE user_id = $userId AND order_id = 0");
                        if($selectCart -> num_rows > 0){
                          foreach($selectCart as $row){
                         
                    ?>
                    <tr>
                      <th class="pl-0 border-0" scope="row">
                        <div class="media align-items-center"><a class="reset-anchor d-block animsition-link" href="detail.php?id=<?= $row['product_id'] ?>"><img src="admin/img/<?= $row['image'] ?>" alt="..." width="70"/></a>
                          <div class="media-body ml-3"><strong class="h6"><a class="reset-anchor animsition-link" href="detail.php?id=<?= $row['product_id'] ?>"><?= $row['name'] ?></a></strong></div>
                        </div>
                      </th>
                      <td class="align-middle border-0">
                        <p class="mb-0 small">$<span class="product-price"><?= $row['price'] - ($row['price'] * ($row['sale'] / 100)) ?></span></p>
                      </td>
                      <td class="align-middle border-0">
                        <div class="border d-flex align-items-center justify-content-between px-3"><span class="small text-uppercase text-gray headings-font-family">Quantity</span>
                          <div class="quantity">
                            <button class="dec-cart-btn p-0" data-cart-id="<?= $row['cartId'] ?>"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control form-control-sm border-0 shadow-0 p-0 product-quantity" disabled readonly type="text" value="<?= $row['quantity'] ?>"/>
                            <button class="inc-cart-btn p-0" data-cart-id="<?= $row['cartId'] ?>" data-max="<?= $row['count'] + $row['quantity'] ?>"><i class="fas fa-caret-right"></i></button>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle border-0">
                        <p class="mb-0 small">$<span class="product-total-price"><?=  ($row['price'] - ($row['price'] * ($row['sale'] / 100))) * $row['quantity'] ?></span></p>
                      </td>
                      <td class="align-middle border-0"><a class="reset-anchor delete-cart cur-point hvr-buzz" data-cart-id="<?= $row['cartId'] ?>"><i class="fas fa-trash-alt small text-muted"></i></a></td>
                    </tr>
                    <?php
                        }}else{
                          echo "<tr><h3>there is <span class='c-gold'>no</span> elements in your cart</h3></tr>";
                        }
                    ?>
                   
                  </tbody>
                </table>
              </div>
              <!-- CART NAV-->
              <div class="bg-light px-4 py-3">
                <div class="row align-items-center text-center">
                  <div class="col-md-6 mb-3 mb-md-0 text-md-left"><a class="btn btn-link p-0 text-dark btn-sm" href="shop.php"><i class="fas fa-long-arrow-alt-left mr-2"> </i>Continue shopping</a></div>
                  <div class="col-md-6 text-md-right"><a class="btn btn-outline-dark btn-sm" href="checkout.php">Procceed to checkout<i class="fas fa-long-arrow-alt-right ml-2"></i></a></div>
                </div>
              </div>
            </div>
            
          </div>
        </section>
      </div>
      <?php
          include_once "componnents/footer.php";
      ?>
     <!-- footer Scripts  -->
     <script src="js/ajaxFun/incAndDecCart.js"></script>
     <script src="js/ajaxFun/removeCart.js"></script>
     <?php
          include "componnents/footerScripts.php";
      ?>
      <script>
        let userName = getCookie("username");
        let date = new Date();
        $(".current-year").text(date.getFullYear());
      </script>
       <script>
        checkLoginForDocument();
      </script>
    </div>
  </body>
</html>