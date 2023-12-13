<form class="coupon">
<div class="mb-30 d-felx">
<button class="btn btn-primary p-10 hvr-hang mr-20 add-coupon">Add Coupon</button>
<!-- disabled readonly  -->
<div class="input-container">
  <input placeholder="Enter Discount value"   required min="0" max="100" class="input-field p-10 " id="value" type="number">
  <label for="input-field" class="input-label fw-bold fs-">Discount value</label>
  <span class="input-highlight"></span>
</div>
<div class="dot-spinner d-none">
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
    <div class="dot-spinner__dot"></div>
</div>
</div>
</form>

<div class="card shadow mb-4 w-100" data-aos="zoom-in" data-aos-duration="1000">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table
        class="table table-bordered coupon-table"
        id="couponTable"
        width="100%"
        cellspacing="0"
      >
        <thead>
          <tr>
            <th>Id</th>
            <th>Serail</th>
            <th>Discount</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Id</th>
            <th>Serail</th>
            <th>Discount</th>
            <th>Delete</th>
          </tr>
        </tfoot>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>
<script src="js/couponTable.js"></script>
<script>


$(".input-field").keypress(function(e){
    if(isNaN(e.key)){
        e.preventDefault();
    }
})

     $(".coupon").submit(function(e){
        e.preventDefault();
        $.ajax({
                method: "POST",
                url: "Phpfun/generatecoupon.php",
                dataType: "json",
                data: {
                    value: $("#value").val(),
                    
                },
                headers: {},
                beforeSend:function(){
                    $(".add-coupon").addClass("disabled");
                    $(".dot-spinner").removeClass("d-none");
                    $("#value").attr("readonly","");

                },
                success: function (response) {
                    $("#value").val("");
                    $("#value").blur();
                    $(".add-coupon").blur();
                    $(".add-coupon").removeClass("disabled");
                    $(".dot-spinner").addClass("d-none");
                    $("#value").removeAttr("readonly");
                    // Handle the JSON response
                    console.log(response);
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
                        $(".coupon-table tbody").append(`<tr>
                        <td scope="col" >${response.number}</td>
                <td scope="col"  >${response.string}</td>
                <td scope="col" >${response.value}%</td>
                <td scope="col" >
                <a data-id='${response.id}' class='btn btn-danger btn-circle deleteButton hvr-buzz'><i class='fas fa-trash'/></a>
                </td>
                </tr>
                `)
                        alertify.notify(response.message, 'success', 1, function(){ });
                    });
                    }
                
                }
            });
    })

    $("#couponTable").on("click", ".deleteButton", function(){
        let elemId = $(this).attr("data-id");
        let deleteButton = $(this);
       
        swal({
            title: "Are you sure ?",
            text: "Once deleted, you will not be able to recover this coupon",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {

            $.ajax({
                method: "POST",
                url: "Phpfun/deletecoupon.php",
                dataType: "json",
                data: {
                    id: elemId,	
                },
                headers: {},
                success: function (response) {	
                    if(response.status == "succses"){
                        $(deleteButton).parent().parent().remove();
                        swal(response.message, {
                        icon: "success",
                    }).then(()=>{
                        
                        alertify.notify(response.message, 'success', 1, function(){ });
                    });
                    }else{
                        swal(response.message, {
                        icon: "error",
                    }).then(()=>{
                        
                        alertify.notify(response.message, 'error', 1, function(){ });
                    });
                    }
                
                }
            });
        
            } else {
                swal({
            text: "deleting coupon is Cancelled",
                icon: "error",
            
            }).then(()=>{
                        
                        alertify.notify(` Coupon is kept`, 'success', 1, function(){ });
                    });
            }
        });
    })





</script>