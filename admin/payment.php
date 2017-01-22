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
  <title>Payment</title>
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
<body class=screen>
  <!-- topmost container -->
  <div class=container-fluid>
    <!-- divide the page into two -->
    <div class=row>
      <!-- payment form -->
      <div class="col-md-5">
        <div class="panel panel-success">
          <!-- panel header -->
          <div class="panel-heading">
            <h1 class="payment-text" style="color:green;"><strong>Payment</strong></h1>
          </div> <!-- end of panel header -->
          <!-- panel body -->
          <div class="panel-body">
            <form method="GET" class="form-group">
              <!-- payment type -->
              <div class="form-group">
                <label for="Select">Payment type:</label>
                <select id="Select" name="paymenttype" id="paymenttype" class="form-control">
                  <option value='advance' class='default' selected>Advance Payment</option>
                  <option value='rental'>Rental Payment</option>
                </select>
              </div>
              <!-- Billing ID -->
              <div class='form-group'>
                <?php
                  $billingid = '';
                  $balance = '';
                ?>
                <!-- billing id -->
                <div class='form-group col-md-6'>
                  <label for='billingid' class='control-label'>Billing ID:</label>
                  <input type='text' class='form-control' placeholder='Billing ID' name='Billing ID' value='<?= $billingid ?>' readonly>
                </div><!-- end of billing id -->
                <!-- remaining balance -->
                <div class='form-group col-md-6'>
                  <label for='balance' class='control-label'>Remaining Balance:</label>
                  <input type='text' class='form-control' placeholder='balance' name='balance' value='<?= $balance ?>' readonly>
                </div><!-- end of remaining balance -->
              </div><!-- end of billing id -->
              <!-- payment -->
              <div class='form-group'>
                <label for='payment'>Amount:</label>
                <input type='text' class='form-control' name='payment'>
              </div> <!-- end of change -->
              <!-- change -->
              <div class='form-group'>
                <label for='change'>Change:</label>
                <input type='text' class='form-control' name='change' readonly>
              </div> <!-- end of change -->
              <!-- pay button -->
              <div class='form-group'>
                <button type='submit' class='btn pull-right btn-success btn-lg' name='pay'>Pay</button>
              </div><!-- end of pay button -->
            </form> <!-- end of get form -->
          </div> <!-- end of panel-body -->
        </div> <!-- end of panel success -->
      </div> <!-- end of payment form -->
      <!-- display table -->
      <div class='col-md-7'>
        <!-- display billing information -->  
        <div>
          <!-- display header -->            
          <div class='panel panel-danger'>
            <div class="panel-heading">
              <h4>Unpaid Bills</h4>
            </div>
          </div><!-- end of display header -->
          <!-- billing table -->
          <div class='panel'>
            <!-- billing table body -->
            <div class='panel-body'>
              <table id="unpaidbill" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <td>Billing ID</td>
                    <td>Amount</td>
                    <td>Due Date</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $id = "";
                    $name = "";
                    $amount = "";
                    $date = "";
                    $query = "SELECT * FROM tbl_billinginfo WHERE id NOT IN(SELECT billingid FROM tbl_transaction WHERE status = 'paid' )";
                    $result = MySqlQuery($query);
                    for( $ctr = 0 ; $ctr < $result->num_rows ; ++$ctr){
                      $result->data_seek($ctr);
                      $rows = $result->fetch_array(MYSQLI_ASSOC);

                      $id = sanitizeString($rows['id']);
                      $amount = sanitizeString($rows['balance']);
                      $_date = sanitizeString($rows['duedate']);

                      if(!empty($id))
                        echo "<tr>
                              <form method='GET'>
                                <td>$id<input type='hidden' value='$id' name='_billing_id' /></td>
                                <td>$amount<input type='hidden' value='$amount' name='amount' /></td>
                                <td>$_date<input type='hidden' value='$_date' name='date' /></td>
                                <td><button type='submit' class='btn btn-danger btn-block btn-md'>Use</button></td>
                              </form>
                            </tr> ";
                    }
                ?>
                </tbody>
              </table><!-- end of billing table -->
            </div><!-- billing table body -->
          </div><!-- end of billing table -->
        </div> <!-- end of display billing information -->
        <!-- display recent transaction -->
        <div class="panel panel-primary">
          <!-- header -->
          <div class="panel-heading">
            <h4>Recent Transaction</h4>
          </div> <!-- end of header -->
          <!-- body -->
          <table id="recenttransact" class="table table-striped table-hover">
            <thead>
              <tr>
                <td>Unit Number</td>
                <td>Payment type</td>
                <td>Amount</td>
                <td>Date</td>
              </tr>
            </thead>
            <tbody>
            <?php
                $id = "";
                $name = "";
                $amount = "";
                $date = "";
                /* change query to call storedprocedurename() */
                $query = "SELECT * FROM tbl_billinginfo WHERE id NOT IN(SELECT billingid FROM tbl_transaction WHERE status = 'paid') limit 5";
                $result = MySqlQuery($query);
                $rows = $result->num_rows;
                for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
                  $result->data_seek($ctr);
                  $rows = $result->fetch_array(MYSQLI_ASSOC);

                  $id = sanitizeString($rows['id']);
                  $name = sanitizeString($rows['unitno']);
                  $amount = sanitizeString($rows['balance']);
                  $_date = sanitizeString($rows['duedate']);

                  if(!empty($id))
                echo "
                <tr>
                  <form method='GET'>
                  <td>$name<input type='hidden' value='$name' name='name' /></td>
                  <td>$id<input type='hidden' value='$id' name='_billing_id' /></td>
                  <td>$amount<input type='hidden' value='$amount' name='amount' /></td>
                  <td>$_date<input type='hidden' value='$_date' name='date' /></td>
                  </form>
                </tr>";
                }
              ?>
            </tbody>
          </table> <!-- end of body -->
        </div> <!-- end of recent transaction display -->
      </div><!-- end of table-display -->
    </div> <!-- end of row -->
  </div> <!-- end of container-fluid -->
  <!-- pay button -->
  <?php
    if (isset($_GET['pay']))
    {
      $billingid = sanitizeString($_GET['billingid']);
      $payer = sanitizeString($_GET['payer']);
      $amount = sanitizeString($_GET['amount']);
      $type = sanitizeString($_GET['type']);
      $query = "call sproc_rentalpayment('$billingid','$payer', '$amount','Payment for rental','$type');";
      if(isset($_GET['billingid'])||(isset($_GET['payer']))||($_GET['amount'])||(isset($_GET['type'])))
      {
        MySqlQuery($query);
        die("<script>alert('Successful Transaction!');</script>");
      }
    }
  ?>
  <!-- conpute button -->
  <?php
    $change = computeChange();
    function computeChange()
    {
      $change = 0;

      return $change;
    }
  ?>

  <script>
    $(document).ready(function() {
        $('#unpaidbill').DataTable();
    } );

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    //change the value of change
    //$('input[type=text].change').value('<?= $change ?>');

  </script>
</body>
</html>
