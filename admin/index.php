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
                    <!-- panel -->
                    <div class='panel panel-$type panel-padding'>
                      <!-- header -->
                      <div class=panel-heading>
                        Unit Number: $unitno <span class='label $label_type'> $house_status </span>
                        <input type=hidden value=$unitno name=unitno>
                      </div> <!-- end of header -->
                      <!-- body -->
                      <div class=panel-body>
                        <div class=row>
                          <img src=$imageloc class='img-responsive img-rounded' alt=Room image>
                        </div> <!-- end of image row -->
                      </div> <!-- end of body --> 
                        <button type=button class='btn btn-md btn-danger btn-block' data-toggle=modal data-target=#propertyinfomodal name='housedescinfo'>View <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>
                    </div> <!-- end of panel -->
                  </div> <!-- end of col --> ";
          } /* display house*/
        } /*end of for loop */
      ?>
      </div> <!-- end of display  -->
    </div> <!--  end of row -->
  </div> <!--  end of container-fluid -->

  <!-- footer -->
  <div class="panel-footer footer-image navbar-fixed-bottom">
      <p id="copyright">Copyright © Homebound Co.</p>
  </div><!-- end of footer -->

  <!-- Modal -->
  <div class="modal fade" id="propertyinfomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <!-- modal dialog -->
    <div class="modal-dialog" role="document">
      <!-- modal content -->
      <div class="modal-content">
        <!-- send request using POST method -->
        <form method="POST">
          <!-- modal-header -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Property Information</h4>
          </div> <!--  end of modal header -->
          <!-- modal body -->
          <div class="modal-body">
            <!-- carousel slide -->
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol> <!-- end of indicators -->

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <!-- each item of carousel is the -->
                <!-- item 1 -->
                <div class="item active">
                  <img src="..." alt="...">
                  <div class="carousel-caption">
                    sub information
                  </div>
                </div> <!--  end of item 1 -->
                <!-- item 2 -->
                <div class="item">
                  <img src="..." alt="...">
                  <div class="carousel-caption">
                    sub information2
                  </div>
                </div>
              </div> <!-- end of item 2 -->

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a> <!--  end of controls -->
            </div> <!-- end of carousel slide -->
            <!-- description -->
            <div class="panel-primary">
              <div class="panel-heading">
                Address
              </div> <!--  end of panel-heading -->
              <div class="panel-body">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium tincidunt risus tristique malesuada. Morbi pharetra gravida augue, nec laoreet leo pharetra et. Morbi sed metus varius, aliquam leo quis, ornare dolor. Etiam at odio et nisl volutpat consequat a sit amet ex. Nulla porta pharetra nunc, ac rhoncus ex dapibus eget. Curabitur viverra egestas lacinia. Cras quis imperdiet nunc. Duis hendrerit, metus eget efficitur lacinia, velit ex dignissim enim, at condimentum purus nunc quis libero. Praesent lacinia consequat nisi sit amet placerat. Mauris orci felis, accumsan quis dolor nec, tincidunt auctor nibh. Donec a pulvinar nulla.
              </div> <!--  end of panel-body -->
           </div> <!-- end of description -->
          </div> <!-- end of modal body -->
          <!-- modal footer -->
          <div class="modal-footer">
            <button type="button" class="pull-right btn btn-default btn-lg" data-dismiss="modal">Close</button>
          </div> <!--  end of modal footer -->
        </form> <!-- end of POST request -->
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->
</body>
</html>
