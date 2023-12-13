<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="row w-100">
    <form  class ='col-12 send'>
        <div class="form-group">
            <label for="formGroupExampleInput">Brand Name</label>
            <input type="text" minlength="2" class="form-control brandName" id="formGroupExampleInput" placeholder="Enter new Brand">
        </div>
        <div  class="mb-20 brandFeedback d-none"></div>
        <div class='  align-center' style="display: flex;">
        <button type="button" class="btn btn-success mr-10 sendBrand">Add Brand</button>
        <div class="d-flex align-center">
            <div class="spinner-border text-primary d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        </div>
    </form>
    </div>

    <script>

    $("h1").text("Brands")


        $("form").submit(function(e){
            e.preventDefault();
            if($(".brandName").val().length <= 2){
                $(".brandName").removeClass("is-invalid").addClass("is-invalid");
                $(".brandFeedback").addClass("c-red").text("length must be at least 2 char").removeClass("d-none");
            }else{
                $(".brandName").removeClass("is-invalid").addClass("is-valid");
                $(".brandFeedback").removeClass("c-red").text("");
                $.ajax({
                method:"POST",
                url:"phpfun/addBrand.php",
                data:{
                    brandName:$(".brandName").val()
                },
                success:function(data){
                    let success =JSON.parse(data)
                    console.log(success);
                    let message =success.message;
                    $(".brandName").val('').removeClass("is-valid");
                    swal({
                        title: "Well done!",
                        text: message,
                        icon: "success",
                        dangerMode: true,
                    }).then(()=>{
                        alertify.notify(message, 'success', 2, function(){  });
                    })
                },
                error:function(xhr){
                    let error =JSON.parse(xhr.responseText);
                    console.log(error)
                    let errorMessage =error.message;
                    $(".brandName").removeClass("is-valid").addClass("is-invalid");
                    swal({
                        title: "oopps!",
                        text: errorMessage,
                        icon: "error",
                        dangerMode: true,
                    }).then(()=>{
                        alertify.notify(errorMessage, 'error', 2, function(){  });
                    })
                }
            })
            }
        })

        


    </script>

</body>
</html>