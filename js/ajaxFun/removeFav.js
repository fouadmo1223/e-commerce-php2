function removeFav(favId, row) {
  $.ajax({
    method: "POST",
    url: "phpFunctions/deleteFav.php",
    dataType: "json",
    data: {
      favId: favId,
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
