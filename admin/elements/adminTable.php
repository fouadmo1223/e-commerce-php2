
 <?php

    include_once 'phpfun/connection.php';
    $selectAdmins = $connection -> query("SELECT * FROM admins");
?>
 

 <?php
    if(isset($_COOKIE['username'])){
        $username = $_COOKIE['username'];
        $selectAdmin = $connection -> query("SELECT * FROM admins WHERE username = '$username' AND permission_id ='1'");
        if($selectAdmin->num_rows > 0){
            $superAdmin = true;
        }else{
            $superAdmin = false;
        }
    }
        
 ?>
 <?php
     if($superAdmin){
 ?>
    <a href="?action=addAdmin" class="btn btn-info btn-icon-split my-4 hvr-rotate">
        <span class="icon text-white-50">
            <i class="fas fa-user-plus"></i>
        </span>
        <span class="text">Add Admin</span>
    </a>
    <?php
        }
    ?>



<div class="card shadow mb-4 w-100">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
        
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Gender</th>
                        <th>Role</th>
                        <?php
                            if($superAdmin){
                        ?>
                        <th>Opreations</th>
                        <?php
                            }
                        ?>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Gender</th>
                        <th>Role</th>
                        <?php
                            if($superAdmin){
                        ?>
                            <th>Opreations</th>
                        <?php
                            }
                        ?>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        foreach($selectAdmins as $admin){
                    ?>
                    <tr>
                        <td><?= $admin['id'] ?></td>
                        <td><?= $admin['fullname'] ?></td>
                        <td><?= $admin['email'] ?></td>
                        <td>
                            <?php
                            
                                $genderId = $admin['gender_id'];
                                $selectGender = $connection -> query("SELECT * FROM genders WHERE id = $genderId");
                                $gender = $selectGender->fetch_assoc();
                                echo $gender['name'];
                        
                        ?>
                        </td>
                        <td>
                            <?php 
                         
                         $permissionId = $admin['permission_id'];;
                         $selectPermission = $connection -> query("SELECT * FROM permissions WHERE id = $permissionId");
                         $permission = $selectPermission->fetch_assoc();
                         echo $permission['name'];
                        
                        ?></td>
                        <?php
                            if($superAdmin){
                        ?>
                        <td><a data-id="<?= $admin['id'] ?>" class="btn btn-danger btn-circle deleteButton hvr-buzz"><i class="fas fa-trash"></i></a></td>
                        <?php
                            }
                        ?>       
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
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
                text: adminMessageerror,
                icon: "error",
                button: "Ok!",
            });
        }else if(adminMessagesuccess){
            swal({
                title: "Good job!",
                text: adminMessagesuccess,
                icon: "success",
                button: "Ok",
            });
        }


    }



    $(".deleteButton").click(function(){
        let id = $(this).attr("data-id");
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this Opreation!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
               window.location.href =`phpfun/deleteadmin.php?id=${id}`;
            } else {
                swal("The admin is safe!");
            }
        });
    })


</script>





  
   

            