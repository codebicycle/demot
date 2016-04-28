 <?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['user_id']))
{
	require APP. 'view/visitors/index.php';
	exit;
}
?>
<a href="<?php echo URL; ?>visitors/logout">LOGOUT</a> 
<br/>
<a href="<?php echo URL; ?>visitors/appointments">Appointments</a> 
<br/>


<?php

$Id=$_SESSION['user_id'];
$sql = "SELECT UserName FROM visitors WHERE Id = :Id";
$stmt = $this->model->db->prepare($sql);
$stmt->bindValue(':Id', $Id);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'Welcome ';
echo $user['UserName'];
echo ', you are now in your account!';










		
?>