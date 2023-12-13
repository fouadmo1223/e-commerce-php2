
<?php
    $productId = $_GET['id'];
    $selectProduct = $connection -> query("SELECT * FROM products WHERE id = $productId");
    if($selectProduct -> num_rows > 0){
        $product = $selectProduct -> fetch_assoc();
    }else{
        header("Location:products.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h4 class="my-3 hvr-float-shadow">Edit <?= $product['name'] ?></h4>

    <form class="add-product w-100" id="<?= $productId ?>" enctype="multipart/form-data" data-aos="zoom-in">
        <div class="row">

        <div class="form-group col-12 col-lg-6">
            <label for="productName" class=" fw-bold">Product Name</label>
            <input value="<?= $product['name'] ?>" type="text" name="productName" required  placeholder="Enter product name"  class="form-control" id="productName" aria-describedby="emailHelp">
            <div class="product-name-validation">  
            </div>
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="productPrice" class=" fw-bold">Product Price</label>
            <input type="number" value="<?= $product['price'] ?>" required name="productPrice" placeholder="Enter product price"  class="form-control" id="productPrice" aria-describedby="emailHelp">
            <div class="product-price-validation">  
            </div>
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="productCount" class=" fw-bold">Product Count</label>
            <input type="number" value="<?= $product['count'] ?>" required name="productCount" placeholder="Enter product quantity"  class="form-control" id="productCount" aria-describedby="emailHelp">
            <div class="product-count-validation">  
            </div>
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="productSale" class=" fw-bold">Product Sale (%)</label>
            <input type="number" value="<?= $product['sale'] ?>" required name="productSale" placeholder="Enter product sale"  class="form-control" id="productSale" aria-describedby="emailHelp">
            <div class="product-sale-validation">  
            </div>
        </div>

        <div class="form-group col-12 " style="padding-left:15px">
            <label for="productDescribtion" class="fw-bold">Product Describtion</label>
            <textarea class="form-control product-describtion"  required  name="productDescribtion" placeholder="Enter product describtion" id="productDescribtion" rows="4"><?= $product['describtion'] ?></textarea>
            <div class="product-describtion-validation">  
            </div>  
            
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="productCategory">Product Category</label>
            <select class="form-control" required name="productCategory" id="productCategory">
                <?php
                    $selectCat = $connection -> query("SELECT * FROM categories");
                    foreach( $selectCat as $category ){
                ?>
                <option <?php
                if($category['id'] == $product['category_id']){
                    echo "selected";
                }   
                ?>  value="<?= $category['id'] ?>" >
                <?= $category['name'] ?></option>
                <?php
                    }
                ?>
            </select>
            <div class="product-category-validation">  
            </div>
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="productBrand">Product Brand</label>
            <select class="form-control" required name="productBrand" id="productBrand">
                <?php
                    $selectbrand = $connection -> query("SELECT * FROM brands");
                    foreach( $selectbrand as $brand ){
                ?>
                <option <?php
                if($brand['id'] == $product['brand_id']){
                    echo "selected";
                }   
                ?> value="<?= $brand['id']?>"  >
                <?= $brand['name'] ?></option>
                <?php
                    }
                ?>
            </select>
            <div class="product-brand-validation">  
            </div>
        </div>

        <div class="col-12 p-15">
            <div class="custom-file ">
                    <input type="file"   name="productImage" accept="image/*" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose Product image</label>
            </div>
            <div class="product-image-validation">  
            </div>
                <img src="img/<?= $product['image'] ?>" class="uploadedImage " style="width: 70px; height:70px; margin-top:10px" alt="">
        </div>

        <div class="col-12 p-15">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input"<?php
                        if($product['new'] == 1){
                            echo 'checked';
                        }
                    ?> name="new" type="checkbox" value="1" id="New" >
                    <label class="form-check-label" for="New">
                        New
                    </label>
                </div>
            </div>
        </div>
        
        <div class="p-15">
        <button class="btn btn-primary" type="submit">Edit product</button>
        </div>

        </div>
    </form>


    <script>
        $("#productPrice").keypress(function (e) {
           if(isNaN(e.key)){
            e.preventDefault();
           }
        })
        $("#productCount").keypress(function (e) {
           if(isNaN(e.key)){
            e.preventDefault();
           }
        })
        $("#productSale").keypress(function (e) {
           if(isNaN(e.key)){
            e.preventDefault();
           }
        })

        $("#customFile").change(function (e) {
            let fileInput = event.target;
            let selectedFile = fileInput.files[0];
            

            if (selectedFile) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    let imageDataUrl = e.target.result;
                    $(`.uploadedImage`).attr("src", imageDataUrl);
                };
                reader.readAsDataURL(selectedFile);
            }

        })
    </script>
    <script>
        $(".add-product").submit(function (e) {
            e.preventDefault();
            let productId = $(this).attr("id");
            let formData =new FormData(this);
            formData.append("productId",productId);
            $.ajax({
                method:"POST",
                url:"phpfun/updateProduct.php",
                data:formData,
                processData: false, // Prevent jQuery from processing data
                contentType: false, // Prevent jQuery from setting content typ
                success:function (data) {
                    if(data == "something went wrong"){
                        swal({
                            title: `${data}`,
                            icon: "error",
                            dangerMode: true,
                        })
                    }else{
                        swal({
                            title: `product is Updated successfully`,
                            icon: "success",
                            dangerMode: true,
                        }).then(() => {
                            window.location.replace("products.php");
                        });
                            }
                },
                error:function(xhr){
                    swal({
                            title: `Failed to update the product`,
                            icon: "error",
                            dangerMode: true,
                        })
                    console.log(xhr);
                    let errors =JSON.parse(xhr.responseJSON);
                    console.log(errors);
                    if(errors.hasOwnProperty("nameError")){
                        $(".product-name-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["nameError"]);
                        $("#productName").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("nameSuccess")){
                        $(".product-name-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["nameSuccess"]);
                        $("#productName").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("describtionError")){
                        $(".product-describtion-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["describtionError"]);
                        $("#productDescribtion").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("describtionSuccess")){
                        $(".product-name-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["describtionSuccess"]);
                        $("#productDescribtion").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("categoryError")){
                        $(".product-category-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["categoryError"]);
                        $("#productCategory").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("categorySuccess")){
                        $(".product-category-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["categorySuccess"]);
                        $("#productCategory").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("BrandError")){
                        $(".product-brand-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["BrandError"]);
                        $("#productBrand").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("BrandSuccess")){
                        $(".product-brand-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["BrandSuccess"]);
                        $("#productBrand").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("priceError")){
                        $(".product-price-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["priceError"]);
                        $("#productPrice").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("priceSuccess")){
                        $(".product-price-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["priceSuccess"]);
                        $("#productPrice").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("imageError")){
                        $(".product-image-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["imageError"]);
                        $("#customFile").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("imageSuccess")){
                        $(".product-image-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["imageSuccess"]);
                        $("#customFile").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("countError")){
                        $(".product-count-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["countError"]);
                        $("#productCount").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("countSuccess")){
                        $(".product-count-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["countSuccess"]);
                        $("#productCount").removeClass("is-invalid").addClass("is-valid");
                    }

                    if(errors.hasOwnProperty("saleError")){
                        $(".product-sale-validation").removeClass("valid-feedback").addClass("invalid-feedback").text(errors["saleError"]);
                        $("#productSale").removeClass("is-valid").addClass("is-invalid");
                    }
                    else if(errors.hasOwnProperty("saleSuccess")){
                        $(".product-sale-validation").removeClass("invalid-feedback").addClass("valid-feedback").text(errors["saleSuccess"]);
                        $("#productSale").removeClass("is-invalid").addClass("is-valid");
                    }
                    

                    
                }
            })
        })
    </script>

</body>
</html>