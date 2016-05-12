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
		
		$sql = "SELECT appointments.Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId, State, inmates.FirstName as inmate_FirstName, inmates.LastName as inmate_LastName, visitors.FirstName as visitor_FirstName, visitors.LastName as visitor_LastName, institutions.Name as institution_Name, institutions.Location as institution_Location
				FROM appointments
                JOIN inmates
                ON appointments.InmateId = inmates.Id
                JOIN visitors
                ON appointments.VisitorId = visitors.Id
                JOIN institutions
                ON inmates.InstId = institutions.Id
				WHERE State = 'approved'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
	return $stmt->fetchAll();
	}
	
	public function getPendingAppointments()
	{
		
		$sql = "SELECT appointments.Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId, State, inmates.FirstName as inmate_FirstName, inmates.LastName as inmate_LastName, visitors.FirstName as visitor_FirstName, visitors.LastName as visitor_LastName, institutions.Name as institution_Name, institutions.Location as institution_Location
                FROM appointments
                JOIN inmates
                ON appointments.InmateId = inmates.Id
                JOIN visitors
                ON appointments.VisitorId = visitors.Id
                JOIN institutions
                ON inmates.InstId = institutions.Id
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
        $sql = "SELECT Id, AppointmentId, SecondVisitor, ThirdVisitor, GivenObjects, ReceivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState 
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
		
		$sql = "SELECT visits.Id, AppointmentId, SecondVisitor, ThirdVisitor, GivenObjects, ReceivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState 
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
		$sql = "SELECT visits.Id, AppointmentId, SecondVisitor, ThirdVisitor, GivenObjects, ReceivedObjects, Relationship, Motive, Comments, Duration, InmatePhisicalState, InmateEmotionalState 
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

class VisitorsModel extends Model 
{
	public $Id;
	public $UserName;
	public $FirstName;
	public $LastName;
	public $Email;
	public $CNP;
    public $OldPassword;
    public $OldPasswordHash;
	public $Password;
	public $RepeatPassword;
    public $PasswordHash;
	public $UploadImage;

	
	public function initialize($Id, $UserName, $FirstName, $LastName, $Email, $CNP, $OldPassword, $Password, $RepeatPassword, $UploadImage) {
		$this->Id		        = $Id;
		$this->UserName			= $UserName;
		$this->FirstName		= $FirstName;
		$this->LastName			= $LastName;
		$this->Email			= $Email;
		$this->CNP				= $CNP;
        $this->OldPassword      = $OldPassword;
        $this->OldPasswordHash  = md5($OldPassword);
		$this->Password			= $Password;
		$this->RepeatPassword	= $RepeatPassword;
		$this->PasswordHash		= md5($Password);
		$this->UploadImage		= $UploadImage;	
	}
	
	 public function update() {
        $valid = $this->is_valid();
        if (!$valid)
            return false;
		
		if(empty($this->Password)) {
            $sql = "UPDATE `visitors` SET `FirstName`=:FirstName,`LastName`=:LastName,`CNP`=:CNP,`UserName`=:UserName,`Email`=:Email 
                    WHERE Id=:Id";
		}
		else {
			$sql = "UPDATE `visitors` SET `FirstName`=:FirstName,`LastName`=:LastName,`CNP`=:CNP,`UserName`=:UserName,`Email`=:Email, `PwdHash`=:PwdHash
                    WHERE Id=:Id";
        }

		$stmt = $this->db->prepare($sql); 			
		$stmt->bindValue(':FirstName', $this->FirstName);
		$stmt->bindValue(':LastName', $this->LastName);
		$stmt->bindValue(':CNP', $this->CNP);
		$stmt->bindValue(':UserName', $this->UserName);
		if(!empty($this->Password)) {
			$stmt->bindValue(':PwdHash', $this->PasswordHash);
		}
		$stmt->bindValue(':Email', $this->Email);
		$stmt->bindValue(':Id', $this->Id);
		$result = $stmt->execute();
			
	if($result)
	{	
		$_SESSION['username']=$this->UserName;
		if(!empty($this->UploadImage['name']))
			{
				
				$oldPictureLocation=$this->find_picture_by_id($this->Id);
				
				if($oldPictureLocation==NULL)
					$this->uploadPicture($this->Id,"create");
				
				else $this->uploadPicture($this->Id,"update");
			}
			
	}
	 return true;
    }
	
	public function is_valid() 
	{
		Validator::validate_visitorId_exists($this, 'Id');
        // TODO: validate username (can contain numbers unlike name)
		// Validator::validate_name($this, 'UserName');
		Validator::validate_name($this, 'FirstName');
		Validator::validate_name($this, 'LastName');
		Validator::validate_email($this, 'Email');
		Validator::validate_cnp($this, 'CNP');

        if(!empty($this->Password)) {
            // validate old password
            Validator::validate_correct_password($this, 'OldPassword');
            // validate password length
            Validator::validate_string_length($this, 'Password', 2, 32);
            // validate repeat password matches
            if(!isset($this->validation_errors['Password'])) {
                Validator::validate_passwords_match($this, 'Password', 'RepeatPassword');
            }
        }
		
		//Validator::validate_not_empty($this, 'uploadImage');
		
		return count($this->validation_errors) === 0;
	}

	
	    public function find_by_id($id) {
        $sql = "SELECT visitors.Id, FirstName, LastName, CNP, UserName, Email, pictures.Location as picture_location
                FROM visitors
                JOIN pictures
                ON pictures.UserId = visitors.Id
                WHERE visitors.Id = :id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

	public function find_picture_by_id($id) {
        $sql = "SELECT Location
                FROM pictures
                WHERE UserId = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

}

class AppointmentsModel extends Model 
{
	public $VisitorId;
	public $DateOfAppointment;
	public $TimeOfAppointment;
	public $Visitor2FirstName;
	public $Visitor2LastName;
	public $Visitor2CNP;
	public $Visitor2Id;
	public $Visitor3FirstName;
	public $Visitor3LastName;
	public $Visitor3CNP;
	public $Visitor3Id;
	public $InmateId;
	

	public function initialize($VisitorId, $DateOfAppointment, $TimeOfAppointment, $Visitor2FirstName, $Visitor2LastName, $Visitor2CNP, $Visitor3FirstName, $Visitor3LastName, $Visitor3CNP) 
	{
		$this->VisitorId			= $VisitorId;
		$this->DateOfAppointment	= $DateOfAppointment;
		$this->TimeOfAppointment	= $TimeOfAppointment;
		$this->Visitor2FirstName	= $Visitor2FirstName;
		$this->Visitor2LastName		= $Visitor2LastName;
		$this->Visitor2CNP			= $Visitor2CNP;
		$this->Visitor2Id			= ($this->Visitor2CNP && $this->Visitor2LastName)? md5($this->Visitor2CNP . $this->Visitor2LastName): NULL;
		$this->Visitor3FirstName	= $Visitor3FirstName;
		$this->Visitor3LastName		= $Visitor3LastName;
		$this->Visitor3CNP			= $Visitor3CNP;
		$this->Visitor3Id			=($this->Visitor3CNP && $this->Visitor3LastName)? md5($this->Visitor3CNP . $this->Visitor3LastName): NULL;
		$_POST=$_SESSION['post_data'];
		
		$this->InmateId 			= $this->getInmateId($_POST['option_chosen'], $_POST['FirstName'], $_POST['LastName'], $_POST['dob']??NULL);
	}
	
	
	public function save()
	{
		$valid = $this->is_valid();
        if (!$valid)
            return false;
		
		$sql = "INSERT INTO appointments (VisitorId, DateOfAppointment , TimeOfAppointment, Visitor2FirstName, Visitor2LastName, Visitor2CNP, Visitor2Id, Visitor3FirstName, Visitor3LastName, Visitor3CNP, Visitor3Id , State, InmateId) 
		VALUES (:VisitorId, :DateOfAppointment, :TimeOfAppointment, :Visitor2FirstName, :Visitor2LastName, :Visitor2CNP, :Visitor2Id, :Visitor3FirstName, :Visitor3LastName, :Visitor3CNP, :Visitor3Id, :State, :InmateId)";
		$query = $this->db->prepare($sql);
		$query->bindValue(':VisitorId', $_SESSION['user_id']);
		$query->bindValue(':DateOfAppointment', $this->DateOfAppointment);
		$query->bindValue(':TimeOfAppointment', $this->TimeOfAppointment);
		$query->bindValue(':Visitor2FirstName', $this->Visitor2FirstName);
		$query->bindValue(':Visitor2LastName', $this->Visitor2LastName);
		$query->bindValue(':Visitor2CNP', $this->Visitor2CNP);
		$query->bindValue(':Visitor2Id', $this->Visitor2Id);
		$query->bindValue(':Visitor3FirstName', $this->Visitor3FirstName);
		$query->bindValue(':Visitor3LastName', $this->Visitor3LastName);
		$query->bindValue(':Visitor3CNP', $this->Visitor3CNP)	;
		$query->bindValue(':Visitor3Id', $this->Visitor3Id)	;
		$query->bindValue(':State', 'pending');
		$query->bindValue(':InmateId', $this->InmateId);
		
		$query->execute();
		return true;	
	}
	 public function is_valid() 
	 {		 
		 	//validare in functie de profil
		Validator::validate_profile($this, 'VisitorId');
		//validare in functie de vizitele pe care le are detinutul
		Validator::validate_remaining_visits($this, 'InmateId', 'VisitorId');	
		
		///
		
		Validator::validate_visitorId_exists($this, 'VisitorId');
		
		Validator::validate_date($this, 'DateOfAppointment');
		if(!isset($this->validation_errors['DateOfAppointment']))
            Validator::validate_date_not_in_past($this, 'DateOfAppointment');
		if(!isset($this->validation_errors['DateOfAppointment']))
			Validator::validate_date_no_more_than($this, 'DateOfAppointment');
		
		//validate timeofapp
		//timpul e luat ca secunde din dropdown
		
		 if (!empty($this->Visitor2FirstName) ||
            !empty($this->Visitor2LastName)  ||
            !empty($this->Visitor2CNP)) 
		{
            Validator::validate_name($this, 'Visitor2FirstName');
            Validator::validate_name($this, 'Visitor2LastName');
            Validator::validate_cnp($this, 'Visitor2CNP');
		}
		if (!empty($this->Visitor3FirstName) ||
            !empty($this->Visitor3LastName)  ||
            !empty($this->Visitor3CNP)) 
		{
            Validator::validate_name($this, 'Visitor3FirstName');
            Validator::validate_name($this, 'Visitor3LastName');
            Validator::validate_cnp($this, 'Visitor3CNP');
		}
		
		Validator::validate_inmateId_exists($this, 'InmateId');
		
	 return count($this->validation_errors) === 0;
	 }
	
    public function getAllAppointments() 
	{
        $sql = "SELECT appointments.Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId, State, inmates.FirstName as inmate_FirstName, inmates.LastName as inmate_LastName, visitors.FirstName as visitor_FirstName, visitors.LastName as visitor_LastName, institutions.Name as institution_Name, institutions.Location as institution_Location
                FROM appointments
                JOIN inmates
                ON appointments.InmateId = inmates.Id
                JOIN visitors
                ON appointments.VisitorId = visitors.Id
                JOIN institutions
                ON inmates.InstId = institutions.Id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllAppointmentsByVisitor($visitor_id)
    {
        $sql = "SELECT appointments.Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId, State, inmates.FirstName as inmate_FirstName, inmates.LastName as inmate_LastName, visitors.FirstName as visitor_FirstName, visitors.LastName as visitor_LastName, institutions.Name as institution_Name, institutions.Location as institution_Location
                FROM appointments
                JOIN inmates
                ON appointments.InmateId = inmates.Id
                JOIN visitors
                ON appointments.VisitorId = visitors.Id
                JOIN institutions
                ON inmates.InstId = institutions.Id
                WHERE visitors.Id = :visitorId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('visitorId', $visitor_id);
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
		
		$sql = "SELECT appointments.Id, VisitorId, DateOfAppointment, TimeOfAppointment, Visitor2FirstName, Visitor2LastName,Visitor3FirstName, Visitor3LastName, InmateId, State, inmates.FirstName as inmate_FirstName, inmates.LastName as inmate_LastName, visitors.FirstName as visitor_FirstName, visitors.LastName as visitor_LastName, institutions.Name as institution_Name, institutions.Location as institution_Location
                FROM appointments
                JOIN inmates
                ON appointments.InmateId = inmates.Id
                JOIN visitors
                ON appointments.VisitorId = visitors.Id
                JOIN institutions
                ON inmates.InstId = institutions.Id
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

	public function getInmateId($InstName, $FirstName, $LastName, $dob)
	{
		$InstId=$this->getInstId($InstName);
		$ok=0;
		if($dob!=NULL)
		{
			$ok=1;
			$sql ="SELECT Id FROM inmates WHERE FirstName = :FirstName AND LastName=:LastName AND InstId=:InstId AND DOB=:dob" ;
		}
		else 
			$sql ="SELECT Id FROM inmates WHERE FirstName = :FirstName AND LastName=:LastName AND InstId=:InstId" ;
		$query = $this->db->prepare($sql);
		$query->bindValue(':FirstName', $FirstName);
		$query->bindValue(':LastName', $LastName);
		$query->bindValue(':InstId', $InstId);
		if($ok==1)
			$query->bindValue(':dob', $dob);
		$query->execute();
		$Inmate = $query->fetch(PDO::FETCH_ASSOC);
		return $Inmate['Id'];		
	}


	public function getInstId($name)
	{
		$sql = "SELECT Id FROM institutions WHERE Name = :Name";
		$stmt = $this->db->prepare($sql);
 		$stmt->bindValue(':Name', $name);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['Id'];
	}
		
	
}
