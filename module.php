<?php
	$dbhost = 'localhost';
	$dbname = 'homeandconnect';
	$dbuser = 'root';
	$dbpass = '';
	$appname = 'Home and Connect';

	$connection = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	if($connection->connect_error) die($connection->connect_error);

	function MySqlQuery($query)
	{
		global $connection;
		$result = $connection->query($query);
		if(!$result) die($connection->error);
		return $result;
	}

	function destroySession()
	{
		$_SESSION = array();
		if(session_id() != "" || isset($_COOKIE[session_name()])) setcookie(session_name(),'',time()-2592000,'/');

		session_destroy();
	}

	function sanitizeString($var)
	{
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $connection->real_escape_string($var);
	}

	function capitalFirstLetter($string)
	{
	    $string =ucwords(strtolower($string));

	    foreach (array('-', '\'') as $delimiter) {
	      if (strpos($string, $delimiter)!==false) {
	        $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
	      }
	    }
	    return $string;
	}

	//password-encryption algorithm
	function encryptPassword($string)
	{
		$salt1 = 'h0m3@nD'; //random words
		$salt2 = 'c0nN3c+'; //another random words
		$password = hash('ripemd128',"$salt1$string$salt2");
		return $password;
	}

	function autogenerateBillingInformation()
	{
		$result = MySqlQuery("SELECT * from tbl_rent");
		$row = $result->num_rows;
		for( $ctr = 0 ; $ctr < $row ; ++$ctr)
		{
			$result->data_seek($ctr);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$unitno = $row['unitno'];
			$result = MySqlQuery("SELECT date,dateadd(date,INTERVAL 1 month) AS 'nextbillingdate' FROM tbl_billinginfo WHERE unitno = $unitno ORDER BY desc date LIMIT 1");
			if($result->num_rows){
				$row = $result->fetch_assoc();
				$lastbillingdate = $row['date'];
				$nextbillingdate = $row['nextbillingdate'];
				if(!ifSimilarDate($lastbillingdate,$nextbillingdate))
				{
					MySqlQuery("");
					return true;
				}
			}
		}

		return false;
	}

	function ifSimilarDate($lastbillingdate,$nextbillingdate)
	{

		$date = date('Y/m/d');
		if (($date>$lastbillingdate)&&($date<$nextbillingdate))
		{
			return true;
		}
		return false;	
	}

	function echoPage($code)
	{
		echo <<<_PAGE
			$code;
_PAGE;
	}
?>
