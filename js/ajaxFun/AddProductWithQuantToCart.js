function addProductWithQuantityToCart(productId, productQuantity, button) {
  if (checkLofinForAjaxButtons()) {
    $.ajax({
      method: "POST",
      url: "phpFunctions/insertOrUbdateProductWithQuant.php",
      dataType: "json",
      data: {
        productid: productId,
        productquantity: productQuantity,
      },
      success: function (response) {
        // Handle the successful response here
        console.log(response);
        swal("Good job!", response.message, "success")
          .then(() => {
            $(button)
              .closest(".modal-content")
              .find('button[data-dismiss="modal"]')
              .trigger("click");
          })
          .then(() => {
            if (!response.existBefore) {
              let currentNumOfProducts = parseInt($(".num-of-products").text());
              $(".num-of-products").text(currentNumOfProducts + 1);
            }
          })
          .then(() => {
            alertify.notify(response.message, "success", 2, function () {});
          });
      },
      error: function (xhr, status, error) {
        // Handle errors
        console.log(xhr);
        data = JSON.parse(xhr.responseText);
        swal("oppss!", data.message, "error");
      },
    });
  } else {
    loginSwal();
  }
}
