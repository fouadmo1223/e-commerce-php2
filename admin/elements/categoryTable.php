<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

<a href="?action=addCategory" class="btn btn-info btn-icon-split my-4 hvr-rotate">
  <span class="icon text-white-50">
    <i class="fas fa-plus-circle"></i>
  </span>
  <span class="text">Add Category</span>
</a>

<div class="card shadow mb-4 w-100" data-aos="zoom-in" data-aos-duration="1000">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table
        class="table table-bordered"
        id="categoryTable"
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
        if(isset($_SESSION['deleteSucceeded'])){
          unset($_SESSION['deleteSucceeded']);
            echo true;
        }else{
            echo false;
        }
    ?>";

    let deleteCatFailed = "<?php
        if(isset($_SESSION['deletefailed'])){
          unset($_SESSION['deletefailed']);
            echo true;
        }else{
            echo false;
        }
    ?>";

    if(deleteCatSucc){
        swal({
          title: "Well done!",
          text: "Category is deleted successfully",
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


  $("#categoryTable").on("click", ".deleteButton", function(){
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
             window.location.href =`phpfun/deletecategory.php?id=${id}`;
          } else {
              swal("The Category is safe!");
          }

      });
  })


</script>

