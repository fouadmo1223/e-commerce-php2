<!DOCTYPE html>
<!-- Designined by CodingLab - youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Responsive Registration Form | CodingLab </title>
    <link rel="stylesheet" href="css/register.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/framework.css">
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   </head>
<body>
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form >
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" minlength="6" id="fullname" placeholder="Enter your name" required>
            <div class="fullname-error c-red fs-14"></div>
          </div>
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" class="is-vaild " id="userName" placeholder="Enter your username" required>
            <div class="username-error fs-13"></div>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" id="email" placeholder="Enter your email" required>
            <div class="email-error"></div>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" minlength="11" pattern="[0-9]*" id="phone" maxlength="11" placeholder="Enter your number" required>
            <div class="phone-error c-red fs-14"></div>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" minlength="6" id="password" placeholder="Enter your password" required>
            <div class="password-error c-red fs-14"></div>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" id="vpassword" placeholder="Confirm your password" required>
            <div class="vpassword-error d-none c-red fs-13"> password dosn't match , it must be identical </div>

          </div>
        </div>
        <div class="gender-details">
          <input type="radio" checked value="1" name="gender" id="dot-1">
          <input type="radio" value="2" name="gender" id="dot-2">
          <span class="gender-title">Gender</span>
          <div class="category">
            <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Male</span>
          </label>
          <label for="dot-2" class="ml-10">
            <span class="dot two"></span>
            <span class="gender">Female</span>
          </label>
         
          </div>
        </div>
        <div class="button d-flex align-center">
          <button type="submit" class="btn btn-primary"  id="reg" >Register</button>
          <div class="spinner-border text-primary ml-10 d-none" role="status">
            <span class="sr-only"></span>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="js/jquery-3.6.1.min.js"></script>
  <script src="js/validation.js"></script>
  <script src='js/matchPasswrd.js'></script>
  <script src='js/ajaxFun/checkUnique.js'></script>
  <script>
    $("form").submit(function(e){
      e.preventDefault();
      if(validUserName && validEmail && identicalPass){
        let objData ={
              fullname:$("#fullname").val(),
              username:$("#userName").val(),
              email:$("#email").val(),
              phone :$("#phone").val(),
              password:$("#password").val(),
              gender:$("input[name='gender']:checked").val() ?? 1
        }
          $.ajax({
            method:"POST",
            url:"phpFunctions/InsertUserToWaitList.php",
            dataType:"json",
            data:objData,
            beforeSend:function(){
              $("#reg").prop("disabled",true);
              $(".spinner-border").removeClass("d-none");
            },
            success:function(data){
              $("#reg").prop("disabled", false);
              $(".spinner-border").addClass("d-none");
              swal("Well done","All your data is added to wait list until verfied", "success").then(()=>{
                window.location.replace("otp.html");
              });
              console.log(data);
            },
            error:function(xhr){
              $(".spinner-border").addClass("d-none");
            
              console.log(xhr);
              let response = xhr.responseJSON;
              if(response.hasOwnProperty("message")){
                message =response.message;
              }else{
                message = "Check your fields"
              }
              swal("Failed To Register",message, "error").then(()=>{
                $("#reg").prop("disabled", false);
              });
            let  errors =response.errors;
             if(errors.hasOwnProperty("fullname")){
              $(".fullname-error").text(errors.fullname);
             }else{
              $(".fullname-error").text('');
             }
             if(errors.hasOwnProperty("phone")){
              $(".phone-error").text(errors.phone);
             }else{
              $(".phone-error").text('');
             }
             if(errors.hasOwnProperty("password")){
              $(".password-error").text(errors.password);
             }else{
              $(".password-error").text('');
             }
            }
          })
      }else{
        swal("Failed To Register", "Check your fields", "error");
      }
    })


  </script>
</body>
</html>
