 <?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['user_id']))
{
	require APP. 'view/visitors/index.php';
	exit;
}

$row['num']=-1;

?>

<a href="<?php echo URL; ?>visitors/logout">LOGOUT</a> 
<br/>
<a href="<?php echo URL; ?>visitors/appointments">Appointments</a> 
<br/>


<?php

$Id=$_SESSION['user_id'];
$sql = "SELECT UserName FROM visitors WHERE Id = :Id";
$stmt = $this->model->db->prepare($sql);
$stmt->bindValue(':Id', $Id);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'Welcome ';
echo $user['UserName'];
echo ', you are now in your account!';



if(isset($_POST['search_dob']))
	{
		$FirstName=$_POST['FirstName']??NULL;
		$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
		$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');
	
	
		$LastName=$_POST['LastName']??NULL;
		$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
		$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

		$InstId=$_POST['Institution']??NULL;
		
		
		
		$dob=$_POST['dob']??NULL;
	
		 $sql = "SELECT COUNT(Id) as num FROM inmates WHERE FirstName = :FirstName AND LastName=:LastName AND InstId=:InstId AND DOB=:dob" ;
		 
		$query = $this->model->db->prepare($sql);
		$query->bindValue(':FirstName', $FirstName);
		$query->bindValue(':LastName', $LastName);
		$query->bindValue(':InstId', $InstId);
		$query->bindValue(':dob', $dob);
		$query->execute();
		$row = $query->fetch(PDO::FETCH_ASSOC);
		if($row['num']==1)
		{
			$_SESSION['post_data']=$_POST;
			header('location: '.URL. 'appointments/add');
		}
		else if ($row['num']>1)
		{
			
			echo "There are more inmates with the same Name and date of birth at this institution";
		}
		else if ($row['num']==0)
		{
			echo "There is no inmate with this name and date of birth at this institution";
			header('location: '.URL. 'visitors/account');
		}
		
	}	
 if(isset($_POST['search']))
{
	
	
	$FirstName=$_POST['FirstName']??NULL;
	$FirstName = mb_convert_encoding($FirstName, 'UTF-8','UTF-8');
	$FirstName =htmlentities($FirstName, ENT_QUOTES, 'UTF-8');
	
	
	$LastName=$_POST['LastName']??NULL;
	$LastName = mb_convert_encoding($LastName, 'UTF-8','UTF-8');
	$LastName =htmlentities($LastName, ENT_QUOTES, 'UTF-8');

	$option_chosen=$_POST['option_chosen']??NULL;
	$option_chosen = mb_convert_encoding($option_chosen, 'UTF-8','UTF-8');
	$option_chosen =htmlentities($option_chosen, ENT_QUOTES, 'UTF-8');
	
	
	$sql = "SELECT Id FROM institutions WHERE Name = :Name";
    $stmt = $this->model->db->prepare($sql);
 
    $stmt->bindValue(':Name', $option_chosen);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	$InstId= $row['Id'];
	
	
	
	
    $sql = "SELECT COUNT(Id) as num FROM inmates WHERE FirstName = :FirstName AND LastName=:LastName AND InstId=:InstId";
    $query = $this->model->db->prepare($sql);
 
    $query->bindValue(':FirstName', $FirstName);
	$query->bindValue(':LastName', $LastName);
	$query->bindValue(':InstId', $InstId);
	$query->execute();
    
    $row = $query->fetch(PDO::FETCH_ASSOC);

	if($row['num'] > 1)
	{
   	 	?>
		
		<div class="container">
		<p>There are more inmates with the name  <?php echo $FirstName;echo" "; echo $LastName;?>  at <?php echo $option_chosen;?> institution. <br/> Please give us <?php echo $FirstName;echo" "; echo $LastName;?>'s date of birth.</p> 
			
			<form method="POST" id="add-form">    
				<input  type="hidden" name="FirstName" id="FirstName" Value="<?php echo $FirstName?>"/>		
				<input  type="hidden" name="LastName" id="LastName" Value="<?php echo $LastName?>"/>
				<input type="hidden" name="Institution" id="Institution" Value="<?php echo $InstId?>" />
				
				<label for="dob"> Date of Birth</label>
				<input type="text" name="dob" id="dob" required autofocus />
				<br/><br/>
				<input name="search_dob" type="submit" Value="Search Inmate"/>	
				
			</form>
		</div>
		<?php
    }
	if($row['num']==1)
	{
			
			$_SESSION['post_data']=$_POST;
			header('location: '.URL. 'appointments/add');
	}
	if($row['num'] ==0)
	{
       echo('There is no inmate with this Name at this institution');
?>
		<a href="<?php echo URL; ?>visitors/appointments">HOME</a> 
	<?php
	}

}

if($row['num']==-1)
{	?>


<div class="container">

<h3>Search Inmate:  </h3> 
<br/>
<br/>
<form method="POST" id="add-form">    

	<label for="FirstName"> First Name</label>
	<input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
<br/>
<label for="LastName"> Last Name</label>
	<input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />
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
<input name="search" type="submit" Value="Search Inmate"/>	

</form>
</div>
<?php
}?>