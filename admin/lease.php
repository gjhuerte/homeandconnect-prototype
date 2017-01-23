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
  <title>Rent</title>
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
<body class='screen'>
  <!-- container -->
  <div class='container-fluid' style='margin-bottom:20%'>
    <!-- row -->
    <div class='row'>
      <div class='col-md-8'>
        <!-- table -->
        <table id="tenantinfo" class="table table-hover">
          <!-- header -->
          <thead>
            <tr>
              <th>ID</th>
              <th>Lastname</th>
              <th>Firstname</th>
              <th>Middlename</th>
              <th></th>
            </tr>
          </thead> <!-- end of header -->
          <!-- body -->
          <tbody>
          <?php        
            //initialize variable to prevent garbage value
            $lastname = "";
            $firstname = "";
            $middlename = "";
            $tenantid = null;
            $tenantno = "";
            //insert query here
            $query = "SELECT id,lname,fname,mname,birthdate,email,cellno,gender,username,password FROM tbl_user left join tbl_personalinfo on tbl_user.userinfo = tbl_personalinfo.id where type='1'";
            $result = MySqlQuery($query);
            $rows = $result->num_rows;
            for( $ctr = 0 ; $ctr < $rows ; ++$ctr){
              $result->data_seek($ctr);
              $rows = $result->fetch_array(MYSQLI_ASSOC);
              $tenantid = $rows['id'];
              $lastname = capitalFirstLetter($rows['lname']);
              $firstname = capitalFirstLetter($rows['fname']);
              $middlename = capitalFirstLetter($rows['mname']);
              if(!empty($tenantid))
                echo "<tr>
                        <!-- get method are used for searching -->
                        <form method='GET'>
                          <td>$tenantid<input type='hidden' value='$tenantid' name='tenantid' /></td>
                          <td>$lastname</td>
                          <td>$firstname</td>
                          <td>$middlename</td>
                          <div class'col-md-12'>
                            <td><button type='submit' class='btn btn-primary' name='use'> Use</button>
                          </div>
                        </form>
                      </tr>";
            } /* end of foor loop */
          ?>
          </tbody> <!--  end of body  -->
        </table> <!-- end of table -->
      </div><!-- end of col-md-8 -->
      <!-- unit number -->
      <div class='col-md-4'>
        <?php 
          //sets whether the panel should be displayed
          $rent_panel_display_status = "hidden";
          $contract_panel_display_status = "hidden";
          //if use button has been clicked
          //sets the tenant number
          if(isset($_GET['use']))
          {
            $tenantno = sanitizeString($_GET['tenantid']);
            $rent_panel_display_status = '';
          }
          //rent form
          if(isset($_GET['_rent']))
          {
            //check if all data are valid
            $isunit = isValidUnitNumber(sanitizeString($_GET['unitno']));
            $istenant = isValidTenant(sanitizeString($_GET['tenantno']));
            if($isunit&&$istenant) //checks if all forms are valid
            {
              echo "  <div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong>You can now show your contract information to your tenant. Get the payment from your tenant afterwards</strong>
              </div>";
              $tenantno = sanitizeString($_GET['tenantno']);
              $rent_panel_display_status = '';
              $contract_panel_display_status = "";
            }elseif(!$isunit) //checks if invalid unit
            {
              echo "  <div class='alert alert-danger alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong>Invalid unit information</strong>
              </div>";

            }elseif(!$istenant) //checks if invalid tenant
            {
              echo "  <div class='alert alert-danger alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong>Invalid tenant information!</strong>
              </div>";
            }
          }
          //successful payment
          if(isset($_POST['pay']))
          {
            $tenantno = sanitizeString($_POST['tenantno']);
            $unitno = sanitizeString($_POST['unitno']);
            $amount = sanitizeString($_POST['payment']);
            if(rentSuccess($tenantno,$unitno,$amount))
            {
              die("<script>alert('Transaction completed');window.location.href='lease.php';</script>");
            }
          }
        ?>
        <div class='panel panel-success' <?= $rent_panel_display_status ?>>
          <div class='panel-heading'>
            Rent
          </div>
          <div class='panel-body'>
            <form method='GET'>
              <!-- tenant -->
              <div class="form-group">
                <label for='tenant'>Tenant Number</label>
                <input class="form-control" type="text" name='tenantno' placeholder='Select a tenant from the left side...' value='<?php echo "$tenantno";?>' readonly>
              </div><!-- end of tenant -->
              <!-- unit -->
              <div class='form-group'>
                <label for='unit'>Unit Number</label>
                <!-- set unit number -->
                <?php
                  $unitno = '';
                  if(isset($_GET['_rent']))
                  {
                    $unitno = sanitizeString($_GET['unitno']);
                  }
                ?>
                <input type='text' class='form-control' name='unitno' value='<?= $unitno ?>' placeholder='Enter unit number here...' >
              </div> <!-- end of unit -->
              <div class='form-group'>
                <button type='submit' class='btn btn-success btn-md pull-right' name='_rent'>Assign</button>
              </div>
            </form> <!-- end of form -->
          </div><!-- end of body -->
        </div><!-- end of panel -->
        <!-- contract information -->
        <div class='panel panel-success' <?= $contract_panel_display_status ?>>
          <div class='panel-body'>
            <strong>Note:</strong> Before finishing your transaction. You need to have the tenant sign this contract. <a href='../forms/leasing_contract_form.pdf' target='_blank'>Click me</a> to print the contract information. 
          </div><!-- end of body -->
        </div><!-- end of contract information -->
        <!-- contract payment -->
        <div class='panel panel-success' <?= $contract_panel_display_status ?>>
          <!-- header -->
            <div class='panel-heading'>
              Payment
            </div> <!-- end of header -->
          <!-- body -->
          <div class='panel-body'>
            <form method='POST'>
              <?php
                $tenantno = '';
                $unitno = '';
                if(isset($_GET['_rent']))
                {
                  $tenantno = sanitizeString($_GET['tenantno']);
                  $unitno = sanitizeString($_GET['unitno']);
                }
              ?>
              <input type='hidden' value='<?= $tenantno ?>' name='tenantno'>
              <input type='hidden' value='<?= $unitno ?>' name='unitno'>
              <!-- total payment -->
              <div class='form-group'>
                <label for='amount'>Total Payment:</label>
                <!-- get amount from database -->
                <?php
                  $amount = getAmount('000000');
                ?>
                <input type='text' class='form-control' value='<?= $amount ?>' name='amount' placeholder='Amount to pay...' readonly>                           
              </div> <!-- end of amount -->
              <!-- payment -->
              <div class='form-group'>
                <label for='payment'>Payment</label>
                <!-- set the payment -->
                <?php
                  $payment = '';
                ?>
                <!-- payment form-->
                <input type='amount' class='form-control' value='<?= $payment ?>' name='payment' placeholder='Payment'>
              </div><!-- end of payment -->
              <!-- change -->
              <div class='form-group'>
                <label for='change'>Change</label><span><h4>XXXXXXXXXXXXXX</h4></span>
              </div><!-- end of change -->
              <!-- button -->
              <div class='form-group'>
                <button type='submit' class='btn btn-success btn-block btn-md' name='pay'>Pay</button>
              </div><!-- end of button -->
            </form> <!-- end of payment form -->
          </div><!-- end of body -->
        </div><!-- end of contract payment -->
      </div> <!-- end of col-md-4 -->
    </div> <!-- end of row -->
  </div> <!-- end of container fluid -->

  <!-- footer -->
  <div class='panel-footer navbar-fixed-bottom'>
      <p id='copyright'>Copyright © Homebound Co.</p>
  </div><!-- end of footer -->

  <script>
    $(document).ready(function() {
        $('#tenantinfo').DataTable();
    });

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
  </script>
</body>
</html>
