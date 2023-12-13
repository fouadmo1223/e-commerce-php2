$(".send-serial").submit(function (e) {
  e.preventDefault();
  if ($(".serial-input").val().length > 5) {
    let totalPrice = parseFloat($(".total-after-discount").text());
    console.log(totalPrice);
    $.ajax({
      method: "POST",
      url: "phpFunctions/checkCoupon.php",
      dataType: "json",
      data: {
        serial: $(".serial-input").val(),
      },
      beforeSend: function () {
        $(".send-coupon").prop("disabled", true);
      },
      success: function (data) {
        $(".serial-input").prop("disabled", true);
        $(".serial-input").prop("readonly", true);
        console.log(data);
        $(".discount-value").text(`${data.discount} %`);
        $(".total-after-discount").text(
          totalPrice - totalPrice * (parseFloat(data.discount) / 100)
        );
        swal("Well done", data.message, "success").then(() => {
          alertify.notify(data.message, "success", 2, function () {});
        });
      },
      error: function (xhr) {
        $(".send-coupon").prop("disabled", false);
        console.log(xhr);
        if (xhr.status == 401) {
          swal("ooops!!!!", xhr.responseJSON.message, "error").then(() => {
            window.location.replace("login.php");
          });
        } else {
          swal("ooops!!!!", xhr.responseJSON.message, "error").then(() => {
            alertify.notify(
              xhr.responseJSON.message,
              "error",
              1,
              function () {}
            );
          });
        }
      },
    });
  }
});
