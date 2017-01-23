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
  <!-- container -->
  <div class="container-fluid">
    <!-- table -->
      <div class="row">
        <!--  -->
        <div class="col-md-12">
          <!-- transaction table -->
          <table id="tenantinfo" class="table table-hover">
            <!-- header -->
            <thead>
              <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Description</th>
                <th></th>
              </tr>
            </thead> <!-- end of header -->
            <!-- body -->
            <tbody>
            <?php        
                $query = "SELECT * FROM tbl_transaction";
                $result = MySqlQuery($query);
                $rows = $result->num_rows;
                for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
                  $result->data_seek($ctr);
                  $rows = $result->fetch_array(MYSQLI_ASSOC);
/*                $id = $rows['id'];
                  $amount = $rows['description']
                  $datepaid = $rows['paydate']
                  $description = $rows['description']*/

                  if(!empty($id))
                    echo "
                          <tr>
                            <form method='POST'>
                              <td>$tenantid<input type='hidden' value='$id' name='tenantid' /></td>
                              <td>$lastname<input type='hidden' value='$amount' name='lastname' /></td>
                              <td>$firstname<input type='hidden' value='$datepaid' name='firstname' /></td>
                              <td>$middlename<input type='hidden' value='$description' name='middlename' /></td>
                              <div class'col-md-12'>
                                <td><button type='submit' class='col-md-6 col-sm-6 btn btn-warning' name='edittenantbutton' data-toggle='tooltip' data-placement='left' title='Update'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>
                                <button type='button' class='col-md-6 col-sm-6 btn btn-danger' name='removebutton' data-toggle='tooltip' data-placement='left' title='Delete'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></td>
                              </div>
                            </form>
                          </tr>";
                }
            ?>
            </tbody> <!-- end of tbody -->
          </table> <!-- end of table -->
        </div> <!-- end of col-md-12 -->
      </div> <!-- end of row -->
  </div> <!-- end of container-fluid -->
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
