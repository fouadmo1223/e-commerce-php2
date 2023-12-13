function addSortingProductsToBody(objData) {
  $.ajax({
    method: "POST",
    url: "phpFunctions/selectSorting.php",
    dataType: "json",
    data: objData,
    beforeSend: function () {
      $(".show-products").html("");
      $(".show-products").html(`
            <div class="mt-30 w-100 d-flex justify-content-center">
              <div class="loader">
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__ball"></div>
              </div>
            </div>
          `);
    },
    success: function (data) {
      console.log(data);
      $(".show-products").html("");
      let products = data.products;
      for (let i = 0; i < products.length; i++) {
        $(".show-products").append(
          `
              <div class="col-xl-3 col-lg-4 col-sm-6 mb-25 "  data-aos="fade-up" data-aos-duration="1000" >
          <div class="product text-center hvr-float">
            <div class="position-relative mb-3">
            ${
              products[i].sale > 0
                ? "<div class='badge text-white badge-primary'>Sale</div>"
                : products[i].new > 0
                ? "<div class='badge text-white badge-info'>New</div>"
                : ""
            }
              <a class="d-block" href="detail.php?id=${
                products[i].id
              }"><img class="img-fluid w-100"  style="height: 350px;" src="admin/img/${
            products[i].image
          }" alt="..." loading="lazy"></a>
              <div class="product-overlay">
                <ul class="mb-0 list-inline">
                  <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-outline-dark add-to-fav ${
                    products[i].fav == true ? "favorite" : ""
                  }" data-id="${
            products[i].id
          }"><i class="far fa-heart"></i></button></li>
                  <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-dark add-to-cart" id="${
                    products[i].id
                  }" >Add to cart</button></li>
                  <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView${
                    products[i].id
                  }" data-toggle="modal"><i class="fas fa-expand"></i></a></li>
                </ul>
              </div>
            </div>
            <h6> <a class="reset-anchor" href="detail.html?id=${
              products[i].id
            }">${products[i].name}</a></h6>
            <p class="small text-muted">$${
              products[i].price - products[i].price * (products[i].sale / 100)
            }</p>
          </div>
        </div>
        
              `
        );
      }
      $(".pagination").html(``);
      $(".pagination").append(
        `<li class="page-item prev"><button class="page-link " aria-label="Previous"><span aria-hidden="true">«</span></button></li>`
      );
      for (let i = 1; i <= data.numOfPages; i++) {
        $(".pagination").append(
          `<li class="page-item pag-item cur-point ${
            data.currentPage == i ? "active" : ""
          }" data-page="${i}"><a class="page-link">${i}</a></li>`
        );
      }
      $(".pagination").append(
        `<li class="page-item next"><button class="page-link"  aria-label="Next"><span aria-hidden="true">»</span></button></li>`
      );
    },
    error: function (xhr) {
      console.log(xhr);
    },
  });
}
