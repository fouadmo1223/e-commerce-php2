<!DOCTYPE html>
<html>
  <?php
  $favProductsId=[];
  include 'phpFunctions/connection.php';
  include "componnents/head.php";

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
  ?>
  <body>
    <div class="page-holder">
      <!-- navbar-->
      <?php
          include "componnents/navBar.php";
      ?>
      <?php
            $getHeighRateProducts = $connection -> query("SELECT * FROM products ORDER BY rate DESC LIMIT 8");
            foreach($getHeighRateProducts as $product){
        ?>
      <!--  Modal -->
      <div class="modal fade" id="productView<?= $product['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="row align-items-stretch">
                <div class="col-lg-6 p-lg-0"><a class="product-view d-block h-100 bg-cover bg-center" style="background: url(admin/img/<?= $product['image'] ?>)" href="admin/img/<?= $product['image'] ?>" data-lightbox="productview" title="<?= $product['name'] ?>"></a></div>
                <div class="col-lg-6">
                  <button class="close p-4" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <div class="p-5 my-md-4">
                    <ul class="list-inline mb-2" >
                    <?php
                        for($i = 0 ; $i < $product['rate']; $i++) {
                          if($i + 1 > $product['rate']) {
                    ?>
                       <li class="list-inline-item m-0" title="<?= $product['rate'] ?> Stars"><i class="fas fa-star-half small text-warning"></i></li>
                    <?php
                        }else{
                    ?>
                      <li class="list-inline-item m-0" title="<?= $product['rate'] ?> Stars"><i class="fas fa-star small text-warning"></i></li>
                     <?php
                        }}
                     ?>
                    <h2 class="h4"><?= $product['name'] ?></h2>
                    <p class="text-muted">$<?=  $product['price'] - ($product['sale'] / 100) * $product['price'] ?></p>
                    <p class="text-small mb-4"><?=  $product['describtion'] ?></p>
                    <div class="row align-items-stretch mb-4">
                      <div class="col-sm-7 pr-sm-0">
                        <div class="border d-flex align-items-center justify-content-between py-1 px-3"><span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                          <div class="quantity">
                            <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control border-0 shadow-0 p-0 add-product-quantity"  data-quantity-id='<?=  $product['id'] ?>' type="number" value="1">
                            <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-5 pl-sm-0"><button class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0 add-to-cart-quantity"  id="<?=  $product['id'] ?>" >Add to cart</button></div>
                    </div><button class="btn btn-link text-dark p-0 add-to-fav-modal" data-id="<?=  $product['id'] ?>" ><i class=" <?php
                          if(in_array($product['id'], $favProductsId)){
                            echo "fas";
                          }else{
                            echo "far";
                          }
                      ?> fa-heart mr-2"></i>
                      <span><?php
                      if(in_array($product['id'], $favProductsId)){
                        echo "Remove from favorites";
                      }else{
                        echo "Add to favorites";
                      }
                  ?></span>  
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
            }
      ?>
      <!-- HERO SECTION-->
      <div class="container">
        <section class="hero pb-3 bg-cover bg-center d-flex align-items-center" data-aos="flip-up"  data-aos-duration="1500" style="background: url(img/hero-banner-alt.jpg)">
          <div class="container py-5">
            <div class="row px-4 px-lg-5">
              <div class="col-lg-6">
                <p class="text-muted small text-uppercase mb-2" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="1000">New Inspiration <span class="current-year"></span></p>
                <h1 class="h2 text-uppercase mb-3"  data-aos="fade-right" data-aos-duration="1500" data-aos-delay="2000">20% off on new season</h1><a class="btn btn-dark"  href="shop.php"  data-aos="fade-right" data-aos-duration="1000" data-aos-delay="2500">Browse collections</a>
              </div>
            </div>
          </div>
        </section>
        <!-- CATEGORIES SECTION-->
        <section class="pt-5">
          <header class="text-center">
            <p class="small text-muted small text-uppercase mb-1">Carefully created collections</p>
            <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
          </header>
          <div class="row">
            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-right"  data-aos-duration="1000"><a class="category-item" href="shop.php?main_catid=1"><img class="img-fluid" loading="lazy" src="img/cat-img-1.jpg" alt=""><strong class="category-item-title">Fashion</strong></a></div>
            <div class="col-md-4 mb-4 mb-md-0"><a class="category-item mb-4" data-aos="fade-down"  data-aos-duration="1000" href="shop.php?catid=17"><img class="img-fluid" loading="lazy" src="img/cat-img-2.jpg" alt=""><strong class="category-item-title">Cosmetic</strong></a><a class="category-item" data-aos="fade-up"  data-aos-duration="1000" href="shop.php?catid=18"><img class="img-fluid" loading="lazy" src="img/cat-img-3.jpg" alt=""><strong class="category-item-title">Nail Art</strong></a></div>
            <div class="col-md-4"><a class="category-item" href="shop.php?main_catid=3" data-aos="fade-left"  data-aos-duration="1000"><img class="img-fluid" src="img/cat-img-4.jpg" loading="lazy" alt=""><strong class="category-item-title">Electronics</strong></a></div>
          </div>
        </section>
        <!-- TRENDING PRODUCTS-->
        <section class="py-5">
          <header>
            <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
            <h2 class="h5 text-uppercase mb-4">Top trending products</h2>
          </header>
          <div class="row">

          <?php
            foreach($getHeighRateProducts as $product){
          ?>

            <!-- PRODUCT-->
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-25 "  data-aos="fade-up" data-aos-duration="1000" >
              <div class="product text-center hvr-float">
                <div class="position-relative mb-3">
                  <?php
                      if($product['sale'] > 0){
                        echo "<div class='badge text-white badge-primary'>Sale</div>";
                      }elseif($product['new']){
                        echo "<div class='badge text-white badge-info'>New</div>";
                      }
                  ?><a class="d-block" href="detail.php?id=<?= $product['id'] ?>"><img class="img-fluid w-100"  style="height: 350px;" src="admin/img/<?= $product['image'] ?> " alt="..." loading="lazy"></a>
                  <div class="product-overlay">
                    <ul class="mb-0 list-inline">
                      <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-outline-dark add-to-fav <?php
                          if(in_array($product['id'], $favProductsId)){
                            echo "favorite";
                          }
                      ?>" data-id="<?= $product['id'] ?>"><i class="far fa-heart"></i></button></li>
                      <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-dark add-to-cart" id="<?= $product['id'] ?>" >Add to cart</button></li>
                      <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView<?= $product['id'] ?>" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                    </ul>
                  </div>
                </div>
                <h6> <a class="reset-anchor" href="detail.html?id=<?= $product['id'] ?>"><?= $product['name'] ?></a></h6>
                <p class="small text-muted">$<?php
                    $price = $product['price'] - ($product['sale'] / 100) * $product['price']; 
                    echo $price;
                ?></p>
              </div>
            </div>
            
            <?php
                }
            ?>
            
        
          
          </div>
        </section>
        <!-- SERVICES-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row text-center">
              <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="d-inline-block">
                  <div class="media align-items-end">
                    <svg class="svg-icon svg-icon-big svg-icon-light">
                      <use xlink:href="#delivery-time-1"> </use>
                    </svg>
                    <div class="media-body text-left ml-3">
                      <h6 class="text-uppercase mb-1">Free shipping</h6>
                      <p class="text-small mb-0 text-muted">Free shipping worlwide</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="d-inline-block">
                  <div class="media align-items-end">
                    <svg class="svg-icon svg-icon-big svg-icon-light">
                      <use xlink:href="#helpline-24h-1"> </use>
                    </svg>
                    <div class="media-body text-left ml-3">
                      <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                      <p class="text-small mb-0 text-muted">Free shipping worlwide</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="d-inline-block">
                  <div class="media align-items-end">
                    <svg class="svg-icon svg-icon-big svg-icon-light">
                      <use xlink:href="#label-tag-1"> </use>
                    </svg>
                    <div class="media-body text-left ml-3">
                      <h6 class="text-uppercase mb-1">Festival offer</h6>
                      <p class="text-small mb-0 text-muted">Free shipping worlwide</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- NEWSLETTER-->
        <section class="py-5">
          <div class="container p-0">
            <div class="row">
              <div class="col-lg-6 mb-3 mb-lg-0">
                <h5 class="text-uppercase">Let's be friends!</h5>
                <p class="text-small text-muted mb-0">Nisi nisi tempor consequat laboris nisi.</p>
              </div>
              <div class="col-lg-6">
                <form action="#">
                  <div class="input-group flex-column flex-sm-row mb-3">
                    <input class="form-control form-control-lg py-3" type="email" placeholder="Enter your email address" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-dark btn-block" id="button-addon2" type="submit">Subscribe</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- Footer Section  -->

      <?php
          include_once "componnents/footer.php";
      ?>
    </div>
       <!-- footer Scripts  -->
       <?php
          include "componnents/footerScripts.php";
      ?>
      <script>
        let userName = getCookie("username");
        let date = new Date();
        $(".current-year").text(date.getFullYear());
      </script>
      <script src="js/ajaxFun/AddProductstoCart.js"></script>
      <script src="js/ajaxFun/addOrRemoveProductFromFav.js"></script>
      <script src="js/ajaxFun/AddProductWithQuantToCart.js"></script>
        
      <script>
        checkLoginForDocument();
      </script>
      
      
  </body>
</html>