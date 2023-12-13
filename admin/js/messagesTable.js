$(document).ready(function () {
  $("#messageTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "phpfun/fetchMessages.php",
    },
  });
});
