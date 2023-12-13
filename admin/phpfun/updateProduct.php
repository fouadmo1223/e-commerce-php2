<?php
   include 'connection.php';
    $errors =[];
    $success =[];
    $newImageName ="";
    $imageTemp ="";
    $productId = $_POST['productId'];
    $selectProduct = $connection -> query("SELECT * FROM products WHERE id = '$productId'");
    if($selectProduct->num_rows > 0){
        $productInfo = $selectProduct->fetch_assoc();
        $oldImage= $productInfo["image"];
    }else{
        header("Location:products.php");
        exit();
    }
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productCount = $_POST['productCount'];
    $productSale = $_POST['productSale'];
    $productDescribtion = $_POST['productDescribtion'];
    $productCategory = $_POST['productCategory'];
    $productBrand = $_POST['productBrand'];
    if(isset($_POST['new'])){
        $new = 1;
    }else{
        $new = 0;
    }
    $image = $_FILES['productImage'];
    if($image['error'] == 0){
        $imageName = $image['name'];
        $imageTemp = $image['tmp_name'];
        $extensions = ['jpg' , 'png' , 'gif','jpeg',"webp","avif"];
        $ext = explode('.', $imageName);
        $ext = end($ext);
        if (in_array($ext, $extensions)) {
            if($image['size'] < 2000000){
                $newImageName = md5(uniqid()).".$ext";
                $success['imageSuccess'] = "valid product image";
                unset($errors["imageError"]);
            }else{
                $errors["imageError"] ="Product image is larger than 2MB";
                unset($success['imageSuccess']);
            }
        }else{
            $errors["imageError"] ="Wrong image extension";
            unset($success['imageSuccess']);
        }
        

    }else{
       $newImageName = $oldImage;
    }


    if(strlen($productName) == 0){
        $errors["nameError"] ="product name must be at least 1 char";
        unset($success['nameSuccess']);
    }else{
        $success['nameSuccess'] = "valid product name";
        unset( $errors["nameError"]);
    }
    
    if(strlen($productDescribtion) == 0){
        $errors["describtionError"] ="product Describtion must be at least 1 char";
        unset($success['describtionSuccess']);
    }else{
        $success['describtionSuccess'] = "valid product Describtion";
        unset($errors["describtionError"]);
    }

    if(strlen($productCategory) == 0){
        $errors["categoryError"] ="product Category must be at least 1 char";
        unset($success['categorySuccess']);
    }else{
        $success['categorySuccess'] = "valid product Category";
        unset($errors["categoryError"]);
    }

    if(strlen($productBrand) == 0){
        $errors["BrandError"] ="product Brand must be at least 1 char";
        unset($success['BrandSuccess']);
    }else{
        unset($errors["BrandError"]);
        $success['BrandSuccess'] = "valid product Brand";
    }

    if (!is_numeric((float)$productCount) || $productCount ==0 || $productCount ==="") {
        $errors["countError"] ="product Count must be a number";
        unset($success["countSuccess"]);
    } else {
        $success["countSuccess"] ="Valid product Count";
        unset($errors["countError"]);
    }

    if (!is_numeric((float)$productPrice  ) || $productPrice == 0 || $productPrice === "") {
        $errors["priceError"] ="product Price must be a number";
        unset($success["priceSuccess"]);
    } else {
        $success["priceSuccess"] ="Valid product Price";
        unset($errors["priceError"]);
    }

    if (!is_numeric((int)$productSale)  || $productSale === "") {
        $errors["saleError"] ="product Sale must be a number";
        unset($success["saleSuccess"]);
    } else {
        if($productSale > 100){
            $errors["saleError"] ="product Sale must be lower than 100";
            unset($success["saleSuccess"]);
        }else{
            $success["saleSuccess"] ="Valid Sale Price";
            unset($errors["saleError"]);
        }

    }



    try {
        if (empty($errors)) {

            $productName = mysqli_real_escape_string($connection, $productName);
            $productPrice = mysqli_real_escape_string($connection, $productPrice);
            $productCount = mysqli_real_escape_string($connection, $productCount);
            $productSale = mysqli_real_escape_string($connection, $productSale);
            $productDescribtion = mysqli_real_escape_string($connection, $productDescribtion);
            $productCategory = mysqli_real_escape_string($connection, $productCategory);
            $productBrand = mysqli_real_escape_string($connection, $productBrand);
            $new = mysqli_real_escape_string($connection, $new);
            $newImageName = mysqli_real_escape_string($connection, $newImageName);

            // Insert data into the database or perform other actions
           
            $updateQuery = $connection->prepare("UPDATE products SET name=?, price=?, image=?, describtion=?, count=?, brand_id=?, category_id=?, sale=?, new=?, rate='5' WHERE id=?");
            $updateQuery->bind_param('sssssssssi', $productName, $productPrice, $newImageName, $productDescribtion, $productCount, $productBrand, $productCategory, $productSale, $new, $productId);
    
            if($updateQuery->execute()){
                   if($oldImage != $newImageName ){
                    move_uploaded_file($imageTemp,"../img/$newImageName");
                    unlink("../img/$oldImage");
                   }
                echo "empty";
            } else{
                echo "something went wrong";
            }                      
        } else {
            // http_response_code(400);
            $combinedMessages = array_merge($errors, $success);
            throw new Exception(json_encode($combinedMessages));
        }
    } catch (Exception $e) {
        http_response_code(400);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($e->getMessage());
    }

  
?>