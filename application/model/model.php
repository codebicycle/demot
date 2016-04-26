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


	public function download_json_results($json_data, $name)
		{
			if( ! $name)
			{
				$name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.json';
			}	

			$fp = fopen($name, 'w');
			fwrite($fp, json_encode($json_data));
			fclose($fp);

		}
	
	
	
	
	public function download_csv_results($visits, $name)
		{
			if( ! $name)
			{
				$name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
			}	

			$fp = fopen($name, "w");
			foreach ($visits as $visit) 
			{
				fputcsv($fp, $visit);
			}

			fclose($fp);	
		}
			
	
}
