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
    private $whitelist_fields = array('FirstName', 'LastName', 'CNP', 'DOB', 'IncarcerationDate', 'ReleaseDate', 'LawyerFirstName', 'LawyerLastName', 'LawyerCNP');

    public function getAllInmates() {
        $sql = "SELECT Id, FirstName, LastName, CNP, InstId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate FROM inmates";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function initialize($object) {
        foreach ($this->whitelist_fields as $field) {
            $this->$field = trim($object[$field]);
        }
    }

    public function is_valid() {
        $this->validate_name('FirstName');
        $this->validate_name('LastName');
        $this->validate_cnp('CNP');
        $this->validate_date('DOB');
        $this->validate_date('IncarcerationDate');
        $this->validate_date('ReleaseDate');
        if (!empty($this->LawyerFirstName)) {
            $this->validate_name('LawyerFirstName');
            $this->validate_name('LawyerLastName');
            $this->validate_cnp('LawyerCNP');
        }

        return count($this->validation_errors) === 0;
    }

    private function validate($pattern, $message, $label) {
        if(preg_match($pattern, $this->$label)){
            unset($this->validation_errors[$label]);
        }
        else {
            $this->validation_errors[$label] = $message;
        }
    }

    private function validate_name($label) {
        $pattern = "/^[- 'a-zA-Z]{2,50}$/";
        $message = "Only letters, spaces, minus and single quote characters are permitted. Must have two or more characters.";
        $this->validate($pattern, $message, $label);
    }

    private function validate_cnp($label) {
        $pattern = '/\d{13}/';
        $message = "Please fill in a valid CNP.";
        $this->validate($pattern, $message, $label);

    }
    private function validate_date($label) {
        $pattern = '/^(\d{4})-(\d{2})-(\d{2})$/';
        $message = "Please fill in a valid date.";
        $this->validate($pattern, $message, $label);
    }
}
