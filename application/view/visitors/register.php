<?php

//register.php

/**
 * Start the session.
 */
session_start();


//If the POST var "register" exists (our submit button), then we can
//assume that the user has submitted the registration form.
if(isset($_POST['register'])){
    
    //Retrieve the field values from our registration form.
    
	$firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
	$lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
	$cnp = !empty($_POST['cnp']) ? trim($_POST['cnp']) : null;
	
	$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
	
	$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    	
	$passwordHash = md5($pass);
	$Id=$lastname . $cnp;
	$IdHash=md5($Id);
	
    //TO ADD: Error checking (username characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.
    
    //Now, we need to check if the supplied username already exists.
    
    //Construct the SQL statement and prepare it.
	
    $sql = "SELECT COUNT(UserName) AS num FROM visitors WHERE UserName = :username";
    $stmt = $this->model->db->prepare($sql);
    
    //Bind the provided username to our prepared statement.
	
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch the row.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If the provided username already exists - display error.
    //TO ADD - Your own method of handling this error. For example purposes,
    //I'm just going to kill the script completely, as error handling is outside
    //the scope of this tutorial.
    if($row['num'] > 0){
        die('That username already exists!');
    }
    
    //Hash the password as we do NOT want to store our passwords in plain text.
    
    //Prepare our INSERT statement.
    //Remember: We are inserting a new row into our users table.
    $sql = "INSERT INTO visitors (Id, FirstName, LastName, CNP, UserName, PwdHash, Email) VALUES (:IdHash, :firstname, :lastname, :cnp, :username, :password, :email)";
    $stmt = $this->model->db->prepare($sql);
    
    //Bind our variables.
	
	$stmt->bindValue(':IdHash', $IdHash);
	$stmt->bindValue(':firstname', $firstname);
	$stmt->bindValue(':lastname', $lastname);
	$stmt->bindValue(':cnp', $cnp);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $passwordHash);
	$stmt->bindValue(':email', $email);

    //Execute the statement and insert the new account.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        echo 'Thank you for registering with our website.';
		require APP. 'view/visitors/account.php';
    }
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <body>
        <h1>Register</h1>
        <form action="<?php echo URL; ?>visitors/account" method="post">
            
		
			<label for="firstname">FirstName</label>
            <input type="text" id="firstname" name="firstname"><br>
		
			<label for="lastname">LastName</label>
            <input type="text" id="lastname" name="lastname"><br>
            <label for="cnp">CNP</label>
            <input type="text" id="cnp" name="cnp"><br>
			
			<label for="username">Username</label>
        	<input type="text" id="username" name="username"><br>
			
            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br>
			
			<label for="email">Email</label>
        	<input type="text" id="email" name="email"><br>
			
            <input type="submit" name="register" value="Register"></button>
        </form>
    </body>
</html>