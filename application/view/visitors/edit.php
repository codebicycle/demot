<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $validation_errors = $validation_errors ?? null;
    $cache = $cache ?? null;
?>

<h3>O tentativa de meniu </h3>
<a href="<?php echo URL; ?>visitors/account">New appointment</a>
<a href="<?php echo URL; ?>visitors/appointments">Appointments</a>
<a href="<?php echo URL; ?>visitors/logout">Logout</a>


<div class="container">
  <h3>Edit acount</h3>
    <form action="<?php echo URL . 'visitors/editaccount'; ?>" method="POST" id="demot-form" novalidate >
      
	  <?php validation_hint($validation_errors, 'UserName');?>
		<label for="Username">User Name</label>
		<input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" value="<?php cached_value('UserName', $cache) ?>" required />

	   <?php validation_hint($validation_errors, 'FirstName'); ?>
        <label for="FirstName">First Name</label>
        <input type="text" name="FirstName" id="FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('FirstName', $cache) ?>" required />
        
        <?php validation_hint($validation_errors, 'LastName') ?>
        <label for="LastName">Last Name</label>
        <input type="text" name="LastName" id="LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('LastName', $cache) ?>" required />
         
        <?php validation_hint($validation_errors, 'CNP')  ?>
        <label for="CNP">CNP</label>
        <input type="text" id="CNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('CNP', $cache) ?>" required/>
        <input type="hidden" name="CNP" value="<?php cached_value('CNP', $cache) ?>" />
        
        <?php validation_hint($validation_errors, 'Email') ?>
        <label for="Email">E-mail</label>
        <input type="text" name="Email" id="Email"  pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" value="<?php cached_value('Email', $cache) ?>" required />
      

        <?php validation_hint($validation_errors, 'Password') ?>
        <label for="Password">Password</label>
        <input type="password" name="Password" id="Password"  />

        <?php validation_hint($validation_errors, 'RepeatPassword') ?>
        <label for="RepeatPassword">Repeat Password</label>
        <input type="password" name="RepeatPassword" id="RepeatPassword"/>

        <?php validation_hint($validation_errors, 'uploadImage') ?>
        <label for="uploadImage">Upload Picture</label>
		<input type="file" name="uploadImage" id="uploadImage"/>
        

        
        <input type="submit" name="Update" value="Update" />
    </form>
</div>

<pre>
  <?php print_r($Visitor ?? null); ?>
</pre>
