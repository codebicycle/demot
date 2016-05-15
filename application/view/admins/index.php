<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['admin_id']))
{
	header('location: '.URL. 'admins/login');
	die();
}

$Rank=$_SESSION['rank'];
$UserName=$_SESSION['username'];

?>	


<div class="container">
 <a href="<?php echo URL . 'admins/add' ?>">Add Admin</a>


    <h3>Admins List</h3>

    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Institution</td>
                <td>User Name</td>
                <td>Type</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($admins as $admin): ?>
        <tr>
            <td><?php e($admin->Id); ?></td>
            <td><?php e($admin->InstName); ?></td>
            <td><?php e($admin->UserName); ?></td>
            <td><?php e($ranks[$admin->Rank]); ?></td>
			<td><a href="<?php e(URL . 'admins/delete/' . $admin->Id); ?>" onclick="return confirm('Admin will be removed from the system. Are you sure you want to proceed?');">Remove admin</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
