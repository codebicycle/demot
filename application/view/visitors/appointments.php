<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
 if(!isset($_SESSION['user_id']))
 {
	
 	header('location: '.URL. 'visitors/login');
 	die();
 }



$Id=$_SESSION['user_id'];
if(isset($_POST['submit']))
	$State=$_POST['visits'];
else $State='pending';
		
		
?>	


<div class="container">
	
<form method="POST">    
<select name="visits" id="visits">
	<option value="pending">Pending appointments</option>
	<option value="rejected">Rejected appointments</option>
	<option value="approved">Accepted appointments</option>
	<option value="done">Done visits</option>
	<option value="noshow">No-show appointments</option>
</select>
<br/>
<br/>
<input name="submit" type="submit" Value="Select Type"/>	
</form>
<br/>

<?php 
$this->model->getAppointments($State);
?>

	<h3>Appointments List</h3>

    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Inmate</td>
                <td>Institution</td>
                <td>Visitor</td>
                <td>2nd visitor</td>
                <td>3rd visitor</td>
                <td>Date </td>
                <td>Time</td>
                <td>State</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?php e($appointment->Id); ?></td>
            <td><?php e("$appointment->inmate_FirstName $appointment->inmate_LastName") ?></td>
            <td><?php e("$appointment->institution_Name, $appointment->institution_Location") ?></td>
            <td><?php e("$appointment->visitor_FirstName $appointment->visitor_LastName") ?></td>
            <td><?php e("$appointment->Visitor2FirstName $appointment->Visitor2LastName") ?></td>
            <td><?php e("$appointment->Visitor3FirstName $appointment->Visitor3LastName") ?></td>
            <td><?php e($appointment->DateOfAppointment); ?></td>
            <td><?php e(substr($appointment->TimeOfAppointment, 0, 5)); ?></td>
            <td><?php e($appointment->State); ?></td>
            <!-- buttons -->
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
