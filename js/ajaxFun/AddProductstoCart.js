function addOneProductToCart(productId) {
  if (checkLofinForAjaxButtons()) {
    $.ajax({
      method: "POST",
      url: "phpFunctions/insertOrUbdateOneProduct.php",
      dataType: "json",
      data: {
        productid: productId,
      },
      success: function (response) {
        // Handle the successful response here
        console.log(response);
        swal("Good job!", response.message, "success").then(() => {
          if (!response.existBefore) {
            let currentNumOfProducts = parseInt($(".num-of-products").text());
            $(".num-of-products").text(currentNumOfProducts + 1);
          }
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
