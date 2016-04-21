<?php

//login.php

/**
 * Start the session.
 */
session_start();



//If the POST var "login" exists (our submit button), then we can
//assume that the user has submitted the login form.
if(isset($_POST['login'])){
    
    //Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordHash=md5($passwordAttempt);
	
    //Retrieve the user account information for the given username.
    $sql = "SELECT Id, UserName, PwdHash FROM visitors WHERE UserName = :username";
    $stmt = $this->model->db->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        die('Incorrect username / password combination!');
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
        //Compare the passwords.
        //$validPassword = password_verify($passwordHash, $user['PwdHash']);
        
        //If $validPassword is TRUE, the login has been successful.
        if($passwordHash==$user['PwdHash']){
            
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['Id'];
            $_SESSION['logged_in'] = time();
            
            //Redirect to our protected page, which we called home.php
            require APP. 'view/visitors/account.php';
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
    }
    
}
 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
	  <a href="<?php echo URL; ?>visitors/register">Register</a>
        <h1>Login</h1>
        <form  method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password</label>
            <input type="text" id="password" name="password"><br>
            <input type="submit" name="login" value="Login">
        </form>
    </body>
</html>