
<div class="container">

<h3>Login</h3> 
<br/>
<br/>


<form action="<?php echo URL; ?>visitors/account" method="POST" id="login-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"   required autofocus />
<br/>
	
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" required/>
<br/>

	
	<input name="submit" type="submit" Value="Login" />	

</form>
</div>

<?php

if(false) {///functie care verifica daca esti logat

//echo 'Esti deja conectat.';
//redirect catre pagina account

//<?php echo URL; //incheiere php  //visitors/account



} 
else {
		if(isset($_POST['UserName']) && isset($_POST['Password'])) {
					$UserName = $_POST['UserName'];
					$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');	//securizare sql injection
					$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');		//securizare sql injection
					$Password = $_POST['Password'];
					$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
					$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');
					$encpassword = md5($Password);
					
					if(!empty($UserName) && !empty($Password)) {
						$query = "SELECT id FROM visitors WHERE UserName = '$UserName' AND PwdHash = '$encpassword'";
						if( $query_run = mysql_query($query)) {
							$query_num_rows = mysql_num_rows($query_run);
								if($query_num_rows == 0) {
									echo $UserName;
									echo $Password;
									echo 'Invalid name/password.';
								} else {
									$user_id = mysql_result($query_run, 0, 'id');
									$_SESSION['user_id'] = $user_id;
									// redirect catre pagina account 
								}
						} 
					} else {
						echo 'You must provide a name and a password.';
					}
		}

}
?>
