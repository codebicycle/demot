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
<a href="<?php echo URL; ?>visitors/edit">Edit Account</a>
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
if($State==0)
{
?>
<h3>ACCEPTED APPOINTMENTS: </h3>
<br/>

<table>
    <thead style="background-color: #ddd; font-weight: bold;">
      <tr>
		<td>Inmate Name</td>
		<td>Institution Name and Location </td>
		<td>Visitor Name</td>
        <td>Second Visitor Name</td>
        <td>Third visitor Name</td>
		<td>Date Of Appointment</td>
        <td>Time Of Appointment</td>
        </tr>
    </thead>
    <tbody>
	
	
    <?php 
	$VisitorId=$_SESSION['user_id'];
	$sql = "SELECT DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId FROM appointments WHERE VisitorId = :VisitorId AND State = :State";
        $stmt = $this->db->prepare($sql);
		$stmt->bindValue(':VisitorId', $VisitorId);
		$stmt->bindValue(':State', $State);
        $stmt->execute();

		$appointments=$stmt->fetchAll();
	
	foreach ($appointments as $appointment) { 
	?>
      <tr>
	  
		<td>
          <?php 
		  if (isset($appointment->InmateId)) 
		  {
			  
			$inmateId=$appointment->InmateId;
			$sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':inmateId',$inmateId);
			$query->execute();
			$inmate = $query->fetch(PDO::FETCH_ASSOC);
			
			echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
			$InstId=$inmate['InstId'];
		  }	
		 
		   ?>
                    
        </td>
		
		<td>
          <?php 
		 	
			$sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':InstId',$InstId);
			$query->execute();
			
			$Institution = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
			echo ", ";
			echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
		 
		   ?>
                    
        </td>  
	  
         <td>
          <?php 
		  $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$VisitorId);
			$query->execute();
			
			$Visitor = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
		  	
		  
		   ?>
                    
        </td>
		
		
		
        <td>
          <?php 
		  if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
		  {
			
			echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
		  }	
		  else echo "NOT PRESENT";
		   ?>
                    
        </td>
		
		<td>
          <?php 
		  if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
		  {
			echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
		  }
			else echo "NOT PRESENT";
		  ?>
                    
        </td>
		
		<td>
          <?php if (isset($appointment->DateOfAppointment)) 
          echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($appointment->TimeOfAppointment)) 
          echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
      
      </tr>
    <?php } ?>
    </tbody>
  </table>

  
  
<?php
}
else if($State==1)
{
?>

<h3>PENDING APPOINTMENTS: </h3>
<br/>

<table>
    <thead style="background-color: #ddd; font-weight: bold;">
      <tr>
		<td>Inmate Name</td>
		<td>Institution Name and Location </td>
		<td>Visitor Name</td>
        <td>Second Visitor Name</td>
        <td>Third visitor Name</td>
		<td>Date Of Appointment</td>
        <td>Time Of Appointment</td>
        </tr>
    </thead>
    <tbody>
	
	
    <?php 
	$VisitorId=$_SESSION['user_id'];
	$sql = "SELECT DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId FROM appointments WHERE VisitorId = :VisitorId AND State = :State";
        $stmt = $this->db->prepare($sql);
		$stmt->bindValue(':VisitorId', $VisitorId);
		$stmt->bindValue(':State', $State);
        $stmt->execute();

		$appointments=$stmt->fetchAll();
	
	foreach ($appointments as $appointment) { 
	?>
      <tr>
	  
		<td>
          <?php 
		  if (isset($appointment->InmateId)) 
		  {
			  
			$inmateId=$appointment->InmateId;
			$sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':inmateId',$inmateId);
			$query->execute();
			$inmate = $query->fetch(PDO::FETCH_ASSOC);
			
			echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
			$InstId=$inmate['InstId'];
		  }	
		 
		   ?>
                    
        </td>
		
		<td>
          <?php 
		 	
			$sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':InstId',$InstId);
			$query->execute();
			
			$Institution = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
			echo ", ";
			echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
		 
		   ?>
                    
        </td>  
	  
         <td>
          <?php 
		  $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$VisitorId);
			$query->execute();
			
			$Visitor = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
		  	
		  
		   ?>
                    
        </td>
		
		
		
        <td>
          <?php 
		  if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
		  {
			
			echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
		  }	
		  else echo "NOT PRESENT";
		   ?>
                    
        </td>
		
		<td>
          <?php 
		  if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
		  {
			echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
		  }
			else echo "NOT PRESENT";
		  ?>
                    
        </td>
		
		<td>
          <?php if (isset($appointment->DateOfAppointment)) 
          echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($appointment->TimeOfAppointment)) 
          echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
      
      </tr>
    <?php } ?>
    </tbody>
  </table>

<?php
}
else if($State==2)
{
?>

<h3>DONE VISITS: </h3>
<br/>


<table>
    <thead style="background-color: #ddd; font-weight: bold;">
      <tr>
		<td>Inmate Name</td>
		<td>Institution Name and Location </td>
		<td>Visitor Name</td>
        <td>Second Visitor Name</td>
        <td>Third visitor Name</td>
		<td>Date Of Appointment</td>
        <td>Time Of Appointment</td>
        </tr>
    </thead>
    <tbody>
	
	
    <?php 
	$VisitorId=$_SESSION['user_id'];
	$sql = "SELECT DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId FROM appointments WHERE VisitorId = :VisitorId AND State = :State";
        $stmt = $this->db->prepare($sql);
		$stmt->bindValue(':VisitorId', $VisitorId);
		$stmt->bindValue(':State', $State);
        $stmt->execute();

		$appointments=$stmt->fetchAll();
	
	foreach ($appointments as $appointment) { 
	?>
      <tr>
	  
		<td>
          <?php 
		  if (isset($appointment->InmateId)) 
		  {
			  
			$inmateId=$appointment->InmateId;
			$sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':inmateId',$inmateId);
			$query->execute();
			$inmate = $query->fetch(PDO::FETCH_ASSOC);
			
			echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
			$InstId=$inmate['InstId'];
		  }	
		 
		   ?>
                    
        </td>
		
		<td>
          <?php 
		 	
			$sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':InstId',$InstId);
			$query->execute();
			
			$Institution = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
			echo ", ";
			echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
		 
		   ?>
                    
        </td>  
	  
         <td>
          <?php 
		  $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$VisitorId);
			$query->execute();
			
			$Visitor = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
		  	
		  
		   ?>
                    
        </td>
		
		
		
        <td>
          <?php 
		  if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
		  {
			
			echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
		  }	
		  else echo "NOT PRESENT";
		   ?>
                    
        </td>
		
		<td>
          <?php 
		  if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
		  {
			echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
		  }
			else echo "NOT PRESENT";
		  ?>
                    
        </td>
		
		<td>
          <?php if (isset($appointment->DateOfAppointment)) 
          echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($appointment->TimeOfAppointment)) 
          echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
      
      </tr>
    <?php } ?>
    </tbody>
  </table>


<?php
}

else if($State==3)
{
?>

<h3>Rejected appointments: </h3>
<br/>


<table>
    <thead style="background-color: #ddd; font-weight: bold;">
      <tr>
		<td>Inmate Name</td>
		<td>Institution Name and Location </td>
		<td>Visitor Name</td>
        <td>Second Visitor Name</td>
        <td>Third visitor Name</td>
		<td>Date Of Appointment</td>
        <td>Time Of Appointment</td>
		<td>Motive</td>
        </tr>
    </thead>
    <tbody>
	
	
    <?php 
	$VisitorId=$_SESSION['user_id'];
	$sql = "SELECT Id, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId FROM appointments WHERE VisitorId = :VisitorId AND State = :State";
        $stmt = $this->db->prepare($sql);
		$stmt->bindValue(':VisitorId', $VisitorId);
		$stmt->bindValue(':State', $State);
        $stmt->execute();

		$appointments=$stmt->fetchAll();
	
	foreach ($appointments as $appointment) { 
	?>
      <tr>
	  
		<td>
          <?php 
		  if (isset($appointment->InmateId)) 
		  {
			  
			$inmateId=$appointment->InmateId;
			$sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':inmateId',$inmateId);
			$query->execute();
			$inmate = $query->fetch(PDO::FETCH_ASSOC);
			
			echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
			$InstId=$inmate['InstId'];
		  }	
		 
		   ?>
                    
        </td>
		
		<td>
          <?php 
		 	
			$sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':InstId',$InstId);
			$query->execute();
			
			$Institution = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
			echo ", ";
			echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
		 
		   ?>
                    
        </td>  
	  
         <td>
          <?php 
		  $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$VisitorId);
			$query->execute();
			
			$Visitor = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
		  	
		  
		   ?>
                    
        </td>
		
		
		
        <td>
          <?php 
		  if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
		  {
			
			echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
		  }	
		  else echo "NOT PRESENT";
		   ?>
                    
        </td>
		
		<td>
          <?php 
		  if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
		  {
			echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
		  }
			else echo "NOT PRESENT";
		  ?>
                    
        </td>
		
		<td>
          <?php if (isset($appointment->DateOfAppointment)) 
          echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($appointment->TimeOfAppointment)) 
          echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); ?>
        </td>
		
		
		
		  <td>
          <?php if (isset($appointment->Id)) 
		  {
			  /////aici am luat din vizite facute comentariu si daca nu e am afisat hard codded un mesaj .
			$appId=$appointment->Id;
			$sql="SELECT Comments FROM visits WHERE AppointmentId=:AppointmentId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':AppointmentId',$appId);
			$query->execute();			
			$visit = $query->fetch(PDO::FETCH_ASSOC);
			if(isset($visit['comments']))
				echo $visit['comments'];
			else 
				echo "A fost respinsa fara motiv";
		  }
		  ?>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>


<?php
}
?>