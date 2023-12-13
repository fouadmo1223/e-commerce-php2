function insertOrDeleteFav(productId) {
  if (checkLofinForAjaxButtons()) {
    $.ajax({
      method: "POST",
      url: "phpFunctions/insertOrDeleteFav.php",
      dataType: "json",
      data: {
        productid: productId,
      },
      success: function (response) {
        // Handle the successful response here
        console.log(response);
        let currentNumOfFavs = parseInt($(".num-of-favs").text());
        swal("Good job!", response.message, "success").then(() => {
          if (response.fav) {
            $(".num-of-favs").text(currentNumOfFavs + 1);
          } else {
            $(".num-of-favs").text(currentNumOfFavs - 1);
          }
        });
      },
      error: function (xhr, status, error) {
        // Handle errors
        console.log(xhr);
        data = JSON.parse(xhr.responseText);
        swal("oppss!", data.message, "error");
      },
    });
  } else {
    loginSwal();
  }
}
