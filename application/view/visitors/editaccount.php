<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(isset($_POST['submit'])){
    
    $visId=$_SESSION['user_id'];
			$sql="SELECT UserName, FirstName, LastName, CNP, Email,PwdHash FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$visId);
			$query->execute();
			$visitor = $query->fetch(PDO::FETCH_ASSOC);
			
			$oldUserName=$visitor['UserName'];
			$oldFirstName=$visitor['FirstName'];
			$oldLastName=$visitor['LastName'];
			$oldCNP=$visitor['CNP'];
			$oldEmail=$visitor['Email'];
			$oldPwdHash=$visitor['PwdHash'];
			
			$sql="SELECT Location FROM pictures WHERE UserId=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$visId);
			$query->execute();
			$picture = $query->fetch(PDO::FETCH_ASSOC);
			$oldPictureLocation=$picture['Location'];
    
	$UserName = $_POST['UserName']??NULL;
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

	$FirstName = $_POST['FirstName']??NULL;
	$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
	$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');


	$LastName =$_POST['LastName']??NULL;
	$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
	$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

	$Email =$_POST["Email"]??NULL;

	$CNP=$_POST['CNP']??NULL;
	$CNP = mb_convert_encoding($CNP, 'UTF-8','UTF-8');
	$CNP =htmlentities($CNP, ENT_QUOTES, 'UTF-8');


	$Password = $_POST['Password']??NULL;
	$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
	$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');
	
	$PasswordLength=strlen($Password);
	
	$RepeatPassword = $_POST['RepeatPassword']??NULL;
	$RepeatPassword = mb_convert_encoding($RepeatPassword, 'UTF-8','UTF-8');
	$RepeatPassword =htmlentities($RepeatPassword, ENT_QUOTES, 'UTF-8');
	
	
	
	$uploadImage=$_FILES['uploadImage']??NULL;
    	
	$PasswordHash = md5($Password);
	$RepeatPasswordHash=md5($RepeatPassword);
	
	$IdHash=$_SESSION['user_id'];
	
if($UserName==false)
{
	$UserName=$oldUserName;
}

if($FirstName==false)
{	
	$FirstName=$oldFirstName;
}

if($LastName==false)
{
	$LastName=$oldLastName;
}
if($CNP==false)
{
	$CNP=$oldCNP;
}
if($Email==false)
{
	$Email=$oldEmail;
}

if($Password==false&&$RepeatPassword==false)
{		
	if(strlen($UserName)<=50)
	{			
							
					
		$sql = "UPDATE `visitors` SET `FirstName`=:FirstName,`LastName`=:LastName,`CNP`=:CNP,`UserName`=:UserName,`PwdHash`=:PwdHash,`Email`=:Email WHERE Id=:Id";
		$stmt = $this->model->db->prepare($sql);
 						
		$stmt->bindValue(':FirstName', $FirstName);
		$stmt->bindValue(':LastName', $LastName);
		$stmt->bindValue(':CNP', $CNP);
		$stmt->bindValue(':UserName', $UserName);
		$stmt->bindValue(':PwdHash', $oldPwdHash);
		$stmt->bindValue(':Email', $Email);
		$stmt->bindValue(':Id', $IdHash);
		$result = $stmt->execute();
							
		if($result)
		{
			if($uploadImage)
			{	
				$this->model->uploadPicture($IdHash,"update");
			}
			echo "Your account was updated!" ;
		}
		else 
		{
			echo "Couldn`t update";
		}
								
	}	
	else
	{
		echo "The maximum lenght for Username is 50 characters";
	}
}
		
else if($PasswordHash==$RepeatPasswordHash)
{	
	$sql = "UPDATE `visitors` SET `FirstName`=:FirstName,`LastName`=:LastName,`CNP`=:CNP,`UserName`=:UserName,`PwdHash`=:PwdHash,`Email`=:Email WHERE Id=:Id";
	$stmt = $this->model->db->prepare($sql);
  						
	$stmt->bindValue(':FirstName', $FirstName);
	$stmt->bindValue(':LastName', $LastName);
	$stmt->bindValue(':CNP', $CNP);
	$stmt->bindValue(':UserName', $UserName);
	$stmt->bindValue(':PwdHash', $PasswordHash);
	$stmt->bindValue(':Email', $Email);
	$stmt->bindValue(':Id', $IdHash);
	$result = $stmt->execute();
							
	if($result)
	{
		
		if($uploadImage)
			{
				$this->model->uploadPicture($IdHash,"update");
			}
		echo "Your account was updated!" ;
	}
	else 
	{
	echo "Couldn`t update";
	}
							
}		
else 
{
	echo "Password doesn`t match";
}
	


}
?>


<h3>O tentativa de meniu </h3>
<a href="<?php echo URL; ?>visitors/account">New appointment</a>
<a href="<?php echo URL; ?>visitors/appointments">Appointments</a>
<a href="<?php echo URL; ?>visitors/logout">Logout</a>

<div class="container">
<h3>Edit Account</h3> 
<br/>
<br/>


<?php 
			$visId=$_SESSION['user_id'];
			$sql="SELECT UserName, FirstName, LastName, CNP, Email,PwdHash FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$visId);
			$query->execute();
			$visitor = $query->fetch(PDO::FETCH_ASSOC);
			
			$oldUserName=$visitor['UserName'];
			$oldFirstName=$visitor['FirstName'];
			$oldLastName=$visitor['LastName'];
			$oldCNP=$visitor['CNP'];
			$oldEmail=$visitor['Email'];
			$oldPwdHash=$visitor['PwdHash'];
			
			$sql="SELECT Location FROM pictures WHERE UserId=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$visId);
			$query->execute();
			$picture = $query->fetch(PDO::FETCH_ASSOC);
			$oldPictureLocation=$picture['Location'];
			
?>

<form method="POST" id="new-visitor-form"  enctype="multipart/form-data">    

<table>
<thead style="background-color: #ddd; font-weight: bold;">

	<tr>
		<td><label for="Username">User Name</label> </td> <td><?php echo htmlspecialchars($oldUserName, ENT_QUOTES, 'UTF-8');  ?>  </td> <td><input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$"  /></td>
    </tr>     
	<tr>
		<td><label for="FirstName">First Name</label></td> <td><?php echo htmlspecialchars($oldFirstName, ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$"/></td>
    </tr>
	<tr>
		<td><label for="LastName">Last Name</label></td><td><?php echo htmlspecialchars($oldLastName, ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{3,50}$"  /></td>
    </tr>
	<tr>
		<td><label for="CNP">CNP</label></td> <td><?php echo htmlspecialchars($oldCNP, ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" /></td>
    </tr>
	<tr>
		<td><label for="Email">E-mail</label></td> <td><?php echo htmlspecialchars($oldEmail, ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="Email" id="Email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" /></td>
    </tr>
	  <tr>
		<td><label for="Password">Password:</label></td> <td>************</td>	<td><input type="password"  name="Password" id="Password" /></td>
    </tr>
	<tr>
		<td><label for="RepeatPassword">Retipe Password:</label></td> <td>************</td><td><input type="password"  name="RepeatPassword" id="RepeatPassword" /></td>
    </tr>	
	<tr>
		<td><label for="uploadImage">Upload Picture:</label></td> 
		<td>
			<?php
				if($oldPictureLocation==NULL)
					echo"No Picture";
				else ?><img src="<?php echo URL . $oldPictureLocation;?>"  width="100" height="100">
				</td><td><input type="file" name="uploadImage" id="uploadImage"/></td>
    </tr>
</thead>
	<td></td><td></td><td><input name="submit" type="submit" Value="Update" />	</td>
</table>
</form>
</div>