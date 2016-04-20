
<div class="container">

<h3>Register</h3> 
<br/>
<br/>
<form action="<?php echo URL; ?>visitors/index" method="POST" id="new-visitor-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	<label for="FirstName">First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>

	<label for="LastName">Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{3,50}$" required />
<br/>
	<label for="CNP">CNP</label>
	<input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" required />
<br/>
	<label for="Email">E-mail</label>
	<input type="text" name="Email" id="Email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" required/>
<br/>
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" required/>
<br/>

	<label for="RepeatPassword">Retipe Password:</label>
	<input type="password"  name="RepeatPassword" id="RepeatPassword" required/>
<br/>
	<input name="submit" type="submit" Value="Register" />	

</form>
</div>

<?php
$UserName = @$_POST['UserName'];
$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

$FirstName = @$_POST['FirstName'];
$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');


$LastName = @$_POST['LastName'];
$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

$Email =@$_POST["Email"];

$CNP=@$_POST['CNP'];
$CNP = mb_convert_encoding($CNP, 'UTF-8','UTF-8');
$CNP =htmlentities($CNP, ENT_QUOTES, 'UTF-8');


$Password = @$_POST['Password'];
$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');

$RepeatPassword = @$_POST['RepeatPassword'];
$RepeatPassword = mb_convert_encoding($RepeatPassword, 'UTF-8','UTF-8');
$RepeatPassword =htmlentities($RepeatPassword, ENT_QUOTES, 'UTF-8');


//concatenare LastName cu CNP

$id=$CNP;
$id.=$LastName;


$submit = @$_POST['submit'];
$encpassword = md5($Password);

//creare hash id

$encid=md5(id);

if($submit){
	if($UserName==true){
		if($FirstName==true){
			if($LastName==true){
			
				if($Password==true){
					if($Password==$RepeatPassword){
						if(strlen($UserName)<=50){
									
							if(strlen($Password)<=20 || strlen($Password)>=3){
								$query= "SELECT CNP FROM visitors WHERE CNP='$CNP'";
								$query_run = mysql_query($query);
						
								if(mysql_num_rows($query_run)){
									echo "The account CNP already exists.";
								}
								else{
									$insert= mysql_query("INSERT INTO visitors VALUES ('$encid','$FirstName','$LastName','$CNP','$UserName','$encpassword','$Email')") or die("Account creation error!");
									echo "Registration successfull.";
									}
								}
							else{
								echo "The password has to be between 3 and 20 characters";
							}
						}
						else{
							echo "The maximum lenght for Username is 50 characters";
						}
					}
					else{
						echo "Passwords do not match";
					}
				}
				else{
					echo "The Password field is empty";
				}
			}
			else{
				echo "The Last Name field is empty";
			}
			
		}
		else{
			echo "The First Name field is empty";
		}
	}
	else{
		echo "The Username field is empty";
	}
}
?>

 </div>
