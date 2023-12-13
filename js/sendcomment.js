$(".sendComment").click(function () {
  $(".comment, .rate").text("");
  let productId = $(this).attr("data-id");
  let comment = $("#comment").val();
  let rate = $("#rate").val();
  $.ajax({
    method: "POST",
    url: "phpFunctions/insertComment.php",
    dataType: "json",
    data: { productId, comment, rate },
    beforeSend: function () {
      $(".spinner-border").removeClass("d-none");
      $(".sendComment").addClass("disabled");
    },
    success: function (data) {
      console.log(data);
      let rate = $("#rate").val();
      let comment = $("#comment").val();
      $(".no-reviews-h2").addClass("d-none");
      $(".spinner-border").addClass("d-none");
      $(".sendComment").removeClass("disabled");
      swal("Good job!", data.message, "success")
        .then(() => {
          $(".show-reviews").prepend(
            `
            <div class="media mb-3"><img class="rounded-circle" src="admin/img/profilepic.svg" alt="" width="50">
              <div class="media-body ml-3">
                <h6 class="mb-0 text-uppercase"><?= $fullName ?></h6>
                <p class="small text-muted mb-0 text-uppercase">Just now</p>
                <ul class="list-inline mb-1 text-xs" title="${rate}">
                ${(() => {
                  let starsHtml = "";
                  for (let i = 0; i < rate; i++) {
                    if (i + 1 > rate) {
                      starsHtml += `<li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>`;
                    } else {
                      starsHtml += `<li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>`;
                    }
                  }
                  return starsHtml;
                })()}
                </ul>
                <div class="row">
                <div class="d-flex col-12 p-0">
                  <p class="text-small mb-0 text-muted col-8">${comment}</p>
                    <div class="d-flex w-100 col-4">
                    <button  class='btn btn-danger btn-circle  hvr-buzz rad-half  delete-comment ml-10' style='width:30px;height: 30px;padding:0;border:0;text-align:center' data-review-id="${
                      data.id
                    }"> <i class='fas fa-trash'></i> </button>
                    </div>
                </div>
                </div>
              </div>
            </div>
            `
          );
        })
        .then(() => {
          $(".close").trigger("click");
          $("#rate,#comment").val("");
        });
    },
    error: function (xhr) {
      $(".spinner-border").addClass("d-none");
      $(".sendComment").removeClass("disabled");
      console.log(xhr);
      if (xhr.status == 400) {
        let response = JSON.parse(xhr.responseText);
        console.log(response);
        let errors = response.errors;
        let keys = Object.keys(errors);

        for (let i = 0; i < keys.length; i++) {
          $(`.${keys[i]}`).text(response.errors[keys[i]]);
        }
      } else if (xhr.status == 401) {
        let response = JSON.parse(xhr.responseText);
        swal("oopps!", response.message, "error");
      } else {
        let response = JSON.parse(xhr.responseText);
        swal("oopps!", response.message, "error");
      }
    },
  });
});
