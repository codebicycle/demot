<?php
session_start();

if(isset($_POST['addadmin'])){
    
    
	$instid = !empty($_POST['instid']) ? trim($_POST['instid']) : null;
	
	$lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
	$cnp = !empty($_POST['cnp']) ? trim($_POST['cnp']) : null;
	
	// trebuie facut drop down menu. momentan e hard coded
	$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
	
	//rank 1 adica e admin simplu.
	$rank =1;
    	
	$passwordHash = md5($pass);
	$Id=$lastname . $cnp;
	$IdHash=md5($Id);
	
    //trebuie verificate datele
	
	
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
        echo 'A new admin was assigned.';
		
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
        <title>Add Admin</title>
    </head>
    <body>
        <h1>Add Admin</h1>
        <form  method="post">
            
			<label for="instid">Idinstitutie</label>
            <input type="text" id="instid" name="instid"><br>
		
			<label for="lastname">LastName</label>
            <input type="text" id="lastname" name="lastname"><br>
            <label for="cnp">CNP</label>
            <input type="text" id="cnp" name="cnp"><br>
			
			<label for="username">Username</label>
        	<input type="text" id="username" name="username"><br>
			
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br>
			
			
            <input type="submit" name="addadmin" value="Register"></button>
        </form>
    </body>
</html>