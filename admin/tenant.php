<?php
  // carousel and navbar
  require_once 'header.php';
  // function
  require_once 'function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Maintenance (Tenant)</title>
  <!-- Bootstrap -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="screen">
  <div class="container-fluid">
    <!-- add new tenant -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4">
        <form method="POST">
          <h1 class="payment-text" style="color:green;"><strong>Add new tenant</strong>
          <button type="button" class="btn btn-success btn-md" name="addtenantbutton" data-toggle="modal" data-target="#addnewtenantmodal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></h1>
        </form>
      </div>
    </div><!-- end of upper body -->
    <!-- table -->
      <div class="row">
        <div class="col-md-12">
          <table id="tenantinfo" class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Lastname</th>
                <th>Firstname</th>
                <th>Middlename</th>
                <th>Birthdate</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Gender</th>
                <th>Username</th>
                <th>Password</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
    <?php        
        $id = "";
        $lastname = "";
        $firstname = "";
        $middlename = "";
        $birthdate = "";
        $email = "";
        $cellno = "";
        $gender = "";
        $tenantid = null;

      $result = MySqlQuery("SELECT id,lname,fname,mname,birthdate,email,cellno,gender,username,password FROM tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where type='1'");
      $rows = $result->num_rows;
      for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
        $result->data_seek($ctr);
        $rows = $result->fetch_array(MYSQLI_ASSOC);
        $tenantid = $rows['id'];
        $lastname = capitalFirstLetter($rows['lname']);
        $firstname = capitalFirstLetter($rows['fname']);
        $middlename = capitalFirstLetter($rows['mname']);
        $birthdate = $rows['birthdate'];
        $email = $rows['email'];
        $cellno = $rows['cellno'];
        $gender = $rows['gender'];
        $username = $rows['username'];
        $password = $rows['password'];

        if($gender == "M")
            $gender = "Male";
        elseif ($gender == "F")
            $gender = "Female";
      if($tenantid!= "")
        echo <<<_END
              <tr>
                <form method="POST">
                  <td>$tenantid<input type="hidden" value="$tenantid" name="tenantid" /></td>
                  <td>$lastname<input type="hidden" value="$lastname" name="lastname" /></td>
                  <td>$firstname<input type="hidden" value="$firstname" name="firstname" /></td>
                  <td>$middlename<input type="hidden" value="$middlename" name="middlename" /></td>
                  <td>$birthdate<input type="hidden" value="$birthdate" name="birthdate" /></td>
                  <td>$email<input type="hidden" value="$email" name="email" /></td>
                  <td>$cellno<input type="hidden" value="$cellno" name="cellno" /></td>
                  <td>$gender<input type="hidden" value="$gender" name="gender" /></td>
                  <td>$username<input type="hidden" value="$username" name="username" /></td>
                  <td>$password<input type="hidden" value="$password" name="password" /></td>
                  <div class"col-md-12">
                    <td><button type="submit" class="col-md-6 col-sm-6 btn btn-warning" name="edittenantbutton" data-toggle="tooltip" data-placement="left" title="Update"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                    <button type="button" class="col-md-6 col-sm-6 btn btn-danger" name="removebutton" data-toggle="tooltip" data-placement="left" title="Delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
                  </div>
                </form>
              </tr>
_END;
      }
?>
            </tbody>
          </table>
        </div>
      </div> <!-- end of row -->
    </div> <!-- end of panel -->
  </div> <!-- end of container-fluid -->
  
  <!-- Modal -->
  <div class="modal fade" id="addnewtenantmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Add new tenant</h4>
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

  if (isset($_POST['addtenantsubmitbutton']))
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

      if($gender == "Female"){
        $femaleChecked = "Checked";
        $maleChecked = "";
      }

      if($username == "" || $password == "" || $lastname == "" ||$firstname == "" ||$middlename == "" ||$birthdate == "" ||$email == "" ||$telno == "" ||$gender == ""){

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
          
          echo "<script>alert('Account Successfully created!');window.location.href = 'viewall.php';</script>";
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
          <button type="submit" class="btn btn-success" name="addtenantsubmitbutton">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
_END;
?>
        </div>
        </form>
      </div> <!-- modal content -->
    </div>
  </div> <!-- end of modal -->


  <!-- Modal -->
  <div class="modal fade" id="edittenantmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Update tenant Information</h4>
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

  if (isset($_POST['edittenantbutton']))
  {  
      $tenantid = sanitizeString($_POST['tenantid']);
      $lastname = sanitizeString($_POST['lastname']);
      $firstname = sanitizeString($_POST['firstname']);
      $middlename = sanitizeString($_POST['middlename']);
      $birthdate = sanitizeString($_POST['birthdate']);
      $email = sanitizeString($_POST['email']);
      $telno = sanitizeString($_POST['cellno']);
      $gender = sanitizeString($_POST['gender']);
      $username = sanitizeString($_POST['username']);
      $password = sanitizeString($_POST['password']);

      if($gender == "Female"){
        $femaleChecked = "Checked";
        $maleChecked = "";
      }

  }

  if (isset($_POST['modaleditbutton']))
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
          MySqlQuery("call sproc_edittenant('$username','$password', '$lastname','$firstname','$middlename','$birthdate','$email','$telno','$gender');"); 
          
          echo "<script>alert('Account Information Updated!');window.location.href = 'tenant.php';</script>";
        }
      }


  }

    echo <<<_END
          <div class="">
            <label for=tenantid>ID</label> <div id=tenantid class="well"><strong>$tenantid</strong></div>
          </div>
          <div class="$username_form_class">
            <label for="username">Username</label>
            <input type="text" class="form-control input-lg" id="username" name="username" value='$username' placeholder="Username">
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
          <button type="submit" class="btn btn-success" name="modaleditbutton">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </form>
_END;
?>
        </div>
      </div>
    </div>
  </div> <!-- end of modal -->

  <!-- data table javascript plugin -->
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
  <?php
    if(isset($_POST['edittenantbutton'])){

      echo "<script type='text/javascript'>
      $(document).ready(function(){
      $('#edittenantmodal').modal('show');
      });
      </script>";
    }
    if(isset($_POST['addtenantbutton'])){

      echo "<script type='text/javascript'>
      $(document).ready(function(){
      $('#addnewtenantmodal').modal('show');
      });
      </script>";
    }

  ?>

  <script>
      $(document).ready(function() {
        $('#tenantinfo').DataTable();
    } );

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  </script>
</body>
</html>
