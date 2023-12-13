<!DOCTYPE html>
<html>
<?php
session_start();
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

  if(isset($_SESSION['selctedPage'])){
    $selctedPage =$_SESSION['selctedPage'];
    if($selctedPage <= 0){
      $selctedPage = 0;
    }
  }else{
    $selctedPage = 0;
  }
  $lastPro = $selctedPage *7;
  

  if(!isset($_GET['main_catid']) && !isset($_GET['catid'])){
    $query = "SELECT * FROM products LIMIT $lastPro, 7";
    $query2 = "SELECT * FROM products";
    
  }elseif(isset($_GET['main_catid'])){
    $mainCatId=$_GET['main_catid'];
    $query = "SELECT * FROM products WHERE main_cat_id = $mainCatId LIMIT $lastPro, 7";
    $query2 = "SELECT * FROM products WHERE main_cat_id = $mainCatId";
    
  }elseif(isset($_GET['catid'])){
    $categoryId = $_GET['catid'];
    $query = "SELECT * FROM products WHERE category_id = $categoryId LIMIT $lastPro, 7";
    $query2 = "SELECT * FROM products WHERE category_id = $categoryId";
  }
  $getProducts = $connection -> query($query);
  $getAllPro = $connection -> query($query2);
  $numOfAllPro = $getAllPro -> num_rows;

  $numberOfPages = ceil($numOfAllPro / 7);
?>
  <body>
    <div class="page-holder">
      <!-- navbar-->
      
      <?php
          include "componnents/navBar.php";
      ?>
       <?php
              $getProducts = $connection -> query($query);
            foreach($getProducts as $product){
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
      <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Shop </h1>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <div class="container p-0">
            <div class="row">
              <!-- SHOP SIDEBAR-->
              <div class="col-lg-3 order-2 order-lg-1">
                <h5 class="text-uppercase mb-4">Categories</h5>
            
                <?php
                    $selectMainCats = $connection -> query("SELECT * FROM `main_cats`");
                    foreach($selectMainCats as $mainCat){
                ?>
                <a class="py-2 px-4  main-cat mb-3 <?php
                    if(isset($_GET['main_catid'])){
                      if($mainCat['id'] == $_GET['main_catid']){
                        echo "main-cat-selected";
                      }
                    }elseif(isset($_GET['catid'])){
                      $selectCategory = $connection -> query("SELECT * FROM categories WHERE id = {$_GET['catid']}");
                      if($selectCategory -> num_rows > 0){
                        $categoryyyyy = $selectCategory -> fetch_assoc();
                        
                        if($categoryyyyy['main_cats_id'] == $mainCat['id']){
                          echo "main-cat-selected";
                        }
                      }

                    }
                ?>" href="phpFunctions/getPageByNum.php?main_catid=<?= $mainCat['id'] ?>"><strong class="small text-uppercase font-weight-bold"><?= $mainCat['name'] ?></strong></a>
                <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                  <?php
                      $selectCats = $connection -> query("SELECT * FROM categories WHERE `main_cats_id` ={$mainCat['id']}");
                      foreach($selectCats as $cat){
                  ?>
                  <li class="mb-2 <?php
                    if(isset($_GET['catid'])){
                      if($cat['id'] == $_GET['catid']){
                        echo "c-gold fw-bold fs-20";
                      }
                    }
                ?>"><a class="reset-anchor" href="phpFunctions/getPageByNum.php?catid=<?= $cat['id'] ?>"><?= $cat['name'] ?></a></li>
                  <?php
                      }
                  ?>
                </ul>
                <?php
                    }
                ?>
               

                <h6 class="text-uppercase mb-4">Price range</h6>
                <div class="price-range pt-4 mb-5">
                  <div id="range"></div>
                  <div class="row pt-2">
                    <div class="col-6"><strong class="small font-weight-bold text-uppercase">From</strong></div>
                    <div class="col-6 text-right"><strong class="small font-weight-bold text-uppercase">To</strong></div>
                    <button class="btn btn-dark mt-10 w-fit rad-10 price-filter hvr-forward" style="margin-left: 10px;">Filter</button>
                  </div>
                </div>
                <h6 class="text-uppercase mb-3">Show only</h6>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck1" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck1">Returns Accepted</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck2" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck2">Returns Accepted</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck3" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck3">Completed Items</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck4" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck4">Sold Items</label>
                </div>
                <div class="custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" id="customCheck5" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck5">Deals &amp; Savings</label>
                </div>
                <div class="custom-control custom-checkbox mb-4">
                  <input class="custom-control-input" id="customCheck6" type="checkbox">
                  <label class="custom-control-label text-small" for="customCheck6">Authorized Seller</label>
                </div>
                <h6 class="text-uppercase mb-3">Buying format</h6>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio1" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio1">All Listings</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio2" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio2">Best Offer</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio3" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio3">Auction</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" id="customRadio4" type="radio" name="customRadio">
                  <label class="custom-control-label text-small" for="customRadio4">Buy It Now</label>
                </div>
              </div>
              <!-- SHOP LISTING-->
              <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row mb-3 align-items-center">
                  <div class="col-lg-6 mb-2 mb-lg-0">
                    <p class="text-small text-muted mb-0"></p>
                  </div>
                  <div class="col-lg-6">
                    <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                      <li class="list-inline-item text-muted mr-3"></li>
                      <li class="list-inline-item text-muted mr-3"></li>
                      <li class="list-inline-item">
                        <select class="selectpicker ml-auto" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                          <option value="default">Default sorting</option>
                          <option value="popularity">Popularity</option>
                          <option value="low-high">Price: Low to High</option>
                          <option value="high-low">Price: High to Low</option>
                        </select>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="row show-products">
                <?php
                if($getProducts -> num_rows > 0){
                  foreach($getProducts as $product){
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
                }}else{
                  echo "<h3 class='txt-c fw-bold mt-40 col-12'> There is <span class='c-gold'>no</span> Products to show in this Category </h3>";
                }
            ?>
                 
                </div>
                <!-- PAGINATION-->
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center justify-content-lg-end">
                    <li class="page-item"><a class="page-link"   href="phpFunctions/getPageByNum.php?<?php
                        if(isset($_GET['main_catid'])){
                          echo "main_catid={$_GET['main_catid']}&page=".($selctedPage);
                        }elseif(isset($_GET['catid'])){
                          echo "catid={$_GET['catid']}&page=".($selctedPage);
                        }else{
                          echo "page=".($selctedPage) ;
                        }
                    ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                    <?php
                        for($i=1; $i <=$numberOfPages ; $i++){
                    ?>
                    <li class="page-item  <?php
                        if( $selctedPage  == $i -1){
                          echo "active";
                        }
                        
                    ?>" data-page="<?= $i ?>"><a class="page-link" href="phpFunctions/getPageByNum.php?<?php
                        if(isset($_GET['main_catid'])){
                          echo "main_catid={$_GET['main_catid']}&page=$i";
                        }elseif(isset($_GET['catid'])){
                          echo "catid={$_GET['catid']}&page=$i";
                        }else{
                          echo "page=$i";
                        }
                    ?>"><?= $i ?></a></li>
                    <?php
                        }
                    ?>
                    <li class="page-item"><a class="page-link" href="phpFunctions/getPageByNum.php?<?php
                        if(isset($_GET['main_catid'])){
                          echo "main_catid={$_GET['main_catid']}&page=".($selctedPage + 2);
                        }elseif(isset($_GET['catid'])){
                          echo "catid={$_GET['catid']}&page=".($selctedPage + 2);
                        }else{
                          echo "page=".($selctedPage + 2) ;
                        }
                    ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php
          include_once "componnents/footer.php";
      ?>
      <!-- footer Scripts  -->
      <?php
          include "componnents/footerScripts.php";
      ?>
      <script>
        
        var range = document.getElementById('range');
        noUiSlider.create(range, {
            range: {
                'min': 0,
                'max': 200000
            },
            step: 100,
            start: [100, 500000],
            margin: 300,
            connect: true,
            direction: 'ltr',
            orientation: 'horizontal',
            behaviour: 'tap-drag',
            tooltips: true,
            format: {
              to: function ( value ) {
                maxValue =value;
                return '$' + value;
              },
              from: function ( value ) {
                minValue = value;
                return value.replace('', '');
              }
            }
        });
        
      </script>
      <script>
        let userName = getCookie("username");
        let date = new Date();
        $(".current-year").text(date.getFullYear());
      </script>
      <script>
        checkLoginForDocument();
      </script>
      <script src="js/ajaxFun/AddProductstoCart.js"></script>
      <script src="js/ajaxFun/addOrRemoveProductFromFav.js"></script>
      <script src="js/ajaxFun/AddProductWithQuantToCart.js"></script>
      <script src="js/ajaxFun/addProductsToBody.js"></script>
      <script src="js/sortAddProductToBody.js"></script>
        <script src="js/getPages.js"></script>

        <script>
          $(".price-filter").click(function(){
            let objData = {};
              let maxPrice = document.querySelectorAll(".noUi-tooltip")[1].innerHTML.split("$")[1];
              let minPrice = document.querySelectorAll(".noUi-tooltip")[0].innerHTML.split("$")[1];
              objData.minprice =minPrice;
              objData.maxprice =maxPrice;
              let page = $(this).parent().find(".active").text();
              let currURL = window.location.href;
              if (currURL.includes("?")) {
                let request = currURL.split("?")[1].split("=");
                if (request[0] == "catid") {
                  objData["catid"] = request[1];
                } else if (request[0] == "main_catid") {
                  objData["main_catid"] = request[1];
                }
              }

              $.ajax({
                method:"POST",
                url:"phpFunctions/priceFilter.php",
                dataType:"json",
                data:objData,
                success:function(data){
                  console.log(data);
                  if(data.products.length > 0){
                    $(".pagination").html("");
                    $(".show-products").html('');
                    let products = data.products;
                    for(let i = 0; i < data.products.length; i++){

                      $(".show-products").append(
                      `
                      <div class="col-xl-3 col-lg-4 col-sm-6 mb-25 "  data-aos="fade-up" data-aos-duration="1000" >
              <div class="product text-center hvr-float">
                <div class="position-relative mb-3">
                ${data.products[i].sale > 0 ? "<div class='badge text-white badge-primary'>Sale</div>" : data.products[i].new > 0 ? "<div class='badge text-white badge-info'>New</div>" : ""}
                 <a class="d-block" href="detail.php?id=${products[i]['id']}"><img class="img-fluid w-100"  style="height: 350px;" src="admin/img/${products[i]['image']}" alt="..." loading="lazy"></a>
                  <div class="product-overlay">
                    <ul class="mb-0 list-inline">
                      <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-outline-dark add-to-fav ${products[i].fav ? "favorite" : ""} " data-id="${products[i]['id']}"><i class="far fa-heart"></i></button></li>
                      <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-dark add-to-cart" id="${products[i]['id']}" >Add to cart</button></li>
                      <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView${products[i]['id']}" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                    </ul>
                  </div>
                </div>
                <h6> <a class="reset-anchor" href="detail.html?id=${products[i]['id']}">${products[i]['name']}</a></h6>
                <p class="small text-muted">$${products[i]['finalPrice']}</p>
              </div>
            </div>

                      `
                      )
                    }
                    
                  }else{
                    $(".pagination").html("");
                    $(".show-products").html('');
                    $(".show-products").html("<h2 class='txt-c'>There is <span class='c-gold'>no</span> products to show </h2>");
                  }
                },
                error:function(xhr){
                  console.log(xhr);
                }
              })          
            })

        </script>
    </div>
  </body>
</html>