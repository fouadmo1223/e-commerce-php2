$(document).ready(function () {
  $("#couponTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "phpfun/fetchCoupons.php",
      //   success: function (data) {
      //     console.log(data);
      //   },
      //   error: function (xhr) {
      //     console.log(xhr);
      //   },
    },
  });
});
