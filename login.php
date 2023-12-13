<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/css/framework.css">
<style>
    
</style>
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
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email"  class="form-control form-control-user"
                                                id="exampleInputEmail" required aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                                <div class="email-response c-red fs-15"></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" required placeholder="Password">
                                                <div class="password-response c-red fs-15"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" value="1" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary  btn-user btn-block Login">
                                            Login
                                        </button>
                                        <p class="server-error c-red mt-10 fs-15 txt-c"></p>
                                        <hr>
                                        <button class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </button>
                                        <button class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(".user").submit(function(e){
            e.preventDefault();
            
            let checked;
            if($("#customCheck").is(":checked")){
                checked = 1;
            }else{
                checked = 0;
            }
            
            $.ajax({
                method: "POST",
                url: "phpFunctions/checkUser.php",
                dataType: "json",
                data:{
                    email:$("#exampleInputEmail").val(),
                    password:$("#exampleInputPassword").val(),
                    remember:checked
                },beforeSend:function(){
                    $(".Login").prop("disabled","true");
                },
                success:function(data){
                    $(".Login").removeProp("disabled");
                    console.log(data);
                    swal("Good job!", data.message, "success").then(()=>{
                        window.location.replace("index.php");
                    });
                },error:function(xhr){
                    $(".Login").removeProp("disabled");
                    let data = xhr.responseJSON;
                    let errors = data.errors
                    
                    swal("ooopppsss!", "Failed to login", "error")

                    if(errors.hasOwnProperty("emailError")){
                        $(".email-response").text(errors.emailError);
                        $("#exampleInputEmail").addClass("is-invalid");
                    }else{
                        $(".email-response").text("");
                        $("#exampleInputEmail").removeClass("is-invalid");
                    }

                    if(errors.hasOwnProperty("passwordError")){
                        $(".password-response").text(errors.passwordError);
                        $("#exampleInputPassword").addClass("is-invalid");
                    }else{
                        $(".password-response").text("");
                        $("#exampleInputPassword").removeClass("is-invalid");
                    }

                    if(errors.hasOwnProperty("serverError")){
                        $(".server-error").text(errors.serverError);
                        
                    }else{
                        $(".server-error").text("");
                        
                    }
                }

            })
       
        })
    </script>

</body>

</html>