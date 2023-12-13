$(document).ready(function () {
  $("#productTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "phpfun/fetchProducts.php",
    },
  });
});
