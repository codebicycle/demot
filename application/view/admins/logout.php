<?php
	session_start();
	session_destroy();

	header('location: '.URL. 'admins/index');
	exit;
?>