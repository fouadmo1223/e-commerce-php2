  <!-- JavaScript files-->
  <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- alertift  -->
      <script src="js/alertify.min.js"></script>
      <!-- Sweet alert  -->
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <!-- Animation on scroll  -->
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
      <script src="vendor/lightbox2/js/lightbox.min.js"></script>
      <script src="vendor/nouislider/nouislider.min.js"></script>
      <script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
      <script src="vendor/owl.carousel2/owl.carousel.min.js"></script>
      <script src="vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
      <script src="js/front.js"></script>
      <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite - 
        //   see more here 
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {
        
            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot 
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
        
      </script>
      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <script>
        AOS.init();
        
        $(".log-out").click(function(){
          swal({
            title: "Are you sure You Want to logout?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                method: "POST",
                url:"phpFunctions/logOut.php",
                dataType: "json",
                success:function(data){
                  console.log(data)
                  swal("Good job!", data.message, "success").then(()=>{
                    window.location.replace("login.php");
                  });
                },error:function(xhr){
                  swal("opps!", "SomeThing went wrong", "error");
                }
              })
            } 
          });
        })
     
      </script>