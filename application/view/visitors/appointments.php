<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['user_id']))
{
	
	header('location: '.URL. 'visitors');
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

if(isset($_POST['submit']))
	$State=$_POST['visits'];
else $State=0;
	///state este valoarea data de optiunea selectata din drop down menu. 
		//0 pentru accepted
		//1 pentru pending
		//2 pentru efectuate
		//eventual 3 pentru refuzate aici trebuie vazut cum facem... ori facem un camp nou in appointments unde setam ceva cand vizita este respinsa automat
		//  si bagam un motiv cand este respinsa de gardian / admin sau alta modalitate prin care sa spunem ca a fost respinsa si de ce.
		
		
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
<option value="0">Accepted appointments</option>
<option value="1">Pending appointments</option>
<option value="2">Done visits</option>
<option value="3">Rejected appointments</option>
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
