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
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-md-4'>
        <div class='panel panel-primary'>
          <div class='panel-heading'>
            Feedback
          </div>
          <div class='panel-body'>
            <form method='GET'>
              <div class='form-group form-inline'>
              <?php
                $unitno = '';
              ?>
                <label for='unitno'>Unit Number:</label>
                <input type='text' class='form-control' name='unitno' value='<?= $unitno ?>' placeholder='Enter unit number here....'>
              </div><!-- end of unit number -->
              <div class='form-group'>
                <label for='feedback'>Feedback</label>
                <textarea class='form-control' rows=8 placeholder='Enter your comments and suggestions here'></textarea>
              </div><!-- end of feedback form -->
              <div class='form-group'>
                <button type='submit' class='btn btn-primary btn-lg pull-right'>Submit</button>
              </div> <!-- end of submit button -->
            </form> <!-- end of getform -->
          </div><!-- end of panel-body -->
        </div><!-- end of panel -->
      </div> <!-- end of col-md-offset-5 -->
    </div> <!-- end of row -->
  </div> <!-- end of container fluid -->
</body>
</html>
