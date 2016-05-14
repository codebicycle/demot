<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(isset($_SESSION['user_id']))
{
	header ('location: ' . URL .'visitors/index');
	die();
}
	$validation_errors = $this->model->validation_errors ?? null;

?>
<div class="container">

<h3>Register</h3> 
<br/>
<br/>
<form method="POST"  id="new-visitor-form" enctype="multipart/form-data">  

	<?php validation_hint($validation_errors, 'registererror') ?>
	<br/>
	<?php validation_hint($validation_errors, 'register_Username') ?>
	<label for="register_Username">User Name</label>
	<input type="text" name="register_UserName" id="register_UserName"  pattern="^[- a-zA-Z]{2,50}$"  required autofocus />
	<?php validation_hint($validation_errors, 'register_FirstName') ?>
	<label for="register_FirstName">First Name</label>
	<input type="text" name="register_FirstName" id="register_FirstName" pattern="^[- a-zA-Z]{2,50}$"  required autofocus />

	<?php validation_hint($validation_errors, 'register_LastName') ?>
	<label for="register_LastName">Last Name</label>
	<input type="text" name="register_LastName" id="register_LastName" pattern="^[- a-zA-Z]{3,50}$"  required />

	<?php validation_hint($validation_errors, 'register_CNP') ?>
	<label for="register_CNP">CNP</label>
	<input type="text" name="register_CNP" id="register_CNP" inputmode="numeric" pattern="\d{13}" required />

	<?php validation_hint($validation_errors, 'register_Email') ?>
	<label for="register_Email">E-mail</label>
	<input type="text" name="register_Email" id="register_Email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" required/>

	<?php validation_hint($validation_errors, 'register_Password') ?>
	<label for="register_Password">Password:</label>
	<input type="password"  name="register_Password" id="register_Password" required/>

	<?php validation_hint($validation_errors, 'register_RepeatPassword') ?>
	<label for="register_RepeatPassword">Retipe Password:</label>
	<input type="password"  name="register_RepeatPassword" id="register_RepeatPassword" required/>


	<label for="uploadImage">Upload Picture:</label>
	<input type="file" name="uploadImage" id="uploadImage" value="<?php cached_value('uploadImage') ?>"/>
	<input name="Register" type="submit" Value="Register" />	

</form>
</div>
