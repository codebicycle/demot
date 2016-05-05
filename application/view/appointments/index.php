<?php require APP . 'libs/helpers.php'; 

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    // if(!isset($_SESSION['user_id']))
    // {
    //     header('location: '.URL. 'visitors');
    //     exit;
    // }

?>

<div class="container">
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
    <?php foreach ($appointments as $appointment) { ?>
        <tr>
            <td>
                <?php e($appointment->Id); ?>
            </td>
            <td>
                <?php e($appointment->InmateId) ?>
            </td>
            <td></td>
            <td>
                <?php e($appointment->VisitorId) ?>
            </td>
            <td>
                <?php 
                    e($appointment->Visitor2FirstName);
                    echo ' ';
                    e($appointment->Visitor2LastName);
                 ?>
            </td>
            <td>
                <?php 
                    e($appointment->Visitor3FirstName);
                    echo ' ';
                    e($appointment->Visitor3LastName);
                 ?>
            </td>
            <td>
                <?php e($appointment->DateOfAppointment); ?>
            </td>
            <td>
                <?php e($appointment->TimeOfAppointment); ?>
            </td>
            <td>
                <?php e($appointment->State); ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
