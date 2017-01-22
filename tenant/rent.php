<?php 
  require_once 'header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Rent</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href='style.css' rel='stylesheet'>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="screen">
  <div class="container-fluid">
  <br />
  <div class="row">
    <div class="col-md-push-4 col-md-4">
<?php 
  if(isset($_GET['rent']))
  {
    echo '<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Request sent! You need to contact the owner to finish rental</strong>
    </div>';
  }
?>
      <div class="panel panel-success">
        <div class="panel-heading">
          Rent
        </div>
        <div class="panel-body">
          <form method='GET'>
              <div class="$username_form_class">
                <label for="property">Property Number</label>
                <select class="form-control" id="property">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
              <br />
              <button type="submit" class="btn btn-success btn-md pull-right" name="rent">Request for rent</button>
          </form>
        </div>
        </div>
    </div> <!-- end of panel -->
    </div> <!-- end of content -->
  </div><!-- end of row -->
  </div> <!-- end of container fluid -->

  <!-- footer -->
  <div class="panel-footer navbar-fixed-bottom">
      <p id="copyright">Copyright © Homebound Co.</p>
  </div><!-- end of footer -->

</body>
</html>
