<?php
    $productId =  $_GET['id'];

    $firstImage= $_FILES['image1']['tmp_name'];
    $firstImgName = $_FILES['image1']['name'];

    $secondImage= $_FILES['image2']['tmp_name'];
    $secondImgName = $_FILES['image2']['name'];

    $thirdImage= $_FILES['image3']['tmp_name'];
    $thirdImgName = $_FILES['image3']['name'];



    if($firstImgName == ""){
        $response = array("status" => "error", "message" => "you must upload the First Image","image1" => true);
        echo json_encode($response);
        die();
    }elseif($secondImgName == ""){
        $response = array("status" => "error", "message" => "You must upload the Second Image","image2" => true);
        echo json_encode($response);
        die();
    }elseif($thirdImgName == ""){
        $response = array("status" => "error", "message" => "You must upload the Third Image","image3" => true);
        echo json_encode($response);
        die();
    }




    if ($_FILES['image1']['error'] == 0 AND $_FILES['image2']['error'] == 0 AND $_FILES['image3']['error'] == 0) {

	// extension

	$extensions = ['jpg' , 'png' , 'gif','jpeg',"webp","avif"];

	$ext1 = explode('.', $firstImgName);
	$ext1 = strtolower(end($ext1));
    if (in_array($ext1, $extensions)) {

		// size 

		if ($_FILES['image1']['size'] < 2000000) {

			// unique name
			$newName = md5(uniqid()) . "." . $ext1;
			
			move_uploaded_file($firstImage, "../img/$newName");

		} else {
            $response = array("status" => "error", "message" => "file size is too big","image1" => true);
            echo json_encode($response);
			die();
		}

	} else {

	//  $response = array("status" => "sucsess", "message" => "product is added");
    $response = array("status" => "error", "message" => "Wrong Extension","image1" => true);
    echo json_encode($response);
		exit();
	}

    $ext2 = explode('.', $secondImgName);
	$ext2 = end($ext2);
    if (in_array($ext2, $extensions)) {

		// size 

		if ($_FILES['image2']['size'] < 2000000) {

			
			$newName2 = md5(uniqid()) . "." . $ext2;
			
			move_uploaded_file($secondImage, "../img/$newName2");

		} else {
            $response = array("status" => "error", "message" => "file size is too big","image2" => true);
            echo json_encode($response);
			
			exit();
		}

	} else {

	
    $response = array("status" => "error", "message" => "Wrong Extension","image2" => true);
    echo json_encode($response);
		exit();
	}

    $ext3 = explode('.', $thirdImgName);
	$ext3 = end($ext3);
    if (in_array($ext3, $extensions)) {

		// size 

		if ($_FILES['image3']['size'] < 2000000) {

			// unique name
			$newName3 = md5(uniqid()) . "." . $ext3;
			
			move_uploaded_file($thirdImage, "../img/$newName3");

		} else {
            $response = array("status" => "error", "message" => "file size is too big","image3" => true);
            echo json_encode($response);
			
			exit();
		}

	} else {

	//  $response = array("status" => "sucsess", "message" => "product is added");
    $response = array("status" => "error", "message" => "Wrong Extension","image3" => true);
    echo json_encode($response);
		exit();
	}

 


}else {
    $response = array("status" => "error", "message" => "you must upload the four images");
	echo json_encode($response);
	die();

}

include("connection.php");

$insert = "INSERT INTO product_images (product_id, image) VALUES ('$productId', '$newName'),('$productId', '$newName2'),('$productId', '$newName3')";
$query =$connection -> query($insert);
if($query){
    $response = array("status" => "succses", "message" => "Images is sent Sucssefully");
    echo json_encode($response);
}else{
    $response = array("status" => "error", "message" => "Some thing went wrong, please try again");
echo json_encode($response);
}
