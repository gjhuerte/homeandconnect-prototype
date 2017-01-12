<?php
	session_start();
	require_once 'module.php';
	$userstr = '(Guest)';
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
		$loggedin = TRUE;
		$userstr = "($username)";
	}
	else
   $loggedin = FALSE;

?>
