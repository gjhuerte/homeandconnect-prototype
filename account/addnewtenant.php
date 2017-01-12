<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Add new tenant</title>
  <!-- Bootstrap -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      padding-top: 60px; 
      padding-bottom: 70px;
      overflow-x: hidden;
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
    die("<script>window.location.href = '../login.php';</script>");
  }
?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="../home.php">Home <span class="sr-only">(current)</span></a></li>
            <li class="active dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Accounts <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Add new tenant</a></li>
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
  <div class="row">
    <div class="col-md-offset-4 col-md-4 col-md-offset-4">
    <div class="">
<?php
  $error = $username = $password = $lastname = $firstname = $middlename = $email = $telno = $education = $address = $nationality = $religion = $gender = $birthdate = $verifypassword = "";
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

  if (isset($_POST['username']))
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

      if($username == "" || $password == "" || $lastname == "" ||$firstname == "" ||$middlename == "" ||$birthdate == "" ||$email == "" ||$telno == ""  ||$gender == ""){

        echo '<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Fill up all the required fields
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
          die("<script>alert('Successfully created an account!');</script>");
        }
      }
  }
  /*
      <script>
        function checkUser(user)
        {
          if (user.value == '')
          {
            0('info').innerHTML = ''
            return
          }

          params = "user=" + user.value
          request = new ajaxRequest()
          request.open("POST","checkuser.php",true)
          request.setRequestHeader("Content-type","applicatoin/x-www-form-urlencoded")
          request.setRequestHeader("Content-length",params.length)
          request.setRequestHeader("Connection","close")
          request.onreadystatechange = function(){
          if (this.readyState == 4)
              if (this.status == 200)
                  if (this.responseText != null)
                    0('info').innerHTML = this.responseText
          }

          request.send(params)
        }
        function ajaxRequest()
        {
          try
          {
            var request = new XMLHttpRequest()
          }
          catch(e1){
            try{
              request = new ActiveXObject("Msxml2.XMLHTTP")
            }
            catch(e2){
              try{
              request = new ActiveXObject("Microsoft.XMLHTTP")
              } 
              catch(e3){
                request = false;
              }
            }
          }
          return request
        }
        </script>
*/
echo <<<_END
      <div class="panel-body">
        <form method="POST" action="addnewtenant.php">
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
  <script src="../js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>