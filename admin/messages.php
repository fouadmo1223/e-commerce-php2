<?php
    include "componnents/checkLogedIn.php";
    include "componnents/head.php";
    // include "componnents/footerScripts.php";
    
    
?>
   

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
            <?php
                    include "componnents/sidebar.php";
            ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include "componnents/navbar.php";
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Messaes</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <?php
                            if(!isset($_GET['action'])){
                            include 'elements/messagesTable.php';
                            }
                        ?>
                    

                    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary modal-button d-none" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

                    </div>

                   

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
                    include "componnents/footer.php";
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


  <?php
    include "componnents/footerScripts.php";
    include 'componnents/aos.php';
      
      
  ?>
  <!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/messagesTable.js"></script>
<script>
    $(document).on('click',".view-button",function(e){
        let messageId = $(this).attr('id');
        let viewButton = $(this) 
        $.ajax({
            method: 'POST',
            url:"phpfun/getmessageBody.php",
            dataType: 'json',
            data: {messageId},
            beforeSend: function(){
                $(".view-button").prop('disabled',true);
            },
            success: function(data){
                $(".view-button").prop('disabled',false);
                $(".modal-body").text(data.message);
                $(".modal-button").trigger("click");
                $(viewButton).parent().prev().text("read")
                if(!data.seen){
                    $(".unRead-messages").text(parseInt($(".unRead-messages").text()) - 1);
                }
                
            },
            error: function(xhr){
                $(".view-button").prop('disabled',false);
                swal("oooppps!!!", "Something Went Wrong ,Try Again Later", "error");
            }
        })
        // $(".modal-button").trigger("click");
    })
</script>

</body>

</html>