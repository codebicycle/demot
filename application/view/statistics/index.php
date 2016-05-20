<div class="container">
<?php 
if($_SESSION['rank']==0)
{
?>

    <p class="title">Visits Per Institution</p>
    <table>
        <thead>
            <tr>
                <td>Name, Location</td>
                <td>Visits</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($visits_per_institution as $visits): ?>
        <tr>
            <td><?php e("$visits->Name $visits->Location") ?></td>
			<td><?php e("$visits->num_visits") ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
	
	<?php require APP . 'view/_templates/_exportSelect.php';?>
	 <input type="hidden" name="function" value="visits_per_institution">
	</form>
	
	
	<p class="title">Average visit duration</p>
    <table>
        <thead>
            <tr>
                <td>Name, Location</td>
                <td>Duration</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($average_visit_duration as $visits): ?>
        <tr>
		    <td><?php e("$visits->Name $visits->Location") ?></td>
			
			<td><?php $hour_conv=$this->model->convertToHoursMins($visits->duration); e($hour_conv); echo " hours";?> </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
	
	<?php require APP . 'view/_templates/_exportSelect.php';?>
	 <input type="hidden" name="function" value="average_visit_duration">
	</form>
	
	
	    <p class="title">Popular visiting hour</p>
    <table>
        <thead>
            <tr>
                <td>Hour</td>
                <td>Visits</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($popular_hour as $pop_hour): ?>
        <tr>
            <td><?php e("$pop_hour->TimeOfAppointment") ?></td>
			<td><?php e("$pop_hour->num_hour") ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
	
	<p class="title">Most active visitors</p>
    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Visits</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($most_visitors_visits as $visits): ?>
        <tr>
            <td><?php e("$visits->FirstName $visits->LastName") ?></td>
			<td><?php e("$visits->visits") ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

	<p class="title">Most active guards</p>
    <table>
        <thead>
            <tr>
                <td>User Name</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($active_guards as $guard): ?>
        <tr>
            <td><?php e("$guard->UserName") ?></td>
			<td><?php e("$guard->num_active_guard") ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
	
	<p class="title">Most visited Inmates</p>
    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Institution</td>
				<td>Visits</td>
				<td>Physical State (avg)</td>
				<td>Emotional State (avg)</td>
				<td>Duration (avg)</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($most_visited as $inmate): ?>
        <tr>
            <td><?php e("$inmate->FirstName $inmate->LastName") ?></td>
			<td><?php e("$inmate->Name $inmate->Location") ?></td>
			<td><?php e("$inmate->num_visits_inmate") ?></td>
			<td><?php e(round($inmate->phisicalState,2)) ?></td>
			<td><?php e(round($inmate->emotionalState,2)) ?></td>
			<td><?php $hour_conv=$this->model->convertToHoursMins($inmate->duration); e($hour_conv); echo " hours";?> </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
	
	<p class="title">Most banned Inmates</p>
    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Institution</td>
				<td>Bans</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($most_banned_inmates as $inmate): ?>
        <tr>
            <td><?php e("$inmate->FirstName $inmate->LastName") ?></td>
			<td><?php e("$inmate->Name $inmate->Location") ?></td>
			<td><?php e("$inmate->num_bans_inmate") ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>



	
<?php
}
else if($_SESSION['rank']==1)
	
{
?>
		<p class="title">NO TABLE FOR YOU</p>
<?php
}
?>
</div>
