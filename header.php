<html>
<head>
  <link href="css/bootstrap.min.css" rel="stylesheet">
<!--   <style>
    #carousel-example-generic .carousel-inner .item {
    width: 100%;
    height: 100px;
    }
    #carousel-example-generic .carousel-inner .item {
        background-size: cover;
        background-position: center top;
    }
    @media (min-width:768px) {
        #carousel-example-generic .carousel-inner .item {
            height: 100px
        }
    }
  </style> -->
</head>
<body>
  <!-- carousel -->
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      <li data-target="#carousel-example-generic" data-slide-to="3"></li>
    </ol> <!-- end of indicators -->

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <!-- header 1 -->
      <div class="item active">
        <!-- header image 1 -->
        <img src="img/header/header_one.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>Home and Connect</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header 1 -->
      <!-- header 2 -->
      <div class="item">
        <!-- header image 2 -->
        <img src="img/header/header_two.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>House Rental System</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header 2  -->
      <!-- header 3 -->
      <div class="item">
        <!-- header image 3 -->
        <img src="img/header/header_three.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>Home and Connect</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header image 3 -->
      <!-- header 4 -->
      <div class="item">
        <!-- header image 4 -->
        <img src="img/header/header_four.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>House Rental System</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header image 4 -->
    </div> <!-- end of wrapper -->

    <!-- Controls -->
    <!-- prev control -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a> <!-- end of prev control -->
    <!-- next control -->
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a> <!-- end of next control -->
    <!-- end of controls -->
  </div><!-- end of carousel -->
  <!-- navbar -->
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Home and Connect</a>
      </div>

    </div><!-- /.container-fluid -->
  </nav><!-- end of navbar -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery.js"></script>
  <!-- online source of jquery (CDN) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <!-- data tables plugin -->
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>
  <script>
    //when scroll, navbar fixed top
    $(document).ready(function(){
      var scroll_start = 0;
      var startchange = $('nav');
      var offset = startchange.offset();
      if (startchange.length){
         $(document).scroll(function() {
            scroll_start = $(this).scrollTop();
            if(scroll_start > offset.top) {
              // sets navbar fixed top when scrolling starts
              $('nav').addClass('navbar-fixed-top');
             } else {
              $('nav').removeClass('navbar-fixed-top');
             }
         });
      }
    });
  </script>
</body>
</html>
