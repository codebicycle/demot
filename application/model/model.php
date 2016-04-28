<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
}

// Model naming convention: Controller_name + 'Model'

class HomeModel extends Model {}

class ErrorzModel extends Model {}

class InmatesModel extends Model {

    public function getAllInmates() {
        $sql = "SELECT Id, FirstName, LastName, CNP, InstId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate FROM inmates";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
	
	public function getAllVisits() {

        $sql = "SELECT Id, AppointmentId, Done, SecondVisitor, ThirdVisitor, GivenObjects, RecivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState FROM visits";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
	

	public function export_form()
	{
		
		echo "<form name=\"export\" method=\"post\" enctype=\"multipart/form-data\">";
			echo "<select name=\"extension\">";
				echo "<option value=\"html\">HTML</option>";
				echo "<option value=\"csv\">CSV</option>";
				echo "<option value=\"json\">JSON</option>";
			echo "</select>";	
			echo "<input name=\"export_press\" type=\"submit\" value=\"Export\">";
		echo "</form>";
		echo "</br>";
	}

	
	public function export_visits($visits)
	{	$exp=$_POST['export_press']??NULL;
		$ext=$_POST['extension']??NULL;
		if($exp)
		{
	
			if($ext=="html")
			{
				echo "EXPORT HTML";
			}
	
	
	
			if($ext=="csv")
			{
				$name = 'CSVExport';
				$filelocation = 'export/';
				$filename     = $name.date('Y-m-d H.i.s').'.csv';
				$file_export  =  $filelocation . $filename;
				$data = fopen($file_export, 'w');
				$csv_data=array();  
		
				foreach($visits as $visit)
				{  
					$csv_data['Id']=$visit->Id;  
					$csv_data['AppointmentId']=$visit->AppointmentId; 
					$csv_data['SecondVisitor']=$visit->SecondVisitor;  
					$csv_data['ThirdVisitor']=$visit->ThirdVisitor;  
					$csv_data['GivenObjects']=$visit->GivenObjects;  
					$csv_data['RecivedObjects']=$visit->RecivedObjects;  
					$csv_data['Relationship']=$visit->Relationship;  
					$csv_data['Motive']=$visit->Motive;  
					$csv_data['Comments']=$visit->Comments;  
					$csv_data['Duration']=$visit->Duration;  
					$csv_data['InmatePhisicalState']=$visit->InmatePhisicalState;  
					$csv_data['InmateEmotionalState']=$visit->InmateEmotionalState;  
					fputcsv($data, $csv_data);
				}
				fclose($data);
			}
		
			if($ext=="json")
			{
				$name = 'JSONExport';
				$filelocation = 'export/';
				$filename     = $name.date('Y-m-d H.i.s').'.json';
				$file_export  =  $filelocation . $filename;
				$data = fopen($file_export, 'w');
				$json_data=array();  
		
				foreach($visits as $visit)
				{  
					$json_array['Id']=$visit->Id;  
					$json_array['AppointmentId']=$visit->AppointmentId; 
					$json_array['SecondVisitor']=$visit->SecondVisitor;  
					$json_array['ThirdVisitor']=$visit->ThirdVisitor;  
					$json_array['GivenObjects']=$visit->GivenObjects;  
					$json_array['RecivedObjects']=$visit->RecivedObjects;  
					$json_array['Relationship']=$visit->Relationship;  
					$json_array['Motive']=$visit->Motive;  
					$json_array['Comments']=$visit->Comments;  
					$json_array['Duration']=$visit->Duration;  
					$json_array['InmatePhisicalState']=$visit->InmatePhisicalState;  
					$json_array['InmateEmotionalState']=$visit->InmateEmotionalState;  
					array_push($json_data,$json_array);  
  
				}

				fwrite($data, json_encode($json_data));
				fclose($data);
			}	
		}
	}
	
	public function getTableHeadAppointments($state)
	{
		echo "<table>";
			echo "<thead style=\"background-color: #ddd; font-weight: bold;\">";
				echo "<tr>";
					echo "<td>Inmate Name</td>";
					echo "<td>Institution Name and Location </td>";
					echo "<td>Visitor Name</td>";
					echo "<td>Second Visitor Name</td>";
					echo "<td>Third visitor Name</td>";
					echo "<td>Date Of Appointment</td>";
					echo "<td>Time Of Appointment</td>";
					if ($state==3)	
						echo "<td>Motive</td>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
	}
	public function getAppointments($state)
	{
		if($state==0)
		{
			echo "<h3>ACCEPTED APPOINTMENTS: </h3>";
			echo"<br/>";
		}
		else if($state==1)
		{
			echo"<h3>PENDING APPOINTMENTS: </h3>";
			echo"<br/>";
		}
		else if($state==2)
		{
			echo"<h3>DONE VISITS: </h3>";
			echo "<br/>";
		}
		else if($state==3)
		{
			echo"<h3>REJECTED APPOINTMENTS: </h3>";
			echo"<br/>";
		}
		  
		  $this->getTableHeadAppointments($state);
		  
	$VisitorId=$_SESSION['user_id'];
	$sql = "SELECT Id, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId FROM appointments WHERE VisitorId = :VisitorId AND State = :State";
        $stmt = $this->db->prepare($sql);
		$stmt->bindValue(':VisitorId', $VisitorId);
		$stmt->bindValue(':State', $state);
        $stmt->execute();

		$appointments=$stmt->fetchAll();
	
	foreach ($appointments as $appointment) { 
	
    echo "<tr>";
	  
	echo "<td>";
		  if (isset($appointment->InmateId)) 
		  {
			  
			$inmateId=$appointment->InmateId;
			$sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':inmateId',$inmateId);
			$query->execute();
			$inmate = $query->fetch(PDO::FETCH_ASSOC);
			
			echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
			$InstId=$inmate['InstId'];
		  }	
		echo" </td>";
		
		echo"<td>"	;
			$sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':InstId',$InstId);
			$query->execute();
			
			$Institution = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
			echo ", ";
			echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
		            
        echo"</td>"; 
	  
         echo"<td>";
           
		  $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':VisitorId',$VisitorId);
			$query->execute();
			
			$Visitor = $query->fetch(PDO::FETCH_ASSOC);
			echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
		  	
		  
		   
                    
     echo " </td>";
		
		
		
        echo"<td>";
          
		  if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
		  {
			
			echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
		  }	
		  else echo "NOT PRESENT";
		  
                    
      echo  "</td>";
		
		echo"<td>";
          
		  if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
		  {
			echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
			echo " ";
			echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
		  }
			else echo "NOT PRESENT";
		 			 
        echo"</td>";
		
	echo	"<td>";
          if (isset($appointment->DateOfAppointment)) 
          echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); 
       echo "</td>";
       
	   echo"<td>";
           if (isset($appointment->TimeOfAppointment)) 
          echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); 
       echo "</td>";
	   
      if($state==3)	  
	  { 
			echo"<td>";
           if (isset($appointment->Id)) 
		  {
			  /////aici am luat din vizite facute comentariu si daca nu e am afisat hard codded un mesaj .
			$appId=$appointment->Id;
			$sql="SELECT Comments FROM visits WHERE AppointmentId=:AppointmentId";
			$query = $this->db->prepare($sql);
			$query->bindValue(':AppointmentId',$appId);
			$query->execute();			
			$visit = $query->fetch(PDO::FETCH_ASSOC);
			
			if(isset($visit['comments']))
				echo $visit['comments'];
			else 
				echo "A fost respinsa fara motiv";
		  }
		  
		   echo "</td>";
	  }
	  
	  
	  
      echo"</tr>";
     } 
    echo"</tbody>";
  echo"</table>";
		
	}
	
	
}
