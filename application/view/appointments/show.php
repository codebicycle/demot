<?php require APP . 'libs/helpers.php'; ?>

<div class="container">

<span class="background">Appointment</span>
<dl>
    <dt>Date</dt>
    <dd><?php e($appointment->DateOfAppointment); ?></dd>
    <dt>Time</dt>
    <dd><?php e($appointment->TimeOfAppointment); ?></dd>
</dl>

<span class="background">Inmate</span>
<dl>
    <dt>FirstName</dt>
    <dd><?php e($inmate->FirstName); ?></dd>
    <dt>LastName</dt>
    <dd><?php e($inmate->LastName); ?></dd>
    <dt>Date of Birth</dt>
    <dd><?php e($inmate->DOB); ?></dd>
</dl>


<span class="background">Visitor</span>
<img src="<?php echo URL . $picture->Location; ?>" width="100" height="100" />
<dl>
    <dt>FirstName</dt>
    <dd><?php e($visitor->FirstName); ?></dd>
    <dt>LastName</dt>
    <dd><?php e($visitor->LastName); ?></dd>
    <dt>CNP</dt>
    <dd><?php e($visitor->CNP ?? null); ?></dd>
</dl>

<?php if (!empty($appointment->Visitor2CNP)) { ?>
    <span class="background">2nd Visitor</span>
    <dl>
        <dt>FirstName</dt>
        <dd><?php e($appointment->Visitor2FirstName); ?></dd>
        <dt>LastName</dt>
        <dd><?php e($appointment->Visitor2LastName); ?></dd>
        <dt>CNP</dt>
        <dd><?php e($appointment->Visitor2CNP ?? null); ?></dd>
    </dl>
<?php } ?>

<?php if (!empty($appointment->Visitor3CNP)) { ?>
    <span class="background">3rd Visitor</span>
    <dl>
        <dt>FirstName</dt>
        <dd><?php e($appointment->Visitor3FirstName); ?></dd>
        <dt>LastName</dt>
        <dd><?php e($appointment->Visitor3LastName); ?></dd>
        <dt>CNP</dt>
        <dd><?php e($appointment->Visitor3CNP ?? null); ?></dd>
    </dl>
<?php } ?>


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
