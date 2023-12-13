<?php
    $id = $_GET['id'];
    $selectproduct = $connection -> query("SELECT * FROM products WHERE id = $id");
    $product = $selectproduct -> fetch_assoc();

?>

<div class = "col-12">
<h2 class=" hvr-float-shadow txt-c" style="display: block; width:fit-content"><?=$product['name']?>'s  Imgaes</h2>
</div>


<div class="col-12 col-md-6 col-lg-4">
    <div class="d-flex p-20" style="flex-direction:column">
      <div class="mb-20 d-flex">
      
      <div>
        <button class="addimage" id="image1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125" stroke="#fffffff" stroke-width="2"></path>
                <path d="M17 15V18M17 21V18M17 18H14M17 18H20" stroke="#fffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                ADD Image 
        </button>
      </div>
      <span class="image1error c-red fs-13 ml-20 d-none"></span>
      </div>
      <div style="width:200px;height:200px" class="">
        <img src="" class="w-full h-full d-none" data-id ="image1" alt="">
      </div>
      

    </div>
</div>

<div class="col-12 col-md-6 col-lg-4">
    <div class="d-flex p-20" style="flex-direction:column">
      <div class="mb-20 d-flex"> 
      
      <div>
      <button class="addimage" id="image2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125" stroke="#fffffff" stroke-width="2"></path>
                <path d="M17 15V18M17 21V18M17 18H14M17 18H20" stroke="#fffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                ADD Image 
        </button>
      </div>
      <span class="image2error c-red fs-13 ml-20  d-none"></span>
      </div>
      <div style="width:200px;height:200px" class="">
        <img src="" class="w-full h-full d-none" data-id ="image2" alt="">
      </div>

    </div>
</div>

<div class="col-12 col-md-6 col-lg-4">
    <div class="d-flex p-20" style="flex-direction:column">
      <div class="mb-20 d-flex">
      
      <div>
      <button class="addimage" id="image3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H11M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125" stroke="#fffffff" stroke-width="2"></path>
                <path d="M17 15V18M17 21V18M17 18H14M17 18H20" stroke="#fffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                ADD Image 
        </button>
      </div>
      <span class="image3error c-red fs-13 ml-20  d-none"></span>
      </div>
      <div style="width:200px;height:200px" class="">
        <img src="" class="w-full h-full d-none" data-id ="image3" alt="">
      </div>

    </div>
</div>




<form  class="send-images col-12">
<input type="file" required name="image1" accept="image/*"  data-image-id="image1"class="d-none"  >
<input type="file" required name="image2" accept="image/*" data-image-id="image2"class="d-none"  >
<input type="file" required name="image3" accept="image/*" data-image-id="image3"class="d-none"  >

<div class="col-12">
<input type="submit" class="bt- btn-success mt-40 p-10 mb-20 w-fit sendd" value="Send Images"   >
</div>
</form>

<script>

  
    $(".addimage").click(function(e){
      let targetId= $(this).attr("id");
      $(`[data-image-id='${targetId}']`).trigger("click");
      console.log(targetId);
    })

    $(".sendd").click(function(e){
        if($("[data-image-id=image1]").val() == "" || $("[data-image-id=image4]").val() == "" || $("[data-image-id=image3]").val() == "" || $("[data-image-id=image2]").val() == ""){
            e.preventDefault();
            swal("All images must have value", "","error")
        }
    })

    $("input[type=file]").change(function (event) {
    let targetImage = $(this).attr("data-image-id");
    let fileInput = event.target;
    let selectedFile = fileInput.files[0];

    if (selectedFile) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let imageDataUrl = e.target.result;
            $(`[data-id='${targetImage}']`).attr("src", imageDataUrl).removeClass("d-none");
        };
        reader.readAsDataURL(selectedFile);
    }
});

let allImages = document.querySelectorAll("[data-id]");
allImages.forEach((image) => {
        if($(image).attr("src").length> 0 && $(image).hasClass("d-none")) {
            $(image).removeClass("d-none");
        }
    });

    $(".send-images").submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

       (async()=>{
            $.ajax({
                method:"POST",
                url:"Phpfun/addImages.php?id=<?= $id ?>",
                data:formData,
                dataType:"json",
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                success:function(data){
                    console.log(data);

                    if(data.status == "error"){
                        alertify.notify(data.message, "error", 2, function () {
                            if(data.hasOwnProperty("image1")){
                        $(".image1error").text(data.message);
                        $(".image1error").removeClass("d-none");
                    }else{
                        $(".image1error").text("");
                        if(!$(".image1error").hasClass("d-none")){
                        $(".image1error").addClass("d-none");
                    }
                }
                if(data.hasOwnProperty("image2")){
                        $(".image2error").text(data.message);
                        $(".image2error").removeClass("d-none");
                    }else{
                        $(".image2error").text("");
                        if(!$(".image2error").hasClass("d-none")){
                        $(".image2error").addClass("d-none");
                    }
                }
                if(data.hasOwnProperty("image3")){
                        $(".image3error").text(data.message);
                        $(".image3error").removeClass("d-none");
                    }else{
                        $(".image3error").text("");
                        if(!$(".image3error").hasClass("d-none")){
                        $(".image1error").addClass("d-none");
                    }
                }
                if(data.hasOwnProperty("image4")){
                        $(".image4error").text(data.message);
                        $(".image4error").removeClass("d-none");
                    }else{
                        $(".image4error").text("");
                        if(!$(".image4error").hasClass("d-none")){
                        $(".image4error").addClass("d-none");
                    }
                }
                        });
                    }else{
                        swal("Good job!", data.message, "success").then(()=>{
                            window.location.href = "products.php";
                        });
                    }

                 
                }
            })

        })();

    })

</script>