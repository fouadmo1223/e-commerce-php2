function removeCart(cartId, row) {
  $.ajax({
    method: "POST",
    url: "phpFunctions/deleteCart.php",
    dataType: "json",
    data: {
      cartId: cartId,
    },
    success: function (data) {
      console.log(data);
      $(row).remove();
      swal(data.message, "", "success");
    },
    error: function (xhr) {
      console.log(xhr);
      swal("Something went wrong please try again later", "", "error");
    },
  });
}
