<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if(isset($_SESSION['admin_id']))
{
	header('location: ' . URL . 'admins/index');
	die();
}
$validation_errors = $this->model->validation_errors ?? null;

?>
<div class="container">

<h3>Login</h3> 
<br/>
<br/>

<form method="POST" action="<?php echo URL . 'admins/login'?>" id="login-form">    
	<?php validation_hint($validation_errors, 'Noadmin') ?>
	<label for="login_Username">User Name</label>
	<input type="text" name="login_UserName" id="login_UserName"    autofocus />
<br/>
	
	<label for="login_Password">Password:</label>
	<input type="password"  name="login_Password" id="login_Password" />
<br/>

	
	<input name="Login" type="submit" Value="Login" />	

</form>

</div>

  