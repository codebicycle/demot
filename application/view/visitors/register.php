<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


if(isset($_POST['submit'])){
    
    
    
	$UserName = $_POST['UserName']??NULL;
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

	$FirstName = $_POST['FirstName']??NULL;
	$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
	$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');


	$LastName = $_POST['LastName']??NULL;
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
	
	$uploadImage=$_FILES['uploadImage'];
	
//concatenare LastName cu CNP
	$Id=$CNP . $LastName;
    	
	$PasswordHash = md5($Password);
	$RepeatPasswordHash=md5($RepeatPassword);
	
	$IdHash=md5($Id);
	
	
if($UserName==true)
{
		if($FirstName==true)
		{
			if($LastName==true)
			{
			
				if($Password==true)
				{
					if($PasswordHash==$RepeatPasswordHash)
					{	
						if(strlen($UserName)<=50)
						{			
							$sql = "SELECT COUNT(UserName) AS num FROM visitors WHERE UserName = :UserName";
							$stmt = $this->model->db->prepare($sql);
   							$stmt->bindValue(':UserName', $UserName);
							$stmt->execute();
    
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
   							if($row['num'] > 0)
							{
							die('That username already exists!');
							}
    
							$sql = "INSERT INTO visitors (Id, FirstName, LastName, CNP, UserName, PwdHash, Email) VALUES (:IdHash, :FirstName, :LastName, :CNP, :UserName, :Password, :Email)";
							$stmt = $this->model->db->prepare($sql);
    						$stmt->bindValue(':IdHash', $IdHash);
							$stmt->bindValue(':FirstName', $FirstName);
							$stmt->bindValue(':LastName', $LastName);
							$stmt->bindValue(':CNP', $CNP);
							$stmt->bindValue(':UserName', $UserName);
							$stmt->bindValue(':Password', $PasswordHash);
							$stmt->bindValue(':Email', $Email);
							$result = $stmt->execute();
    
							if($result)
							{
								if($uploadImage)
								{
								$this->model->uploadPicture($IdHash);
								}
								$_SESSION['user_id'] = $IdHash;           
								require APP. 'view/visitors/account.php';
								exit; 
							}
							else 
							{
								echo "Couldn`t register";
							}
								
						}
						
						else
						{
							echo "The maximum lenght for Username is 50 characters";
						}
					}
							
					else 
					{
						echo "Password doesn`t match";
					}
				}
				else
				{
					echo "The Password field is empty";
				}
			}
			else
			{
				echo "The Last Name field is empty";
			}
			
		}
		else
		{
			echo "The First Name field is empty";
		}
	}
	else
	{
		echo "The Username field is empty";
	}
}	


?>
<div class="container">

<h3>Register</h3> 
<br/>
<br/>
<form method="POST" id="new-visitor-form" enctype="multipart/form-data">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>

	<label for="FirstName">First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>

	<label for="LastName">Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{3,50}$" required />
<br/>
	<label for="CNP">CNP</label>
	<input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" required />
<br/>
	<label for="Email">E-mail</label>
	<input type="text" name="Email" id="Email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" required/>
<br/>
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" required/>
<br/>

	<label for="RepeatPassword">Retipe Password:</label>
	<input type="password"  name="RepeatPassword" id="RepeatPassword" required/>
<br/>
	<label for="uploadImage">Upload Picture:</label>
	<input type="file" name="uploadImage" id="uploadImage"/>
<br/>

	<input name="submit" type="submit" Value="Register" />	

</form>
</div>
