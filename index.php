<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Home and Connect</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar{
      border-radius: 0;
      margin-bottom: 0;
    }
    .panel-footer{
      background-color:rgb(66,66,66);
      color:white;
    }
    .header-image{
      margin-bottom: 3%;
    }

    .jumbotron{
      margin: 3%;
    }

    .navbar-fixed-bottom{
      border-radius: 0;
    }
  </style>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php
  require_once 'header.php';
  if($loggedin)
  {
    echo '<script>window.location.href = "home.php";</script>';
  }
  else
    echo <<<_END
  <!-- header -->
  <div class="panel">
    <!-- navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
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
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php">Log in</a></li>
            <li><a href="signup.php">Sign up</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav><!-- end of navbar -->
  </div><!-- end of header -->
  <div class="header-image">
    <img class="img-responsive" src="img/house/header.jpg" alt="header image">
  </div>
  <!-- jumbotron -->
  <div class="jumbotron">
    <div class="container">
      <h1>Welcome!</h1>
      <p>A revolutionary house rental system made for tenant and house owners. It features a variety of information regarding your rental status. Sign up now to avail our services.</p>
      <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
    </div>
  </div><!-- end of jumbotron -->

  <div class="container">
    <div class="row">
      
    </div>
  </div>
_END;
?>
  <!-- footer -->
  <div class="panel-footer navbar-fixed-bottom">
      <p>Copyright © Homebound Co.</p>
  </div><!-- end of footer -->


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>