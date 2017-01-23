<?php 
  require_once '../session.php';
  if (!$loggedin){
    die("<script>window.location.href = '../login.php';</script>");
  }

  if ($access != 1){
    die("<script>window.location.href = '../error.php';</script>");
  }

  $name = "";
  $result = MySqlQuery("SELECT lname,fname from tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where username = '$username'");

  if($result->num_rows){
    $row = $result->fetch_assoc();
    $name = ucfirst(capitalFirstLetter($row['lname'])).", ".capitalFirstLetter(sanitizeString($row['fname']));
  }
  
?>  
<html>
<head>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="../img/header/header_one.jpg" alt="...">
      <div class="carousel-caption">
        <h1>Home and Connect</h1>
      </div>
    </div>
    <div class="item">
      <img src="../img/header/header_two.jpg" alt="...">
      <div class="carousel-caption">
        <h1>House Rental System</h1>
      </div>
    </div>
    <div class="item">
      <img src="../img/header/header_three.jpg" alt="...">
      <div class="carousel-caption">
        <h1>Home and Connect</h1>
      </div>
    </div>
    <div class="item">
      <img src="../img/header/header_four.jpg" alt="...">
      <div class="carousel-caption">
        <h1>House Rental System</h1>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="header">
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

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=""><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
        <!-- rental history -->
        <li class=""><a href="rentalhistory.php">Rental History <span class="sr-only">(current)</span></a></li>
        <!-- billing dropdown tab -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Billing <span class="caret"></span></a>
          <!-- dropdown items -->
          <ul class="dropdown-menu">
            <!-- unpaid bills tab -->
            <li><a href="billing.php">Unpaid Bills</a></li>
            <!-- property transaction tab -->
            <li><a href="history.php">Transaction</a></li>
          </ul> <!-- end of dropdown items -->
        </li> <!-- end of billing dropdown tab -->
        <!-- <li class=""><a href="rent.php">Rent <span class="sr-only">(current)</span></a></li> -->
        <li class=""><a href="feedback.php">Feedback<span class="sr-only">(current)</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
<?php
          echo "<a href=# class=dropdown-toggle data-toggle=dropdown role=button aria-haspopup=true aria-expanded=false> 
          $name <span class=caret></span></a>";
?>
            <ul class="dropdown-menu">
              <li><a href="#">Settings</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="../logout.php">Log out</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav><!-- end of navigation bar -->
  </div><!-- end of header -->
  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../js/bootstrap.min.js"></script>
  <!-- data tables -->
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
  <script>
  $(document).ready(function(){       
   var scroll_start = 0;
   var startchange = $('nav');
   var offset = startchange.offset();
        if (startchange.length){
       $(document).scroll(function() { 
          scroll_start = $(this).scrollTop();
          if(scroll_start > offset.top) {
            $('nav').addClass('navbar-fixed-top');
           } else {
            $('nav').removeClass('navbar-fixed-top');  
           }
       });
        }
    });

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


