<?php
	require_once 'header.php';
	destroySession();
	die("<script>window.location.href = 'login.php';</script>");
?>