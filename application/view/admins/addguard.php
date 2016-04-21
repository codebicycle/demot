
<div class="container">

<h3>Add New Guard</h3> 
<br/>
<br/>
<form action="<?php echo URL; ?>admins/index" method="POST" id="add-new-guard-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	<label for="FirstName">First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
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

<?php

$UserName = @$_POST['UserName'];
$UserName = mb_convert_encoding($UserName, 'UTF-8','UTF-8');
$UserName =htmlentities($UserName, ENT_QUOTES, 'UTF-8');

$FirstName = @$_POST['FirstName'];
$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');

$CNP=@$_POST['CNP'];
$CNP = mb_convert_encoding($CNP, 'UTF-8','UTF-8');
$CNP =htmlentities($CNP, ENT_QUOTES, 'UTF-8');

$Password = @$_POST['Password'];
$Password = mb_convert_encoding($Password, 'UTF-8','UTF-8');
$Password =htmlentities($Password, ENT_QUOTES, 'UTF-8');


//concatenare FirstName cu CNP

$id=$CNP;
$id.=$FirstName;
$Rank=2;

//$instid=id institutie

$query= "SELECT instid FROM admins WHERE id='$session_id'";//// selectez id-ul institutiei dupa id-ul sesiunii adminului. 
$instid = mysql_query($query);

$submit = @$_POST['submit'];
$encpassword = md5($Password);

//creare hash id

$encid=md5($id);

if($submit){
	if($UserName==true){
		if($FirstName==true){
			
				if($Password==true){
						if(strlen($UserName)<=50){
									
							if(strlen($Password)<=20 || strlen($Password)>=3){
								$query= "SELECT id FROM admins WHERE id='$encid'";
								$query_run = mysql_query($query);
						
								if(mysql_num_rows($query_run)){
									echo "An account already exists for this person.";
								}
								else{
									$insert= mysql_query("INSERT INTO admins VALUES ('$encid','$instid','$UserName','$encpassword','$Rank')") or die("Account creation error!");
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
					echo "The Password field is empty";
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
