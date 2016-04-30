<?php

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

// Model naming convention: Controller_name + 'Model'

class HomeModel extends Model {}

class ErrorzModel extends Model {}

class Validator {

    private static function validate($model, $key, $pattern, $message, $err_label) {
        if(!preg_match($pattern, $model->$key)) {
            $model->validation_errors[$err_label ?? $key] = $message;
        }
    }

    public static function validate_name($model, $key, $err_label=null) {
        $pattern = "/^[- 'a-zA-Z]{2,50}$/";
        $message = "Only letters, spaces, minus and single quote characters are permitted. Must have two or more characters.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    public static function validate_cnp($model, $key, $err_label=null) {
        $pattern = "/\d{13}/";
        $message = "Please fill in a valid CNP.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    private static function is_valid_date($input) {
        $pattern = "/^(\d{4})[-\/ .]?(\d{1,2})[-\/ .]?(\d{1,2})$/";
        if (preg_match($pattern, $input, $matches)) {
            if(checkdate($matches[2], $matches[3], $matches[1])) {
                return true;
            }
        }
        return false;
    }

    public static function validate_date($model, $key, $err_label=null) {
        $message = "Please fill in a valid date.";
        if (Validator::is_valid_date($model->$key))
            return;
        $model->validation_errors[$err_label ?? $key] = $message;
    }

    public static function validate_date_not_in_future ($model, $key, $err_label=null) {
        $message = "Date can not be in the future.";
        $date = $model->$key;
        if(Validator::is_valid_date($date) &&
            strtotime($date) < time() )
            return;
        $model->validation_errors[$err_label ?? $key] = $message;
    }

    public static function is_date1_before_date2($date1, $date2) {
        return strtotime($date1) <= strtotime($date2);
    }

    public static function validate_dates_in_order($model, $key1, $key2) {
      $message = 'Time flows in one direction. Check the order of dates.';
      if (!Validator::is_date1_before_date2($model->$key1, $model->$key2)) {
        $model->validation_errors[$key1] = $message;
        $model->validation_errors[$key2] = $message;
      }
    }

    public static function validate_not_empty($model, $key, $err_label=null) {
        $pattern = "/.+/";
        $message = "Field can not be empty.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    public static function validate_sentence($model, $key, $err_label=null) {
        $pattern = "/\d{1,2}/";
        $message = "Between 1 and 99.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    public static function validate_no_inmate_with_id($model, $key, $err_label=null) {
        $message = "Credentials match an existing inmate.";
        $exists = Validator::inmateId_exists($model, $model->$key);
        if ($exists) {
            $model->validation_errors[$err_label ?? $key] = $message;
        }
    }

    public static function validate_institutionId_exists($model, $key, $err_label=null) {
        $exists = Validator::instId_exists($model, $model->$key);
        if (!$exists) {
            $message = "Not a valid Institution id.";
            $model->validation_errors[$err_label ?? $key] = $message; 
        }
    }

    private static function instId_exists($model, $id) {
        $sql = "SELECT Id FROM institutions WHERE id=:id LIMIT 1";
        $query = $model->db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $exists = $query->fetchColumn();
        if ($exists)
            return true;
        return false;
    }

    private static function inmateId_exists($model, $id) {
        $sql = "SELECT 1 FROM inmates WHERE id=:id LIMIT 1";
        $stmt = $model->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $exists = $stmt->fetchColumn();
        if($exists)
            return true;
        return false;
    }
}

class InmatesModel extends Model {
    public $id;
    public $firstName;
    public $lastName;
    public $CNP;
    public $DOB;
    public $instId;
    public $crime;
    public $sentence;
    public $incarcerationDate;
    public $releaseDate;
    public $lawyerFirstName;
    public $lawyerLastName;
    public $lawyerCNP;
    public $lawyerId;

    public function initialize($firstName, $lastName, $CNP, $DOB, 
            $instId, $crime, $sentence, $incarcerationDate, $releaseDate, 
            $lawyerFirstName, $lawyerLastName, $lawyerCNP) {
        $this->firstName            = $firstName;
        $this->lastName             = $lastName;
        $this->CNP                  = $CNP;
        $this->DOB                  = $DOB;
        $this->instId               = $instId;
        $this->crime                = $crime;
        $this->sentence             = $sentence;
        $this->incarcerationDate    = $incarcerationDate;
        $this->releaseDate          = $releaseDate;
        $this->lawyerFirstName      = $lawyerFirstName;
        $this->lawyerLastName       = $lawyerLastName;
        $this->lawyerCNP            = $lawyerCNP;
        $this->id       = ($this->CNP && $this->lastName) 
                            ? md5($this->CNP . $this->lastName) 
                            : null;
        $this->lawyerId = ($this->lawyerCNP && $this->lawyerLastName) 
                            ? md5($this->lawyerCNP . $this->lawyerLastName) 
                            : null;
    }

    private function is_valid() {
        Validator::validate_name($this, 'firstName');
        Validator::validate_name($this, 'lastName');
        Validator::validate_cnp($this, 'CNP');
        // Id not in inmates table
        Validator::validate_no_inmate_with_id($this, 'id');
        Validator::validate_institutionId_exists($this, 'instId');
        Validator::validate_date_not_in_future($this, 'DOB');
        Validator::validate_date_not_in_future($this, 'incarcerationDate');
        Validator::validate_date($this, 'releaseDate');
        if (!isset($this->validation_errors['incarcerationDate']) &&
            !isset($this->validation_errors['releaseDate'])) {
            Validator::validate_dates_in_order($this, 'incarcerationDate', 
                'releaseDate');
        }
        Validator::validate_not_empty($this, 'crime');
        Validator::validate_sentence($this, 'sentence');
        if (!empty($this->lawyerFirstName) ||
            !empty($this->lawyerLastName)  ||
            !empty($this->lawyerCNP)) {
            Validator::validate_name($this, 'lawyerFirstName');
            Validator::validate_name($this, 'lawyerLastName');
            Validator::validate_cnp($this, 'lawyerCNP');
            // lawyerId not in inmates table
            Validator::validate_no_inmate_with_id($this,'lawyerId');
        }

        return count($this->validation_errors) === 0;
    }

    public function getAllInmates() {
        $sql = "SELECT Id, FirstName, LastName, CNP, InstId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate 
                FROM inmates";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function save() {
        $valid = $this->is_valid();
        if (!$valid)
            return false;
        // save to database
        $sql = "INSERT INTO inmates(Id, FirstName, LastName, CNP, DOB, InstId, Crime, Sentence, IncarcerationDate, ReleaseDate, LawyerId) 
                VALUES(:id, :firstName, :lastName, :CNP, :DOB, :instId, :crime, :sentence, :incarcerationDate, :releaseDate, :lawyerId)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('id', $this->id);
        $stmt->bindValue('firstName', $this->firstName);
        $stmt->bindValue('lastName', $this->lastName);
        $stmt->bindValue('CNP', $this->CNP);
        $stmt->bindValue('DOB', $this->DOB);
        $stmt->bindValue('instId', $this->instId, PDO::PARAM_INT);
        $stmt->bindValue('crime', $this->crime);
        $stmt->bindValue('sentence', $this->sentence);
        $stmt->bindValue('incarcerationDate', $this->incarcerationDate);
        $stmt->bindValue('releaseDate', $this->releaseDate);
        $stmt->bindValue('lawyerId', $this->lawyerId);
        $stmt->execute();
        return true;
    }    
}

class AdminsModel extends Model {}

class VisitorsModel extends Model {}

class AppointmentsModel extends Model {}
