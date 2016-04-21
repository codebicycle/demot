<?php
session_start();



if(isset($_POST['addguard'])){
    
    
	
	
	$lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
	$cnp = !empty($_POST['cnp']) ? trim($_POST['cnp']) : null;
	
	
	$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    
	$pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
	
	//rank 2 adica e guard.
	$rank =2;
    	
	$passwordHash = md5($pass);
	$Id=$lastname . $cnp;
	$IdHash=md5($Id);
	
    //trebuie verificate datele
	
	
	
	//incerc sa iau instid;
	
	 $sql = "SELECT InstId FROM admins WHERE Id = :Id";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':Id', $_SESSION['user_id']);
    
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$instid = $row['InstId'];
	
	
    //verific daca username-ul este in baza de date
    $sql = "SELECT COUNT(UserName) AS num FROM admins WHERE UserName = :username";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':username', $username);
    
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //daca exista adunci crapa
    if($row['num'] > 0){
        die('That username already exists!');
    }
    //adaugam in tabela admins
    $sql = "INSERT INTO admins (Id, InstId, UserName, PwdHash, Rank) VALUES (:IdHash, :instid, :username, :password, :rank)";
    $stmt = $this->model->db->prepare($sql);
    
  
	$stmt->bindValue(':IdHash', $IdHash);
	$stmt->bindValue(':instid', $instid);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $passwordHash);
	$stmt->bindValue(':rank', $rank);

   
    $result = $stmt->execute();
    
    if($result){
        echo 'A new Guard was assigned.';
		
		?>
		<a href="<?php echo URL; ?>admins/account">HOME</a> 
		<?php
		
    }
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Guard</title>
    </head>
    <body>
        <h1>Add Guard</h1>
        <form  method="post">
            
			
			<label for="lastname">LastName</label>
            <input type="text" id="lastname" name="lastname"><br>
            <label for="cnp">CNP</label>
            <input type="text" id="cnp" name="cnp"><br>
			
			<label for="username">Username</label>
        	<input type="text" id="username" name="username"><br>
			
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br>
			
			
            <input type="submit" name="addguard" value="Add Guard"></button>
        </form>
    </body>
</html>