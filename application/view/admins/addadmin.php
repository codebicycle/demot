<?php


if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


if(!isset($_SESSION['admin_id']))
{
	require APP. 'view/admins/index.php';
	exit;
}

else if(isset($_POST['submit']))
{
	$UserName = $_POST['UserName']??NULL;
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

	$LastName = $_POST['LastName']??NULL;
	$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
	$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

	$CNP=$_POST['CNP']??NULL;
	$CNP = mb_convert_encoding($CNP, 'UTF-8','UTF-8');
	$CNP =htmlentities($CNP, ENT_QUOTES, 'UTF-8');

	$Password = $_POST['Password']??NULL;
	$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
	$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');
	
	$RetipePassword = $_POST['RetipePassword']??NULL;
	$RetipePassword = mb_convert_encoding($RetipePassword, 'UTF-8','UTF-8');
	$RetipePassword =htmlentities($RetipePassword, ENT_QUOTES, 'UTF-8');

	//concatenare CNP cu  LastName
	//Rank e 1 pentru ca e admin simplu
	$Rank=1;

	$option_chosen=$_POST['option_chosen']??NULL;
	$option_chosen = mb_convert_encoding($option_chosen, 'UTF-8','UTF-8');
	$option_chosen =htmlentities($option_chosen, ENT_QUOTES, 'UTF-8');
	
	///Sql pentru a selecta idul institutiei
	$sql = "SELECT Id FROM institutions WHERE Name = :Name";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':Name', $option_chosen);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$InstId= $row['Id'];
		
	$PwdHash = md5($Password);
	
	$Id=$CNP . $LastName;
	
	$IdHash=md5($Id);
	
    $sql = "SELECT COUNT(UserName) AS num FROM admins WHERE UserName = :UserName";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':UserName', $UserName);
    
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
	if($row['num'] > 0){
        die('That username already exists!');
    }
    
	$sql = "INSERT INTO admins (Id, InstId, UserName, PwdHash, Rank) VALUES (:IdHash, :InstId, :UserName, :Password, :Rank)";
    $stmt = $this->model->db->prepare($sql);
    
  
	$stmt->bindValue(':IdHash', $IdHash);
	$stmt->bindValue(':InstId', $InstId);
    $stmt->bindValue(':UserName', $UserName);
    $stmt->bindValue(':Password', $PwdHash);
	$stmt->bindValue(':Rank', $Rank);

    $result = $stmt->execute();
    
    if($result){
        echo 'A new admin was assigned.';
		
		?>
		<a href="<?php echo URL; ?>admins/account">HOME</a> 
		<?php
		
    }
    
}

?>



<div class="container">

<h3>Add New Admin</h3> 
<br/>
<br/>
<form method="POST" id="add-new-admin-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	<label for="LastName">Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	<label for="CNP">CNP</label>
	<input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" required />
<br/>
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" required/>
<br/>
	<label for="RetipePassword">RetipePassword:</label>
	<input type="password"  name="RetipePassword" id="RetipePassword" required/>
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
<input name="submit" type="submit" Value="Add Admin"/>	

</form>
</div>