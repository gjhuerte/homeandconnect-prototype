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
                <th>Property Number</th>
                <th>Rent Date</th>
              </tr>
            </thead>
            <tbody>
    <?php        
        $query = "SELECT * FROM tbl_rent WHERE tenantid IN (SELECT id FROM tbl_personalinfo left join tbl_user on tbl_personalinfo.id = tbl_user.userinfo WHERE username = '$username')";
        $result = MySqlQuery($query);
        $rows = $result->num_rows;
        for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
          $result->data_seek($ctr);
          $unitno = $rows['unitno'];
          $rentdate = $rows['rentday'];

      if(!empty($unitno))
        echo <<<_END
              <tr>
                <form method="POST">
                  <td>$unitno<input type="hidden" value="$unitno" name="tenantid" /></td>
                  <td>$rentdate<input type="hidden" value="$rentdate" name="lastname" /></td>
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
