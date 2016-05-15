<?php


if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


if(!isset($_SESSION['admin_id']))
{
	require APP. 'view/admins/index.php';
	exit;
}
$validation_errors = $validation_errors ?? null;

?>

<div class="container">

<h3>Add New Admin</h3> 
<br/>
<br/>
<form method="POST" id="add-new-admin-form">    
<?php validation_hint($validation_errors, 'adderror'); ?>
<?php validation_hint($validation_errors, 'admin_UserName'); ?>
	<label for="admin_UserName">User Name</label>
	<input type="text" name="admin_UserName" id="admin_UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<?php validation_hint($validation_errors, 'admin_LastName'); ?>
	<label for="admin_LastName">Last Name</label>
	<input type="text" name="admin_LastName" id="admin_LastName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<?php validation_hint($validation_errors, 'admin_CNP') ?>
	<label for="admin_CNP">CNP</label>
	<input type="text" name="admin_CNP" id="admin_CNP" inputmode="numeric" pattern="\d{13}" required />
<?php validation_hint($validation_errors, 'admin_Password') ?>
	<label for="admin_Password">Password:</label>
	<input type="password"  name="admin_Password" id="admin_Password" required/>
<?php validation_hint($validation_errors, 'admin_RetipePassword') ?>
	<label for="admin_RepeatPassword">RetipePassword:</label>
	<input type="password"  name="admin_RepeatPassword" id="admin_RepeatPassword" required/>

<?php validation_hint($validation_errors, 'InstitutionId') ?>
       <label for="InstitutionId">Institution</label>
       <select name="InstitutionId" id="InstitutionId">
       <?php foreach ($institutions as $inst): ?>
           <option value="<?php e($inst->Id) ?>"><?php e("$inst->Name, $inst->Location") ?></option>
       <?php endforeach; ?>
</select>



<br/>
<br/>
<input name="AddAdmin" type="submit" Value="Add Admin"/>	

</form>
</div>