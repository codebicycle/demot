<?php 
  //  require APP . 'libs/helpers.php';
    $validation_errors = $validation_errors ?? null;
    $cache = $cache ?? null;
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
        <img src="<?php echo URL . $picture->Location; ?>" width="100" height="100" />
        <dl>
            <dt>FirstName</dt>
            <dd><?php e($visitor->FirstName); ?></dd>
            <dt>LastName</dt>
            <dd><?php e($visitor->LastName); ?></dd>
            <dt>CNP</dt>
            <dd><?php e($visitor->CNP ?? null); ?></dd>
            <?php validation_hint($validation_errors, 'Relationship') ?>
            <label for="Relationship">Relationship</label>
            <input type="text" name="Relationship" id="Relationship" required />
        </dl>


        <?php if (!empty($appointment->Visitor2CNP)) { ?>
            <span class="title">2nd Visitor</span>
            <dl>
                <dt>FirstName</dt>
                <dd><?php e($appointment->Visitor2FirstName); ?></dd>
                <dt>LastName</dt>
                <dd><?php e($appointment->Visitor2LastName);?></dd>
                <dt>CNP</dt>
                <dd><?php e($appointment->Visitor2CNP); ?></dd>
				<label for="SecondVisitor">No-Show</label>
				<input type="hidden" name="SecondVisitor" id="SecondVisitor" value="<?php echo $appointment->Visitor2Id ?>">
                <input type="checkbox" name="SecondVisitor" id="SecondVisitor" value="">
            </dl>
        <?php } ?>


        <?php if (!empty($appointment->Visitor3CNP)) { ?>
            <span class="title">3rd Visitor</span>

            <dl>
                <dt>FirstName</dt>
                <dd><?php e($appointment->Visitor3FirstName); ?></dd>
                <dt>LastName</dt>
                <dd><?php e($appointment->Visitor3LastName); ?></dd>
                <dt>CNP</dt>
                <dd><?php e($appointment->Visitor3CNP);	?></dd>

				<label for="ThirdVisitor">No-Show</label>
			    <input type="hidden" name="ThirdVisitor" id="ThirdVisitor" value="<?php echo $appointment->Visitor3Id ?>">
                <input type="checkbox" name="ThirdVisitor" id="ThirdVisitor" value="">
            </dl>
        <?php } ?>


        <h3>Visit review</h3>
        <input type="hidden" name="AppointmentId" value="<?php e($appointment->Id); ?>" />

        <?php validation_hint($validation_errors, 'Duration')  ?>
        <label for="Duration">Duration</label>
        <input type="range" min="10" max="120" value="60" step="10" name="Duration" id="Duration" list="time-values" oninput="outputUpdate(value)" required />
        <datalist id="time-values">
            <option>30</option>
            <option>60</option>
            <option>90</option>
            <option>120</option>
        </datalist>
        <output for="Duration" id="output-duration">60 minutes.</output>

        <?php validation_hint($validation_errors, 'ReceivedObjects') ?>
        <label for="ReceivedObjects">Received Objects</label>
        <input type="text" name="ReceivedObjects" id="ReceivedObjects" value="<?php cached_value('ReceivedObjects', $cache) ?>" required />

        <?php validation_hint($validation_errors, 'GivenObjects') ?>
        <label for="GivenObjects">Given Objects</label>
        <input type="text" name="GivenObjects" id="GivenObjects" value="<?php cached_value('GivenObjects', $cache) ?>" required />

        <?php validation_hint($validation_errors, 'Motive') ?>
        <label for="Motive">Visit Nature</label>
        <input type="text" name="Motive" id="Motive" value="<?php cached_value('Motive', $cache) ?>" required />

        <?php validation_hint($validation_errors, 'Comments') ?>
        <label for="Comments">Comments</label>
        <textarea name="Comments" rows="3" id="Comments" value="<?php cached_value('Comments', $cache) ?>" required></textarea>

        <label for="InmatePhisicalState">Inmate Phisical State</label>
        <span class="star-rating">
            <input type="radio" name="InmatePhisicalState" value="1" title="Bad" /><i></i>
            <input type="radio" name="InmatePhisicalState" value="2" title="Not Good" /><i></i>
            <input type="radio" name="InmatePhisicalState" value="3" title="Average" checked /><i></i>
            <input type="radio" name="InmatePhisicalState" value="4" title="Good" /><i></i>
            <input type="radio" name="InmatePhisicalState" value="5" title="Excellent" /><i></i>
        </span>
        <br />

        <label for="InmateEmotionalState">Inmate Emotional State</label>
        <span class="star-rating">
            <input type="radio" name="InmateEmotionalState" value="1" title="Bad" /><i></i>
            <input type="radio" name="InmateEmotionalState" value="2" title="Not Good" /><i></i>
            <input type="radio" name="InmateEmotionalState" value="3" title="Average" checked /><i></i>
            <input type="radio" name="InmateEmotionalState" value="4" title="Good" /><i></i>
            <input type="radio" name="InmateEmotionalState" value="5" title="Exellent" /><i></i>
        </span>
		<input type="hidden" name="GuardId" value="<?php echo $_SESSION['admin_id'] ?>" >
        <input type="submit" name="Save" value="Save" />
    </form>
</div>

<pre>
  <?php 
    //verific daca primesc datele
    print_r($appointment);
    print_r($visitor);
    print_r($inmate);
    print_r($picture);
  ?>
</pre>

<script type="text/javascript">
    function outputUpdate(val) {
        document.querySelector('#output-duration').value = val + " minutes.";
    }
</script>
