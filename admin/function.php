<?php
  //set the type of panel for house
  function setHouseType($status)
  {
    if($status == 'lease')
    {
      return 'success';
    }

    if($status == 'occupied')
    {
      return 'danger';
    }

    if($status == 'undermaintenance')
    {
      return 'warning';
    }
  }
  //set the type of label for house-label
  function setLabelType($status)
  {
    if($status == 'lease')
    {
      return 'label-success';
    }

    if($status == 'occupied')
    {
      return 'label-danger';
    }

    if($status == 'undermaintenance')
    {
      return 'label-warning';
    }
  }
  //set the status of house
  function setHouseStatus($status)
  {
    if($status == 'lease')
    {
      return 'Unoccupied';
    }

    if($status == 'occupied')
    {
      return 'Occupied';
    }

    if($status == 'undermaintenance')
    {
      return 'Undermaintenance';
    }
  }

  function getAmount($billingid)
  {
    $amount = "";
    return $amount;
  }

  function isValidUnitNumber($property)
  {
    // //reokace query with the proper query
    // $query = "SELECT * FROM tbl_housedesc WHERE unitno = $property";
    // $result = MySqlQuery($query);
    // if($result->num_rows)
    // {
    //   return true;
    // }
    
    // return false;
    return true;
  }
  function isValidTenant($tenant)
  {
    // //reokace query with the proper query
    // $query = "SELECT * FROM tbl_personalinfo WHERE id = $tenant";
    // $result = MySqlQuery($query);
    // if($result->num_rows)
    // {
    //   return true;
    // }
    
    // return false;
    return true;
  }

  function rentSuccess($tenantno,$unitno,$amount)
  {
    // //reokace query with the proper query
    // $query = "call sproc_rent()";
    // $result = MySqlQuery($query);
    // $query = "SELECT * FROM PAYMENT WHERE id = ";
    // $result = MySqlQuery($query);
    // if($result->num_rows)
    // {
    //   return true;
    // }else
    //    return false;
    
    return true;
  }
  //process image
  //$loc is the location of file
  //filename: name of file to be uploaded
  //basename($_FILES[name]["name"]) => original name of file
  //getimagesize($_FILES[name]["size"])  => returns the size of file
  //getimagesize($_FILES[name]["tmp_name"])  => returns the property of file
  //$_FILES[name]['tmp_name']) => generates a temporary filename
  function processImage($filename,$temp_name,$size,$limit,$target_dir,$newfilename)
  {
    createDirectory($target_dir);
    $target_file = $target_dir . $newfilename; //path of file to be uploaded
    $filetype = getFileExtension($target_file); //holds the extension
    // Check if image file is a actual image or fake image
    if(checkFileIfImage($temp_name)){
      //checks if file is already on the server
      if(!checkFileIfExist($target_file)){
        //check if file is greater than limit
        if(!checkFileIfGreaterThanLimit($size,$limit)){
          //check if the file has the right format
          if(checkFileIfRightFormat($filetype)){
            //moves the file
            if(moveFile($temp_name,$target_file)){
              return $target_file;
            }else
              return "";
          }
        }
      }
    }
  }
  //check if file is fake or true
  function checkFileIfImage($temp_name)
  {
    if(getimagesize($temp_name) !== false) 
    {
      echo "<script>alert('$temp_name is an image');</script>";
      return true; //file is an image
    }else
    {
      echo "<script>alert('$temp_name file not image');</script>";
      return false; //file is not an image
    }
  }
  //checks if file already exist in the database
  function checkFileIfExist($filename)
  {
    if(file_exists($filename))
    {
      echo "<script>alert('$filename exists in checking');</script>";
      return true;
    }else
    {
      echo "<script>alert('$filename file not exists in checking');</script>";
      return false;
    }
  }

  //checks if file is greater than the limit
  //$file format: $_FILES["fileToUpload"]["size"]
  //limit is kb
  //return true if file is larger than the limit
  function checkFileIfGreaterThanLimit($size,$limit)
  {
    if ($size > $limit) {
      echo "<script>alert('file is greater than limit');</script>";
      return true;
    }else{
      echo "<script>alert('file less than');</script>";
      return false;
    }
  }
  //move file to a target location
  //file format: $_FILES["fileToUpload"]["tmp_name"]
  function moveFile($temp_name,$target_file)
  {
    if(move_uploaded_file($temp_name, $target_file)){
      echo "<script>alert('success moving file');</script>";
      return true;
    }else{
      echo "<script>alert('error in moving file');</script>";
      return false;
    }
  }
  //checks if extension is right
  function checkFileIfRightFormat($filetype)
  {
    if($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg"
    && $filetype != "gif" ) 
    {
      echo "<script>alert('correct file type');</script>";
      return false;
    }else{
      echo "<script>alert('$filetype right type');</script>";
      return true;
    }
  }
  //returns extension of a file
  function getFileExtension($file){
    return pathinfo($file,PATHINFO_EXTENSION);
  }
  //check if directory exists then create directory if not
  function createDirectory($dir)
  {
    if(!checkFileIfExist($dir)){ //function to check if dir exists
      mkdir($dir,0777,true); //creates directory based on chmod ( all ) recursion = true 
    }else{
      echo "<script>alert('$dir exists already');</script>";
    }
  }
?>



