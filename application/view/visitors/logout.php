<?php
	session_start();
	session_destroy();
	
	require APP. 'view/visitors/index.php';
	exit;
?>