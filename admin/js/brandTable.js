$(document).ready(function () {
  $("#brandTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "phpfun/fetchbrands.php",
      //   success: function (data) {
      //     console.log(data);
      //   },
      //   error: function (xhr) {
      //     console.log(xhr);
      //   },
    },
  });
});
