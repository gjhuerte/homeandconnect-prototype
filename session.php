<?php
	session_start();
	require_once 'module.php';
	require_once 'validate.php';
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
		$loggedin = TRUE;
    	$access = $_SESSION['access'];
	}
	else
   $loggedin = FALSE;
?>
