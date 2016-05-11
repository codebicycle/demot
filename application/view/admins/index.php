<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['admin_id']))
{
	header('location: '.URL. 'admins/login');
	die();
}

$Rank=$_SESSION['rank'];
$UserName=$_SESSION['username'];


if($Rank==0)
{
	echo 'Welcome ';
	echo $UserName;
	echo ', you are using a SUPERADMIN account';

	
?>	
<br/>
<br/>
<h3>THIS IS YOUR MENU: </h3>
<br/>
<a href="<?php echo URL; ?>admins/addadmin">ADD ADMIN</a>	
<br/>
<a href="<?php echo URL; ?>admins/deleteadmin">DELETE ADMIN</a>
<br/>
<a href="<?php echo URL; ?>admins/stats">STATS</a>
<br/>
<a href="<?php echo URL; ?>admins/logout">LOGOUT</a> 
<br/>


<div class="container">


<?php
} 
if($Rank==1)
{
	echo 'Welcome ';
	echo $UserName;
	echo ', you are using a ADMIN account';
}
?>
<br/>
<br/>
<a href="<?php echo URL; ?>admins/addguard">ADD GUARD</a>	
<div class="container">

</div>
