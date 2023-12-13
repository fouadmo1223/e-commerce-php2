$(document).on("click", ".delete-comment", function () {
  let deleteCommentButton = $(this);
  let reviewId = $(this).attr("data-review-id");

  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this Comment",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      // swal("Poof! Your Comment has been deleted!", {
      //   icon: "success",
      // });

      $.ajax({
        method: "POST",
        url: "phpFunctions/deleteComment.php",
        dataType: "json",
        data: {
          reviewId,
        },
        success: function (data) {
          console.log(data);
          $(deleteCommentButton)
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .remove();
          swal(`Poof! ${data.message}`, {
            icon: "success",
          });
        },
        error: function (xhr) {
          if (xhr.status == 400 || xhr.status == 500 || xhr.status == 401) {
            let response = xhr.responseJSON;

            swal(response.message, {
              icon: "error",
            });
          }
        },
      });
    } else {
      swal("Your Comment is safe!");
    }
  });
});
