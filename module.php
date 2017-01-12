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

	function capitalFirstLetter($string){
	    $string =ucwords(strtolower($string));

	    foreach (array('-', '\'') as $delimiter) {
	      if (strpos($string, $delimiter)!==false) {
	        $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
	      }
	    }
	    return $string;
	}
?>