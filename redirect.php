<?php
	require_once 'session.php';
	if(!$loggedin)
	{
		echo "<script>window.location.href= 'login.php';</script>";
	}

	if($access == 0)
	{
		echo '<script>window.location.href = "admin/index.php";</script>';
	}else
	{
		echo '<script>window.location.href = "tenant/index.php";</script>';
	}
?>