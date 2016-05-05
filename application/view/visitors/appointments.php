<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
// if(!isset($_SESSION['user_id']))
// {
	
// 	header('location: '.URL. 'visitors');
// 	exit;
// }



$Id=$_SESSION['user_id'];
$sql = "SELECT UserName FROM visitors WHERE Id = :Id";
$stmt = $this->model->db->prepare($sql);
$stmt->bindValue(':Id', $Id);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'Welcome ';
echo $user['UserName'];
echo ', you are now in your account!';

if(isset($_POST['submit']))
	$State=$_POST['visits'];
else $State='accepted';
		
		
?>	
<br/>
<br/>
<h3>THIS IS YOUR MENU: </h3>
<br/>
<a href="<?php echo URL; ?>visitors/account">New Appointment</a>	
<br/>
<a href="<?php echo URL; ?>visitors/editaccount">Edit Account</a>
<br/>
<a href="<?php echo URL; ?>visitors/logout">LOGOUT</a> 
<br/>



<h3>THIS IS YOUR LEFT SIDE MENU: </h3>

<form method="POST">    
<select name="visits" id="visits">
	<option value="pending">Pending appointments</option>
	<option value="rejected">Rejected appointments</option>
	<option value="accepted">Accepted appointments</option>
	<option value="done">Done visits</option>
	<option value="noshow">No-show appointments</option>
</select>
<br/>
<br/>
<input name="submit" type="submit" Value="Select Type"/>	
</form>
<br/>

<div class="container">
	<?php 
	$this->model->getAppointments($State);
	?>

</div>
