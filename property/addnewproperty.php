<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Add new property</title>
  <!-- Bootstrap -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      padding-top: 70px; 
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
  </style>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
    <div class="header">
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
            <ul class="nav navbar-nav">
              <li><a href="#">Home <span class="sr-only">(current)</span></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Accounts <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="../account/addnewtenant.php">Add new tenant</a></li>
                  <li><a href="#">Bill-a-tenant</a></li>
                  <li><a href="../rent.php">Assign to property</a></li>
                  <li role="separator" class="divider"></li>
                  <li class=""><a href="#">View all</a></li>
                </ul>
              </li>
              <li class="active dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Properties <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="active"><a href="addnewproperty.php">Add new Property</a></li>
                  <li><a href="#">Maintenance</a></li>
                  <li><a href="property/viewall.php">View all</a></li>
                </ul>
              </li>
              <li><a href="../payment.php">Payment</a></li>
              <li><a href="../reports.php">Reports</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
<?php
  require_once '../header.php';
  if (!$loggedin){
    die("<script>window.location.href = 'login.php';</script>");
  }
  $result = MySqlQuery("SELECT lname,fname from tbl_user natural join tbl_personalinfo where username = '$username'");
  if($result->num_rows){
    $row = $result->fetch_array();
    $name = ucfirst(capitalFirstLetter($row['lname'])).", ".capitalFirstLetter(sanitizeString($row['fname']));
  echo <<<_END
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">$name <span class="caret"></span></a>
_END;
}
?>
                <ul class="dropdown-menu">
                  <li><a href="#">Profile</a></li>
                  <li><a href="#">Reports</a></li>
                  <li><a href="#">Settings</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="logout.php">Log out</a></li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav><!-- end of navigation bar -->
    </div><!-- end of header -->

<?php
  $error = $unitno = $description = $rentamount = "";
  $unitno_form_class = "form-group";
  $description_form_class = "form-group";
  $rent_amount_form_class = "form-group";

  if(isset($_GET['addnewproperty'])){
    $unitno = sanitizeString($_GET['unitno']);
    $description = sanitizeString($_GET['description']);
    $rentamount = sanitizeString($_GET['rentamount']);


    if($unitno == "" || $description == "" || $rentamount == ""){

      echo '<div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Fill up all the required fields
      </div>';

      if($unitno == "") $unitno_form_class = $unitno_form_class." has-error";
      if($description == "") $description_form_class = $description_form_class." has-error";
      if($rentamount == "") $rentamount_form_class = $rentamount_form_class." has-error";

  }else{

      MySqlQuery("call sproc_addnewproperty('$unitno','$description', '$rentamount','lease');"); 
      die("<script>alert('Property Added!');window.location.href = 'addnewproperty.php';</script>");
    }
  }

  echo <<<_END
    <div class="col-md-offset-1 col-md-4">
      <form class="form-horizontal" action="addnewproperty.php" method="GET">
        <div class="$unitno_form_class">
          <label for="unitno" class="control-label">Unit Name/Number</label>
            <input type="text" class="form-control" id="unitno" name="unitno" placeholder="Unit Name/Number">
        </div>
        <div class="$description_form_class">
          <label for="unitno" class="control-label">Description</label>
            <textarea class="form-control" rows="10" name="description" placeholder="Enter description here..."></textarea>
        </div>
        <div class="$rent_amount_form_class">
          <label for="rentamount" class="control-label">Rent Amount</label>
            <input type="number" class="form-control" id="rentamount" name="rentamount" placeholder="Rent Amount">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block btn-lg" name="addnewproperty">Add</button>
        </div>
      </form>
    </div>
_END;
    ?>
    <div class="col-md-4">
    </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>