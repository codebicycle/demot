<?php

class Model
{
    private $validation_errors = array();

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
    public $FirstName;
    public $LastName;
    public $CNP;
    public $DOB;
    public $IncarcerationDate;
    public $ReleaseDate;
    public $LawyerFirstName;
    public $LawyerLastName;
    public $LawyerCNP;

    public function getAllInmates() {
        $sql = "SELECT Id, FirstName, LastName, CNP, InstId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate FROM inmates";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function initialize($object) {
        $this->FirstName = $object['FirstName'];
    }

    public function is_valid() {
        $this->validate_name($this->FirstName,  'FirstName');
        $this->validate_name($this->LastName, 'LastName');
        $this->validate_cnp($this->CNP, 'CNP');
        $this->validate_date($this->DOB, 'DOB');
        $this->validate_date($this->IncarcerationDate, 'IncarcerationDate');
        $this->validate_date($this->ReleaseDate, 'ReleaseDate');
        $this->validate_name($this->LawyerFirstName, 'LawyerFirstName');
        $this->validate_name($this->LawyerLastName, 'LawyerLastName');
        $this->validate_cnp($this->LawyerCNP, 'LawyerCNP');

        return count($this->validation_errors) === 0;
    }

    private function validate_name($input, $label) {
        $this->validation_errors[$label] = "Only letters, spaces, minus and single quote characters are permitted. Must have two or more characters.";
    }
    private function validate_cnp($input, $label) {
        $this->validation_errors[$label] = "Please fill in a valid CNP.";
    }
    private function validate_date($input, $label) {
        $this->validation_errors[$label] = "Please fill in a valid date.";
    }
}
