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
	
	
}
