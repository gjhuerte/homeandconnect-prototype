<?php
  //session contains the login information of the user
  require_once '../session.php';
  if (!$loggedin){
    die("<script>window.location.href = '../login.php';</script>");
  }

  // access level redirects if not home owner
  // 0 - home owner
  // 1- tenant
  if ($access != 0){
    die("<script>window.location.href = '../error.php';</script>");
  }

  // initialize name
  $name = "user";
  //fetch name from database
  $query = "SELECT lname,fname from tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where username = '$username'";
  $result = MySqlQuery($query);
  //assign value to name
  if($result->num_rows){
    $row = $result->fetch_assoc();
    $name = ucfirst(capitalFirstLetter($row['lname'])).", ".capitalFirstLetter(sanitizeString($row['fname']));
  }

?>
<html>
<head>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
<!--   <style>
    #carousel-example-generic .carousel-inner .item {
    width: 100%;
    height: 300px;
    }
    #carousel-example-generic .carousel-inner .item {
        background-size: cover;
        background-position: center top;
    }
    @media (min-width:768px) {
        #carousel-example-generic .carousel-inner .item {
            height: 500px
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
        <img src="../img/header/header_one.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>Home and Connect</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header 1 -->
      <!-- header 2 -->
      <div class="item">
        <!-- header image 2 -->
        <img src="../img/header/header_two.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>House Rental System</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header 2  -->
      <!-- header 3 -->
      <div class="item">
        <!-- header image 3 -->
        <img src="../img/header/header_three.jpg" alt="...">
        <!-- caption -->
        <div class="carousel-caption">
          <h1>Home and Connect</h1>
        </div> <!-- end of caption -->
      </div> <!-- end of header image 3 -->
      <!-- header 4 -->
      <div class="item">
        <!-- header image 4 -->
        <img src="../img/header/header_four.jpg" alt="...">
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
  <!-- navigation bar -->
  <nav class="navbar navbar-inverse">
    <!-- container inside navbar -->
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <!-- mobile responsive icon -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- icon and header name -->
        <a class="navbar-brand" href="#">Home and Connect</a>
      </div> <!-- end of mobile responsive icon -->

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <!-- left navbar -->
        <ul class="nav navbar-nav">
          <!-- home tab -->
          <li class=""><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
          <!-- lease tab -->
          <li class=""><a href="lease.php">Lease <span class="sr-only">(current)</span></a></li>
          <!-- payment tab -->
          <li class=""><a href="payment.php">Payment <span class="sr-only">(current)</span></a></li>
          <!-- maintenance dropdown tab -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Maintenance <span class="caret"></span></a>
            <!-- dropdown items -->
            <ul class="dropdown-menu">
              <!-- tenant maintenance tab -->
              <li><a href="tenant.php">Tenant</a></li>
              <!-- property maintenance tab -->
              <li><a href="property.php">Property</a></li>
            </ul> <!-- end of dropdown items -->
          </li> <!-- end of maintenance dropdown tab -->
          <!-- report tab -->
          <li class=""><a href="#">Report <span class="sr-only">(current)</span></a></li>
        </ul> <!-- end of left navbar -->
        <!-- right navbar -->
        <ul class="nav navbar-nav navbar-right">
          <!-- dropdown name -->
          <li class="dropdown">
          <!-- display name -->
          <?php echo "<a href=# class=dropdown-toggle data-toggle=dropdown role=button aria-haspopup=true aria-expanded=false>
              $name <span class=caret></span></a>"; ?>
              <!-- dropdown list -->
              <ul class="dropdown-menu">
                <li><a href="#">Settings</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="../logout.php">Log out</a></li>
              </ul> <!-- end of dropdown list -->
            </li> <!-- end of dropdown name -->
          </ul> <!-- end of right navbar -->
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
  </nav><!-- end of navigation bar -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery.js"></script>
  <!-- online source of jquery (CDN) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- data tables plugin -->
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
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
    // set the active tab of navbar
    // bug when the page used is blank (index.php)
    var url = window.location;
    // Will only work if string in href matches with location
    $('ul.nav a[href="'+ url +'"]').parent().addClass('active');
    // Will also work for relative and absolute hrefs
    $('ul.nav a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');
  </script>
</body>
</html>
