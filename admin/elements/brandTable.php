<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

<div class="row w-100 mt-30">
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Brands</h1>
        </div>

    </div>
</div>
<a href="?action=addBrand" class="btn btn-primary btn-icon-split my-4 hvr-rotate">
  <span class="icon text-white-50">
    <i class="fas fa-plus-square"></i>
  </span>
  <span class="text">Add Brand</span>
</a>

<div class="card shadow mb-4 w-100" data-aos="zoom-in" data-aos-duration="1000">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table
        class="table table-bordered"
        id="brandTable"
        width="100%"
        cellspacing="0"
      >
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Delete</th>
          </tr>
        </tfoot>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<script>

window.onload = function(){
    let deleteCatSucc = "<?php
        if(isset($_SESSION['deleteBSucceeded'])){
          unset($_SESSION['deleteBSucceeded']);
            echo true;
        }else{
            echo false;
        }
    ?>";

    let deleteCatFailed = "<?php
        if(isset($_SESSION['deleteBfailed'])){
          unset($_SESSION['deleteBfailed']);
            echo true;
        }else{
            echo false;
        }
    ?>";

    if(deleteCatSucc){
        swal({
          title: "Well done!",
          text: "Brand is deleted successfully",
          icon: "success",
          dangerMode: true,
          })
    }else if(deleteCatFailed){
        swal({
          title: "Oppss!",
          text: "Something went wrong, please try again",
          icon: "error",
          dangerMode: true,
          })
    }

}



  $("#brandTable").on("click", ".deleteButton", function(){
    let id = $(this).attr("data-id");
      console.log(id);
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this Opreation!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          })
          .then((willDelete) => {
          if (willDelete) {
             window.location.href =`phpfun/deletebrand.php?id=${id}`;
          } else {
              swal("The Brand is safe!");
          }

      });
  })


</script>

