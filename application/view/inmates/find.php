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
<form method="POST" action="" id="add-form">    

	<?php validation_hint($validation_errors, 'InmateBanned') ?>
	<?php validation_hint($validation_errors, 'FirstName') ?>
	<label for="FirstName"> First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
<?php validation_hint($validation_errors, 'LastName') ?>
<label for="LastName"> Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	
<label for="Institution">Institution</label>
<?php
	$sql = "SELECT Name FROM institutions";
    $stmt = $this->model->db->prepare($sql);
    $stmt->execute();
	$data =$stmt->fetchAll();
	?>
	
	<select name="option_chosen">
<?php foreach ($data as $row): $Name=$row->Name; ?>		
    <option><?=$Name?></option>
<?php endforeach ?>
</select>
<br/>
<br/>
<input name="search" type="submit" Value="Search Inmate"/>	

</form>
</div>