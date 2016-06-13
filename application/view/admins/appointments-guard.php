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
?>

<div class="container">
	
<?php if (empty($ap_pending)) { ?>
    <h3>No pending appointments.</h3>
<?php } else { 
        $appointments = $ap_pending; ?>

    <h3>Pending Appointments</h3>

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
            <td>
			
				<?php
				$remainingvisits = $this->model->getRemainingVisits($appointment->InmateId);
				$thismonth = date("n");	
				$thisyear  = date("Y");
				$d = date_parse_from_format("Y-m-d", $appointment->DateOfAppointment);	
				if($remainingvisits>0)	
                {
				?>
					<a href="<?php e(URL . 'appointments/approve/' . $appointment->Id); ?>">Approve</a>
				<?php
				}
				
				else if( $thismonth <= $d["month"] && $thismonth != $d["month"] && $thisyear<=$d["year"])
				{
				?>
					<a href="<?php e(URL . 'appointments/approve/' . $appointment->Id); ?>">Approve</a>
				<?php
				}
				else
				{
					//automatic reject 
					  header('location: ' . URL . 'appointments/reject/' . $appointment->Id);
				}
				?>
                <a href="<?php e(URL . 'appointments/reject/' . $appointment->Id); ?>">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>

<?php if (empty($ap_for_review)) { ?>
    <h3>No appointments in need of review.</h3>
<?php } else { 
        $appointments = $ap_for_review; ?>

    <h3>Appointments in Need of Review</h3>

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
            <td>
                <a href="<?php e(URL . 'appointments/show/' . $appointment->Id) ?>">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>

</div>
