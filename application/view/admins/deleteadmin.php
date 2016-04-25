<?php
session_start();

if(isset($_POST['submit']))
{
	
	
	$UserName=@$_POST['UserName'];
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

	$option_chosen=$_POST['option_chosen'];
	$option_chosen = mb_convert_encoding($option_chosen, 'UTF-8','UTF-8');
	$option_chosen =htmlentities($option_chosen, ENT_QUOTES, 'UTF-8');
	
	
	$sql = "SELECT Id FROM institutions WHERE Name = :Name";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':Name', $option_chosen);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$InstId= $row['Id'];
	
	
    $sql = "SELECT COUNT(Id) AS num FROM admins WHERE UserName = :UserName AND InstId = :InstId";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':UserName', $UserName);
	$stmt->bindValue(':InstId', $InstId);
	$stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
	if($row['num'] > 1){
        die('There are more admins with this User Name at this institution');
		// aici se pot baga mai multe filtre pentru a selecta pe cine trebuie
		
    }
	if($row['num'] < 1){
        echo('There is no admin with this User Name at this institution');
		?>
		<a href="<?php echo URL; ?>admins/account">HOME</a> 
		<?php
		die;
	}
 
	$sql = "DELETE FROM admins WHERE UserName = :UserName AND InstId = :InstId";
	$stmt = $this->model->db->prepare($sql);
	
	$stmt->bindValue(':UserName', $UserName);
	$stmt->bindValue(':InstId', $InstId);
	$result = $stmt->execute();
	
	
    if($result){
        echo $UserName; echo ' '; echo ' was deleted from admins.';
		
		?>
		<a href="<?php echo URL; ?>admins/account">HOME</a> 
		<?php
		
    }
    
}

?>



<div class="container">

<h3>Delete Admin</h3> 
<br/>
<br/>
<form method="POST" id="delete-admin-form">    

	<label for="UserName"> User Name</label>
	<input type="text" name="UserName" id="UserName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	
	
	
	
<label for="Institution">Institution</label>
<?php
	$sql = "SELECT Name FROM institutions";
    $stmt = $this->model->db->prepare($sql);
    $stmt->execute();
	$data =$stmt->fetchAll();
	?>
	
	<select name="option_chosen">
<?php foreach ($data as $row): $Name=$row->Name; ?>		
    <option><?=$Name?></option>
<?php endforeach ?>
</select>
<br/>
<br/>
<input name="submit" type="submit" Value="Delete Admin"/>	

</form>
</div>