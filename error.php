<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Invalid page</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .panel{
      margin: 10%;
      margin-left:30%;
      margin-right: 30%;
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
  <div class="container-fluid">
    <div class="row">
      <div class="panel panel-danger">
        <div class="panel-heading">
          Page not found!
        </div>
        <div class="panel-body">
          <blockquote>
            The page you want to view is unavailable or not existing. You might not have enough permission to access this page. Contact the house owner for more information.
          </blockquote>          
          <form method="GET">
            <button type="submit" class="btn btn-lg btn-primary pull-right" name="redirect">Redirect</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
    if(isset($_GET['redirect']))
    {
      echo "die('<script>window.location.href = 'redirect.php';</script>');";
    }
  ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>