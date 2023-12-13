<?php
// 
include("connection.php");

if(isset($_POST['categoryName'])){
    $category = $_POST['categoryName'];
    if(strlen($category)<= 2){
        http_response_code(400);
        echo json_encode(array('status'=> 'error','message'=> 'Category name must be provided'));
        die();
    }else{
        $checkCat = $connection -> query("SELECT * FROM categories WHERE name='$category'");
        if($checkCat->num_rows > 0){
            http_response_code(400);
            echo json_encode(array('status'=> 'error','message'=> 'Category name exists before'));
            die();
        }else{
            $insert = $connection -> query("INSERT INTO categories (name) VALUES ('$category')");
            if($insert){
                echo json_encode(array('status'=> 'succsess','message'=> 'category is added successfully'));
                die();
            }else{
                http_response_code(400);
                echo json_encode(array('status'=> 'error','message'=> 'Something went wrong, please try again'));
                die();
            }
        }
    }
}else{
    http_response_code(400);
    echo json_encode(array('status'=> 'error','message'=> 'Category name must be provided'));
}

?>