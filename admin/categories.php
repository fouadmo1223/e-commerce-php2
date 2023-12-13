<?php
    include "componnents/checkLogedIn.php";
    include "componnents/head.php";  
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
                        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <?php
                            if(!isset($_GET['action'])){
                            include 'elements/categoryTable.php';
                            include 'elements/brandTable.php';
                            }elseif($_GET['action'] == "addCategory"){
                                include "elements/addCategory.php";
                            }elseif($_GET['action'] == "addBrand"){
                                include "elements/addBrand.php";
                            }
                        ?>
                    
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

<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<!-- <script src="js/demo/datatables-demo.js"></script> -->

<script src="js/categoryTable.js"></script>
<script src="js/brandTable.js"></script>
</body>

</html>