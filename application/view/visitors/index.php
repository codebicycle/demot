
<div class="container">

<?php

// verificare prin functie de login ... daca e loga face redirect catre pagina account
//$logg=0;
//if($logg==1) {
//f	
//require APP. 'view/visitors/register.php';
//} 
?>

<h3>Login</h3> 
<br/>
<br/>


<form action="<?php echo URL; ?>visitors/index" method="POST" id="login-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"    autofocus />
<br/>
	
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" />
<br/>

	
	<input name="submit" type="submit" Value="Login" />	

</form>
</div>

<?php
//else daca nu e logat afiseaza pagina index pentru login.
$logg=0;
if($logg==0)
	{
		if(isset($_POST['UserName']) && isset($_POST['Password'])) 
		{
					$UserName = $_POST['UserName'];
					$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');	//securizare sql injection
					$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');		//securizare sql injection
					
					$Password = $_POST['Password'];
					$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
					$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');
					
					$encpassword = md5($Password);
					
					if(!empty($UserName) && !empty($Password)) {
						
						//select in pdo
						//luat de pe net
						
						$result = $this->model->db->prepare("SELECT Id FROM visitors WHERE UserName= :usr AND PwdHash= :pass");
						$result->bindParam(':usr', $UserName);
						$result->bindParam(':pass', $encpassword);
						$result->execute();
						$rows = $result->fetch(PDO::FETCH_OBJ);
						
						if($rows > 0)
						{
							require APP. 'view/visitors/account.php';
						}
					
					else{
						$errmsg_arr[] = 'Username and Password are not found';
						$errflag = true;
						}
					if($errflag) {
						$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
						session_write_close();
						require APP. 'view/visitors/index.php';
					exit();
					}

					}

		}
	}
?>
