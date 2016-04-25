<?php
	session_start();
	session_destroy();
	
	require APP. 'view/admins/index.php';
	exit;
?>