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
  <title>Home</title>
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
<!-- screen is used to darken background -->
<body class="screen">
  <!-- sets the container of the whole page -->
  <div class="container-fluid">
    <!-- divides the whole page using grid system -->
    <div class="row">
      <!-- notification tab -->
      <div class="col-md-4">
        <!-- panel for notification tab-->
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Notification</h3>
          </div>
        </div> <!-- end of panel for notification tab -->
        <!-- display all notification-->
        <?php
            // $result = MySqlQuery("SELECT * from tbl_housedesc");
            // $row = $result->num_rows;
            // for( $ctr = 0 ; $ctr < $row ; ++$ctr)
            // {
            //   $result->data_seek($ctr);
            //   $row = $result->fetch_array(MYSQLI_ASSOC);
              for($x = 0; $x < 5 ; $x++ )
              echo "
                <div class=panel panel-info>
                  <div class=panel-body>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium tincidunt risus tristique malesuada. Morbi pharetra gravida augue, nec laoreet leo pharetra et. Morbi sed metus varius, aliquam leo quis, ornare dolor. Etiam at odio et nisl volutpat consequat a sit amet ex. <a href=#> View more >>></a>
                  </div>
                </div>";
            // }
        ?>
      </div> <!-- end notification tab -->
      <!-- display all house -->
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
          $type = setHouseType($status);
          $label_type = setLabelType($status);
          $house_status = setHouseStatus($status);
          if(!empty($unitno))
          {
            echo "<div class='clearfix visible-xs-block'></div>
                  <div class='col-md-4'>
                  <form method='POST'>
                    <!-- panel -->
                    <div class='panel panel-$type panel-padding'>
                      <!-- header -->
                      <div class=panel-heading>
                        Unit Number: $unitno <span class='label $label_type'> $house_status </span>
                      </div> <!-- end of header -->
                      <!-- body -->
                      <div class=panel-body>
                        <div class=row>
                          <img src=$imageloc class='img-responsive img-rounded' alt=Room image>
                        </div> <!-- end of image row -->
                      </div> <!-- end of body --> 
                        <button type=button class='btn btn-md btn-danger btn-block' data-toggle=modal data-target=#propertyinfomodal name='housedescinfo' onclick='viewbuttonclicked($unitno)'>View <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>
                    </form>
                    </div> <!-- end of panel -->
                  </div> <!-- end of col --> ";
          } /* display house*/
        } /*end of for loop */
      ?>
      </div> <!-- end of display  -->
    </div> <!--  end of row -->
  </div> <!--  end of container-fluid -->

  <!-- footer -->
<!--   <div class="panel-footer footer-image navbar-fixed-bottom">
      <p id="copyright">Copyright © Homebound Co.</p>
  </div> --><!-- end of footer -->

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
                <li data-target="#propertyinfomodal" data-slide-to="0" class="active"></li>
                <li data-target="#propertyinfomodal" data-slide-to="1"></li>
                <li data-target="#propertyinfomodal" data-slide-to="2"></li>
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
              <a class="left carousel-control" href="#propertyinfomodal" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#propertyinfomodal" role="button" data-slide="next">
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
              <div class="panel-body">
                <h3 id='unitnumber' name='unitnumber'></h3>
              </div>
            </div> <!-- end of panel -->
            <!-- address -->
            <div class="panel-primary" >
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

  <script>
    /* view all information button */
    function viewbuttonclicked(_unit)
    {
      $('#unitnumber').val(_unit);
      $('#unitnumber').text(_unit);
    }    
  </script>
</body>
</html>
