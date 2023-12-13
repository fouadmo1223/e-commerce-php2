<?php
session_start();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        
                                    </div>
                                    <form class="user" method="POST" action="phpfun/checkAdmin.php" >
                                        <div class="form-group">
                                            <input type="email" required name="email" 
                                            value ="<?php
                                            if(isset($_SESSION['emailsuccses'])) {
                                                echo  $_SESSION['emailValue'];
                                                unset( $_SESSION['emailValue']);
                                            }   
                                            ?>" 
                                            class="form-control form-control-user <?php
                                                if(isset($_SESSION['emailerror'])){
                                                    echo "is-invalid";
                                                    
                                                }elseif(isset($_SESSION['emailsuccses'])){
                                                    echo "is-valid";
                                                   
                                                }
                                            ?>"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                                <?php
                                                        if(isset($_SESSION['emailerror'])){
                                                    ?>
                                                    <div  class="invalid-feedback">
                                                    <?php
                                                        echo $_SESSION['emailerror']; 
                                                        ?>
                                                    </div>
                                                    <?php 
                                                    unset($_SESSION['emailerror']);
                                                        }elseif(isset($_SESSION['emailsuccses'])){
                                                    ?>
                                                    <div class="valid-feedback">
                                                        Valid E-mail
                                                    </div>
                                                    <?php
                                                    unset($_SESSION['emailsuccses']);
                                                        }
                                                    ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user <?php
                                                if(isset($_SESSION['passworderror'])){
                                                    echo "is-invalid";
                                                }
                                            ?>"
                                                id="exampleInputPassword" required minlength="6" placeholder="Password">
                                                <?php
                                                        if(isset($_SESSION['passworderror'])){
                                                    ?>
                                                    <div  class="invalid-feedback">
                                                    <?php
                                                        echo $_SESSION['passworderror']; 
                                                        ?>
                                                    </div>
                                                    <?php 
                                                    unset($_SESSION['passworderror']);
                                                        }
                                                    ?>
                                                
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remeber" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                        <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        let adminFound = "<?php 
        if(isset($_SESSION['adminFound'])){
            echo $_SESSION['adminFound'];
            unset($_SESSION['adminFound']);
        }else{
            echo false ;
        }
        ?>";
        if(adminFound){
            if(adminFound == "found"){
                swal({
                title: "Good job!",
                text: "Admin is Found",
                icon: "success",
                button: "Ok",
            }).then(()=>{
                window.location.replace("index.php");
                // console.log(adminFound);
            });
            }else{
                $("#exampleInputEmail").removeClass("is-valid");
                $(".valid-feedback").text('').removeClass("valid-feedback");

                swal({
                title: "Opps!",
                text: "Wrong E-Mail or Password",
                icon: "error",
                button: "Ok",
            })
            }
        }
        
    </script>

</body>

</html>