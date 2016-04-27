<?php
	session_start();
	session_destroy();
	header('location: '.URL. 'visitors');
	exit;
?>