 <?php
 
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['user_id']))
{
	header('location: ' . URL . 'visitors/login');
	die();
}

$validation_errors = $this->model->validation_errors ?? null;

?>
<div class="container">

<h3>Search Inmate:  </h3> 
<br/>
<br/>
<form method="POST" action="<?php echo URL . 'inmates/find'?>" novalidate >
	<?php validation_hint($validation_errors, 'InmateBanned') ?>
	<?php validation_hint($validation_errors, 'MoreInmates') ?>
	<?php validation_hint($validation_errors, 'FirstName') ?>
	<label for="FirstName">First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" value="<?php cached_value('FirstName') ?>" required autofocus />
<br/>
<?php validation_hint($validation_errors, 'LastName') ?>
<label for="LastName">Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{2,50}$" value="<?php cached_value('LastName') ?>" required />
<br/>


<?php if (isset($show_dob_field)) { ?>
	<?php validation_hint($validation_errors, 'DOB') ?>
	<label for="dob"> Date of Birth</label>
	<input type="text" name="dob" id="dob" value="<?php cached_value('dob') ?>" />
<?php } ?>

<?php validation_hint($validation_errors, 'InstitutionId') ?>
       <label for="InstitutionId">Institution</label>
       <select name="InstitutionId" id="InstitutionId">
       <?php foreach ($institutions as $inst): ?>
           <option value="<?php e($inst->Id) ?>"><?php e("$inst->Name, $inst->Location") ?></option>
       <?php endforeach; ?>
</select>
<br/>
<br/>
<input name="search" type="submit" Value="Search Inmate"/>	

</form>
</div>