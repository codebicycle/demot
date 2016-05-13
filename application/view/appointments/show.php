<?php 
  //  require APP . 'libs/helpers.php';
    $validation_errors = $validation_errors ?? null;
?>

<div class="container">

    <form action="<?php echo URL . 'visits/create'; ?>" method="POST" novalidate >

        <span class="title">Appointment</span>
        <dl>
            <dt>Date</dt>
            <dd><?php e($appointment->DateOfAppointment); ?></dd>
            <dt>Time</dt>
            <dd><?php e($appointment->TimeOfAppointment); ?></dd>

            <input type="submit" name="No-Show" value="No-Show" formaction="<?php echo URL . 'appointments/noshow/' . $appointment->Id; ?>" />
        </dl>


        <span class="title">Inmate</span>
        <dl>
            <dt>FirstName</dt>
            <dd><?php e($inmate->FirstName); ?></dd>
            <dt>LastName</dt>
            <dd><?php e($inmate->LastName); ?></dd>
            <dt>Date of Birth</dt>
            <dd><?php e($inmate->DOB); ?></dd>
        </dl>


        <span class="title">Visitor</span>
        <img class="avatar-left" src="<?php e(URL . $picture->Location); ?>" width="100" height="100" />
        <dl>
            <dt>FirstName</dt>
            <dd><?php e($visitor->FirstName); ?></dd>
            <dt>LastName</dt>
            <dd><?php e($visitor->LastName); ?></dd>
            <dt>CNP</dt>
            <dd><?php e($visitor->CNP); ?></dd>
            <?php validation_hint($validation_errors, 'Relationship') ?>
            <label for="Relationship">Relationship</label>
            <input type="text" name="Relationship" id="Relationship" list="relations" value="<?php cached_value('Relationship') ?>" required />
            <datalist id="relations">
                <option value="family">
                <option value="friends">
                <option value="colleagues">
                <option value="professional">
            </datalist>
        </dl>


        <?php if (!empty($appointment->Visitor2Id)) { ?>
            <span class="title">2nd Visitor</span>
            <dl>
                <dt>FirstName</dt>
                <dd><?php e($appointment->Visitor2FirstName); ?></dd>
                <dt>LastName</dt>
                <dd><?php e($appointment->Visitor2LastName);?></dd>
                <dt>CNP</dt>
                <dd><?php e($appointment->Visitor2CNP); ?></dd>
				<label for="SecondVisitor">No-Show</label>
				<input type="hidden" name="SecondVisitor" id="SecondVisitor" value="<?php e($appointment->Visitor2Id); ?>">
                <input type="checkbox" name="SecondVisitor" id="SecondVisitor" value=""<?php cb_cache('SecondVisitor'); ?> >
            </dl>
        <?php } ?>


        <?php if (!empty($appointment->Visitor3Id)) { ?>
            <span class="title">3rd Visitor</span>

            <dl>
                <dt>FirstName</dt>
                <dd><?php e($appointment->Visitor3FirstName); ?></dd>
                <dt>LastName</dt>
                <dd><?php e($appointment->Visitor3LastName); ?></dd>
                <dt>CNP</dt>
                <dd><?php e($appointment->Visitor3CNP);	?></dd>

				<label for="ThirdVisitor">No-Show</label>
			    <input type="hidden" name="ThirdVisitor" id="ThirdVisitor" value="<?php e($appointment->Visitor3Id); ?>">
                <input type="checkbox" name="ThirdVisitor" id="ThirdVisitor" value="" <?php cb_cache('ThirdVisitor'); ?> >
            </dl>
        <?php } ?>


        <h3>Visit review</h3>
        <input type="hidden" name="AppointmentId" value="<?php e($appointment->Id); ?>" />

        <?php validation_hint($validation_errors, 'Duration')  ?>
        <label for="Duration">Duration</label>
        <input type="range" min="10" max="120" step="10" value="<?php cached_value('Duration', null, 60); ?>" name="Duration" id="Duration" list="time-values" oninput="outputUpdate(value)" required />
        <datalist id="time-values">
            <option>30</option>
            <option>60</option>
            <option>90</option>
            <option>120</option>
        </datalist>
        <output for="Duration" id="output-duration"><?php cached_value('Duration', null, 60); ?> minutes.</output>

        <?php validation_hint($validation_errors, 'ReceivedObjects') ?>
        <label for="ReceivedObjects">Received Objects</label>
        <input type="text" name="ReceivedObjects" id="ReceivedObjects" list="received" value="<?php cached_value('ReceivedObjects') ?>" />
        <datalist id="received">
            <option value="books">
            <option value="food">
            <option value="money">
            <option value="clothing">
            <option value="photos">
        </datalist>

        <?php validation_hint($validation_errors, 'GivenObjects') ?>
        <label for="GivenObjects">Given Objects</label>
        <input type="text" name="GivenObjects" id="GivenObjects" list="given" value="<?php cached_value('GivenObjects') ?>" />
        <datalist id="given">
            <option value="books">
            <option value="letters">
            <option value="manuscripts">
            <option value="drawings">
            <option value="paintings">
            <option value="hand-made gifts">
        </datalist>

        <?php validation_hint($validation_errors, 'Motive') ?>
        <label for="Motive">Visit Nature</label>
        <input type="text" name="Motive" id="Motive" list="motives" value="<?php cached_value('Motive') ?>" required />
        <datalist id="motives">
            <option value="personal">
            <option value="counseling">
            <option value="educational">
            <option value="business">
        </datalist>

        <?php validation_hint($validation_errors, 'Comments') ?>
        <label for="Comments">Comments</label>
        <textarea name="Comments" rows="3" id="Comments"><?php cached_value('Comments'); ?></textarea>

        <?php validation_hint($validation_errors, 'InmatePhisicalState') ?>
        <label for="InmatePhisicalState">Inmate Phisical State</label>
        <span class="star-rating">
            <input type="radio" name="InmatePhisicalState" value="1" title="Bad" <?php radio_cache('InmatePhisicalState', "1"); ?> /><i></i>
            <input type="radio" name="InmatePhisicalState" value="2" title="Not Good" <?php radio_cache('InmatePhisicalState', "2"); ?>  /><i></i>
            <input type="radio" name="InmatePhisicalState" value="3" title="Average" <?php radio_cache('InmatePhisicalState', "3", "checked"); ?> /><i></i>
            <input type="radio" name="InmatePhisicalState" value="4" title="Good" <?php radio_cache('InmatePhisicalState', "4"); ?>  /><i></i>
            <input type="radio" name="InmatePhisicalState" value="5" title="Excellent" <?php radio_cache('InmatePhisicalState', "5"); ?>  /><i></i>
        </span>
        <br />

        <?php validation_hint($validation_errors, 'InmateEmotionalState') ?>
        <label for="InmateEmotionalState">Inmate Emotional State</label>
        <span class="star-rating">
            <input type="radio" name="InmateEmotionalState" value="1" title="Bad" <?php radio_cache('InmateEmotionalState', "1"); ?>  /><i></i>
            <input type="radio" name="InmateEmotionalState" value="2" title="Not Good" <?php radio_cache('InmateEmotionalState', "2"); ?>  /><i></i>
            <input type="radio" name="InmateEmotionalState" value="3" title="Average" <?php radio_cache('InmateEmotionalState', "3", "checked"); ?> /><i></i>
            <input type="radio" name="InmateEmotionalState" value="4" title="Good" <?php radio_cache('InmateEmotionalState', "4"); ?>  /><i></i>
            <input type="radio" name="InmateEmotionalState" value="5" title="Exellent" <?php radio_cache('InmateEmotionalState', "5"); ?>  /><i></i>
        </span>
		<input type="hidden" name="GuardId" value="<?php echo $_SESSION['admin_id'] ?>" >
        <input type="submit" name="Save" value="Save" />
    </form>
</div>

<pre>
<?php
echo "appointment\n";
print_r($appointment);
echo "visitor\n";
print_r($visitor);
echo "inamte\n";
print_r($inmate);
echo "picture\n";
print_r($picture);
echo "POST\n";
print_r($_POST);
?>
</pre>

<script type="text/javascript">
    function outputUpdate(val) {
        document.querySelector('#output-duration').value = val + " minutes.";
    }
</script>
