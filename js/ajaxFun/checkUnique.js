function checkUnique(apiPage, inputFeildId, sendData, placeToDisplayError) {
  $.ajax({
    method: "POST",
    url: `phpFunctions/${apiPage}`,
    dataType: "json",
    data: {
      [sendData]: $(`#${inputFeildId}`).val(),
    },
    success: function (data) {
      if (sendData == "email") {
        validEmail = true;
      } else {
        validUserName = true;
      }
      console.log(data);
      if ($(`.${placeToDisplayError}`).hasClass("c-red")) {
        $(`.${placeToDisplayError}`)
          .removeClass("c-red")
          .addClass("c-green")
          .text(data.message);
      } else {
        $(`.${placeToDisplayError}`).addClass("c-green").text(data.message);
      }
    },
    error: function (xhr) {
      console.log(xhr);
      if (sendData == "email") {
        validEmail = false;
      } else {
        validUserName = false;
      }
      let response = xhr.responseJSON;
      if ($(`.${placeToDisplayError}`).hasClass("c-green")) {
        $(`.${placeToDisplayError}`)
          .removeClass("c-green")
          .addClass("c-red")
          .text(response.message);
      } else {
        $(`.${placeToDisplayError}`).addClass("c-red").text(response.message);
      }
    },
  });
}

$("#userName").blur(function (e) {
  checkUnique(
    "checkUniqueUserName.php",
    "userName",
    "username",
    "username-error"
  );
});

$("#email").blur(function (e) {
  checkUnique("checkUniqueEmail.php", "email", "email", "email-error");
});
