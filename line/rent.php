
<?php
  require_once 'header.php';
  if(isset($_GET['searchtenantinmodal'])){

    $name = sanitizeString($_GET['tenantname']);
    $result = MySqlQuery("SELECT * FROM tbl_personalinfo left join tbl_user on tbl_user.userinfo = tbl_personalinfo.id WHERE lname IN ('%$name','%$name%','$name%') OR fname IN ('%$name',%'$name%','$name%') OR mname IN ('%$name','%$name%','$name%') UNION SELECT * FROM tbl_personalinfo left join tbl_user on tbl_personalinfo.id = tbl_user.userinfo WHERE type = '2' ");
    $row = $result->num_rows;
    for( $ctr = 0 ; $ctr < $row ; ++$ctr){
    $result->data_seek($ctr);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $name = ucfirst(capitalFirstLetter($row['lname'])).", ".capitalFirstLetter(sanitizeString($row['fname']))." ".capitalFirstLetter(sanitizeString($row['mname']));
                echo <<<_END
                <tr>
                  <td>$name</td>
                  <button type="submit" name="selectbutton">Select</button>
                </tr>
_END;
  
    }
  }

?>