<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['user_id']))
{
	require APP. 'view/visitors/index.php';
	exit;
}


?>

<div class="container">

 
    <?php
	
	if(isset($_POST))
	{
		
		$DateOfAppointment = $_POST['DateOfAppointment']??NULL;
		$DateOfAppointment = mb_convert_encoding($DateOfAppointment, 'UTF-8','UTF-8');
		$DateOfAppointment =htmlentities($DateOfAppointment, ENT_QUOTES, 'UTF-8');

		$TimeOfAppointment = $_POST['TimeOfAppointment']??NULL;
		$TimeOfAppointment = mb_convert_encoding($TimeOfAppointment, 'UTF-8','UTF-8');
		$TimeOfAppointment =htmlentities($TimeOfAppointment, ENT_QUOTES, 'UTF-8');
		
		$Visitor2FirstName = $_POST['Visitor2FirstName']??NULL;
		$Visitor2FirstName = mb_convert_encoding($Visitor2FirstName, 'UTF-8','UTF-8');
		$Visitor2FirstName =htmlentities($Visitor2FirstName, ENT_QUOTES, 'UTF-8');
		
		$Visitor2LastName = $_POST['Visitor2LastName']??NULL;
		$Visitor2LastName = mb_convert_encoding($Visitor2LastName, 'UTF-8','UTF-8');
		$Visitor2LastName =htmlentities($Visitor2LastName, ENT_QUOTES, 'UTF-8');
		
		$Visitor2CNP = $_POST['Visitor2CNP']??NULL;
		$Visitor2CNP = mb_convert_encoding($Visitor2CNP, 'UTF-8','UTF-8');
		$Visitor2CNP =htmlentities($Visitor2CNP, ENT_QUOTES, 'UTF-8');
		
		$Visitor3FirstName = $_POST['Visitor3FirstName']??NULL;
		$Visitor3FirstName = mb_convert_encoding($Visitor3FirstName, 'UTF-8','UTF-8');
		$Visitor3FirstName =htmlentities($Visitor3FirstName, ENT_QUOTES, 'UTF-8');
		
		$Visitor3LastName = $_POST['Visitor3LastName']??NULL;
		$Visitor3LastName = mb_convert_encoding($Visitor3LastName, 'UTF-8','UTF-8');
		$Visitor3LastName =htmlentities($Visitor3LastName, ENT_QUOTES, 'UTF-8');
		
		$Visitor3CNP = $_POST['Visitor3CNP']??NULL;
		$Visitor3CNP = mb_convert_encoding($Visitor3CNP, 'UTF-8','UTF-8');
		$Visitor3CNP =htmlentities($Visitor3CNP, ENT_QUOTES, 'UTF-8');
		
		$_POST=$_SESSION['post_data'];
		$InmateFirstName = $_POST['FirstName']??NULL;
		$InmateLastName = $_POST['LastName']??NULL;
		$InstId=$_POST['Institution'];
		
		$ok=0;
		if(isset($_POST['dob']))
		{
			$ok=1;
			$dob=$_POST['dob'];
			$sql ="SELECT Id FROM inmates WHERE FirstName = :FirstName AND LastName=:LastName AND InstId=:InstId AND DOB=:dob" ;
		}
		else 
			$sql ="SELECT Id FROM inmates WHERE FirstName = :FirstName AND LastName=:LastName AND InstId=:InstId" ;
		$query = $this->model->db->prepare($sql);
		$query->bindValue(':FirstName', $InmateFirstName);
		$query->bindValue(':LastName', $InmateLastName);
		$query->bindValue(':InstId', $InstId);
		if($ok==1)
			$query->bindValue(':dob', $dob);
		$query->execute();
		$Inmate = $query->fetch(PDO::FETCH_ASSOC);
		$InmateId=$Inmate['Id'];
		$VisitorId=$_SESSION['user_id'];
		//pana aici am selectat datele de care am nevoie pentru insert urmeaza sa fac insert
	}
	
      print_r($_POST); print_r($this->model);
    ?>
  </pre>
</div>
