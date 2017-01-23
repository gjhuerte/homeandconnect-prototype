
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Rent</title>
  <!-- Bootstrap -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      padding-top: 70px; 
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
<?php
  require_once '../header.php';
  if (!$loggedin){
    die("<script>window.location.href = 'login.php';</script>");
  }
?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="../home.php">Home <span class="sr-only">(current)</span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Accounts <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../account/index.php">Add new tenant</a></li>
                <li><a href="../account/billing.php">Bill-a-tenant</a></li>
                <li><a href="../rental/index.php">Assign to property</a></li>
                <li role="separator" class="divider"></li>
                <li class=""><a href="../account/viewall.php">View all</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Properties <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../property/index.php">Add new Property</a></li>
                <li><a href="../property/maintenance.php">Maintenance</a></li>
                <li><a href="../property/viewall.php">View all</a></li>
              </ul>
            </li>
            <li class="active dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rental <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../rental/index.php">Rent a property</a></li>
                <li><a href="../rental/unoccupy.php">Unoccupy a property</a></li>
                <li role="separator" class="divider"></li>
                <li class=""><a href="../rental/viewall.php">View all</a></li>
              </ul>
            </li>
            <li><a href="../payment.php">Payment</a></li>
            <li><a href="../reports.php">Reports</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
<?php
              $result = MySqlQuery("SELECT lname,fname from tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where username = '$username'");
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
                <li><a href="../logout.php">Log out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav><!-- end of navigation bar -->
    </div><!-- end of header -->

  <div class="container-fluid">
    <div class="col-md-4 col-sm-12">
<?php
  $id;
  $name = $unitno = $amount = "";
  $name_form_class = "form-controlgroup";
  $unitno_form_class = "form-group";
  $amount_form_class = "form-group";

  if (isset($_GET['searchtenantbutton']))
  {  
      $name = sanitizeString($_GET['tenantname']);

      if($name == "") $name_form_class = $name_form_class." has-error";

      $result = MySqlQuery("SELECT * FROM tbl_personalinfo WHERE lname IN (SELECT lname FROM tbl_personalinfo left join tbl_user on id = userinfo WHERE type = '2' AND lname = '$name') OR fname  IN (SELECT fname FROM tbl_personalinfo left join tbl_user on id = userinfo WHERE type = '2' AND fname = '$name') OR mname IN (SELECT mname FROM tbl_personalinfo left join tbl_user on id = userinfo WHERE type = '2' AND mname = '$name') LIMIT 2");
      if($result->num_rows == 1)
      {
        while ($row = mysqli_fetch_assoc($result)) 
        {
            $id = $row["id"];
            $name = ucfirst(capitalFirstLetter($row['lname'])).", ".capitalFirstLetter(sanitizeString($row['fname']));
        }
        echo <<<_FOUND_ALERT
        <div class="alert alert-success alert-dismissible" role="alert">
          <strong>Tenant Name: $name </strong>
        </div>
_FOUND_ALERT;
      }
      elseif($result->num_rows > 1)
      {
        echo <<<_MULTIPLE_ALERT
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong> Multiple Result! </strong>
        </div>
              <table class="table table-hover table-striped table-responsive">
              <thead>
                <tr>
                  <td>ID</td>
                  <td>Name</td>
                </tr>
              </thead>
              <tbody>
_MULTIPLE_ALERT;
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["id"];
            $name = ucfirst(capitalFirstLetter($row['lname'])).", ".capitalFirstLetter(sanitizeString($row['fname']));
            echo <<<_TABLE
                <tr>
                  <td>$id</td>
                  <td>$name</td>
                </tr>
_TABLE;
        }

        echo "
              </tbody>
              </table>";

        $name = "";
      }
      else
      {
        echo <<<_NOTFOUND_ALERT
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong> Tenant not found!</strong>
        </div>
_NOTFOUND_ALERT;
        $name = "";
      }
    }

    if(isset($_GET['rentbutton'])){
      $unitno = sanitizeString($_GET['unitno']);
      $amount = sanitizeString($_GET['amount']);
      $id = sanitizeString($_GET['tenantid']);
      $status = "";

      if($unitno == "" || $amount == "")
      { 
        echo <<<_NOTFOUND_ALERT
        <div class="alert alert-warning alert-dismissible" role="alert">
          <strong>Fill all the required fields!</strong>
        </div>

_NOTFOUND_ALERT;

        if($unitno == "") $unitno_form_class = $unitno_form_class." has-error";
        if($amount == "") $amount_form_class = $amount_form_class." has-error";
      }
      else
      {

        $result = MySqlQuery("SELECT * from tbl_rent WHERE unitno = $unitno");

        if($result->num_rows){
                  echo <<<_NOTFOUND_ALERT
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Already Occupied</strong>
          </div>

_NOTFOUND_ALERT;
        }
        else
        {
          MySqlQuery("call sproc_rent('$id','$unitno', '$amount');");
          die('<script>window.location.href = "index.php";</script>');
        }
      }
    }

    if(isset($_GET['resetname']))
    {
      $name = "";
    }
?>
<?php
  if(empty($name))
  {
    echo <<<_TENANTNAME
        <form method="GET" autocomplete="on">
        <div class="panel panel-info">
          <div class="panel-heading">
            Search Tenant
          </div>
          <div class="panel-body">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="tenantname" value="" id="Search tenant name..." placeholder="Enter tenant name here...">
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-primary" name="searchtenantbutton">Search</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
        </form>
_TENANTNAME;

}

?>
<?php
  if(!empty($name)){

  echo <<<_RENT
      <form method="GET">
        <div class="panel panel-info">
          <div class="panel-heading">Unit Number</div>
          <div class="panel-body">
            <input type="hidden" name="tenantid" value="$id" />
            <div class="$unitno_form_class">
              <input type="text" class="form-control" name="unitno"  id="unitno" placeholder="Enter unit number here...">
            </div>
          </div>
        </div>
        <div class="$amount_form_class">
          <div class="input-group">
            <div class="input-group-addon">Php</div>
            <input type="text" class="form-control" id="exampleInputAmount" name="amount" placeholder="Advance Payment">
            <div class="input-group-addon">.00</div>
          </div>
        </div>
        <div class="row">
          <br />
          <div class="col-md-offset-4 col-md-4">
            <button type="submit" class="btn btn-primary btn-block btn-md" name="rentbutton">Rent</button>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-danger btn-block btn-md" name="resetname">Cancel</button>
          </div>
        </div>
    </form>
_RENT;
}
?>
    </div>
    <div class="col-md-8">
      <div class="row">
<?php
  $result = MySqlQuery("SELECT * from tbl_housedesc");
  $row = $result->num_rows;
  for( $ctr = 0 ; $ctr < $row ; ++$ctr)
  {
    $result->data_seek($ctr);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $unitname = $row['unitno'];
    $description = $row['description'];
    $status = $row['status'];
    if($status == "lease")
    {
      $btn_type = "btn-success";
      $btn_name = "Lease";
      $label_type = "label-success";
      $house_status = "Unoccupied";
    }
    if($status == "occupied")
    {
      $btn_type = "btn-danger";
      $btn_name = "Free";
      $label_type = "label-danger";
      $house_status = "Occupied";
    }
    if($status == "undermaintenance")
    {
      $btn_type = "btn-danger";
      $btn_name = "Make Functional";
      $label_type = "label-danger";
      $house_status = "Undermaintenance";
    }
    if($unitname != "")
  echo <<<_HOUSEINFO
        <div class="clearfix visible-xs-block"></div>
        <div class="col-md-4">
        <div class="panel panel-success">
          <div class="panel-heading">
            $unitname <span class="label $label_type"> $house_status </span>
          </div>
          <div class="panel-body">
            $description
            <!--<button type="submit" class="btn $btn_type btn-md btn-block" data-toggle="modal" data-target="#tenantnamemodal">$btn_name</button>-->
          </div>
        </div>
        </div>
_HOUSEINFO;
}
?>
          </div>
        </div>
      </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>