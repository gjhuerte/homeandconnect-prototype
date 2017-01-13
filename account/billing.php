<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Home and Connect</title>
  <!-- Bootstrap -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      padding-top: 60px; 
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

    .table{
      margin-top:10px;
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
            <li class="active dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Accounts <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../account/addnewtenant.php">Add new tenant</a></li>
                <li><a href="#">Bill-a-tenant</a></li>
                <li><a href="../rent.php">Assign to property</a></li>
                <li role="separator" class="divider"></li>
                <li class=""><a href="viewall.php">View all</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Properties <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../property/addnewproperty.php">Add new Property</a></li>
                <li><a href="#">Maintenance</a></li>
                <li><a href="../property/viewall.php">View all</a></li>
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
    <!-- body -->
    <div class="container">
    <!-- upper body -->
    <div class="row">
    <div class="col-xs-12 col-sm-12 pull-right col-md-4">
        <form  class="form-inline" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
            <button type="submit" class="btn btn-default">Search</button>
          </div>
        </form>
    </div>
    </div><!-- end of upper body -->
    <!-- table -->
    <div class="row">
    <div class="col-md-12">
      <table class="table table-striped table-hover table-responsive">
        <thead>
          <tr>
            <td>ID</td>
            <td>Lastname</td>
            <td>Firstname</td>
            <td>Middlename</td>
            <td>Unit Number</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
<?php
    $id = "";
    $lastname = "";
    $firstname = "";
    $middlename = "";
    $unitno = "";

  $result = MySqlQuery("SELECT id,lname,fname,mname,tbl_rent.unitno as 'unitno' FROM tbl_user right join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id right join tbl_rent on tbl_personalinfo.id = tbl_rent.tenantid where type='2' AND tbl_rent.unitno NOT IN (SELECT unitno FROM tbl_billinginfo WHERE billdate < DATE_ADD(NOW(),INTERVAL 15 DAY) OR duedate > NOW())");
  $rows = $result->num_rows;
  for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
    $result->data_seek($ctr);
    $rows = $result->fetch_array(MYSQLI_ASSOC);
    $id = $rows['id'];
    $lastname = capitalFirstLetter($rows['lname']);
    $firstname = capitalFirstLetter($rows['fname']);
    $middlename = capitalFirstLetter($rows['mname']);
    $unitno = capitalFirstLetter($rows['unitno']);


  if(!empty($id))
    echo <<<_END
          <tr>
            <form method="GET">
            <td>$id</td>
            <td>$lastname</td>
            <td>$firstname</td>
            <td>$middlename</td>
            <td id = "unitno">$unitno <input type="hidden" value="$unitno" name="unitno" /></td>
            <td><button type="submit" class="btn btn-success btn-block" name="billbutton">Bill</button>
          </tr>
_END;
  }
    echo <<<_END
        </tbody>
      </table>
      </form>
    </div>
    </div>
    </div>
_END;
?>

<?php
  if(isset($_GET['billbutton']))
  {
    $unitno = $_GET['unitno'];
    MySqlQuery("call sproc_billtenant('$unitno');"); 
    die("<script>window.location.href = 'billing.php';</script>");
  }
?>
  <!-- footer -->
  <div class="panel-footer navbar-fixed-bottom">
      <p>Copyright © Homebound Co.</p>
  </div><!-- end of footer -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins)  -->
  <script src="../js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>