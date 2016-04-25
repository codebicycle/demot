<?php


session_start();
if(isset($_POST['submit'])){
    
    
    
	$UserName = @$_POST['UserName'];
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

	$FirstName = @$_POST['FirstName'];
	$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
	$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');


	$LastName = @$_POST['LastName'];
	$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
	$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

	$Email =@$_POST["Email"];

	$CNP=@$_POST['CNP'];
	$CNP = mb_convert_encoding($CNP, 'UTF-8','UTF-8');
	$CNP =htmlentities($CNP, ENT_QUOTES, 'UTF-8');


	$Password = @$_POST['Password'];
	$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
	$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');
	
	$PasswordLength=strlen($Password);
	
	$RepeatPassword = @$_POST['RepeatPassword'];
	$RepeatPassword = mb_convert_encoding($RepeatPassword, 'UTF-8','UTF-8');
	$RepeatPassword =htmlentities($RepeatPassword, ENT_QUOTES, 'UTF-8');


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
							
							
							$sql = "UPDATE `visitors` SET `FirstName`=:FirstName,`LastName`=:LastName,`CNP`=:CNP,`UserName`=:UserName,`PwdHash`=:PwdHash,`Email`=:Email WHERE Id=:Id";
							$stmt = $this->model->db->prepare($sql);
    						
							$stmt->bindValue(':FirstName', $FirstName);
							$stmt->bindValue(':LastName', $LastName);
							$stmt->bindValue(':CNP', $CNP);
							$stmt->bindValue(':UserName', $UserName);
							$stmt->bindValue(':PwdHash', $PasswordHash);
							$stmt->bindValue(':Email', $Email);
							$stmt->bindValue(':Id', $_SESSION['user_id']);
							$result = $stmt->execute();
							
							if($result)
							{
								
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

<h3>Edit Account</h3> 
<br/>
<br/>


<?php 
			$visId=$_SESSION['user_id'];
			$sql="SELECT UserName, FirstName, LastName, CNP, Email FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$visId);
			$query->execute();
			$visitor = $query->fetch(PDO::FETCH_ASSOC);
			
			
?>

<form method="POST" id="new-visitor-form">    

<table>
<thead style="background-color: #ddd; font-weight: bold;">

	<tr>
		<td><label for="Username">User Name</label> </td> <td><?php echo htmlspecialchars($visitor['UserName'], ENT_QUOTES, 'UTF-8');  ?>  </td> <td><input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus /></td>
    </tr>     
	<tr>
		<td><label for="FirstName">First Name</label></td> <td><?php echo htmlspecialchars($visitor['FirstName'], ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus /></td>
    </tr>
	<tr>
		<td><label for="LastName">Last Name</label></td><td><?php echo htmlspecialchars($visitor['LastName'], ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{3,50}$" required /></td>
    </tr>
	<tr>
		<td><label for="CNP">CNP</label></td> <td><?php echo htmlspecialchars($visitor['CNP'], ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" required /></td>
    </tr>
	<tr>
		<td><label for="Email">E-mail</label></td> <td><?php echo htmlspecialchars($visitor['Email'], ENT_QUOTES, 'UTF-8');  ?></td><td><input type="text" name="Email" id="Email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" required/></td>
    </tr>
	  <tr>
		<td><label for="Password">Password:</label></td> <td>************</td>	<td><input type="password"  name="Password" id="Password" required/></td>
    </tr>
	<tr>
		<td><label for="RepeatPassword">Retipe Password:</label></td> <td>************</td><td><input type="password"  name="RepeatPassword" id="RepeatPassword" required/></td>
    </tr>	  
</thead>
	<td></td><td></td><td><input name="submit" type="submit" Value="Update" />	</td>
</table>
</form>

</div>
