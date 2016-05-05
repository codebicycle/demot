<?php require APP . 'libs/helpers.php'; ?>

<div class="container">
    <h3>Visits List</h3>
	
    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Appointment Id</td>
                <td>Second visitor</td>
                <td>Third visitor</td>
                <td>Given objects</td>
                <td>Received objects</td>
                <td>Relationship</td>
                <td>Motive</td>
                <td>Comments</td>
                <td>Duration</td>
                <td>Inmate phisical state</td>
                <td>Inmate emotional state</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visits as $visit) { ?>
            <tr>
                <td>
                    <?php e($visit->Id); ?>
                </td>
                <td>
                <?php e($visit->AppointmentId); ?>
                </td>
                <td>
                    <?php e($visit->SecondVisitor); ?>
                </td>
                <td>
                    <?php e($visit->ThirdVisitor); ?>
                </td>
                <td>
                    <?php e($visit->GivenObjects); ?>
                </td>
                <td>
                    <?php e($visit->ReceivedObjects); ?>
                </td>
                <td>
                    <?php e($visit->Relationship); ?>
                </td>
                <td>
                    <?php e($visit->Motive); ?>
                </td>
                <td>
                    <?php e($visit->Comments); ?>
                </td>
                <td>
                    <?php e($visit->Duration); ?>
                </td>
                <td>
                    <?php e($visit->InmatePhisicalState); ?>
                </td>
                <td>
                    <?php e($visit->InmateEmotionalState); ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
