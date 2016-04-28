<?php
  require APP . 'libs/helpers.php';
  $validation_errors = $validation_errors ?? null;
?>

<div class="container">
  <h3>Add new appointment</h3>
  <form action="<?php echo URL; ?>appointments/create" method="POST" id="demot-form" novalidate >
    <?php validation_hint($validation_errors, 'FirstName') ?>
    <label for="FirstName">First Name</label>
    <input type="text" name="FirstName" id="FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="Jane" required disabled />
    
    <?php validation_hint($validation_errors, 'LastName') ?>
    <label for="LastName">Last Name</label>
    <input type="text" name="LastName" id="LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="Doe" required  disabled/>
    

    <?php validation_hint($validation_errors, 'DateOfAppointment') ?>
    <label for="DateOfAppointment">Date</label>
    <input type="date" name="DateOfAppointment" id="DateOfAppointment" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" value="<?php cached_value('DateOfAppointment') ?>" required />

    <?php validation_hint($validation_errors, 'TimeOfAppointment') ?>
    <label for="TimeOfAppointment">Time</label>
    <input type="time" name="TimeOfAppointment" id="TimeOfAppointment" value="<?php cached_value('TimeOfAppointment') ?>" required />

    <div>
        <?php validation_hint($validation_errors, 'Visitor2FirstName') ?>
        <label for="Visitor2FirstName">First Name (2nd visitor)</label>
        <input type="text" name="Visitor2FirstName" id="Visitor2FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor2FirstName') ?>" />
        
        <?php validation_hint($validation_errors, 'Visitor2LastName') ?>
        <label for="Visitor2LastName">Last Name(2nd visitor)</label>
        <input type="text" name="Visitor2LastName" id="Visitor2LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor2LastName') ?>" />

         <?php validation_hint($validation_errors, 'Visitor2CNP')  ?>
        <label for="Visitor2CNP">CNP (2nd visitor)</label>
        <input type="text" name="Visitor2CNP" id="Visitor2CNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('Visitor2CNP') ?>" />
    </div>

    <div>
        <?php validation_hint($validation_errors, 'Visitor3FirstName') ?>
        <label for="Visitor3FirstName">First Name (3rd visitor)</label>
        <input type="text" name="Visitor3FirstName" id="Visitor3FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor3FirstName') ?>" />
        
        <?php validation_hint($validation_errors, 'Visitor3LastName') ?>
        <label for="Visitor3LastName">Last Name(3rd visitor)</label>
        <input type="text" name="Visitor3LastName" id="Visitor3LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor3LastName') ?>" />

        <?php validation_hint($validation_errors, 'Visitor2CNP')  ?>
        <label for="Visitor3CNP">CNP (3rd visitor)</label>
        <input type="text" name="Visitor3CNP" id="Visitor3CNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('Visitor3CNP') ?>" />
    </div>

  
    <label></label>
    <input type="button" id="add-visitor" value="Add Visitor" />

    <label></label>
    <input type="submit" name="Create" value="Create" />
  </form>
</div>

<pre>
    <?php print_r($appointment ?? null); ?>
</pre>
