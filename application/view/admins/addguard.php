<?php


if(isset($_POST['submit'])){
	
	$UserName = @$_POST['UserName'];
	$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
	$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

	$LastName = @$_POST['LastName'];
	$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
	$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

	$CNP=@$_POST['CNP'];
	$CNP = mb_convert_encoding($CNP, 'UTF-8','UTF-8');
	$CNP =htmlentities($CNP, ENT_QUOTES, 'UTF-8');

	$Password = @$_POST['Password'];
	$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
	$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');

	//rank 2 adica e guard.
	$Rank =2;
    	
	$PwdHash = md5($Password);
	$Id=$CNP . $LastName;
	$IdHash=md5($Id);
	
    //trebuie verificate datele
	
	$sql = "SELECT InstId FROM admins WHERE Id = :Id";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':Id', $_SESSION['admin_id']);
    
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$InstId = $row['InstId'];
	
	//verific daca username-ul este in baza de date
    $sql = "SELECT COUNT(UserName) AS num FROM admins WHERE UserName = :UserName";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':UserName', $UserName);
    
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['num'] > 0){
        die('That username already exists!');
    }
    //adaugam in tabela admins
    $sql = "INSERT INTO admins (Id, InstId, UserName, PwdHash, Rank) VALUES (:IdHash, :InstId, :UserName, :Password, :Rank)";
    $stmt = $this->model->db->prepare($sql);
    
  
	$stmt->bindValue(':IdHash', $IdHash);
	$stmt->bindValue(':InstId', $InstId);
    $stmt->bindValue(':UserName', $UserName);
    $stmt->bindValue(':Password', $PwdHash);
	$stmt->bindValue(':Rank', $Rank);

   
    $result = $stmt->execute();
    
    if($result){
        echo 'A new Guard was assigned.';
		
		?>
		<a href="<?php echo URL; ?>admins/account">HOME</a> 
		<?php
		
    }
    
}

?>



<div class="container">

<h3>Add New Guard</h3> 
<br/>
<br/>
<form method="POST" id="add-new-guard-form">    

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

	<input name="submit" type="submit" Value="Add Guard" />	

</form>
</div>

   