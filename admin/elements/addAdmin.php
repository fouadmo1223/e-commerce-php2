

<form class="w-100 " data-aos="zoom-in"  method="POST" action="phpfun/insertAdmin.php">

<div class="row">

<div class="form-group col-12 col-lg-6">
    <label for="FullName">Full Name</label>
    <input type="text" name="fullname"
     value="<?php
        if(isset($_SESSION['fullnameValue'])){
            echo $_SESSION['fullnameValue'];
            unset($_SESSION['fullnameValue']); 
        }
    ?>"
     required minlength="5" maxlength="20"  class="form-control <?php
    if(isset($_SESSION['fullnameerror'])){
        echo "is-invalid";
        
    }elseif(isset($_SESSION['fullnamesuccess'])){
        echo "is-valid";
    }
    ?>" 
    id="FullName" placeholder="Enter Your Full Name">
    <?php
        if(isset($_SESSION['fullnameerror'])){
    ?>
      <div  class="invalid-feedback">
       <?php
        echo $_SESSION['fullnameerror']; 
        ?>
      </div>
    <?php 
    unset($_SESSION['fullnameerror']);
        }elseif(isset($_SESSION['fullnamesuccess'])){
    ?>
    <div class="valid-feedback">
        Valid Full Name
    </div>
    <?php
    unset($_SESSION['fullnamesuccess']);
        }
    ?>
  </div>

  <div class="form-group col-12 col-lg-6">
    <label for="UserName">User Name</label>
    <input type="text" value="<?php
        if(isset($_SESSION['usernameValue'])){
            echo $_SESSION['usernameValue'];
            unset($_SESSION['usernameValue']);
        }
    ?>" name="username" required  maxlength="20"  class="form-control <?php
    if(isset($_SESSION['usernameerror'])){
        echo "is-invalid";
    }elseif(isset($_SESSION['usernamesuccess'])){
        echo "is-valid";
    }
    ?>" 
    id="UserName" placeholder="Enter Your User Name">
    <?php
        if(isset($_SESSION['usernameerror'])){
    ?>
      <div id="validationServer04Feedback" class="invalid-feedback">
       <?php
        echo $_SESSION['usernameerror']; 
        ?>
      </div>
    <?php 
    unset($_SESSION['usernameerror']);
        }elseif(isset($_SESSION['usernamesuccess'])){
    ?>
    <div class="valid-feedback">
        Valid Username
    </div>
    <?php
    unset($_SESSION['usernamesuccess']);
        }
    ?>
  </div>

  <div class="form-group col-12 col-lg-6">
    <label for="email">E-Mail</label>
    <input type="email"  value="<?php
        if(isset($_SESSION['emailValue'])){
            echo $_SESSION['emailValue'];
            unset($_SESSION['emailValue']);
        }
    ?>" name="email" required class="form-control <?php
    if(isset($_SESSION['emailerror'])){
        echo "is-invalid";
    }elseif(isset($_SESSION['emailsuccess'])){
        echo "is-valid";
    }
    ?>" 
    id="email" placeholder="Enter Your E-Mail">
    <?php
        if(isset($_SESSION['emailerror'])){
    ?>
      <div id="validationServer04Feedback" class="invalid-feedback">
       <?php
        echo $_SESSION['emailerror']; 
        ?>
      </div>
    <?php 
    unset($_SESSION['emailerror']);
        }elseif(isset($_SESSION['emailsuccess'])){
    ?>
    <div class="valid-feedback">
        Valid E-Mail
    </div>
    <?php
    unset($_SESSION['emailsuccess']);
        }
    ?>
  </div>

  <div class="form-group col-12 col-lg-6">
    <label for="password">Password</label>
    <input type="password" name="password"  required minlength="5" maxlength="15" class="form-control <?php
    if(isset($_SESSION['passworderror'])){
        echo "is-invalid";
    }elseif(isset($_SESSION['passwordsuccess'])){
        echo "is-valid";
    }
    ?>" 
    id="password" placeholder="Enter Your password">
    <?php
        if(isset($_SESSION['passworderror'])){
    ?>
      <div id="validationServer04Feedback" class="invalid-feedback">
       <?php
        echo $_SESSION['passworderror']; 
        ?>
      </div>
    <?php 
    unset($_SESSION['passworderror']);
        }elseif(isset($_SESSION['passwordsuccess'])){
    ?>
    <div class="valid-feedback">
        Valid Password ,rewrite it
    </div>
    <?php
    unset($_SESSION['passwordsuccess']);
        }
    ?>
  </div>

  <div class="form-group col-12 col-lg-6">
    <label for="cPassword">Confirm Password</label>
    <input type="password" required minlength="5" maxlength="15" class="form-control" id="cPassword" placeholder="Enter Your password">
    <div class="cPassworderror"></div>
  </div>
  
  <div class="pl-15 col-12">
    <div class="form-check fw-bold">
        <input class="form-check-input" checked required type="radio" name="gender" id="inlineRadio1" value="1">
        <label class="form-check-label" for="inlineRadio1">Male</label>
    </div>
    <div class="form-check fw-bold ">
        <input class="form-check-input" required type="radio" name="gender" id="inlineRadio2" value="2">
        <label class="form-check-label" for="inlineRadio2">Female</label>
    </div>
  </div>

  <div class="pl-15 col-12 my-3">
    <button type="submit" class="button">
        <span class="button__text">Add </span>
        <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
    </button>
  </div>

</div>
   
  
</form>

<script>
        // Check if form valid or Not
        let formValid = "<?php
            if(isset($_SESSION['formValid'])){
                echo "true";
                unset($_SESSION['formValid']);
            }
        ?>";
        if(formValid){
            swal({
                title: "Good job!",
                text: "Admin is added",
                icon: "success",
                button: "Ok",
            }).then(()=>{
                window.location.replace("admins.php");
            });
        }
        

        // End of Checking if form valid or Not


        // Start of idrntical password
let identicalPass = false;
    $("#cPassword").keyup(function(){
        if($("#cPassword").val() != $("#password").val()){

            $("#cPassword").removeClass("is-valid").addClass("is-invalid");
            $(".cPassworderror").removeClass("valid-feedback").addClass("invalid-feedback");
            $(".cPassworderror").text("password dose not match");
        }else{
            identicalPass =true
            $("#cPassword").removeClass("is-invalid").addClass("is-valid");
            $(".cPassworderror").removeClass("invalid-feedback").addClass("valid-feedback");
            $(".cPassworderror").text("password matchs");
        }
    })

    $("#password").keyup(function(){
       if($("#cPassword").val().length > 0){
        if($("#cPassword").val() != $("#password").val()){
            $("#cPassword").removeClass("is-valid").addClass("is-invalid");
            $(".cPassworderror").removeClass("valid-feedback").addClass("invalid-feedback");
            $(".cPassworderror").text("password dose not match");
        }else{
            identicalPass =true
            $("#cPassword").removeClass("is-invalid").addClass("is-valid");
            $(".cPassworderror").removeClass("invalid-feedback").addClass("valid-feedback");
            $(".cPassworderror").text("password matchs");
        }
       }
    })

    $("form").submit(function(event){
        if(!identicalPass){
            event.preventDefault();
        }
    })

     // End of identical password

</script>