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


	public function download_json_results($visits)
		{
			
			$name = 'JSONExport';
			$filelocation = '';
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

	public function download_csv_results($visits)
		{
			$name = 'CSVExport';
			$filelocation = '';
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
		}
			
	
}
