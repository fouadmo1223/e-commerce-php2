<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

<a href="?action=addUser" class="btn btn-info btn-icon-split my-4 hvr-rotate">
  <span class="icon text-white-50">
    <i class="fas fa-user-plus"></i>
  </span>
  <span class="text">Add User</span>
</a>

<div class="card shadow mb-4 w-100">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table
        class="table table-bordered"
        id="dataTable"
        width="100%"
        cellspacing="0"
      >
        <thead>
          <tr>
            <th>Id</th>
            <th>Full Name</th>
            <th>E-mail</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Delete</th>
            <th>Block</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Id</th>
            <th>Full Name</th>
            <th>E-mail</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Delete</th>
            <th>Block</th>
          </tr>
        </tfoot>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<script>
    window.onload =function(){
      let adminMessageerror = "<?php
          if(isset($_SESSION['error'])){
              echo $_SESSION['error'];
              unset($_SESSION['error']);
          }else{
              echo "";
          }
      ?>";

      let adminMessagesuccess = "<?php
          if(isset($_SESSION['success'])){
              echo $_SESSION['success'];
              unset($_SESSION['success']);
          }else{
              echo "";
          }
      ?>"

      if(adminMessageerror){
          swal({
              title: "!!!!",
              text: "Failed to delete user",
              icon: "error",
              button: "Ok!",
          });
      }else if(adminMessagesuccess){
          swal({
              title: "Good job!",
              text: "User deleted successfully",
              icon: "success",
              button: "Ok",
          });
      }
  }

  let userBlocked = "<?php
      if(isset($_SESSION["blocked"])){
          echo $_SESSION["blocked"];
          unset($_SESSION["blocked"]);
      }else{
          echo "";
      }
  ?>";

  if(userBlocked){
      swal({
              title: "Good job!",
              text: "User is blocked successfully",
              icon: "success",
              button: "Ok",
          });
  }


  $("#dataTable").on("click", ".deleteButton", function(){
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
             window.location.href =`phpfun/deleteuser.php?id=${id}`;
          } else {
              swal("The user is safe!");
          }

      });
  })

  $(".deleteButton").click(function(){
      let id = $(this).attr("data-id");
      console.log(id);
    
  })
</script>


