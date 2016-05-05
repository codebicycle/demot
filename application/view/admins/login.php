<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


if(isset($_SESSION['admin_id']))
{
	header('location: '.URL. 'admins/index');
	die();
}

else if(isset($_POST['submit']))
{
	$UserName = $_POST['UserName']??NULL;
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');	//securizare sql injection
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');		//securizare sql injection
	
	$Password = $_POST['Password']??NULL;
	$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
	$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');
	
	$encpassword = md5($Password);
	
	
		$errMsg='';
	if($UserName == '')
			$errMsg .= 'You must enter your Username<br>';
		
	if($Password == '')
		$errMsg .= 'You must enter your Password<br>';
	
	
    if($errMsg == '') 
	{
		$sql = "SELECT Id, UserName, PwdHash, Rank
						FROM admins WHERE UserName = :UserName";
		$stmt = $this->model->db->prepare($sql);
		$stmt->bindValue(':UserName', $UserName);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($user == false) 
		{
			die('Incorrect username / password combination!');
		} 
		else
		{

			if($encpassword==$user['PwdHash'])
			{
				session_destroy();
				session_start();
				$_SESSION['admin_id'] = $user['Id']; 
				$_SESSION['rank'] = $user['Rank'];
				$_SESSION['username'] = $user['UserName']; 
				header('location: '.URL. 'admins/index');
				die();
			}
			else 
			{
				die('Incorrect username / password combination!');
			}
			
		}
	}
	
	else
	{
		echo $errMsg;
    }
    
    
}
 
?>



<div class="container">

<h3>Login</h3> 
<br/>
<br/>


<form method="POST" id="login-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"   required autofocus />
<br/>
	
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" required/>
<br/>

	
	<input name="submit" type="submit" Value="Login" />	

</form>
</div>