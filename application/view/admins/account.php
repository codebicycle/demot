



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
<h3>Visits: </h3>
<br/>

  <table>
    <thead style="background-color: #ddd; font-weight: bold;">
      <tr>
        <td>Id</td>
        <td>Appointment Id</td>
        <td>Done</td>
        <td>Second visitor</td>
        <td>Third visitor</td>
        <td>Given objects</td>
        <td>Recived objects</td>
        <td>Relationship</td>
        <td>Motive</td>
        <td>Comments</td>
        <td>Duration</td>
		<td>Inmate phisical state</td>
        <td>Inmate emotional state</td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($visits as $visit) { ?>
      <tr>
        <td>
          <?php if (isset($visit->Id)) 
          echo htmlspecialchars($visit->Id, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->AppointmentId)) 
          echo htmlspecialchars($visit->AppointmentId, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->Done)) 
          echo htmlspecialchars($visit->Done, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->SecondVisitor)) 
          echo htmlspecialchars($visit->SecondVisitor, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->ThirdVisitor)) 
          echo htmlspecialchars($visit->ThirdVisitor, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->GivenObjects)) 
          echo htmlspecialchars($visit->GivenObjects, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->RecivedObjects)) 
          echo htmlspecialchars($visit->RecivedObjects, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->Relationship)) 
          echo htmlspecialchars($visit->Relationship, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->Motive)) 
          echo htmlspecialchars($visit->Motive, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->Comments)) 
          echo htmlspecialchars($visit->Comments, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->Duration)) 
          echo htmlspecialchars($visit->Duration, ENT_QUOTES, 'UTF-8'); ?>
        </td>
		<td>
		<?php if (isset($visit->InmatePhisicalState)) 
          echo htmlspecialchars($visit->InmatePhisicalState, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($visit->InmateEmotionalState)) 
          echo htmlspecialchars($visit->InmateEmotionalState, ENT_QUOTES, 'UTF-8'); ?>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>


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