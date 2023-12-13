<!DOCTYPE html>
<html>
  <?php

$haveImages = false;
include 'phpFunctions/connection.php';
if(isset($_COOKIE['username'])){
  $username = $_COOKIE['username'];
  $checkUser = $connection -> query("SELECT * FROM users WHERE username = '$username'");
  if($checkUser -> num_rows == 0){
    header("location:index.php");
        exit();
      }else{
        $user = $checkUser -> fetch_assoc();
        $userId = $user['id'];
        $fullName = $user['fullname'];
        $getFavProducts = $connection -> query("SELECT product_id  FROM favorites WHERE user_id = '$userId'");
        foreach($getFavProducts as $favProduct){
          $favProductsId[]= $favProduct['product_id'];
        }
        if(isset($_GET['id'])){
          $productId = $_GET['id'];
          $GetAllRev = $connection -> query("SELECT * FROM reviews WHERE product_id =$productId");
          $checkProduct = $connection -> query("SELECT products.*,categories.name as CatName FROM products JOIN categories ON products.category_id = categories.id  WHERE products.id = '$productId'");
          if($checkProduct -> num_rows > 0){
            $product = $checkProduct -> fetch_assoc();
            $productId = $product["id"];
            $getProductImages = $connection -> query("SELECT * FROM product_images WHERE product_id =$productId");
            if($getProductImages -> num_rows > 0){
              $haveImages = true;
            }
          }else{
            header("location:index.php");
            exit();
          }
        }else{
          header("location:index.php");
          exit();
        }
      }
    }else{
      header("location:index.php");
      exit();
    }

      include "componnents/head.php";
  ?>
  <body>
    
    <div class="page-holder bg-light">
      <!-- navbar-->
    <?php
        include "componnents/navBar.php";
    ?>
      <!--  Modal -->
      <div class="modal fade" id="productView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="row align-items-stretch">
                <div class="col-lg-6 p-lg-0"><a class="product-view d-block h-100 bg-cover bg-center" style="background: url(img/product-5.jpg)" href="img/product-5.jpg" data-lightbox="productview" title="Red digital smartwatch"></a><a class="d-none" href="img/product-5-alt-1.jpg" title="Red digital smartwatch" data-lightbox="productview"></a><a class="d-none" href="img/product-5-alt-2.jpg" title="Red digital smartwatch" data-lightbox="productview"></a></div>
                <div class="col-lg-6">
                  <button class="close p-4" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <div class="p-5 my-md-4">
                    <ul class="list-inline mb-2">
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                      <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                    </ul>
                    <h2 class="h4">Red digital smartwatch</h2>
                    <p class="text-muted">$250</p>
                    <p class="text-small mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p>
                    <div class="row align-items-stretch mb-4">
                      <div class="col-sm-7 pr-sm-0">
                        <div class="border d-flex align-items-center justify-content-between py-1 px-3"><span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                          <div class="quantity">
                            <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control border-0 shadow-0 p-0" type="text" value="1">
                            <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-5 pl-sm-0"><a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="cart.html">Add to cart</a></div>
                    </div><a class="btn btn-link text-dark p-0" href="#"><i class="far fa-heart mr-2"></i>Add to wish list</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section class="py-5">
        <div class="container">
          <div class="row mb-5">
            <div class="col-lg-6">
              <!-- PRODUCT SLIDER-->
              <div class="row m-sm-0">
                <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0">
                  <div class="owl-thumbs d-flex flex-row flex-sm-column" data-slider-id="1">
                      <?php
                      if($haveImages){
                       ?>
                    <div class="owl-thumb-item flex-fill mb-2 mr-2 mr-sm-0"><img class="w-100" src="admin/img/<?= $product['image'] ?>" alt="..."></div>
                    <?php
                      foreach($getProductImages as $image){
                    ?>
                    <div class="owl-thumb-item flex-fill mb-2 mr-2 mr-sm-0"><img class="w-100" src="admin/img/<?= $image['image'] ?>" alt="..."></div>
                   <?php
                        }
                      }
                   ?>
                  </div>
                </div>
                <div class="col-sm-10 order-1 order-sm-2">
                  <div class="owl-carousel product-slider" data-slider-id="1">
                    <?php
                        if($haveImages){
                          ?>
                           <a class="d-block" href="admin/img/<?=$product['image'] ?>" data-lightbox="product" title="<?= $product['name'] ?>"><img class="img-fluid" src="admin/img/<?=$product['image'] ?>" alt="..."></a>
                          <?php
                          foreach($getProductImages as $image){       
                    ?>
                    <a class="d-block" href="admin/img/<?= $image['image'] ?>" data-lightbox="product" title="<?= $product['name'] ?>"><img class="img-fluid" src="admin/img/<?= $image['image'] ?>" alt="..."></a>
                    <?php
                        }
                        }else{
                    ?>
                    <a class="d-block" href="admin/img/<?=$product['image'] ?>" data-lightbox="product" title="<?= $product['name'] ?>"><img class="img-fluid" src="admin/img/<?=$product['image'] ?>" alt="..."></a>
                    <?php
                        }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- PRODUCT DETAILS-->
            <div class="col-lg-6">
              <ul class="list-inline mb-2">
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
               
              </ul>
              <h1><?= $product['name'] ?></h1>
              <p class="text-muted lead">$<?=  $product['price'] - ($product['sale'] / 100) * $product['price'] ?></p>
              <p class="text-small mb-4"><?= $product['describtion'] ?></p>
              <div class="row align-items-stretch mb-4">
                <div class="col-sm-5 pr-sm-0">
                  <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white"><span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                    <div class="quantity">
                      <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                      <input class="form-control border-0 shadow-0 p-0 add-product-quantity"  data-quantity-id='<?=  $product['id'] ?>' type="number" value="1">
                      <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 pl-sm-0"><button class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0 add-to-cart-quantity" id="<?=  $product['id'] ?>" >Add to cart</button></div>
              </div><button class="btn btn-link text-dark p-0 mb-4 add-to-fav-modal" data-id="<?=  $product['id'] ?>" ><i class=" <?php
                          if(in_array($product['id'], $favProductsId)){
                            echo "fas";
                          }else{
                            echo "far";
                          }
                      ?> fa-heart mr-2"></i> <span><?php
                      if(in_array($product['id'], $favProductsId)){
                        echo "Remove from favorites";
                      }else{
                        echo "Add to favorites";
                      }
                  ?></span> </button><br>
              <ul class="list-unstyled small d-inline-block">
                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">SKU:</strong><span class="ml-2 text-muted">039</span></li>
                <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Category:</strong><a class="reset-anchor ml-2" href="#"><?= $product['CatName'] ?></a></li>
                <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Tags:</strong><a class="reset-anchor ml-2" href="#">Innovation</a></li>
              </ul>
            </div>
          </div>
          <!-- DETAILS TABS-->
          <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a></li>
            <li class="nav-item"><a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a></li>
          </ul>
          <div class="tab-content mb-5" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
              <div class="p-4 p-lg-5 bg-white">
                <h6 class="text-uppercase">Product description </h6>
                <p class="text-muted text-small mb-0"><?= $product['describtion'] ?></p>
              </div>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
              <div class="p-4 p-lg-5 bg-white">
                <div class="row">
                  <?php
                      
                  ?>
                  <div class="col-lg-12 show-reviews">
                    <?php
                        $productId=$product['id'];
                        $selectReviews = $connection -> query("SELECT reviews.*,users.fullname as fullname FROM reviews JOIN users ON reviews.user_id = users.id WHERE reviews.product_id= $productId LIMIT 4");
                        if($selectReviews -> num_rows > 0){
                          foreach($selectReviews as $review){
                    ?>
                    <div class="media mb-3"><img class="rounded-circle" src="admin/img/profilepic.svg" alt="" width="50">
                      <div class="media-body ml-3">
                        <h6 class="mb-0 text-uppercase"><?= $review['fullname'] ?></h6>
                        <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                        <ul class="list-inline mb-1 text-xs" title="<?=$review['rate'] ?>">
                          <?php
                              $rate = $review['rate'];
                              for($i =0; $i < $rate ; $i++){
                                if($i +1 >  $rate){
                                  ?>
                                   <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                                  <?php
                                }else{
                                ?>
                          <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                          <?php
                              }}
                          ?>
                          
                        </ul>
                        <div class="row">
                        <div class="d-flex col-12 p-0">
                          <p class="text-small mb-0 text-muted col-8"><?= $review['comment'] ?></p>
                          <?php
                              if($review['user_id'] == $userId){
                          ?>
                            <div class="d-flex w-100 col-4">
                            <!-- <button  class='btn btn-success btn-circle hvr-wobble-to-top-right rad-half edit-comment' style='width:30px;height: 30px;padding:0;border:0;text-align:center' data-pro-id="" > <i class='fas fa-pen'></i> </button> -->
                            <button  class='btn btn-danger btn-circle  hvr-buzz rad-half  delete-comment ml-10' style='width:30px;height: 30px;padding:0;border:0;text-align:center'  data-review-id="<?= $review['id'] ?>"> <i class='fas fa-trash'></i> </button>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        </div>
                      </div>
                    </div>
                    <?php
                        }
                      }else{
                    ?>
                    <h2 class='no-reviews-h2'>there is <span class="c-gold">no</span> comments,Be the first one</h2>
                    <?php
                      }
                    ?>
                    
                  </div>
                  <?php
                        if($GetAllRev -> num_rows > 4){
                    ?>
                    <p class='c-grey fs-14  col-12 more-comments cur-point text-decoration-underline' style="display: block;" data-pro-id='<?= $productId ?>'>See more comments</p>
                    <?php
                        }
                    ?>
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-20 rad-10" data-toggle="modal" data-target="#exampleModal">
  Add Comment
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class='row w-100'>
        <div class="form-group p-10 w-100">
          <label for="comment">Comment</label>
          <textarea class="form-control" id="comment" placeholder="Enter your comment" rows="3"></textarea>
        </div>
        <p class='comment c-red fs-14'></p>
          
        <div class="form-group p-10">
          <label for="rate">Rate</label>
          <input class="form-control" id="rate" max="5" placeholder="Enter your Rate" type="number">
        </div>
        <p class="rate c-red fs-14 col-12"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary sendComment " data-id='<?= $productId ?>'>Save changes</button>
        <div class="spinner-border text-primary d-none" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>
                </div>
              </div>
            </div>
          </div>
          <!-- RELATED PRODUCTS-->
          <h2 class="h5 text-uppercase mb-4">Related products</h2>
          <div class="row">
            <!-- PRODUCT-->
          <?php
            $categoryId = $product['category_id'];
            $getRelatedProducts = $connection -> query("SELECT * FROM products WHERE category_id =$categoryId && id != $productId  ORDER BY RAND() LIMIT 4");
            foreach($getRelatedProducts as $product){
          ?>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-25 "  data-aos="fade-right" data-aos-duration="1000" >
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

          </div>
        </div>
      </section>


      <!-- edit modal  -->
                          <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary mt-20 rad-10" data-toggle="modal" data-target="#editModal">
  
</button> -->

<!-- Modal -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Edit Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class='row w-100'>
        <div class="form-group p-10 w-100">
          <label for="editComment">Comment</label>
          <textarea class="form-control" id="editComment" rows="3"></textarea>
        </div>
        <p class='comment c-red fs-14'></p>
          
        <div class="form-group p-10">
          <label for="editRate">Rate</label>
          <input class="form-control" id="editRate" max="5" type="number">
        </div>
        <p class="rate c-red fs-14 col-12"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary sendComment " data-id='<?= $productId ?>'>Save changes</button>
        <div class="spinner-border text-primary d-none" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div> -->

      <!-- Footer Section  -->

      <?php
          include_once "componnents/footer.php";
      ?>
   <!-- footer Scripts  -->
      <?php
          include "componnents/footerScripts.php";
      ?>
      
      
      <script>
          let date = new Date();
          $(".current-year").text(date.getFullYear());
        </script>
        
        <script src="js/ajaxFun/addOrRemoveProductFromFav.js"></script>
        <script src="js/ajaxFun/AddProductWithQuantToCart.js"></script>
        <script src="js/sendcomment.js"></script>
        <script src="js/deletecomment.js"></script>

        <script>
          $(".more-comments").click(function(){
            // $(".more-comments").addClass("d-none");
            $(".more-comments").css("display","none");
            let productId = $(this).attr("data-pro-id");
            $.ajax({
              method: "GET",
              url:"phpFunctions/getRestOfReviews.php",
              data:{
                productId
              },
              dataType: "json",
              success:function(data){
                console.log(data);
                let reviews = data.reviews;
                for(let i = 0; i < reviews.length; i++){
                $(".show-reviews").append(
                    `
                    <div class="media mb-3"><img class="rounded-circle" src="admin/img/profilepic.svg" alt="" width="50">
                      <div class="media-body ml-3">
                        <h6 class="mb-0 text-uppercase">${reviews[i].fullname}</h6>
                        <p class="small text-muted mb-0 text-uppercase">Just now</p>
                        <ul class="list-inline mb-1 text-xs" title="${reviews[i].rate}">
                        ${(() => {
    let starsHtml = '';
    const rate = parseFloat(reviews[i].rate);

    if (!isNaN(rate) && rate >= 0 && rate <= 5) {
        for (let j = 0; j < rate; j++) {
            if (j + 1 > rate) {
                starsHtml += `<li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>`;
            } else {
                starsHtml += `<li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>`;
            }
        }
    } 
    return starsHtml;
})()}
                        </ul>
                        <div class="row">
                        <div class="d-flex col-12 p-0">
                          <p class="text-small mb-0 text-muted col-8">${reviews[i].comment}</p>
                            <div class="d-flex w-100 col-4">
                            <button  class='btn btn-danger btn-circle  hvr-buzz rad-half  delete-comment ml-10' style='width:30px;height: 30px;padding:0;border:0;text-align:center' data-review-id="${reviews[i].id}"> <i class='fas fa-trash'></i> </button>
                            </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    `
                    );
                  }
              },
              error:function(xhr){

              },
            })
          })
        </script>
    </div>
  </body>
</html>