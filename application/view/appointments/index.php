<div class="container">
    <h3>Appointments List</h3>

    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Inmate</td>
                <td>Institution</td>
                <td>Visitor</td>
                <td>2nd visitor</td>
                <td>3rd visitor</td>
                <td>Date </td>
                <td>Time</td>
                <td>State</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?php e($appointment->Id); ?></td>
            <td><?php e("$appointment->inmate_FirstName $appointment->inmate_LastName") ?></td>
            <td><?php e("$appointment->institution_Name, $appointment->institution_Location") ?></td>
            <td><?php e("$appointment->visitor_FirstName $appointment->visitor_LastName") ?></td>
            <td><?php e("$appointment->Visitor2FirstName $appointment->Visitor2LastName") ?></td>
            <td><?php e("$appointment->Visitor3FirstName $appointment->Visitor3LastName") ?></td>
            <td><?php e($appointment->DateOfAppointment); ?></td>
            <td><?php e(substr($appointment->TimeOfAppointment, 0, 5)); ?></td>
            <td><?php e($appointment->State); ?></td>
            <!-- buttons -->
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
