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
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3>Notification</h3>
            </div>
          </div>
          <?php
            $result = MySqlQuery("SELECT * from tbl_housedesc");
            $row = $result->num_rows;
            for( $ctr = 0 ; $ctr < $row ; ++$ctr)
            {
              $result->data_seek($ctr);
              $row = $result->fetch_array(MYSQLI_ASSOC);
              if(!empty($unitno))
              echo '
                <div class="panel panel-info">
                  <div class="panel-body">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium tincidunt risus tristique malesuada. Morbi pharetra gravida augue, nec laoreet leo pharetra et. Morbi sed metus varius, aliquam leo quis, ornare dolor. Etiam at odio et nisl volutpat consequat a sit amet ex.
                  </div>
                </div>';
            }
          ?>
        </div>
         <div class="col-md-8">
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
                $imageloc = "../img/sample/sample_image.jpg";
                $address = "";
                if($status == "lease")
                {
                  $type = "success";
                  $label_type = "label-success";
                  $house_status = "Unoccupied";
                }
                if($status == "occupied")
                {
                  $type = "danger";
                  $label_type = "label-danger";
                  $house_status = "Occupied";
                }
                if($status == "undermaintenance")
                {
                  $label_type = "label-danger";
                  $house_status = "Undermaintenance";
                }
                if($unitno != "")
                  echo <<<_HOUSEINFO
              <div class="clearfix visible-xs-block"></div>
              <div class="col-md-4">
                <form method="POST">
                <input type='hidden' value='$address' name='address'>
                <input type='hidden' value='$description' name='description'>
                <div class="panel panel-$type panel-padding">
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
                      <div class='form-group'>
                        <button type='button' class='btn btn-md btn-block btn-primary' name="housedescinfo" data-toggle='modal' data-target='#propertyinfomodal' onclick='viewbuttonclicked($unitno)'>View more</button>
                      </div>
                    </div>
                  </div>
                  </form>
                </div>
              </div>
_HOUSEINFO;
      }
      ?>
            </div>
        </div> <!-- row -->
    </div> <!--- container fluid -->


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
              <div class="panel-body" id='unitnumber'>
              </div>
            </div> <!-- end of panel -->
            <!-- description -->
            <div class="panel-primary">
              <!-- heading -->
              <div class="panel-heading">
                Description
              </div> <!-- end of heading -->
              <!-- body -->
              <div class="panel-body" id='unitdescription'>
              </div> <!-- end of body -->
            </div> <!-- end ofdescription -->
            <!-- address -->
            <div class="panel-primary">
              <!-- heading -->
              <div class="panel-heading">
                Address
              </div> <!-- end of heading -->
              <!-- body -->
              <div class="panel-body" id='unitaddress'>
              </div> <!-- end of body -->
            </div> <!-- end of address -->
          </div> <!-- end of modal body -->
        </form> <!-- end of post form -->
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->

  <script>
    function viewbuttonclicked(_unit)
    {
      $('#unitnumber').val(_unit);
      $('#unitnumber').text(_unit);
    }    
  </script>
</body>
</html>
