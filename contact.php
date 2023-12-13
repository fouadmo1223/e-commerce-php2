<!doctype html>
<html lang="en">
<head>
<title>Contact </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="css/framework.css">
<link rel="stylesheet" href="contactcss/style.css">

</head>
<body>
<section class="ftco-section">
<div class="container">

<div class="row justify-content-center">
	<div class="col-lg-10">
		<div class="wrapper">
			<div class="row no-gutters">
				<div class="col-md-6 d-flex align-items-stretch">
					<div class="contact-wrap w-100 p-md-5 p-4 py-5">
						<h3 class="mb-4">Contact with us</h3>
						<div id="form-message-warning" class="mb-4"></div> 
				<div id="form-message-success" class="mb-4">
				Your message was sent, thank you!
				</div>
<form  id="contactForm" name="contactForm" class="contactForm">
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<input type="text" class="form-control" minlength="5" required name="name" id="name" placeholder="Name">
		</div>
		<p class='name m-0 p-0 c-red fs-15'> </p>
	</div>
	<div class="col-md-12"> 
		<div class="form-group">
			<input type="email" class="form-control" name="email" required id="email" placeholder="Email">
		</div>
		<p class='email m-0 p-0 c-red fs-15' style="margin-bottom:10px !important"> </p>
	</div>
	
	<div class="col-md-12">
		<div class="form-group">
			<textarea name="message" class="form-control" id="message" minlength="5" required cols="30" rows="4" placeholder="Message"></textarea>
		</div>
		<p class='message m-0 p-0 c-red fs-15' style="margin-bottom:10px !important"> </p>
	</div>
	<div class="col-md-12">
		<div class="form-group d-flex">
			<input type="submit"  value="Send Message" class="btn btn-primary mr-10" id="sendButton">
			
				<div class="loader d-none">
					<span class="loader-text">loading</span>
					<span class="load"></span>
				</div>

			<div class="submitting"></div>
		</div>
	</div>
</div>
</form>
					</div>
				</div>
				<div class="col-md-6 d-flex align-items-stretch">
					<div class="info-wrap w-100 p-md-5 p-4 py-5 img">
						<h3>Contact information</h3>
						<p class="mb-4">We're open for any suggestion or just to have a chat</p>
				<div class="dbox w-100 d-flex align-items-start">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="fa fa-map-marker"></span>
					</div>
					<div class="text pl-3">
					<p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
					</div>
				</div>
				<div class="dbox w-100 d-flex align-items-center">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="fa fa-phone"></span>
					</div>
					<div class="text pl-3">
					<p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
					</div>
				</div>
				<div class="dbox w-100 d-flex align-items-center">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="fa fa-paper-plane"></span>
					</div>
					<div class="text pl-3">
					<p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
					</div>
				</div>
				<div class="dbox w-100 d-flex align-items-center">
					<div class="icon d-flex align-items-center justify-content-center">
						<span class="fa fa-globe"></span>
					</div>
					<div class="text pl-3">
					<p><span>Website</span> <a href="#">yoursite.com</a></p>
					</div>
				</div>
			</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
	</section>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="contactjs/jquery.min.js"></script>
	<script src="contactjs/popper.js"></script>
	<script src="contactjs/bootstrap.min.js"></script>
	<script src="contactjs/jquery.validate.min.js"></script>
	<!-- <script src="contactjs/main.js"></script> -->
	<script>
	$("form").submit(function(e){
		$(".message,.name,.email").val("");
		var formData = new FormData(this);
		e.preventDefault();
		$.ajax({
			method:"POST",
			url:"phpFunctions/insertMessage.php",
			dataType:"json",
			data:formData,
			processData: false,
      		contentType: false,
			beforeSend: function(){
				$("#sendButton").prop("disabled",true)
				$(".loader").removeClass("d-none")
			},
			success:function(data){
				$(".loader").addClass("d-none")
				$("#sendButton").prop("disabled",false)
				$("#name").val("");
				$("#email").val("");
				$("#message").val("");
				swal("Good job!", data.message, "success");
			},
			error:function(xhr){
				$("#sendButton").prop("disabled",false)
				$(".loader").addClass("d-none")
				let response =JSON.parse(xhr.responseText);
				console.log(response);
				if(response.hasOwnProperty("errors")){
					let errors =response.errors
					let keys =Object.keys(errors);

					for (let i = 0; i < keys.length; i++) {
						$(`.${keys[i]}`).text(response.errors[keys[i]]);
					}
				}else{
					swal("oooopps!!!", "Something Went wrong please try again later", "error");
				}
			}

		})
	})
	</script>
	</body>
</html>

