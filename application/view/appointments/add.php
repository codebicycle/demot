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





    require APP . 'libs/helpers.php';
    $validation_errors = $validation_errors ?? null;
	
?>

<div class="container">
    <h3>Add new appointment</h3>

    <form action="<?php echo URL; ?>appointments/create" method="POST" id="demot-form" novalidate >        
     
        <?php validation_hint($validation_errors, 'DateOfAppointment') ?>
        <label for="DateOfAppointment">Date</label>
        <input type="date" name="DateOfAppointment" id="DateOfAppointment" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" value="<?php cached_value('DateOfAppointment') ?>" required />

        <?php validation_hint($validation_errors, 'TimeOfAppointment') ?>
        <label for="TimeOfAppointment">Time</label>
        <select name="TimeOfAppointment" id="TimeOfAppointment">
            <option value="12">12:00</option>
            <option value="13">13:00</option>
            <option value="14">14:00</option>
            <option value="15">15:00</option>
            <option value="16">16:00</option>
        </select>

        <fieldset id="second-visitor">
            <legend>Accompanying Visitor</legend>

            <?php validation_hint($validation_errors, 'Visitor2FirstName') ?>
            <label for="Visitor2FirstName">First Name</label>
            <input type="text" name="Visitor2FirstName" id="Visitor2FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor2FirstName') ?>" />

            <?php validation_hint($validation_errors, 'Visitor2LastName') ?>
            <label for="Visitor2LastName">Last Name</label>
            <input type="text" name="Visitor2LastName" id="Visitor2LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor2LastName') ?>" />

            <?php validation_hint($validation_errors, 'Visitor2CNP')  ?>
            <label for="Visitor2CNP">CNP</label>
            <input type="text" name="Visitor2CNP" id="Visitor2CNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('Visitor2CNP') ?>" />
        </fieldset>

        <fieldset id="third-visitor">
            <legend>Second Accompanying Visitor</legend>

            <?php validation_hint($validation_errors, 'Visitor3FirstName') ?>
            <label for="Visitor3FirstName">First Name </label>
            <input type="text" name="Visitor3FirstName" id="Visitor3FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor3FirstName') ?>" />

            <?php validation_hint($validation_errors, 'Visitor3LastName') ?>
            <label for="Visitor3LastName">Last Name</label>
            <input type="text" name="Visitor3LastName" id="Visitor3LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('Visitor3LastName') ?>" />

            <?php validation_hint($validation_errors, 'Visitor2CNP')  ?>
            <label for="Visitor3CNP">CNP </label>
            <input type="text" name="Visitor3CNP" id="Visitor3CNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('Visitor3CNP') ?>" />
        </fieldset>
        <input type="submit" name="Create" value="Make Appointment" />
    </form>
</div>

<pre>
    <?php print_r($appointment ?? null); ?>
</pre>

<script>
window.onload = function () {
    // hide form fields
    var second = document.getElementById('second-visitor');
    var third = document.getElementById('third-visitor');
    second.classList.toggle('remove');
    third.classList.toggle('remove');

    // accompanying visitor button
    var button = document.createElement('input');
    button.setAttribute('type', 'button');
    button.setAttribute('value', 'Accompanying Visitor');
    var form = document.getElementById('demot-form')
    form.insertBefore(button, form.lastElementChild);

    var visitor_click_count = 0;
    button.addEventListener("click", click_handler, false);

    function click_handler( event ) {
        visitor_click_count += 1;
        if (visitor_click_count === 1) {
            second.classList.toggle('remove');
        }
        else if (visitor_click_count === 2) {
            third.classList.toggle('remove');
            button.classList.toggle('remove');
        }
    }
};
</script>
