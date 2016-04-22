<?php

 session_start();

if(!isset($_SESSION['user_id']))
{
	require APP. 'view/visitors/index.php';
	exit;
}


$Id=$_SESSION['user_id'];
$sql = "SELECT UserName FROM visitors WHERE Id = :Id";
$stmt = $this->model->db->prepare($sql);
$stmt->bindValue(':Id', $Id);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'Welcome ';
echo $user['UserName'];
echo ', you are now in your account!';
		
