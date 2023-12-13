<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

<a href="?action=addProduct" class="btn btn-info btn-icon-split my-4 hvr-rotate">
  <span class="icon text-white-50">
    <i class="fas fa-user-plus"></i>
  </span>
  <span class="text">Add Product</span>
</a>

<div class="card shadow mb-4 w-100">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table
        class="table table-bordered"
        id="productTable"
        width="100%"
        cellspacing="0"
      >
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Main Image</th>
            <th>Describtion</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Count</th>
            <th>Sale</th>
            <th>New</th>
            <th>Rate</th>
            <th>Images</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Main Image</th>
            <th>Describtion</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Count</th>
            <th>Sale</th>
            <th>New</th>
            <th>Rate</th>
            <th>Images</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </tfoot>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<script>
    window.onload =function(){
      let succesDelete = "<?php
          if(isset($_SESSION['success'])){
            echo $_SESSION['success'];
            unset($_SESSION['success']);
          }else{
            echo false;
          }
      ?>";

          if(succesDelete){
            swal({
              title: "Good Job",
              text: succesDelete,
              icon: "success", 
              dangerMode: true,
            })
          }


      let failDelete = "<?php
          if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
          }else{
            echo false;
          }
      ?>";

      if(failDelete){
            swal({
              title: "!!!!!",
              text: failDelete,
              icon: "error", 
              dangerMode: true,
            })
          }

  }

  
 


  $("#productTable").on("click", ".deleteButton", function(){
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
             window.location.href =`phpfun/deleteProduct.php?id=${id}`;
          } else {
              swal("The Product is safe!");
          }

      });
  })

  
</script>



<!-- Page level custom scripts -->
<!-- <script src="js/demo/datatables-demo.js"></script> -->

