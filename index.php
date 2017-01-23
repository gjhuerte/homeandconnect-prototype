<?php 
  require_once 'session.php';
  require_once 'function.php';
  require_once 'header.php';
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
  <style>
    body{
      padding: 0;
    }
  </style>
</head>
<body class="screen">
  <!-- sets the page container -->
  <div class="container-fluid">
    <!-- grid system -->
    <div class="row">
      <!-- house information panel -->
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
          echo "
                <div class='clearfix visible-xs-block'></div>
                <div class='col-md-4'>
                  <form method='POST'>
                    <!-- panel head -->
                    <div class='panel panel-$type'>
                      <div class='panel-heading'>
                        Unit Number: $unitno <input type=hidden name=unitno value=$unitno /> <span class='label $label_type'> $house_status </span>
                      </div> <!-- end panel head -->
                      <!-- panel body -->
                      <div class='panel-body'>
                        <!-- house main image -->
                        <div class='row'>
                          <a href='#' class='thumbnail'>
                            <img src='$imageloc' class='img-responsive img-rounded' alt='Room image'>
                          </a>
                        </div> <!-- end of image
                        <!-- house description
                        <div class='row'>
                          $description
                        </div> <!-- end of description -->
                        <!-- rent button -->
                        <div class='form-group'>
                          <button type='button' class='btn btn-md btn-primary btn-block'  data-toggle='modal' data-target='#propertyinfomodal' name='rent' id='rent' onclick='viewbuttonclicked($unitno)'>View Information</button>
                        </div> <!-- rent button -->
                      </div> <!-- end of body -->
                    </div> <!-- end of panel -->
                  </form> <!-- end of form -->
                </div> <!-- end of col-md-4 -->"; 
        }
      ?>
      </div> <!-- end of house description -->
      <!-- login form -->
      <div class="col-md-4">

      <?php
        /* initialize values */
        $error = $username = $password = "";
        $username_form_class = "form-group";
        $password_form_class = "form-group";

        /* login form validation */
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
                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  <strong>Oops! Incorrect Login details</strong>
                </div>";
                }else{
                  $row = $result->fetch_array();
                  $_SESSION['username'] = $username;
                  $_SESSION['access'] = $row['type'];
                  die("<script>window.location.href = 'redirect.php';</script>");
                }
            }
        }
        /* display login form */
        echo "
            <div class='panel panel-success'>
              <!-- panel heading -->
              <div class='panel-heading'>
                Login Form
              </div> <!-- end of panel heading -->
              <!-- panel body -->
              <div class='panel-body'>
                <form method='POST'>
                  <!-- username -->
                  <div class='$username_form_class'>
                    <label for='username'>Username</label>
                    <input type='text' class='form-control input-lg' id='username' name='username' value='$username' placeholder='Username'>
                  </div> <!-- end of username class -->
                  <!-- password -->
                  <div class='$password_form_class'>
                    <label for='password'>Password</label>
                    <input type='password' class='form-control input-lg' id='password' name='password' value='$password' placeholder='Password'>
                  </div> <!-- end of password -->
                  <button type='submit' class='btn btn-success btn-lg btn-block' name='loginbutton'>Login</button>
                  <button type='button' class='btn btn-link' data-toggle='modal' data-target='#signupmodal'><strong>Create an account to continue</strong></button>
                </form>
              </div> <!-- end of panel body -->
            </div> <!-- end of panel -->";
      ?>
      </div> <!-- end of col-md-4 -->
    </div> <!-- end of row -->
  </div> <!-- end of container fluid -->


  <!-- signup Modal -->
  <div class="modal fade" id="signupmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Signup</h4>
        </div> <!-- end of modal header -->
        <!-- modal body -->
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

            echo "
                  <div class='$username_form_class'>
                    <label for='username'>Username</label>
                    <input type='text' class='form-control input-lg' id='username' name='username' value='$username' placeholder='Username'>
                  </div>
                  <div class='$password_form_class'>
                    <label for='password'>Password</label>
                    <input type='password' class='form-control input-lg' id='password' name='password' value='$password' placeholder='Password'>
                  </div>
                  <div class='$verifypassword_form_class'>
                    <label for='verifypassword'>Verify Password</label>
                    <input type='password' class='form-control input-lg' id='verifypassword' name='verifypassword' value='$verifypassword' placeholder='Verify Password'>
                  </div>
                  <div class='$lastname_form_class'>
                    <label for='lastname'>Last name</label>
                    <input type='text' class='form-control input-lg' id='lastname' name='lastname' value='$lastname' placeholder='Lastname'>
                  </div>
                  <div class='$firstname_form_class'>
                    <label for='firstname'>First name</label>
                    <input type='text' class='form-control input-lg' id='firstname' name='firstname' value='$firstname' placeholder='Firstname'>
                  </div>
                  <div class='$middlename_form_class'>
                    <label for='middlename'>Middle name</label>
                    <input type='text' class='form-control input-lg' id='middlename' name='middlename' value='$middlename' placeholder='Middlename'>
                  </div>
                  <div class='$birthdate_form_class'>
                    <label for='birthdate'>Birthdate</label>
                    <input type='date' class='form-control input-lg' id='birthdate' value='$birthdate' name='birthdate'>
                  </div>
                  <div class='$email_form_class'>
                    <label for='email'>Email Address</label>
                    <input type='email' class='form-control input-lg' id='email' name='email' value='$email' placeholder='Email Address'>
                  </div>
                  <div class='$telno_form_class'>
                    <label for='telno'>Cellphone Number</label>
                    <input type='tel' class='form-control input-lg' id='telno' name='telno' value='$telno' placeholder='Cellphone Number'>
                  </div>
                    <div class='radio'>
                      <label class='checkbox-inline input-lg'>
                        <input type='radio' name='gender' id='optionsRadios1' value='M' $maleChecked>
                        Male
                      </label>
                      <label class='checkbox-inline input-lg'>
                        <input type='radio' name='gender' id='optionsRadios2' value='F' $femaleChecked>
                        Female
                      </label>
                    </div>
                </div>
                <div class='modal-footer'>
                  <button type='submit' class='col-md-push-2 col-md-5 btn btn-success btn-lg' name='signupbutton'>Signup</button>
                  <button type='button' class='col-md-push-2 col-md-5 btn btn-default btn-lg' data-dismiss='modal'>Close</button>
                </form>";
        ?>
        </div> <!-- end of modal body -->
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->


  <!-- unit number Modal -->
  <div class="modal fade" id="propertyinfomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <!-- modal dialog -->
    <div class="modal-dialog" role="document">
      <!-- modal content -->
      <div class="modal-content">
        <!-- header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <!-- close button -->
          <h3>Unit Information</h3>
        </div> <!-- end of header -->
        <!-- form -->
        <form method="POST">
          <!-- modal body -->
          <div class="modal-body">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol> <!-- end of indicators -->

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
              </div> <!-- end of wrapper -->

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a> <!-- end of controls -->

            </div> <!-- end of carousel -->
            <!-- panel -->
            <div class="panel-primary">
              <!-- heading -->
              <div class="panel-heading">
                Unit Number
              </div> <!-- end of heading -->
              <!-- body -->
              <div class="panel-body" id='unitnumber'></div>
            </div> <!-- end of panel -->
            <!-- address -->
            <div class="panel-primary">
              <!-- heading -->
              <div class="panel-heading">
                Address
              </div> <!-- end of heading -->
              <!-- body -->
              <div class="panel-body">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium tincidunt risus tristique malesuada. Morbi pharetra gravida augue, nec laoreet leo pharetra et. Morbi sed metus varius, aliquam leo quis, ornare dolor. Etiam at odio et nisl volutpat consequat a sit amet ex. Nulla porta pharetra nunc, ac rhoncus ex dapibus eget. Curabitur viverra egestas lacinia. Cras quis imperdiet nunc. Duis hendrerit, metus eget efficitur lacinia, velit ex dignissim enim, at condimentum purus nunc quis libero. Praesent lacinia consequat nisi sit amet placerat. Mauris orci felis, accumsan quis dolor nec, tincidunt auctor nibh. Donec a pulvinar nulla.

              </div> <!-- end of body -->
            </div> <!-- end of address -->
          </div> <!-- end of modal body -->
        </form> <!-- end of post form -->
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->
 

  <!-- footer -->
<!--   <div class="panel-footer navbar-fixed-bottom">
      <p id="copyright">Copyright © Homebound Co.</p>
  </div> --><!-- end of footer -->

  <?php

      if(isset($_POST['signupbutton'])){

        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#signupmodal').modal('show');
        });
        </script>";
      }


      if(isset($_POST['rent'])){
        $unitno = $_POST['unitno'];
        echo " ";
      }

  ?> 

  <script>
    function viewbuttonclicked(_unit)
    {
      $('#unitnumber').val(_unit);
      $('#unitnumber').text(_unit);
    }    
  </script>

</body>
</html>
