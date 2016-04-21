
<div class="container">

<h3>Add New Admin</h3> 
<br/>
<br/>
<form action="<?php echo URL; ?>admins/index" method="POST" id="add-new-admin-form">    

	<label for="Username">User Name</label>
	<input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	<label for="LastName">First Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
	<label for="CNP">CNP</label>
	<input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" required />
<br/>
	<label for="Password">Password:</label>
	<input type="password"  name="Password" id="Password" required/>
<br/>


<label for="Institution">Institution</label>
<?php

$sql ="SELECT Name FROM institutions";
$result = mysql_query($sql);

echo "<select name='option_chosen'>";
while ($row=mysql_fetch_array($result))
{
	echo "<option value='" . $row['Name'] . "'>" . $row['Name'] ."</option>";
}
echo "</select>";

?>
	<input name="submit" type="submit" Value="Add Admin" />	

</form>
</div>

<?php

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


//concatenare CNP cu  LastName
$id=$CNP;
$id.=$LastName;

$Rank=1;

$option_chosen=$_POST['option_chosen'];
$option_chosen = mb_convert_encoding($option_chosen, 'UTF-8','UTF-8');
$option_chosen =htmlentities($option_chosen, ENT_QUOTES, 'UTF-8');

$sql ="SELECT id FROM institutions WHERE name='$option_chosen'";

$instid = mysql_query($sql);



$submit = @$_POST['submit'];
$encpassword = md5($Password);

//creare hash id

$encid=md5($id);

if($submit){
	if($UserName==true){
		if($LastName==true){
			
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
			echo "The Last Name field is empty";
		}
	}
	else{
		echo "The Username field is empty";
	}
}
?>

 </div>
