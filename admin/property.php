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
  <title>Property</title>
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
    <div class='row'>
      <div class='col-md-12'>
        <div class='panel-body'>        
          <div class='form-group'>
            <form method="POST">
              <label for=addproperty>Add new property</label>
              <button type='button' class='btn btn-md btn-primary'data-toggle='modal' data-target='#formmodal' name='add'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
            </form><!-- end of get form -->
          </div><!-- end of form-group -->
        </div> <!-- end of panel-body -->
      </div> <!-- end of col-md-12 -->
      <div class="col-md-12">
        <!-- display all house -->
        <?php
          $isHidden = '';
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
            echo "
              <div class='clearfix visible-xs-block'></div>
              <div class='col-md-3'>
                <form method='POST'>
                  <!-- panel-body -->
                  <div class='panel panel-$type panel-padding'>
                    <div class='panel-heading'>
                      Unit Number: $unitno <span class='label $label_type'> $type </span>
                    </div>
                    <div class='panel-body'>
                      <div class='form-group'>
                        <img src='$imageloc' class='img-responsive img-rounded' alt='Room image'>
                      </div>
                      <div class='form-group'>
                        <button type='button' class='btn btn-primary btn-md btn-block' data-toggle='modal' data-target='#propertyinfomodal' name='view'>View</button>
                      </div>
                    </div> <!-- end of panel-body -->
                  </form> <!-- end of form -->
                </div> <!-- end of panel -->
              </div> <!-- end of col-md-4 -->";
          }
        ?>
      </div> <!-- end of table -->
    </div> <!-- end of row -->
  </div> <!-- end of container fluid -->

  <!-- View Modal -->
  <div class="modal fade" id="propertyinfomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Property Information</h4>
        </div>
        <!-- form -->
        <form method="POST">
            <!-- body -->
            <div class="modal-body">
              <!-- carousel -->
              <div id="propety-image" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  <li data-target="#property-image" data-slide-to="0" class="active"></li>
                  <li data-target="#property-image" data-slide-to="1"></li>
                  <li data-target="#property-image" data-slide-to="2"></li>
                </ol>

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
            <div class='form-group'>
              <!-- house information -->
              <div class="panel-primary">
                <!-- panel heading -->
                <div class="panel-heading">
                  House Description
                </div>  <!-- end of panel heading -->
                <!-- panel body -->
                <div class="panel-body">
                  <?= $address?>
                </div> <!-- end of panel body -->
              </div> <!-- end of house information --> 
            </div>
          </div> <!-- end of modal body -->
          <!-- modal footer -->
          <div class="modal-footer">
            <button type="submit" class="col-md-push-2 col-md-5 btn btn-warning btn-lg" name="update">Update Information</button>
            <button type="button" class="col-md-push-2 col-md-5 btn btn-danger btn-lg" name="remove">Remove</button>
          </div> <!-- end of modal footer -->
        </form>
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->

  <!--Add,Update Modal -->
  <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <?php

          $addButton = '';
          $updateButton = '';

          if(isset($_POST['add']))
          {
            echo "<script>alert('add');</script>";
            $addButton = '';
            $updateButton = 'hidden';            
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#formmodal').modal('show');
            });
            </script>";
          }

          if(isset($_POST['update']))
          {
            echo "<script>alert('edit');</script>";
            $addButton = 'hidden';
            $updateButton = '';
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#formmodal').modal('show');
            });
            </script>";
          }   

        ?>
        <!-- header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Property Information <?= $unitno ?> </h4>
        </div>
        <!-- form -->
        <form method="POST" enctype="multipart/form-data">
          <!-- body -->
          <div class="modal-body">
            <div class='row'>
              <!-- main image -->
              <div class='form-group'>
                <label for="main">Main Image</label>
                <div class='col-md-6'>
                  <a href="../img/sample/no_image.png" class="thumbnail">
                    <img id='mainimage' src="../img/sample/no_image.png" alt="main image">
                  </a>
                </div>
                <div class='col-md-6'>
                  <input type="file" name='mainimage' class='img-responsive' id="main" onchange='displayMainImage(this);'>
                </div>
              </div><!-- end of main image -->
            </div>
            <div class='row'>
              <!-- balcony image -->
              <div class='form-group'>
                <label for="balcony">Balcony Image</label>
                <div class='col-md-6'>
                  <a href="../img/sample/no_image.png" class="thumbnail">
                    <img id='balconyimage' src="../img/sample/no_image.png" alt="balcony image">
                  </a>
                </div>
                <div class='col-md-6'>
                  <input type="file" name='balconyimage' class='img-responsive' id="balcony" onchange='displayBalconyImage(this);'>
                </div>
              </div><!-- end of balcony image -->
            </div>
            <div class='row'>
              <!-- bedroom image -->
              <div class='form-group'>
                <label for="bedroom">Bedroom Image</label>
                <div class='col-md-6'>
                  <a href="../img/sample/no_image.png" class="thumbnail">
                    <img id = 'bedroomimage' src="../img/sample/no_image.png" alt="bedroom image">
                  </a>
                </div>
                <div class='col-md-6'>
                  <input type="file" name='bedroomimage' class='img-responsive' id="bedroom" onchange='displayBedroomImage(this);'>
                </div>
              </div><!-- end of bedroom image -->
            </div>
            <div class='row'>
              <!-- kitchen image -->
              <div class='form-group'>
                <label for="kitchen">Kitchen Image</label>
                <div class='col-md-6'>
                  <a href="../img/sample/no_image.png" class="thumbnail">
                    <img id='kitchenimage' src="../img/sample/no_image.png" alt="kitchen image">
                  </a>
                </div>
                <div class='col-md-6'>
                  <input type="file" name='kitchenimage' class='img-responsive' id="kitchen" onchange='displayKitchenImage(this);'>
                </div>
              </div><!-- end of kitchen image -->            
            </div>
            <div class='row'>
              <!-- bathroom image -->
              <div class='form-group'>
                <label for="bathroom">Bathroom Image</label>
                <div class='col-md-6'>
                  <a href="../img/sample/no_image.png" class="thumbnail">
                    <img id='bathroomimage' src="../img/sample/no_image.png" alt="bathroom image">
                  </a>
                </div>
                <div class='col-md-6'>
                  <input type="file" name='bathroomimage' class='img-responsive' id="bathroom"onchange='displayBathroomImage(this);'>
                </div>
              </div><!-- end of bathroom image -->
            </div>
            <!-- house information -->
            <div class='form-group'>
              <div class="panel-primary">
                <!-- panel heading -->
                <div class="panel-heading">
                  House Description
                </div>  <!-- end of panel heading -->
                <!-- panel body -->
                <div class="panel-body">
                  <textarea class='form-control' rows='6' name='description' placeholder='Enter description here...'></textarea>
                </div> <!-- end of panel body -->
              </div> <!-- end of house information --> 
            </div><!-- end of house information form-group -->
            <!-- address -->
            <div class='form-group'>
              <div class="panel-primary">
                <!-- panel heading -->
                <div class="panel-heading">
                  Address
                </div>  <!-- end of panel heading -->
                <!-- panel body -->
                <div class="panel-body">
                  <textarea class='form-control' rows='6' name='address' placeholder='Enter description here...'></textarea>
                </div> <!-- end of panel body -->
              </div> <!-- end of address --> 
            </div><!-- end of address form-group -->
            <!-- rent -->
            <div class='form-group'>
              <div class="panel-success">
                <!-- panel heading -->
                <div class="panel-heading">
                  Rent Amount
                </div>  <!-- end of panel heading -->
                <!-- panel body -->
                <div class="panel-body">
                  <textarea class='form-control' rows='6' name='price' placeholder='Enter description here...'></textarea>
                </div> <!-- end of panel body -->
              </div> <!-- end of rent amount --> 
          </div> <!-- end of modal body -->
          <!-- modal footer -->
          <div class="modal-footer">  
            <!-- set hidden button -->
            <div class='form-group' <?= $addButton ?>>
              <button type="submit" class="btn btn-success btn-lg" name="_add">Add</button>
            </div>
            <div class='form-group' <?= $updateButton ?>>
              <button type="submit" class="btn btn-warning btn-lg" name="_update">Update</button>
              <button type="submit" class="btn btn-danger btn-lg" data-dismiss='modal'>Cancel</button>
            </div>
          </div> <!-- end of modal footer -->
        </form>
      </div> <!-- modal content -->
    </div> <!-- modal-dialog -->
  </div> <!-- modal fade -->

  <?php
    $unitno = 005;
    if(isset($_POST['_add'])){
      //upload main image
      $filename = $_FILES['mainimage']['name'];
      $temp_name = $_FILES['mainimage']['tmp_name'];
      $size = getimagesize($_FILES['mainimage']["size"]);
      $limit = 50000000;
      $target_dir = "../img/house/" . $unitno . '/' . 'main' . '/';
      $newfilename = getFileExtension($filename);
      $maindir = uploadImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename);
      //upload balcony image
      $filename = $_FILES['balconyimage']['name'];
      $temp_name = $_FILES['balconyimage']['tmp_name'];
      $size = getimagesize($_FILES['balconyimage']["size"]);
      $limit = 50000000;
      $target_dir = "../img/house/" . $unitno . '/' . 'balcony' . '/';
      $newfilename = getFileExtension($filename);
      $balconydir = uploadImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename);
      //upload bedroom image
      $filename = $_FILES['balconyimage']['name'];
      $temp_name = $_FILES['balconyimage']['tmp_name'];
      $size = getimagesize($_FILES['bedroomimage']["size"]);
      $limit = 50000000;
      $target_dir = "../img/house/" . $unitno . '/' . 'bedroom' . '/';
      $newfilename = $unitno . "." . 'bedroom' . "." . getFileExtension($filename);
      $bedroomdir = uploadImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename);
      //upload bathroom image
      $filename = $_FILES['balconyimage']['name'];
      $temp_name = $_FILES['balconyimage']['tmp_name'];
      $size = getimagesize($_FILES['bathroomimage']["size"]);
      $limit = 50000000;
      $target_dir = "../img/house/" . $unitno . '/' . 'bathroom' . '/';
      $newfilename = $unitno . "." . 'bathroom' . "." . getFileExtension($filename);
      $bathroomdir = uploadImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename);
      //upload kitchen image
      $filename = $_FILES['balconyimage']['name'];
      $temp_name = $_FILES['balconyimage']['tmp_name'];
      $size = getimagesize($_FILES['kitchenimage']["size"]);
      $limit = 50000000;
      $target_dir = "../img/house/" . $unitno . '/' . 'kitchen' . '/';
      $newfilename = $unitno . "." . 'kitchen' . "." . getFileExtension($filename);
      $kitchendir = uploadImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename);
      //other information
      $description = sanitizeString($_POST['description']);
      $address = sanitizeString($_POST['address']);
      $price = sanitizeString($_POST['price']);

      $query = "sproc_createhouse";
      $result = MySqlQuery($query);

    }

    function uploadImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename)
    {
      $dir = processImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename);
      if(!empty($dir)){
        return $dir;
      }else{
        return "";
      }
    }
  ?>

  <script>    
  function displayMainImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#mainimage').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }  
    function displayBalconyImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#balconyimage').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }  

    function displayBedroomImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#bedroomimage').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }  

    function displayBathroomImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#bathroomimage').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    } 

    function displayKitchenImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#kitchenimage').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }  
  </script>
</body>
</html>
