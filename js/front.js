$(function () {
  /* ===============================================================
         LIGHTBOX
      =============================================================== */
  lightbox.option({
    resizeDuration: 200,
    wrapAround: true,
  });

  /* ===============================================================
         PRODUCT SLIDER
      =============================================================== */
  $(".product-slider").owlCarousel({
    items: 1,
    thumbs: true,
    thumbImage: false,
    thumbsPrerendered: true,
    thumbContainerClass: "owl-thumbs",
    thumbItemClass: "owl-thumb-item",
  });

  /* ===============================================================
         PRODUCT QUNATITY
      =============================================================== */
  $(".dec-cart-btn").click(function () {
    let totalPriceElem = $(this)
      .parent()
      .parent()
      .parent()
      .parent()
      .find(".product-total-price");
    let totalPriceValue = parseFloat(
      $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".product-total-price")
        .text()
    );
    let productPricevalue = parseFloat(
      $(this).parent().parent().parent().parent().find(".product-price").text()
    );

    let cartId = $(this).data("cart-id");
    var siblings = $(this).siblings("input");

    if (parseInt(siblings.val(), 10) >= 2) {
      incAndDec(
        false,
        cartId,
        siblings,
        totalPriceElem,
        totalPriceValue,
        productPricevalue
      );
    } else {
      $(this)
        .parent()
        .parent()
        .parent()
        .next()
        .next()
        .find(".delete-cart")
        .click();
    }
  });

  $(".dec-btn").click(function () {
    var siblings = $(this).siblings("input");
    if (parseInt(siblings.val(), 10) >= 1) {
      siblings.val(parseInt(siblings.val(), 10) - 1);
    }
  });

  $(".inc-btn").click(function () {
    var siblings = $(this).siblings("input");
    siblings.val(parseInt(siblings.val(), 10) + 1);
  });

  $(".inc-cart-btn").click(function () {
    let totalPriceElem = $(this)
      .parent()
      .parent()
      .parent()
      .parent()
      .find(".product-total-price");
    let totalPriceValue = parseFloat(
      $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".product-total-price")
        .text()
    );
    let productPricevalue = parseFloat(
      $(this).parent().parent().parent().parent().find(".product-price").text()
    );

    let cartId = $(this).data("cart-id");
    var siblings = $(this).siblings("input");
    let max = $(this).data("max");

    if (parseInt(siblings.val(), 10) + 1 <= max) {
      incAndDec(
        true,
        cartId,
        siblings,
        totalPriceElem,
        totalPriceValue,
        productPricevalue
      );
    } else {
      swal("that's the limit of provided number of this product", "", "info");
    }
  });

  /* ===============================================================
           BOOTSTRAP SELECT
        =============================================================== */
  $(".selectpicker").on("change", function () {
    $(this)
      .closest(".dropdown")
      .find(".filter-option-inner-inner")
      .addClass("selected");
  });

  /* ===============================================================
           TOGGLE ALTERNATIVE BILLING ADDRESS
        =============================================================== */
  $("#alternateAddressCheckbox").on("change", function () {
    var checkboxId = "#" + $(this).attr("id").replace("Checkbox", "");
    $(checkboxId).toggleClass("d-none");
  });

  /* ===============================================================
           DISABLE UNWORKED ANCHORS
        =============================================================== */
  $('a[href="#"]').on("click", function (e) {
    e.preventDefault();
  });
});

/* ===============================================================
     COUNTRY SELECT BOX FILLING
  =============================================================== */
$.getJSON("js/countries.json", function (data) {
  $.each(data, function (key, value) {
    var selectOption =
      "<option value='" +
      value.name +
      "' data-dial-code='" +
      value.dial_code +
      "'>" +
      value.name +
      "</option>";
    $("select.country").append(selectOption);
  });
});

$(".add-to-cart").click(function () {
  let productId = $(this).attr("id");
  addOneProductToCart(productId);
});

$(document).on("click", ".add-to-cart-quantity", function () {
  let productId = $(this).attr("id");
  let productQuantity = $(`[data-quantity-id="${productId}"]`).val();
  let addToCartButton = $(this);
  addProductWithQuantityToCart(productId, productQuantity, addToCartButton);
});

$(document).on("click", ".add-to-fav", function () {
  let productId = $(this).attr("data-id");
  $(this).toggleClass("favorite");
  insertOrDeleteFav(productId);
});

$(document).on("click", ".add-to-fav-modal", function () {
  // let button = $(this);
  let productId = $(this).attr("data-id");
  let heart = $(this).find("i.fa-heart");
  var span = $(this).find("span");

  insertOrDeleteFav(productId);
  $(heart).toggleClass("far fas");
  if ($(heart).hasClass("far")) {
    $(span).text("Add to favorites");
  } else {
    $(span).text("Remove from favorites");
  }
});

function getCookie(name) {
  var cookieArray = document.cookie.split(";");

  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i].trim();
    if (cookie.indexOf(name + "=") === 0) {
      return cookie.substring(name.length + 1, cookie.length);
    }
  }

  // Return an empty string if the cookie is not found
  return false;
}

function loginSwal() {
  swal({
    icon: "info",
    title: "You Should login First",
    icon: "info",
    buttons: { confirm: "login", cancel: "Cancel" },
  }).then((res) => {
    if (res) {
      window.location.href = "login.php";
    }
  });
}

function checkLoginForDocument() {
  let userName = getCookie("username");
  $(document).click(function (event) {
    if (!userName && !$(event.target).closest(".swal-modal").length) {
      event.preventDefault();
      loginSwal();
    }
  });
}

function checkLofinForAjaxButtons() {
  let userName = getCookie("username");
  if (userName) {
    return true;
  } else {
    return false;
  }
}

$(document).ready(function () {
  $(document).on("click", ".pag-item", function () {
    $(".pag-item").removeClass("active");
    $(this).addClass("active");
  });
});

$(".delete-cart").click(function () {
  let cartId = $(this).data("cart-id");
  let row = $(this).parent().parent();
  swal({
    title: "Are you sure you want to delete this element?",
    icon: "error",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      removeCart(cartId, row);
    } else {
      swal("Your element is safe!");
    }
  });
});

$(".delete-fav").click(function () {
  let favId = $(this).data("fav-id");
  let row = $(this).parent().parent();
  swal({
    title: "Are you sure you want to delete this element?",
    icon: "error",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      removeFav(favId, row);
    } else {
      swal("Your element is safe!");
    }
  });
});
