
<?php
    $id = $_GET['id'];
    $selectproduct = $connection -> query("SELECT * FROM products WHERE id = $id");
    $product = $selectproduct -> fetch_assoc();

?>


<div class="col-12">
<h2 class=" hvr-float-shadow txt-c" style="display: block; width:fit-content"><?=$product['name']?>'s Imgaes</h2>

</div>
<?php
    $selecte = $connection -> query("SELECT * FROM product_images WHERE product_id = $id ");
    foreach($selecte as $image){ 
?>
<div class="col-12 col-md-6 col-lg-4">
    <div class="d-flex p-20" style="flex-direction:column">
      <div class="mb-20 d-flex">
      
      <div>
        <button class="cssbuttons-io-button" id="<?= $image['id'] ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path></svg>
        <span>Change Image</span>
        </button>
      </div>
      <span class="image1error c-red fs-13 ml-20 d-none"></span>
      </div>
      <div style="width:200px;height:200px" class="">
        <img src="img/<?= $image['image'] ?>" class="w-full h-full" data-id ="<?= $image['id'] ?>" alt="">
      </div>
      

    </div>
</div>
<?php
    }
?>


<form class="send-images col-12">

<?php
    $selecte = $connection -> query("SELECT * FROM product_images WHERE product_id = $id ");
    foreach($selecte as $image){ 
?>
<input type="file" name="<?= $image['id']?>"  data-image-id="<?= $image['id']?>"class="d-none"  >
<?php
    }
?>

<div class="p-10 col-12">
<button class="btn btn-success p-10 hvr-float mt-20 mb-20 change">Send Changes</button>
</div>
</form>

<script>

    let changedImages =[];
  
    $(".cssbuttons-io-button").click(function(e){
      let targetId= $(this).attr("id");
      $(`[data-image-id='${targetId}']`).trigger("click");
    //   console.log(targetId);
    })

    $("input[type=file]").change(function (event) {
        
    let targetImage = $(this).attr("data-image-id");
    changedImages.push(targetImage);
    let fileInput = event.target;
    let selectedFile = fileInput.files[0];
    console.log(targetImage);

    if (selectedFile) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let imageDataUrl = e.target.result;
            $(`[data-id='${targetImage}']`).attr("src", imageDataUrl).removeClass("d-none");
        };
        reader.readAsDataURL(selectedFile);
    }
});




$(".send-images").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        formData.append("ids",changedImages);

       (async()=>{
            $.ajax({
                method:"POST",
                url:"Phpfun/updateproductimages.php?id=<?= $id ?>",
                data:formData,
                dataType:"json",
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                success:function(response){
                    if(response.status == "error"){
                        swal(response.message, {
                        icon: "error",
                    }).then(()=>{
                        alertify.notify(response.message, 'error', 1, function(){ });
                    });
                    }else{
                        swal(response.message, {
                        icon: "success",
                    }).then(()=>{
                        alertify.notify(response.message, 'success', 1, function(){ });
                    });
                }
                }
            })

        })();

    })




</script>