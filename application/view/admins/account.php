



<?php

 session_start();

if(!isset($_SESSION['user_id']))
{
	require APP. 'view/admins/index.php';
	exit;
}


$Id=$_SESSION['user_id'];
$sql = "SELECT UserName, Rank FROM admins WHERE Id = :Id";
$stmt = $this->model->db->prepare($sql);
$stmt->bindValue(':Id', $Id);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$Rank=5;
$Rank=$user['Rank'];
$UserName=$user['UserName'];


if($Rank==0)
{
	echo 'Welcome ';
	echo $UserName;
	echo ', you are using a SUPERADMIN account';

	
?>	
<br/>
<br/>
<h3>You can add an admin:</h3>
<a href="<?php echo URL; ?>admins/addadmin">ADD ADMIN</a>	


<?php
}		


if($Rank==1)
{
	echo 'Welcome ';
	echo $UserName;
	echo ', you are using a ADMIN account';

	
?>	
<br/>
<br/>
<h3>You can add a guard:</h3>

<a href="<?php echo URL; ?>admins/addguard">ADD GUARD</a>


<?php
}
	
if($Rank==2)
{
	echo 'Welcome ';
	echo $UserName;
	echo ', you are using a GUARD account';

	
?>	
<br/>
<br/>
<h3>WALK AWAY:</h3>

<?php
}	
?>