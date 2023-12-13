$(document).on("click", ".prev", function () {
  let page = $(this).parent().find(".active").text();
  page = parseInt(page) - 1;
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
  objData.page = page;
  addSortingProductsToBody(objData);
});

$(document).on("click", ".next", function () {
  let page = $(this).parent().find(".active").text();
  page = parseInt(page) + 1;
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
  objData.page = page;
  addSortingProductsToBody(objData);
});
