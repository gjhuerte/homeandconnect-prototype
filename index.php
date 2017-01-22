<?php 
  require_once 'session.php';
  require_once 'function.php';
  if($loggedin)
  {
    echo '<script>window.location.href = "redirect.php";</script>';
  }
?>
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
  <link href="style.css" rel='stylesheet'>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="screen">
  <!-- header -->
  <div class="">
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

      </div><!-- /.container-fluid -->
    </nav><!-- end of navbar -->
  </div><!-- end of header -->
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-7">
      <?php
        $result = MySqlQuery("SELECT * from tbl_housedesc");
        $row = $result->num_rows;
        for( $ctr = 0 ; $ctr < $row ; ++$ctr)
        {
          $result->data_seek($ctr);
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $unitno = $row['unitno'];
          $description = $row['description'];
          $status = $row['status'];
          $imageloc = "img/sample/sample_image.jpg";
          $type = setHouseType($status);
          $label_type = setLabelType($status);
          $house_status = setHouseStatus($status);
          if(!empty($unitno))
        echo <<<_HOUSEINFO
              <div class="clearfix visible-xs-block"></div>
              <div class="col-md-4">
                <form method="POST">
                <div class="panel panel-$type" data-toggle="modal" data-target="#propertyinfomodal" name="housedescinfo">
                  <div class="panel-heading">
                    Unit Number: $unitno <input type=hidden name=unitno value=$unitno /> <span class="label $label_type"> $house_status </span>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <a href="#" class="thumbnail">
                        <img src="$imageloc" class="img-responsive img-rounded" alt="Room image">
                      </a>
                    </div>
                    <div class="row">
                      $description
                    </div>
                    <div class="row">
                    </div>
                  </div>
                  </form>
                </div>
              </div>
_HOUSEINFO;
      }
      ?>
      </div>
    <div class="col-md-4">

<?php

  $error = $username = $password = "";
  $username_form_class = "form-group";
  $password_form_class = "form-group";

  if (isset($_POST['loginbutton']))
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
        $result = MySqlQuery("SELECT lname,fname,type from tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where username = '$username'");

          if($result->num_rows == 0){
          echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Oops! Incorrect Login details
          </div>';
          }else{
            $row = $result->fetch_array();
            $_SESSION['username'] = $username;
            $_SESSION['access'] = $row['type'];
            die("<script>window.location.href = 'redirect.php';</script>");
          }
      }
  }

  echo <<<_END
      <div class="panel panel-success">
        <div class="panel-heading">
          Login Form
        </div>
        <div class="panel-body">
        <form method='POST'>
            <div class="$username_form_class">
              <label for="username">Username</label>
              <input type="text" class="form-control input-lg" id="username" name="username" value="$username" placeholder="Username">
            </div>
            <div class="$password_form_class">
              <label for="password">Password</label>
              <input type="password" class="form-control input-lg" id="password" name="password" value="$password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-success btn-lg btn-block" name="loginbutton">Login</button>
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#signupmodal"><strong>Create an account to continue</strong></button>
          </form>
        </div>
        </div>
    </div> <!-- end of panel -->
    </div> <!-- end of content -->
  </div><!-- end of row -->
_END;
?>
  </div> <!-- end of container fluid -->


  <!-- Modal -->
  <div class="modal fade" id="signupmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Signup</h4>
        </div>
        <form method="POST">
        <div class="modal-body">
    
<?php
    $error = $username = $password = $lastname = $firstname = $middlename = $email = $telno = $gender = $birthdate = $verifypassword = "";
    $username_form_class = "form-group";
    $password_form_class = "form-group";
    $lastname_form_class = "form-group";
    $firstname_form_class = "form-group";
    $middlename_form_class = "form-group";
    $birthdate_form_class = "form-group";
    $email_form_class = "form-group";
    $telno_form_class = "form-group";
    $verifypassword_form_class = "form-group";
    $maleChecked = "Checked";
    $femaleChecked = "";
  if (isset($_POST['signupbutton']))
  {  
      $username = sanitizeString($_POST['username']);
      $password = sanitizeString($_POST['password']);
      $verifypassword = sanitizeString($_POST['verifypassword']);
      $lastname = sanitizeString($_POST['lastname']);
      $firstname = sanitizeString($_POST['firstname']);
      $middlename = sanitizeString($_POST['middlename']);
      $birthdate = sanitizeString($_POST['birthdate']);
      $email = sanitizeString($_POST['email']);
      $telno = sanitizeString($_POST['telno']);
      $gender = sanitizeString($_POST['gender']);

      if($gender == "F"){
        $femaleChecked = "Checked";
        $maleChecked = "";
      }

      if($username == "" || $password == "" || $lastname == "" ||$firstname == "" ||$middlename == "" ||$birthdate == "" ||$email == "" ||$telno == "" ||$gender == ""){

        echo '<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Fill up all the required fields</strong>
        </div>';

        if($username == "") $username_form_class = $username_form_class." has-error";
        if($password == "") $password_form_class = $password_form_class." has-error";
        if($lastname == "") $lastname_form_class = $lastname_form_class." has-error";
        if($firstname == "") $firstname_form_class = $firstname_form_class." has-error";
        if($middlename == "") $middlename_form_class = $middlename_form_class." has-error";
        if($birthdate == "") $birthdate_form_class = $birthdate_form_class." has-error";
        if($email == "") $email_form_class = $email_form_class." has-error";
        if($telno == "") $telno_form_class = $telno_form_class." has-error";
        if($verifypassword == "") $verifypassword_form_class = $verifypassword_form_class." has-error";

      }elseif ($password !=  $verifypassword ){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Password Mismatch!</div>';
        $password_form_class = $password_form_class." has-error";
        $verifypassword_form_class = $verifypassword_form_class." has-error";
      }
      else{
        $result = MySqlQuery("SELECT * FROM tbl_user WHERE username = '$username'");
        if($result->num_rows){
          echo '<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Username already taken
          </div>';
        }
        else{
          MySqlQuery("call sproc_insertnewtenant('$username','$password', '$lastname','$firstname','$middlename','$birthdate','$email','$telno','$gender');"); 
          
          echo "<script>alert('Account Successfully created!');</script>";
        }
      }  
  }

    echo <<<_END
          <div class="$username_form_class">
            <label for="username">Username</label>
            <input type="text" class="form-control input-lg" id="username" name="username" value='$username' placeholder="Username">
          </div>
          <div class="$password_form_class">
            <label for="password">Password</label>
            <input type="password" class="form-control input-lg" id="password" name="password" value='$password' placeholder="Password">
          </div>
          <div class="$verifypassword_form_class">
            <label for="verifypassword">Verify Password</label>
            <input type="password" class="form-control input-lg" id="verifypassword" name="verifypassword" value='$verifypassword' placeholder="Verify Password">
          </div>
          <div class="$lastname_form_class">
            <label for="lastname">Last name</label>
            <input type="text" class="form-control input-lg" id="lastname" name="lastname" value='$lastname' placeholder="Lastname">
          </div>
          <div class="$firstname_form_class">
            <label for="firstname">First name</label>
            <input type="text" class="form-control input-lg" id="firstname" name="firstname" value='$firstname' placeholder="Firstname">
          </div>
          <div class="$middlename_form_class">
            <label for="middlename">Middle name</label>
            <input type="text" class="form-control input-lg" id="middlename" name="middlename" value='$middlename' placeholder="Middlename">
          </div>
          <div class="$birthdate_form_class">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control input-lg" id="birthdate" value='$birthdate' name="birthdate">
          </div>
          <div class="$email_form_class">
            <label for="email">Email Address</label>
            <input type="email" class="form-control input-lg" id="email" name="email" value='$email' placeholder="Email Address">
          </div>
          <div class="$telno_form_class">
            <label for="telno">Cellphone Number</label>
            <input type="tel" class="form-control input-lg" id="telno" name="telno" value='$telno' placeholder="Cellphone Number">
          </div>
            <div class="radio">
              <label class="checkbox-inline input-lg">
                <input type="radio" name="gender" id="optionsRadios1" value="M" $maleChecked>
                Male
              </label>
              <label class="checkbox-inline input-lg">
                <input type="radio" name="gender" id="optionsRadios2" value="F" $femaleChecked>
                Female
              </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="col-md-push-2 col-md-5 btn btn-success btn-lg" name="signupbutton">Signup</button>
          <button type="button" class="col-md-push-2 col-md-5 btn btn-default btn-lg" data-dismiss="modal">Close</button>
        </form>
_END;
?>
        </div>
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->


  <!-- Modal -->
  <div class="modal fade" id="propertyinfomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Unit Number: 
          <?php
            $unitno = $_POST['unitno'];
           echo "$unitno"; 
           ?>
           </h4>
        </div>
        <form method="POST">
            <div class="modal-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img src="..." alt="...">
                  <div class="carousel-caption">
                    sub information
                  </div>
                </div>
                <div class="item">
                  <img src="..." alt="...">
                  <div class="carousel-caption">
                    sub information2
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
            <div class="panel-primary">
              <div class="panel-heading">
                Address
              </div>
              <div class="panel-body">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium tincidunt risus tristique malesuada. Morbi pharetra gravida augue, nec laoreet leo pharetra et. Morbi sed metus varius, aliquam leo quis, ornare dolor. Etiam at odio et nisl volutpat consequat a sit amet ex. Nulla porta pharetra nunc, ac rhoncus ex dapibus eget. Curabitur viverra egestas lacinia. Cras quis imperdiet nunc. Duis hendrerit, metus eget efficitur lacinia, velit ex dignissim enim, at condimentum purus nunc quis libero. Praesent lacinia consequat nisi sit amet placerat. Mauris orci felis, accumsan quis dolor nec, tincidunt auctor nibh. Donec a pulvinar nulla.

              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </form>
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->
 

  <!-- footer -->
  <div class="panel-footer navbar-fixed-bottom">
      <p id="copyright">Copyright © Homebound Co.</p>
  </div><!-- end of footer -->


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <?php

      if(isset($_POST['signupbutton'])){

        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#signupmodal').modal('show');
        });
        </script>";
      }


      if(isset($_POST['housedescinfo'])){

        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#propertyinfomodal').modal('show');
        });
        </script>";
      }

  ?>
  </script>
</body>
</html>
