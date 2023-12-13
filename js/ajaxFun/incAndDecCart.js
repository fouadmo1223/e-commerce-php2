function incAndDec(
  booleanInc,
  cartId,
  siblings,
  totalPriceElem,
  totalPriceValue,
  productPricevalue
) {
  $.ajax({
    method: "POST",
    url: "phpFunctions/incAndDecCart.php",
    dataType: "json",
    data: {
      inc: booleanInc,
      cartId: cartId,
    },
    beforeSend: () => {
      $(this).prop("disabled", true);
    },
    success: (data) => {
      console.log(data);
      $(this).prop("disabled", false);
      if (booleanInc) {
        siblings.val(parseInt(siblings.val(), 10) + 1);
        $(totalPriceElem).text(totalPriceValue + productPricevalue);
      } else {
        siblings.val(parseInt(siblings.val(), 10) - 1);
        $(totalPriceElem).text(totalPriceValue - productPricevalue);
      }
    },
    error: (xhr) => {
      $(this).prop("disabled", false);
      if (xhr.hasOwnProperty("responseJSON")) {
        swal(xhr.responseJSON.message, "", "error");
      }
      console.log(xhr);
    },
  });
}
