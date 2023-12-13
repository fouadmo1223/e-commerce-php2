$(document).ready(function () {
  $("#categoryTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "phpfun/fetchcategories.php",
      //   success: function (data) {
      //     console.log(data);
      //   },
      //   error: function (xhr) {
      //     console.log(xhr);
      //   },
    },
  });
});
