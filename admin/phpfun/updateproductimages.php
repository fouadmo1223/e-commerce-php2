<?php
    $imageArr = [];
    $arr = $_FILES;
    foreach($arr as $img){
      if($img['error'] ==0){
        $imageArr[] = $img;
      }
    }
    include("connection.php");
    $ids=explode(",",$_POST['ids']);
    // print_r($imageArr);
    $extensions = ['jpg' , 'png' , 'gif','jpeg',"webp","avif"];

    for($i = 0; $i < count($imageArr); $i++){
        $imageId = $ids[$i] ;
        $imageTemp = $imageArr[$i]['tmp_name'];
        $imageName = $imageArr[$i]['name'];
        // $ext = strtolower(end(explode(".",$imageName)));
         $ext = explode(".",$imageName);
         $ext = strtolower(end($ext));

         if(in_array($ext,$extensions)){
            if ($imageArr[$i]['size'] < 2000000) {

                $selectImage = $connection -> query("SELECT * FROM product_images WHERE id = $imageId");
                $image = $selectImage -> fetch_assoc();
                $oldImageName = $image['image'];
                $newImageName = md5(uniqid()) . "." . $ext;
               
                $updateImage = $connection -> query("UPDATE product_images SET image='$newImageName' WHERE id = $imageId");
                move_uploaded_file($imageTemp , "../img/$newImageName");
                unlink("../img/$oldImageName");
                
            }else{
                $response = array("status" => "error", "message" => "file size must be less or equal to 2MB");
                echo json_encode($response);
                die();
            }
         }else{
            $response = array("status" => "error", "message" => "wrong file extenstion");
            echo json_encode($response);
			die();
         }

                $response = array("status" => "succses", "message" => "product images is updated");
                echo json_encode($response);
                

    }
  
   
   
?>