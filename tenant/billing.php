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
    <!-- row -->
    <div class="row">
      <div class="col-md-offset-4 col-md-4">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Unpaid Bills</h3>
          </div>
        </div>
    <?php  
      $query = "SELECT * FROM tbl_transaction";
      $result = MySqlQuery($query);
      $rows = $result->num_rows;
      for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
        $result->data_seek($ctr);
        $rows = $result->fetch_array(MYSQLI_ASSOC);
        echo "          
          <div class='panel panel-info'>
            <div class='panel-body'>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium tincidunt risus tristique malesuada. Morbi pharetra gravida augue, nec laoreet leo pharetra et. Morbi sed metus varius, aliquam leo quis, ornare dolor. Etiam at odio et nisl volutpat consequat a sit amet ex.
            </div>
          </div>";
      }
    ?>
      </div>
      </div> <!-- row -->
  </div> <!--- container fluid -->

</body>
</html>
