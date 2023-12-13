(async () => {
  const inputs = document.querySelectorAll(".otp-field input");
  inputs.forEach((input, index) => {
    input.dataset.index = index;
    input.addEventListener("keyup", handleOtp);
    input.addEventListener("paste", handleOnPasteOtp);
  });

  function handleOtp(e) {
    const input = e.target;
    let value = input.value;
    let isValidInput = value.match(/[0-9]/gi);
    input.value = "";
    input.value = isValidInput ? value[0] : "";
    let fieldIndex = input.dataset.index;
    if (fieldIndex < inputs.length - 1 && isValidInput) {
      input.nextElementSibling.focus();
    }
    if (e.key === "Backspace" && fieldIndex > 0) {
      input.previousElementSibling.focus();
    }
  }

  function handleOnPasteOtp(e) {
    const data = e.clipboardData.getData("text");
    const value = data.split("");
    if (value.length === inputs.length) {
      inputs.forEach((input, index) => (input.value = value[index]));
    }
  }

  let errorMessages,
    otpcode,
    otpcode1,
    otpcode2,
    otpcode3,
    otpcode4,
    otpcode5,
    otpcode6;
  $(".otppage input[type='text']").keypress(function (event) {
    if (isNaN(event.key)) {
      event.preventDefault();
    }
  });

  $(".form").submit(function (event) {
    event.preventDefault();
    otpcode1 = $("#otp1").val();
    otpcode2 = $("#otp2").val();
    otpcode3 = $("#otp3").val();
    otpcode4 = $("#otp4").val();
    otpcode5 = $("#otp5").val();
    otpcode6 = $("#otp6").val();
    otpcode = otpcode1 + otpcode2 + otpcode3 + otpcode4 + otpcode5 + otpcode6;
    let obData = {
      otp: otpcode,
    };
    $.ajax({
      method: "POST",
      url: "phpFunctions/checkOtp.php",
      dataType: "json",

      data: obData,
      success: function (data, st, xhr) {
        console.log(data);
        $(".wrong-pass").css("display", "none");
        swal("Well Done", data.message, "success").then(() => {
          alertify.notify(data.message, "success", 1, function () {
            window.location.replace("index.php");
          });
        });
      },
      error: function (xhr, status, err) {
        console.log(xhr);
        if (xhr.status == 401) {
          swal("ooops!!!!", xhr.responseJSON.message, "error").then(() => {
            alertify.notify(xhr.responseJSON.message, "error", 1, function () {
              window.location.replace("register.php");
            });
          });
        } else if (xhr.status === 400) {
          $(".wrong-pass").css("display", "block");
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
  });

  // Make resend anchor

  $(".resend").click(function (event) {
    event.preventDefault();
    $(".resend").css("pointer-events", "none");
    let minuts = 1;
    let seconds = 60;
    timer = setInterval(function () {
      seconds--;
      if (seconds < 10) {
        $(".lefttime").html(
          "0" +
            minuts +
            " " +
            ":" +
            " " +
            "0" +
            seconds +
            "    " +
            "Remaind to resend again"
        );
      } else {
        $(".lefttime").html(
          "0" +
            minuts +
            " " +
            ":" +
            " " +
            seconds +
            "    " +
            "Remaind to resend again"
        );
      }
      if (seconds == 0) {
        seconds = 59;
        if (minuts == "0") {
          clearInterval(timer);
          $(".lefttime").html(" ");
          $(".resend").css("pointer-events", "all");
          $.ajax({
            method: "POST",
            url: "phpFunctions/UpdateOtp.php",
            dataType: "json",
            success: function (data, st, xhr) {
              console.log(data);
              swal(data.message, "", "success").then(() => {
                alertify.notify(data.message, "success", 3, function () {});
              });
            },
            error: function (xhr, status, err) {
              let res = xhr.responseJSON;
              swal(res.message, "", "error").then(() => {
                alertify.notify(res.message, "error", 3, function () {});
              });
            },
          });
        }
        minuts--;
      }
    }, 1000);
  });
})();
