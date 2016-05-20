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

      
      public function export_visits($arr, $name)
      { $exp=$_POST['export_press']??NULL;
        $ext=$_POST['extension']??NULL;
        if($exp)
        {
      
          if($ext=="html")
          {
            echo "EXPORT HTML";
			//header('location: '.URL. $file_export);
			//die();
          }
      
      
      
          if($ext=="csv")
          {
            
            $filelocation = 'export/';
            $filename     = $name.date('Y-m-d H.i.s').'.csv';
            $file_export  =  $filelocation . $filename;
            $data = fopen($file_export, 'w');
            $csv_data=array();  
			
            foreach($arr as $elem)
            {  
              fputcsv($data, (array)$elem);
			}
            fclose($data);
			header('location: '.URL. $file_export);
			die();
          }
        
          if($ext=="json")
          {
           
            $filelocation = 'export/';
            $filename     = $name.date('Y-m-d H.i.s').'.json';
            $file_export  =  $filelocation . $filename;
            $data = fopen($file_export, 'w');
            $json_data=array();  
        
            foreach($arr as $elem)
            {  
              array_push($json_data,(array)$elem);  
            }
            fwrite($data, json_encode($json_data));
            fclose($data);
			header('Content-Type: application/json');
			header('Content-Disposition: attachment; filename='.$file_export);
			header('Pragma: no-cache');
			readfile($file_export);
					
			die();
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
				WHERE State = 'approved'
				ORDER BY DateOfAppointment ASC, TimeOfAppointment ASC";
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
				WHERE State = 'pending'
				ORDER BY DateOfAppointment ASC, TimeOfAppointment ASC";
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
          
          $appId=$appointment->Id;
          $sql="SELECT GuardId 
				FROM appointments 
				WHERE Id=:id";
          $query = $this->db->prepare($sql);
          $query->bindValue(':id',$appId);
          $query->execute();      
          $guard = $query->fetch();
		  
          if(!empty($guard->GuardId))
		  {  
			echo "By inmate";
		  }
          else 
            echo "Automatic";
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
            $filelocation = 'uploadimg/' . $id;
			
			move_uploaded_file($_FILES["uploadImage"]["tmp_name"] , $filelocation);
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
			$stmt->bindValue(':Location', $filelocation);
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

    public function decrement_visits($id) {
      $sql="UPDATE remainingvisits
        SET Remainingvisits=Remainingvisits - 1
        WHERE InmateId = :id";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue('id',$id);
      $stmt->execute();
    }

    public function increment_visits($id) {
      $sql="UPDATE remainingvisits
        SET Remainingvisits=Remainingvisits + 1
        WHERE InmateId = :id";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue('id',$id);
      $stmt->execute();
    }

	public function is_banned($id)
	{
		return strtotime($this->ban_end_date($id)) > strtotime(date("Y-m-d"));
		
	}
	
	public function ban_end_date($id) {
		$sql = "SELECT EndDate
				FROM bans
				WHERE InmateId = :inmateId
				ORDER BY EndDate DESC
				LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('inmateId', $id);
        $stmt->execute();
		
        return ($stmt->fetch()->EndDate);
    }
	
	public function getAllInstitutions() {
       $sql = "SELECT Id, Name, Location
               FROM institutions";
       $stmt = $this->db->prepare($sql);
       $stmt->execute();
       return $stmt->fetchAll();
   }
	
}


class StatisticsModel extends Model {

	public function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		return sprintf($format, $hours, $minutes);
	}

	public function get_visits_per_institution()
	{
		$sql="SELECT COUNT(1) AS num_visits, institutions.Name, institutions.Location  
			  FROM visits
			  JOIN appointments
			  ON visits.AppointmentId=appointments.Id
			  JOIN inmates
			  ON appointments.InmateId = inmates.Id
			  JOIN institutions
			  ON institutions.Id=inmates.InstId
			  GROUP by institutions.Id
			  ORDER BY num_visits DESC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
		
	}
	public function get_visited_inmates()
	{
		$sql="SELECT COUNT(1) AS num_visits_inmate, inmates.FirstName, inmates.LastName, institutions.Name, institutions.Location, AVG(visits.InmateEmotionalState) as emotionalState, AVG(visits.InmatePhisicalState) as phisicalState , AVG(visits.Duration) as duration
			  FROM visits
			  JOIN appointments
			  ON visits.AppointmentId=appointments.Id
			  JOIN inmates
			  ON appointments.InmateId = inmates.Id
			  JOIN institutions
			  ON institutions.Id=inmates.InstId
			  GROUP by institutions.Id
			  ORDER BY num_visits_inmate DESC
			  LIMIT 3";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
		      
	}
	public function get_visitors_visits()
	{
		$sql="SELECT COUNT(1) AS visits, visitors.FirstName, visitors.LastName
			  FROM appointments
			  JOIN visitors
			  ON appointments.visitorId = visitors.Id
			  WHERE State= 'done'
			  GROUP By appointments.VisitorId
			  ORDER BY visits DESC
			  LIMIT 10";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();	
	}
	
	public function get_banned_inmates()
	{
		$sql="SELECT COUNT(1) AS num_bans_inmate, inmates.FirstName, inmates.LastName, institutions.Name, institutions.Location
			  FROM bans
			  JOIN inmates
			  ON bans.InmateId = inmates.Id
			  JOIN institutions
			  ON institutions.Id=inmates.InstId
			  GROUP by inmates.Id
			  ORDER BY num_bans_inmate DESC
			  LIMIT 3";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	public function get_most_active_guard()
	{
		
		//TODO count approved and rejected
		$sql="SELECT COUNT(1) AS num_active_guard, admins.UserName, institutions.Name, institutions.Location
			  FROM admins
			  JOIN appointments
			  ON admins.Id=appointments.GuardId
			  JOIN institutions
			  ON institutions.Id=admins.InstId
			  GROUP by admins.Id
			  ORDER BY num_active_guard DESC
			  LIMIT 3";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	
	}
	public function get_average_visit_duration()
	{
		
		$sql="SELECT AVG(Duration) as duration, institutions.Name, institutions.Location
			  FROM visits
			  JOIN appointments
			  ON visits.AppointmentId=appointments.Id
			  JOIN inmates
			  ON appointments.InmateId=inmates.Id
			  JOIN institutions
			  ON institutions.Id=inmates.InstId
			  GROUP by institutions.Id
			  ORDER BY duration DESC";
		  
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	public function get_popular_hour()
	{
		$sql="SELECT COUNT(1) AS num_hour, TimeOfAppointment
			  FROM appointments
			  GROUP BY TimeOfAppointment
			  ORDER By num_hour DESC
			  LIMIT 5";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
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
		
		$sql="INSERT INTO remainingvisits(InmateId,RemainingVisits)
			  VALUES(:id, :remainingvisits)";
		$stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $this->Id);
        $stmt->bindValue('remainingvisits', '5');
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
        $sql = "SELECT inmates.Id, FirstName, LastName, CNP, DOB, InstId, Crime, Sentence, IncarcerationDate, ReleaseDate, LawyerId, RemainingVisits
                FROM inmates
                LEFT JOIN remainingvisits
                ON inmates.Id = remainingvisits.InmateId
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch();
		
    }

	public function find_inmate_by_name($FirstName, $LastName, $InstId, $dob)
	{
		if($dob)
		{
			$sql = "SELECT Id
				FROM inmates 
				WHERE FirstName = :FirstName 
				AND LastName=:LastName 
				AND InstId=:InstId 
				AND DOB=:dob" ;
		}
		else 
		{
			$sql = "SELECT Id 
				FROM inmates 
				WHERE FirstName = :FirstName 
				AND LastName=:LastName 
				AND InstId=:InstId";
		}
		$query = $this->db->prepare($sql);
		$query->bindValue(':FirstName', $FirstName);
		$query->bindValue(':LastName', $LastName);
		$query->bindValue(':InstId', $InstId);
		if($dob)
			$query->bindValue(':dob', $dob);
		$query->execute();
		return $query->fetchAll();
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

    public function lift_ban($id) {
        $sql = "UPDATE bans
                SET EndDate = :newEndDate
                WHERE InmateId = :inmateId
                AND   EndDate >= :endDate";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('inmateId', $id);
        $stmt->bindValue('newEndDate', date("Y-m-d", strtotime("-1 day")));
        $stmt->bindValue('endDate', date("Y-m-d"));
        $stmt->execute();

        return true;
    }


    public function ban($id, $mysql_string_period) {
        $end_date = $this->ban_end_date($id);

        $sql = "INSERT INTO bans(InmateId, StartDate, EndDate) 
                VALUES(:inmateId, :startDate, :endDate)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('inmateId', $id);
        $stmt->bindValue('startDate', date("Y-m-d"));

        $new_end_date = date("Y-m-d", strtotime($mysql_string_period, strtotime($end_date)));
        if (strtotime($end_date) >= strtotime(date("Y-m-d"))) {
             $stmt->bindValue('endDate', $new_end_date);
        }
        else {
            $stmt->bindValue('endDate', date("Y-m-d", strtotime($mysql_string_period)));
        }

        $stmt->execute();
        return true;
    }
}


class AdminsModel extends Model {
	public $Id;
    public $UserName;
    public $OldPasswordHash;
    public $Password;
    public $RepeatPassword;
    public $PasswordHash;
	public $admin_UserName;
    public $admin_LastName;
	public $admin_CNP;
    public $admin_Password;
    public $admin_RepeatPassword;
    public $admin_PasswordHash;
	public $admin_InstId;
	public $admin_Rank;
	public $admin_IdHash;
	public $login_UserName;
	public $login_Password;
	

	public function getAllAdmins()
	{
		$sql="SELECT admins.Id, InstId, UserName, Rank, institutions.Name as InstName
		      FROM admins
			  JOIN institutions
			  ON institutions.Id= admins.InstId";
		$stmt = $this->db->prepare($sql);			  
        $stmt->execute();
		$admins=$stmt->fetchAll();
		return $admins;		
	}
	
	public function getAllGuards_by_rank_and_inst($InstId, $Rank)
	{
		$sql="SELECT admins.Id, InstId, UserName, Rank, institutions.Name as InstName
		      FROM admins
			  JOIN institutions
			  ON institutions.Id= admins.InstId
			  WHERE admins.InstId=:id
			  AND admins.Rank>:rank";
		$stmt = $this->db->prepare($sql);			  
		$stmt->bindValue(':id', $InstId);
		$stmt->bindValue(':rank', $Rank);
        $stmt->execute();
		$admins=$stmt->fetchAll();
		return $admins;
		
	}
	
    public function initialize($Id, $UserName, $OldPassword, $Password, $RepeatPassword) {
        $this->Id               = $Id;
        $this->UserName         = $UserName;
        $this->OldPasswordHash  = md5($OldPassword);
        $this->Password         = $Password;
        $this->RepeatPassword   = $RepeatPassword;
        $this->PasswordHash     = md5($Password);
    }

    public function is_valid()
    {
        Validator::validate_string_length($this, 'UserName',3 , 50);
        if(!isset($this->validation_errors['UserName'])) {
            Validator::validate_admin_unique_username($this, 'UserName');
        }
        if(!empty($this->Password)) {
            // validate old password
            Validator::validate_admin_correct_password($this, 'OldPassword');
            // validate password length
            Validator::validate_string_length($this, 'Password', 2, 32);
            // validate repeat password matches
            if(!isset($this->validation_errors['Password'])) {
                Validator::validate_passwords_match($this, 'Password', 'RepeatPassword');
            }
        }

        return count($this->validation_errors) === 0;
    }

public function initialize_add($UserName, $LastName, $CNP, $Password, $RepeatPassword, $InstId, $Rank) 
	{
        $this->admin_UserName         = $UserName;
        $this->admin_LastName  		  = $LastName;
		$this->admin_CNP			  = $CNP;
        $this->admin_Password         = $Password;
        $this->admin_RepeatPassword   = $RepeatPassword;
		$this->admin_InstId           = $InstId;
		$this->admin_Rank	          = $Rank;
		$this->admin_PasswordHash     = md5($this->admin_Password);
		$this->admin_IdHash			  = md5($this->admin_CNP . $this->admin_LastName);
    }

    public function is_valid_add()
    {
        Validator::validate_string_length($this, 'admin_UserName',3 , 50);
        if(!isset($this->validation_errors['admin_UserName'])) 
		{
            Validator::validate_admin_unique_username($this, 'admin_UserName');
        }
		Validator::validate_string_length($this, 'admin_LastName',3 , 50);
		Validator::validate_cnp($this, 'admin_CNP');          
        Validator::validate_string_length($this, 'admin_Password', 2, 32);
        // validate repeat password matches
        if(!isset($this->validation_errors['admin_Password']))
		{
			Validator::validate_passwords_match($this, 'admin_Password', 'admin_RepeatPassword');
        }
       return count($this->validation_errors) === 0;
    }	
	
	public function add_admin()
	{
		$valid = $this->is_valid_add();
        if (!$valid)
            return false;
		
		$sql="SELECT Id
			  FROM admins
			  WHERE UserName =:username
			  OR Id =:id " ;
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':username', $this->admin_UserName);
		$stmt->bindValue(':id', $this->admin_IdHash);
		$stmt->execute();
		$doubleacc=$stmt->fetch();
		if(empty($doubleacc))
		{		
			$sql = "INSERT INTO admins (Id, InstId, UserName, PwdHash, Rank) 
					VALUES (:IdHash, :InstId, :UserName, :Password, :Rank)";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(':IdHash', $this->admin_IdHash);
			$stmt->bindValue(':InstId', $this->admin_InstId);
			$stmt->bindValue(':UserName', $this->admin_UserName);
			$stmt->bindValue(':Password', $this->admin_PasswordHash);
			$stmt->bindValue(':Rank', $this->admin_Rank);
			$result = $stmt->execute();
            if($result)
				return true;
		}
		else 
			$this->validation_errors['adderror']="An account with this username or id already exists.";
		return false;
	}
	
	
    public function update() {
        $valid = $this->is_valid();
        if (!$valid)
            return false;

        if(empty($this->Password)) {
            $sql = "UPDATE `admins` SET `UserName`=:UserName
                    WHERE Id=:Id";
        }
        else {
            $sql = "UPDATE `admins` SET `UserName`=:UserName, `PwdHash`=:PwdHash
                    WHERE Id=:Id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':UserName', $this->UserName);
        if(!empty($this->Password)) {
            $stmt->bindValue(':PwdHash', $this->PasswordHash);
        }
        $stmt->bindValue(':Id', $this->Id);
        $result = $stmt->execute();

        if($result) {
            $_SESSION['username'] = $this->UserName;
        }
        return true;
    }
	
	
	public function initialize_login($UserName, $Password) {
		$this->login_UserName = $UserName;
		$this->login_Password = md5($Password);
	}
	public function login()
	{
		$valid = $this->is_valid_login();
        if (!$valid)
            return false;
		
		$sql = "SELECT Id, UserName, PwdHash, Rank
				FROM admins WHERE UserName = :UserName";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':UserName', $this->login_UserName);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($this->login_Password==$user['PwdHash'])
		{
			session_destroy();
			session_start();
			$_SESSION['admin_id'] = $user['Id']; 
			$_SESSION['rank'] = $user['Rank'];
			$_SESSION['username'] = $user['UserName'];         
			return true;		 
		}
        $this->validation_errors['Noadmin']='Incorrect username / password combination!';
		return;
	}
	
	public function is_valid_login() 
	{
        Validator::validate_string_length($this, 'login_UserName',3 , 50);
        Validator::validate_string_length($this, 'login_Password', 2, 32);	
		return count($this->validation_errors) === 0;
	}
	

    public function find_by_id($id) {
        $sql = "SELECT Id, UserName
                FROM admins
                WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
	
	 public function destroy($id) 
	 {
        $sql = "DELETE from admins
                WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return boolval($stmt->rowCount());
    }
	
	public function getInstId_by_id($id)
	{
		$sql = "SELECT InstId
				FROM admins
                WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
		return $stmt->fetch();
	}

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


class VisitorsModel extends Model {
	public $Id;
	public $UserName;
	public $FirstName;
	public $LastName;
	public $Email;
	public $CNP;
    public $OldPasswordHash;
	public $Password;
	public $RepeatPassword;
    public $PasswordHash;
	public $UploadImage;
	public $login_UserName;
	public $login_Password;
	public $register_UserName;
	public $register_FirstName;
	public $register_LastName;
	public $register_Email;
	public $register_CNP;
	public $register_Passwort;
	public $register_RepeatPassword;
	public $register_uploadImage;
	public $register_IdHash;
	
	
	public function initialize($Id, $UserName, $FirstName, $LastName, $Email, $CNP, $OldPassword, $Password, $RepeatPassword, $UploadImage) {
		$this->Id		        = $Id;
		$this->UserName			= $UserName;
		$this->FirstName		= $FirstName;
		$this->LastName			= $LastName;
		$this->Email			= $Email;
		$this->CNP				= $CNP;
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
        Validator::validate_string_length($this, 'UserName',3 , 50);
        if(!isset($this->validation_errors['UserName'])) {
            Validator::validate_visitor_unique_username($this, 'UserName');
        }
		Validator::validate_name($this, 'FirstName');
		Validator::validate_name($this, 'LastName');
		Validator::validate_email($this, 'Email');
		Validator::validate_cnp($this, 'CNP');

        if(!empty($this->Password)) {
            // validate old password
            Validator::validate_visitor_correct_password($this, 'OldPassword');
            // validate password length
            Validator::validate_string_length($this, 'Password', 2, 32);
            // validate repeat password matches
            if(!isset($this->validation_errors['Password'])) {
                Validator::validate_passwords_match($this, 'Password', 'RepeatPassword');
            }
        }
		
		return count($this->validation_errors) === 0;
	}
	
	
	public function initialize_register($UserName, $FirstName, $LastName, $Email, $CNP, $Password, $RepeatPassword, $UploadImage) 
	{
		$this->register_UserName		= $UserName;
		$this->register_FirstName		= $FirstName;
		$this->register_LastName		= $LastName;
		$this->register_Email			= $Email;
		$this->register_CNP				= $CNP;
		$this->register_Password		= $Password;
		$this->register_RepeatPassword	= $RepeatPassword;
		$this->register_PasswordHash	= md5($this->register_Password);
		$this->register_uploadImage		= $UploadImage;	
		$this->register_IdHash			= md5($this->register_CNP . $this->register_LastName);
	}
	
	public function register()
	{
		$valid = $this->is_valid_register();
        if (!$valid)
            return false;
		
		$sql="SELECT Id
			  FROM visitors
			  WHERE UserName =:username
			  OR Id =:id " ;
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':username', $this->register_UserName);
		$stmt->bindValue(':id', $this->register_IdHash);
		$stmt->execute();
		$doubleacc=$stmt->fetch();
		if(empty($doubleacc))
		{			
			$sql = "INSERT INTO visitors (Id, FirstName, LastName, CNP, UserName, PwdHash, Email)
					VALUES (:IdHash, :FirstName, :LastName, :CNP, :UserName, :Password, :Email)";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(':IdHash', $this->register_IdHash);
			$stmt->bindValue(':FirstName', $this->register_FirstName);
			$stmt->bindValue(':LastName', $this->register_LastName);
			$stmt->bindValue(':CNP', $this->register_CNP);
			$stmt->bindValue(':UserName', $this->register_UserName);
			$stmt->bindValue(':Password', $this->register_PasswordHash);
			$stmt->bindValue(':Email', $this->register_Email);
			$result = $stmt->execute();
		
			if($result)
			{
				if(!empty($this->register_uploadImage['name']))
				{
					$this->uploadPicture($this->register_IdHash,"create");
				}
				session_start();
				$_SESSION['user_id'] 	= $this->register_IdHash;  
				$_SESSION['username']	=$this->register_UserName;      
				return;
			}
			else 
			{
				$this->validation_errors['registererror']="Couldn`t register";
				return false;
			}
		}
		else 
			$this->validation_errors['registererror']="An account with this username or id already exists.";
			return false;
		
	}
	
	public function is_valid_register()
	{
        Validator::validate_string_length($this, 'register_UserName',3 , 50);
        if(!isset($this->validation_errors['register_UserName']))
		{
            Validator::validate_visitor_unique_username($this, 'register_UserName');
        }
				
		Validator::validate_name($this, 'register_FirstName');
		Validator::validate_name($this, 'register_LastName');
		Validator::validate_email($this, 'register_Email');
		Validator::validate_cnp($this, 'register_CNP');
        Validator::validate_string_length($this, 'register_Password', 2, 32);
		if(!isset($this->validation_errors['register_Password'])) 
		{
            Validator::validate_passwords_match($this, 'register_Password', 'register_RepeatPassword');
        }
		return count($this->validation_errors) === 0;
	}
	
	public function initialize_login($UserName, $Password) {
		$this->login_UserName = $UserName;
		$this->login_Password = md5($Password);
	}
	public function login()
	{
		$valid = $this->is_valid_login();
        if (!$valid)
            return false;
		
		$sql = "SELECT Id, UserName, PwdHash FROM visitors WHERE UserName = :UserName";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':UserName', $this->login_UserName);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($this->login_Password==$user['PwdHash'])
		{
			session_destroy();
			session_start();
			$_SESSION['user_id'] = $user['Id'];           
			$_SESSION['username'] = $user['UserName'];           
			return true;		 
		}
        $this->validation_errors['Novisitor']='Incorrect username / password combination!';
		return;
	}
	
	public function is_valid_login() 
	{
        Validator::validate_string_length($this, 'login_UserName',3 , 50);
        Validator::validate_string_length($this, 'login_Password', 2, 32);	
		return count($this->validation_errors) === 0;
	}
	

	
	public function find_by_id($id) {
		$sql="SELECT Location 
			  FROM pictures	
			  WHERE UserId =:id";
		$stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $loc = $stmt->fetch();
		if($loc)
		{
        $sql = "SELECT visitors.Id, FirstName, LastName, CNP, UserName, Email, pictures.Location as picture_location
                FROM visitors
                JOIN pictures
                ON pictures.UserId = visitors.Id
                WHERE visitors.Id = :id
                LIMIT 1";
		}
		else 
		{
			$sql = "SELECT Id, FirstName, LastName, CNP, UserName, Email
                FROM visitors
				WHERE visitors.Id = :id
                LIMIT 1";
		}
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


class AppointmentsModel extends Model {
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
		$this->Visitor3Id			= ($this->Visitor3CNP && $this->Visitor3LastName)? md5($this->Visitor3CNP . $this->Visitor3LastName): NULL;
		$this->InmateId				= $_SESSION['inmateid']	;
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
		if(Validator::check_lawyer($this,$this->InmateId, $this->VisitorId))
		{
			$query->bindValue(':State', 'approved');
		}
		else
		{
			$query->bindValue(':State', 'pending');
		}
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
				
		Validator::validate_visitorId_exists($this, 'VisitorId');
		
		Validator::validate_date($this, 'DateOfAppointment');
		if(!isset($this->validation_errors['DateOfAppointment']))
            Validator::validate_date_not_in_past($this, 'DateOfAppointment');
		if(!isset($this->validation_errors['DateOfAppointment']))
			Validator::validate_date_no_more_than($this, 'DateOfAppointment');
		//validez sa nu mai fie o programare la acea ora
		Validator::validate_double_appointment($this, $this->DateOfAppointment, $this->TimeOfAppointment, $this->InmateId);
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
	
	public function getRemainingVisits($InmateId)
	{
		$sql= "SELECT RemainingVisits
			   FROM remainingvisits
			   WHERE InmateId =:id";
		$stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $InmateId);
        $stmt->execute();
		$remainingvisits = $stmt->fetch();
		
		return $remainingvisits->RemainingVisits;
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
                WHERE visitors.Id = :visitorId
				ORDER BY DateOfAppointment ASC, TimeOfAppointment ASC";
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
				WHERE inmates.InstId=:id
				ORDER BY DateOfAppointment ASC, TimeOfAppointment ASC";
			
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue('id', $instid);
        $stmt->execute();
        return $stmt->fetchAll();
	}

	public function approve_appointment($Id, $GuardId)
	{
		//trebuie facut ceva pentru appointmet-urile de luna viitoare.
		$this->setState($Id, 'approved');
		$this->setGuard($Id, $GuardId);
		
		$sql= "SELECT InmateId
			   FROM appointments
			   WHERE Id =:id";
		$stmt = $this->db->prepare($sql);
    $stmt->bindValue('id', $Id);
    $stmt->execute();
		$result= $stmt->fetch();
		
		$this->decrement_visits($result->InmateId);
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
 