<?php

if(isset($_SESSION['user_id']))
{
	header('location: ' . URL . 'visitors/index');
	die();
}

$validation_errors = $this->model->validation_errors ?? null;

?>
<div class="container">

<a href="<?php echo URL; ?>visitors/register">Register</a>


<h3>Login</h3> 
<br/>
<br/>

<form method="POST" action="<?php echo URL . 'visitors/login'?>" id="login-form">    
	<?php validation_hint($validation_errors, 'Novisitor') ?>
	<label for="login_Username">User Name</label>
	<input type="text" name="login_UserName" id="login_UserName"    autofocus />
<br/>
	
	<label for="login_Password">Password:</label>
	<input type="password"  name="login_Password" id="login_Password" />
<br/>

	
	<input name="Login" type="submit" Value="Login" />	

</form>

</div>

  