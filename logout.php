<?php
	require_once 'session.php';
	destroySession();
	die("<script>window.location.href = 'index.php';</script>");
?>
