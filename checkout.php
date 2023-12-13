<!DOCTYPE html>
<html>
<?php

  include 'phpFunctions/connection.php';
  include "componnents/head.php";
  $counter = 0;
  $totalPrice = 0;
  $discount =0;
  if(isset($_COOKIE['username'])){
    $userName = $_COOKIE['username'];
    $selectUser = $connection -> query("SELECT * FROM users WHERE username = '$userName'");
    if($selectUser->num_rows > 0){
      $user = $selectUser->fetch_assoc();
      $userId = $user['id'];
      $couponId = $user['coupon_id'];

      $selectCarts = $connection -> query("SELECT cart.*,products.* FROM cart JOIN products ON cart.product_id = products.id WHERE user_id = '$userId' AND order_id =0");
      foreach($selectCarts as $row){
        $totalPrice +=   ($row['price'] - ($row['price'] * ($row['sale'] / 100))) * $row['quantity'] ;
      }
      if($selectCarts->num_rows > 0){
        $bigerThan3 = true;
      }else{
        $bigerThan3 = false;
      }
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
                <h1 class="h2 text-uppercase mb-0">Checkout</h1>
              </div>
              <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                    <li class="breadcrumb-item">
                      <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="cart.php">Cart</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Checkout
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>
        <section class="py-5">
          <!-- BILLING ADDRESS-->
          <h2 class="h5 text-uppercase mb-4">Billing details</h2>
          <div class="row">
            <div class="col-lg-8">
              <form class="make-order">
                <div class="row">
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="firstName"
                      >First name</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="firstName"
                      type="text" minlength="2" name="firstname"
                      placeholder="Enter your first name"
                    />
                    <p class='fs-14 c-red firstname m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="lastName"
                      >Last name</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="lastName"
                      type="text" minlength="2"  name="lastname"
                      placeholder="Enter your last name"
                    />
                    <p class='fs-14 c-red lastname m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="email"
                      >Email address</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="email"
                      type="email"  name="email"
                      placeholder="e.g. Jason@example.com"
                    />
                    <p class='fs-14 c-red email m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="phone"
                      >Phone number</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="phone"
                      type="tel"  name="phone"
                      placeholder="e.g. +02 245354745"
                    />
                    <p class='fs-14 c-red phone m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="company"
                      >Company name (optional)</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="company"
                      type="text"  name="company"
                      placeholder="Your company name"
                    />
                    <p class='fs-14 c-red company m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="country"
                      >Country</label
                    >
                    <select
                      class="selectpicker country"
                      id="country"  name="country"
                      data-width="fit"
                      data-style="form-control form-control-lg"
                      data-title="Select your country"
                    ></select>
                    <p class='fs-14 c-red countryy m-0 p-0'></p>
                  </div>
                  <div class="col-lg-12 form-group">
                    <label class="text-small text-uppercase" for="address"
                      >Address line 1</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="address"  name="address1"
                      type="text"
                      placeholder="House number and street name"
                    />
                    <p class='fs-14 c-red address1 m-0 p-0'></p>
                  </div>
                  <div class="col-lg-12 form-group">
                    <label class="text-small text-uppercase" for="address"
                      >Address line 2</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="addressalt"  name="address2"
                      type="text"
                      placeholder="Apartment, Suite, Unit, etc (optional)"
                    />
                    <p class='fs-14 c-red address2 m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="city"
                      >Town/City</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="city"  name="town"
                      type="text"
                    />
                    <p class='fs-14 c-red town m-0 p-0'></p>
                  </div>
                  <div class="col-lg-6 form-group">
                    <label class="text-small text-uppercase" for="state"
                      >State/County</label
                    >
                    <input
                      class="form-control form-control-lg"
                      id="state"  name="county"
                      type="text"
                    />
                    <p class='fs-14 c-red county m-0 p-0'></p>
                  </div>
                  <div class="d-flex col-lg-12">
                    <div class=" form-group mr-15">
                      <button class="btn btn-dark send-order" type="submit">
                        Place order
                      </button>
                    </div>
                    <div class="spinner-border d-none" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-4">
              <!-- ORDER SUMMARY-->
              <div>
                <div class="card border-0 rounded-0 p-lg-4 bg-light">
                  <div class="card-body">
                    <h5 class="text-uppercase mb-4">Your order</h5>
                    <ul class="list-unstyled mb-0">
                      <?php
                          foreach($selectCarts as $cart){
                            if($counter < 3){
                      ?>
                      <li
                        class="d-flex align-items-center justify-content-between"
                      >
                        <strong class="small font-weight-bold"
                          ><?= $cart['name'] ?> <span class='c-grey fs-15 fw-normal'>*<?= $cart['quantity'] ?></span></strong
                        ><span class="text-muted small">$<?=  ($cart['price'] - ($cart['price'] * ($cart['sale'] / 100))) * $cart['quantity'] ?></span>
                      </li>
                      <li class="border-bottom my-2"></li>
                     <?php
                     }else{
                      ?>
                       <li
                        class="d-flex align-items-center justify-content-between"
                      >...................
                      </li>
                      <li class="border-bottom my-2"></li>
                      <?php
                          break;
                         }
                         $counter++;
                        }
                     ?>
                      <li
                        class="d-flex align-items-center justify-content-between"
                      >
                        <strong class="text-uppercase small font-weight-bold"
                          >Total</strong
                        ><span>$<?= $totalPrice ?></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- ORDER TOTAL-->
              <div class="mt-10">
                <div class="card border-0 rounded-0 p-lg-4 bg-light">
                  <div class="card-body">
                    <h5 class="text-uppercase mb-4">Cart total</h5>
                    <ul class="list-unstyled mb-0">
                      <li
                        class="d-flex align-items-center justify-content-between"
                      >
                        <strong class="text-uppercase small font-weight-bold"
                          >Discount</strong
                        ><span class="text-muted small discount-value"><?php
                            if($couponId > 0){
                              $selectCoupon = $connection -> query("SELECT * FROM coupons WHERE id = $couponId");
                              if($selectCoupon -> num_rows > 0){
                                $coupon = $selectCoupon -> fetch_assoc();
                                $discount = $coupon['discount'];
                                $couponSerial = $coupon['serial']; 
                                echo "{$coupon['discount']} %";
                              }else{
                                echo "0";
                              }
                            }else{
                              echo "0";
                            }
                        ?></span>
                      </li>
                      <li class="border-bottom my-2"></li>
                      <li
                        class="d-flex align-items-center justify-content-between mb-4"
                      >
                        <strong class="text-uppercase small font-weight-bold"
                          >Total</strong
                        ><span >$<span class="total-after-discount"><?= $totalPrice -($totalPrice * ($discount / 100)) ?></span></span>
                      </li>
                      <li>
                        <form class="send-serial">
                          <div class="form-group mb-0">
                            <input
                              class="form-control serial-input"
                              type="text" minlength="6"
                              placeholder="Enter your coupon" required
                              value="<?php
                                  if(isset($couponSerial)){
                                    echo $couponSerial;
                                  }
                              ?>"
                              <?php
                                  if(isset($couponSerial)){
                                    echo "disabled readonly";
                                  }
                              ?>
                            />
                            <button
                              class="btn btn-dark btn-sm btn-block send-coupon"
                              type="submit"
                              <?php
                                  if(isset($couponSerial)){
                                    echo "disabled";
                                  }
                              ?>
                            >
                              <i class="fas fa-gift mr-2"></i>Apply coupon
                            </button>
                          </div>
                        </form>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php
          include_once "componnents/footer.php";
      ?>
      <!-- JavaScript files-->
      <?php
          include "componnents/footerScripts.php";
      ?>
      <script>
        let userName = getCookie("username");
        let date = new Date();
        $(".current-year").text(date.getFullYear());
        checkLoginForDocument();
      </script>
      <script src='js/sendSerial.js'></script>
      <script>
        $(".make-order").submit(function(e){

          let orderData =new FormData(this);
          e.preventDefault();
          $.ajax({
            method: "POST",
            url:"phpFunctions/makeOrder.php",
            dataType: "json",
            data:orderData,
            processData:false,
            contentType: false,
            beforeSend:function(){
              $(".send-order").prop("disabled",true);
              $(".spinner-border").removeClass("d-none")
            },
            success: function(data){
              $(".send-order").prop("disabled",false);
              $(".spinner-border").addClass("d-none")
              $('.fs-14.c-red').text('');
              console.log(data);
              swal("Well done!!!", data.message, "success").then(() => {
                  window.location.replace("pay.php");
                });
            },
            error:function(xhr){
              console.log(xhr);
              $('.fs-14.c-red').text('');
              $(".send-order").prop("disabled",false);
              $(".spinner-border").addClass("d-none")
              if(xhr.status == 401 ){
                swal("ooops!!!!", xhr.responseJSON.message, "error").then(() => {
                  window.location.replace("login.php");
                });
              }else if( xhr.status == 400){
                swal("ooops!!!!", "Check your fields again", "error")
                let response = xhr.responseJSON;
                let errors =response.errors;
                let keyErrors = Object.keys(errors);
                for(let i = 0; i < keyErrors.length; i++){
                  $(`.${keyErrors[i]}`).text(errors[keyErrors[i]]);
                }
                
              }else if(xhr.status == 402 ){
                swal("ooops!!!!", xhr.responseJSON.message, "error").then(() => {});
              }
            }
          })
        })
      </script>
    </div>
  </body>
</html>
