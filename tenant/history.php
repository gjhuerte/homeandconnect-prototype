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
  <title>Home and Connect</title>
  <!-- Bootstrap -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
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
  </div> <!-- end of container-fluid -->
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="../js/dataTables.bootstrap.min.js"></script>
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
