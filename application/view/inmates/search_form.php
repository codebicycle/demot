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
<form method="POST" action="<?php echo URL . 'inmates/find'?>" novalidate >
	<?php validation_hint($validation_errors, 'InmateBanned') ?>
	<?php validation_hint($validation_errors, 'MoreInmates') ?>
	<label for="FirstName">First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" value="<?php cached_value('FirstName') ?>" required autofocus />

    <label for="LastName">Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{2,50}$" value="<?php cached_value('LastName') ?>" required />

    <?php if (isset($show_dob_field) || isset($_POST['DOB'])) { ?>
    	<?php validation_hint($validation_errors, 'DOB') ?>
    	<label for="DOB">Date of Birth</label>
    	<input type="text" name="DOB" id="DOB" value="<?php cached_value('DOB') ?>" />
    <?php } ?>

    <?php validation_hint($validation_errors, 'InstId') ?>
   <label for="InstId">Institution</label>
   <select name="InstId" id="InstId">
   <?php foreach ($institutions as $inst): ?>
       <option value="<?php e($inst->Id) ?>"><?php e("$inst->Name, $inst->Location") ?></option>
   <?php endforeach; ?>
</select>
<input name="search" type="submit" Value="Search Inmate"/>

</form>
</div>
