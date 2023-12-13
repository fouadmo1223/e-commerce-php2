$("#vpassword").keyup(function (e) {
  if ($("#vpassword").val() != $("#password").val()) {
    $(".vpassword-error").removeClass("d-none");
    identicalPass = false;
  } else {
    if (!$("#vpassword").hasClass("d-none")) {
      $(".vpassword-error").addClass("d-none");
      identicalPass = true;
    }
  }
});

$("#password").keyup(function (e) {
  if (
    $("#vpassword").val() != $("#password").val() &&
    $("#vpassword").val().length > 0
  ) {
    $(".vpassword-error").removeClass("d-none");
    identicalPass = false;
  } else {
    if (!$("#vpassword").hasClass("d-none")) {
      $(".vpassword-error").addClass("d-none");
      identicalPass = true;
    }
  }
});
