// Call the dataTables jQuery plugin

$(document).ready(function () {
  $("#dataTable").DataTable({
    serverSide: true,
    processing: true,
    ajax: {
      url: "phpfun/fetchUsers.php",
      //   success: function (data) {
      //     console.log(data);
      //   },
      //   error: function (xhr) {
      //     console.log(xhr);
      //   },
    },
  });
});
