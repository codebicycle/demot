<?php


session_start();
if(isset($_POST['submit']))
{
	$UserName = $_POST['UserName'];
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');	//securizare sql injection
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');		//securizare sql injection
	
	$Password = $_POST['Password'];
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
		$sql = "SELECT Id, UserName, PwdHash FROM visitors WHERE UserName = :UserName";
		$stmt = $this->model->db->prepare($sql);
    
		$stmt->bindValue(':UserName', $UserName);
        
		$stmt->execute();
    
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
    
		if($user === false)
		{
			die('Incorrect username / password combination!');
		} 
		else
		{
			if($encpassword==$user['PwdHash'])
			{
				$_SESSION['user_id'] = $user['Id'];
				$_SESSION['logged_in'] = time();
           
				require APP. 'view/visitors/account.php';
				exit; 
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

<a href="<?php echo URL; ?>visitors/register">Register</a>


<h3>Login</h3> 
<br/>
<br/>

<form method="POST" id="login-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"    autofocus />
<br/>
	
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" />
<br/>

	
	<input name="submit" type="submit" Value="Login" />	

</form>

</div>

  