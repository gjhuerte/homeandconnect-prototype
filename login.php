<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Log in</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      padding-top: 50px; 
      overflow: hidden;
    }
    .navbar{
      border-radius: 0;
      margin-bottom: 0;
    }
    .panel-footer{
      background-color:rgb(66,66,66);
      color:white;
    }

    .navbar-fixed-bottom{
      border-radius: 0;
    }

    .row{
      margin-top: 5%;
      margin-left: 2%;
      margin-right:10%;
      width:100%;
    }

    p.bg-danger{
      padding: 2%;
      width: 100%;
      font-size: 20px;
      background-color: rgb(162,2,21);
      color: white;
    }

    .alert{
      margin-bottom: 0;
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
            <li><a href="index.php">Welcome</a></li>
            <li class="active"><a href="#">Log in</a></li>
            <li><a href="signup.php">Sign up</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav><!-- end of navbar -->
  </div><!-- end of header -->
  <div class="row">
    <div class="col-md-offset-4 col-md-4 col-md-offset-4">
    <div class="">

<?php
  require_once 'header.php'; 
  if($loggedin)
  {
    echo '<script>window.location.href = "home.php";</script>';
  }
  
  $error = $username = $password = "";
  $username_form_class = "form-group";
  $password_form_class = "form-group";

  if (isset($_POST['username']))
  {
      $username = sanitizeString($_POST['username']);
      $password = sanitizeString($_POST['password']);
      if($username == "" || $password == ""){
        echo '<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Fill up all the required fields
        </div>';
        if($username == "") $username_form_class = $username_form_class." has-error";
        if($password == "") $password_form_class = $password_form_class." has-error";
      }
      else{
        $result = MySqlQuery("SELECT lname,fname from tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where username = '$username'");
        
          if($result->num_rows == 0){
          echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Oops! Incorrect Login details
          </div>';
          }else{
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            die("<script>window.location.href = 'home.php';</script>");
          }
      }
  }

  echo <<<_END
      <div class="panel-body">
        <form method='POST' action='login.php'>
          <div class="$username_form_class">
            <label for="username">Username</label>
            <input type="text" class="form-control input-lg" id="username" name="username" value="$username" placeholder="Username">
          </div>
          <div class="$password_form_class">
            <label for="password">Password</label>
            <input type="password" class="form-control input-lg" id="password" name="password" value="$password" placeholder="Password">
          </div>  
          <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
        </form>
      </div>
    </div>
    </div> <!-- end of content -->
  </div><!-- end of row -->
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
  <script>
  </script>
</body>
</html>