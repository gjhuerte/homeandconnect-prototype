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
?>



