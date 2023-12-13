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
            <label for="formGroupExampleInput">Category Name</label>
            <input type="text" minlength="2" class="form-control categoryName" id="formGroupExampleInput" placeholder="Enter new Category">
        </div>
        <div  class="mb-20 categoryFeedback d-none"></div>
        <div class='  align-center' style="display: flex;">
        <button type="button" class="btn btn-success mr-10 sendCat">Add Category</button>
        <div class="d-flex align-center">
            <div class="spinner-border text-primary d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        </div>
    </form>
    </div>

    <script>
        $(".sendCat").click(function(e){
            e.preventDefault();
            if($(".categoryName").val().length <= 2){
                $(".categoryName").removeClass("is-invalid").addClass("is-invalid");
                $(".categoryFeedback").addClass("c-red").text("length must be at least 2 char").removeClass("d-none");
            }else{
                $(".categoryName").removeClass("is-invalid").addClass("is-valid");
                $(".categoryFeedback").removeClass("c-red").text("");
                $.ajax({
                method:"POST",
                url:"phpfun/addCategory.php",
                data:{
                    categoryName:$(".categoryName").val()
                },
                success:function(data){
                    let success =JSON.parse(data)
                    console.log(success);
                    let message =success.message;
                    $(".categoryName").val('').removeClass("is-valid");
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
                    $(".categoryName").removeClass("is-valid").addClass("is-invalid");
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