$(".selectpicker").change(function () {
  let objData = {};
  let currURL = window.location.href;
  if (currURL.includes("?")) {
    let req = currURL.split("?")[1].split("=");
    if (req[0] == "catid") {
      objData["catid"] = req[1];
    } else if (req[0] == "main_catid") {
      objData["main_catid"] = req[1];
    }
  }
  let sorting = $(this).val();
  objData.sort = sorting;
  addSortingProductsToBody(objData);
});

$(document).on("click", ".pag-item", function (e) {
  let objData = {};
  let currURL = window.location.href;
  if (currURL.includes("?")) {
    let req = currURL.split("?")[1].split("=");
    if (req[0] == "catid") {
      objData["catid"] = req[1];
    } else if (req[0] == "main_catid") {
      objData["main_catid"] = req[1];
    }
  }
  let sorting = $(".selectpicker").val();
  objData.sort = sorting;
  objData.page = $(this).attr("data-page");
  addSortingProductsToBody(objData);
});
