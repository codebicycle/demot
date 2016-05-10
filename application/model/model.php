<?php

require APP . 'model/validator.php';

class Model
{
	public $validation_errors = array();

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
      { $exp=$_POST['export_press']??NULL;
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
              $csv_data['ReceivedObjects']=$visit->ReceivedObjects;  
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
              $json_array['ReceivedObjects']=$visit->ReceivedObjects;  
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
    
		public function getApprovedAppointments() 
	{
		
		$sql = "SELECT Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId 
				FROM appointments 
				WHERE State = 'approved'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
	return $stmt->fetchAll();
	}
	
	public function getPendingAppointments()
	{
		
		$sql = "SELECT Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId 
                FROM appointments 
				WHERE State = 'pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
	    return $stmt->fetchAll();
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
              if ($state=='rejected')  
                echo "<td>Motive</td>";
            echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
      }
      
      public function getAppointments($state)
      {

        if($state=='approved')
        {
          echo "<h3>ACCEPTED APPOINTMENTS: </h3>";
          echo"<br/>";
        }
        else if($state=='pending')
        {
          echo"<h3>PENDING APPOINTMENTS: </h3>";
          echo"<br/>";
        }
        else if($state=='done')
        {
          echo"<h3>DONE VISITS: </h3>";
          echo "<br/>";
        }
        else if($state=='noshow')
        {
          echo"<h3>NO-SHOW VISITS: </h3>";
          echo "<br/>";
        }
        else if($state=='rejected')
        {
          echo"<h3>REJECTED APPOINTMENTS: </h3>";
          echo"<br/>";
        }
          
          $this->getTableHeadAppointments($state);
          
      $VisitorId=$_SESSION['user_id'];
      $sql = "SELECT Id, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName, Visitor2Id,Visitor3FirstName, Visitor3LastName, Visitor3Id, InmateId 
			  FROM appointments 
			  WHERE VisitorId = :VisitorId 
			  AND State = :State
			  OR Visitor2Id= :VisitorId
			  AND State = :State
			  OR Visitor3Id= :VisitorId
			  AND State = :State";
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
        
        echo"<td>"  ;
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
        
      echo  "<td>";
              if (isset($appointment->DateOfAppointment)) 
              echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); 
           echo "</td>";
           
         echo"<td>";
               if (isset($appointment->TimeOfAppointment)) 
              echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); 
           echo "</td>";
         
          if($state=='rejected')   
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

	  public function uploadPicture($id,$type)
	  {
		  
			$name = 'Image';
            $filelocation = 'uploadimg/';
            $filename=date('Y-m-d.H.i.s').$_FILES["uploadImage"]["name"];
			
			move_uploaded_file($_FILES["uploadImage"]["tmp_name"] , "$filelocation"."$filename");
			$location="$filelocation"."$filename";
			
			if($type=="create")
			{
				$sql = "INSERT INTO pictures (UserId, Location) VALUES ( :UserId, :Location)";
			}
			else if($type=="update")
			{
				$sql = "UPDATE `pictures` SET `Location`=:Location WHERE UserId=:UserId";	
			}
			$stmt = $this->db->prepare($sql);
    		$stmt->bindValue(':UserId', $id);
			$stmt->bindValue(':Location', $location);
			$stmt->execute();
			
	  }

    public function getAppointment($Id)
    {
        $sql = "SELECT Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName, Visitor2CNP, Visitor2Id, Visitor3FirstName, Visitor3LastName, Visitor3CNP, Visitor3Id, State, InmateId
                FROM appointments 
                WHERE Id =:Id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('Id', $Id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getInmate($appointmentId)
    {
        $sql = "SELECT FirstName, LastName, CNP, InstId, LawyerId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate
                FROM inmates
                WHERE Id =:Id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('Id', $appointmentId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getVisitor($appointmentId)
    {
        $sql = "SELECT FirstName, LastName, CNP, Email
                FROM visitors 
                WHERE Id =:Id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('Id', $appointmentId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPicture($appointmentId)
    {
        $sql = "SELECT Location
                FROM pictures 
                WHERE UserId =:Id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('Id', $appointmentId);
        $stmt->execute();
        return $stmt->fetch();
    }

}

// Model naming convention: Controller_name + 'Model'

class HomeModel extends Model {}

class ErrorzModel extends Model {}



class InmatesModel extends Model {
    public $Id;
    public $FirstName;
    public $LastName;
    public $CNP;
    public $DOB;
    public $InstId;
    public $Crime;
    public $Sentence;
    public $IncarcerationDate;
    public $ReleaseDate;
    public $LawyerFirstName;
    public $LawyerLastName;
    public $LawyerCNP;
    public $LawyerId;

    public function initialize($id, $firstName, $lastName, $CNP, $DOB, 
            $instId, $crime, $sentence, $incarcerationDate, $releaseDate, 
            $lawyerFirstName, $lawyerLastName, $lawyerCNP, $lawyerId) {
        $this->Id                   = $id;
        $this->FirstName            = $firstName;
        $this->LastName             = $lastName;
        $this->CNP                  = $CNP;
        $this->DOB                  = $DOB;
        $this->InstId               = $instId;
        $this->Crime                = $crime;
        $this->Sentence             = $sentence;
        $this->IncarcerationDate    = $incarcerationDate;
        $this->ReleaseDate          = $releaseDate;
        $this->LawyerFirstName      = $lawyerFirstName;
        $this->LawyerLastName       = $lawyerLastName;
        $this->LawyerCNP            = $lawyerCNP;
        $this->LawyerId = ($this->LawyerCNP && $this->LawyerLastName) 
                            ? md5($this->LawyerCNP . $this->LawyerLastName) 
                            : $lawyerId;
    }

    private function generate_and_set_Id() {
        $this->Id = ($this->CNP && $this->LastName) 
                            ? md5($this->CNP . $this->LastName) 
                            : null;
    }

    private function is_valid() {
        Validator::validate_name($this, 'FirstName');
        Validator::validate_name($this, 'LastName');
        Validator::validate_cnp($this, 'CNP');
        Validator::validate_institutionId_exists($this, 'InstId');
        Validator::validate_date($this, 'DOB');
        if(!isset($this->validation_errors['DOB']))
            Validator::validate_date_not_in_future($this, 'DOB');
        Validator::validate_date($this, 'IncarcerationDate');
        if(!isset($this->validation_errors['IncarcerationDate']))
            Validator::validate_date_not_in_future($this, 'IncarcerationDate');
        Validator::validate_date($this, 'ReleaseDate');
        if (!isset($this->validation_errors['IncarcerationDate']) &&
            !isset($this->validation_errors['ReleaseDate'])) {
            Validator::validate_dates_in_order($this, 'IncarcerationDate', 
                'ReleaseDate');
        }
        Validator::validate_not_empty($this, 'Crime');
        Validator::validate_sentence($this, 'Sentence');
        if (!empty($this->LawyerFirstName) ||
            !empty($this->LawyerLastName)  ||
            !empty($this->LawyerCNP)) {
            Validator::validate_name($this, 'LawyerFirstName');
            Validator::validate_name($this, 'LawyerLastName');
            Validator::validate_cnp($this, 'LawyerCNP');
            // lawyerId not in inmates table
            Validator::validate_no_inmate_with_id($this,'LawyerId');
        }
        
        return count($this->validation_errors) === 0;
    }

    public function getAllInmates() {
        $sql = "SELECT Id, FirstName, LastName, CNP, InstId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate, LawyerId
                FROM inmates";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function save() {
        $valid = $this->is_valid();
        if (!$valid)
            return false;

        $this->generate_and_set_Id();
        $exists = $this->inmateId_exists($this->Id);
        if($exists) {
            Validator::validate_no_inmate_with_id($this, 'Id');
            return false;
        }
           
        // save to database
        $sql = "INSERT INTO inmates(Id, FirstName, LastName, CNP, DOB, InstId, Crime, Sentence, IncarcerationDate, ReleaseDate, LawyerId) 
                VALUES(:id, :firstName, :lastName, :CNP, :DOB, :instId, :crime, :sentence, :incarcerationDate, :releaseDate, :lawyerId)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $this->Id);
        $stmt->bindValue('firstName', $this->FirstName);
        $stmt->bindValue('lastName', $this->LastName);
        $stmt->bindValue('CNP', $this->CNP);
        $stmt->bindValue('DOB', $this->DOB);
        $stmt->bindValue('instId', $this->InstId, PDO::PARAM_INT);
        $stmt->bindValue('crime', $this->Crime);
        $stmt->bindValue('sentence', $this->Sentence);
        $stmt->bindValue('incarcerationDate', $this->IncarcerationDate);
        $stmt->bindValue('releaseDate', $this->ReleaseDate);
        $stmt->bindValue('lawyerId', $this->LawyerId);
        $stmt->execute();
        return true;
    }

    public function destroy($id) {
        $sql = "DELETE from inmates
                WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return boolval($stmt->rowCount());
    }

    public function find_by_id($id) {
        $sql = "SELECT Id, FirstName, LastName, CNP, DOB, InstId, Crime, Sentence, IncarcerationDate, ReleaseDate, LawyerId 
                FROM inmates
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function inmateId_exists($id) {
        $sql = "SELECT 1 FROM inmates WHERE id=:id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $exists = $stmt->fetchColumn();
        if($exists)
            return true;
        return false;
    }

    public function update($id) {
        $valid = $this->is_valid();
        if (!$valid)
            return false;

        // update in database
        $sql = "UPDATE inmates
                SET FirstName = :firstName, LastName = :lastName, CNP = :CNP, DOB = :DOB, InstId = :instId, Crime = :crime, Sentence = :sentence, IncarcerationDate = :incarcerationDate, ReleaseDate = :releaseDate, LawyerId = :lawyerId
                WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $this->Id);
        $stmt->bindValue('firstName', $this->FirstName);
        $stmt->bindValue('lastName', $this->LastName);
        $stmt->bindValue('CNP', $this->CNP);
        $stmt->bindValue('DOB', $this->DOB);
        $stmt->bindValue('instId', $this->InstId, PDO::PARAM_INT);
        $stmt->bindValue('crime', $this->Crime);
        $stmt->bindValue('sentence', $this->Sentence);
        $stmt->bindValue('incarcerationDate', $this->IncarcerationDate);
        $stmt->bindValue('releaseDate', $this->ReleaseDate);
        $stmt->bindValue('lawyerId', $this->LawyerId);
        $stmt->execute();
        return true;
    }
}

class AdminsModel extends Model {
	
	

	
}

class VisitsModel extends Model {
    public $AppointmentId;
    public $GivenObjects;
    public $ReceivedObjects;
    public $Duration;
    public $Motive;
    public $Comments;
    public $InmatePhisicalState;
    public $InmateEmotionalState;
    public $Relationship;
    // public $Id;
    public $Done=1;
    public $SecondVisitor;
    public $ThirdVisitor;
	public $GuardId;
	  

    public function initialize($AppointmentId, $GivenObjects, $ReceivedObjects, $Duration, $Motive, $Comments, $InmatePhisicalState, $InmateEmotionalState, $Relationship, $SecondVisitor, $ThirdVisitor, $GuardId) {
        $this->AppointmentId        = $AppointmentId;
        $this->GivenObjects         = $GivenObjects;
        $this->ReceivedObjects      = $ReceivedObjects;
        $this->Duration             = $Duration;
        $this->Motive               = $Motive;
        $this->Comments             = $Comments;
        $this->InmatePhisicalState  = $InmatePhisicalState;
        $this->InmateEmotionalState = $InmateEmotionalState;
        $this->Relationship         = $Relationship;
        $this->SecondVisitor        = $SecondVisitor;
        $this->ThirdVisitor         = $ThirdVisitor;
        $this->GuardId				= $GuardId;
    }


    public function save() {
        $valid = $this->is_valid();
        if (!$valid)
            return false;
           
        // save to database
        $sql = "INSERT INTO visits(AppointmentId, GivenObjects, ReceivedObjects, Duration, Motive, Comments, InmatePhisicalState, InmateEmotionalState, Relationship, SecondVisitor, ThirdVisitor, GuardId) 
                VALUES(:AppointmentId, :GivenObjects, :ReceivedObjects, :Duration, :Motive, :Comments, :InmatePhisicalState, :InmateEmotionalState, :Relationship, :SecondVisitor, :ThirdVisitor, :GuardId)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('AppointmentId', $this->AppointmentId, PDO::PARAM_INT);
        $stmt->bindValue('GivenObjects', $this->GivenObjects);
        $stmt->bindValue('ReceivedObjects', $this->ReceivedObjects);
        $stmt->bindValue('Duration', $this->Duration, PDO::PARAM_INT);
        $stmt->bindValue('Motive', $this->Motive);
        $stmt->bindValue('Comments', $this->Comments);
        $stmt->bindValue('InmatePhisicalState', $this->InmatePhisicalState);
        $stmt->bindValue('InmateEmotionalState', $this->InmateEmotionalState);
        $stmt->bindValue('Relationship', $this->Relationship);
        $stmt->bindValue('SecondVisitor', $this->SecondVisitor);
        $stmt->bindValue('ThirdVisitor', $this->ThirdVisitor);
		$stmt->bindValue('GuardId', $this->GuardId);
        $stmt->execute();
		
		$sql="UPDATE appointments
			  SET State= 'done'
			  WHERE	Id=:id";
		$stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $this->AppointmentId);
		$stmt->execute();
		
        return true;
    }

    public function is_valid() {
        Validator::validate_integer_between($this, 'Duration', 10, 120);
        Validator::validate_integer_between($this, 'InmatePhisicalState', 1, 5);
        Validator::validate_integer_between($this, 'InmateEmotionalState', 1, 5);

        Validator::validate_required($this, 'Relationship');
        if (!isset($this->validation_errors['Relationship'])) {
            Validator::validate_string_length($this, 'Relationship', 3, 50);
        }

        if (!empty($this->Comments)) {
            Validator::validate_string_length($this, 'Comments', 3);
        }

        if (!empty($this->ReceivedObjects)) {
            Validator::validate_string_length($this, 'ReceivedObjects', 2, 100);
        }

        if (!empty($this->GivenObjects)) {
            Validator::validate_string_length($this, 'GivenObjects', 2, 100);
        }

        if (!empty($this->Motive)) {
            Validator::validate_string_length($this, 'Motive', 3);
        }

        return count($this->validation_errors) === 0;
    }
	
	public function getAllVisits() {
        $sql = "SELECT Id, AppointmentId, Done, SecondVisitor, ThirdVisitor, GivenObjects, ReceivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState 
        FROM visits";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
	public function getAllVisitsByInstitution($admin_id)
	{
		
		$sql ="SELECT InstId 
			   FROM admins
			   WHERE Id=:id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue('id', $admin_id);
        $stmt->execute();
		$instid= $stmt->fetch()->InstId;
		
		$sql = "SELECT visits.Id, AppointmentId, Done, SecondVisitor, ThirdVisitor, GivenObjects, ReceivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState 
                FROM visits
				JOIN appointments
				ON visits.AppointmentId=appointments.Id 
				JOIN inmates
				ON appointments.InmateId=inmates.Id
				WHERE inmates.InstId=:id";
			
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue('id', $instid);
        $stmt->execute();
        return $stmt->fetchAll();		
	}
	
	public function getAllVisitsByVisitor($user_id)
	{
		$sql = "SELECT visits.Id, AppointmentId, Done, SecondVisitor, ThirdVisitor, GivenObjects, ReceivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState 
                FROM visits
				JOIN appointments
				ON visits.AppointmentId=appointments.Id 
				WHERE appointments.VisitorId=:id 
				OR (appointments.Visitor2Id=:id AND visits.SecondVisitor=:id) 
				OR (appointments.Visitor3Id=:id AND visits.ThirdVisitor=:id)";
			
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue('id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();			
	}

	
	
}

class VisitorsModel extends Model {}

class AppointmentsModel extends Model 
{
		
    public function getAllAppointments() {
        $sql = "SELECT Id, InmateId, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor2Id, Visitor3FirstName, Visitor3LastName, Visitor3Id, State
                FROM appointments";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
	public function getAllAppointmentsByInstitution($admin_id)
	{
		
		$sql ="SELECT InstId 
			   FROM admins
			   WHERE Id=:id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue('id', $admin_id);
        $stmt->execute();
		$instid= $stmt->fetch()->InstId;
		
		$sql = "SELECT appointments.Id, InmateId, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, State
                FROM appointments
				JOIN inmates
				ON (appointments.InmateId=inmates.Id)
				WHERE inmates.InstId=:id";
			
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue('id', $instid);
        $stmt->execute();
        return $stmt->fetchAll();
	}

	public function approve_appointment($Id, $GuardId)
	{
		$this->setState($Id, 'approved');
		$this->setGuard($Id, $GuardId);
	}

	public function reject_appointment($Id, $GuardId)
	{
        $this->setState($Id, 'rejected');
		$this->setGuard($Id, $GuardId);
	}
	 public function setGuard($id, $guardid) {
        
		$sql="UPDATE appointments
			  SET GuardId = :GuardId
              WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->bindValue('GuardId', $guardid);
        $stmt->execute();
    }
    

    public function setState($id, $state) {
        $valid_states = ['pending', 'rejected', 'approved', 'noshow', 'done'];

        if ( in_array($state, $valid_states)) {
            $sql="UPDATE appointments
                  SET State = :state
                  WHERE Id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->bindValue('state', $state);
            $stmt->execute();
        }
    }

	
	
}
