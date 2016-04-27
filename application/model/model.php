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

class Validator {
    private static function validate($model, $key, $pattern, $err_label, $message) {
        if(preg_match($pattern, $model->$key)) {
            unset($model->validation_errors[$err_label]);
        }
        else {
            $model->validation_errors[$err_label] = $message;
        }
    }

    public static function validate_name($model, $key, $err_label) {
        $pattern = "/^[- 'a-zA-Z]{2,50}$/";
        $message = "Only letters, spaces, minus and single quote characters are permitted. Must have two or more characters.";
        Validator::validate($model, $key, $pattern, $err_label, $message);
    }

    public static function validate_cnp($model, $key, $err_label) {
        $pattern = "/\d{13}/";
        $message = "Please fill in a valid CNP.";
        Validator::validate($model, $key, $pattern, $err_label, $message);
    }

    public static function validate_date($model, $key, $err_label) {
        $pattern = "/^(\d{4})[-\/ .]?(\d{1,2})[-\/ .]?(\d{1,2})$/";
        $message = "Please fill in a valid date.";
        if (preg_match($pattern, $model->$key, $matches)) {
            if(checkdate($matches[2], $matches[3], $matches[1])) {
                unset($model->validation_errors[$err_label]);
                return true;
            }
        }
        $model->validation_errors[$err_label] = $message;
        return false;
    }

    public static function validate_exists($model, $key, $err_label) {
        $pattern = "/.+/";
        $message = "Field can not be empty.";
        Validator::validate($model, $key, $pattern, $err_label, $message);
    }

    public static function validate_sentence($model, $key, $err_label) {
        $pattern = "/\d{1,2}/";
        $message = "Between 1 and 99.";
        Validator::validate($model, $key, $pattern, $err_label, $message);
    }
}

class InmatesModel extends Model {

    public function getAllInmates() {
        $sql = "SELECT Id, FirstName, LastName, CNP, InstId, DOB, Sentence, Crime, IncarcerationDate, ReleaseDate FROM inmates";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function initialize($arr) {
        $this->FirstName          = clean($arr, 'FirstName');
        $this->LastName           = clean($arr, 'LastName');
        $this->CNP                = clean($arr, 'CNP');
        $this->Id                 = ($this->CNP && $this->LastName) 
                                        ? md5($this->CNP . $this->LastName) 
                                        : null;
        $this->DOB                = clean($arr, 'DOB');
        $this->InstId             = clean($arr, 'InstId');
        $this->Crime              = clean($arr, 'Crime');
        $this->Sentence           = clean($arr, 'Sentence');
        $this->IncarcerationDate  = clean($arr, 'IncarcerationDate');
        $this->ReleaseDate        = clean($arr, 'ReleaseDate');
        $this->LawyerFirstName    = clean($arr, 'LawyerFirstName');
        $this->LawyerLastName     = clean($arr, 'LawyerLastName');
        $this->LawyerCNP          = clean($arr, 'LawyerCNP');
        $this->LawyerId           = ($this->LawyerCNP && $this->LawyerLastName) 
                                        ? md5($this->LawyerCNP . $this->LawyerLastName) 
                                        : null;
    }

    public function save() {
        $valid = $this->is_valid();
        if (!$valid)
            return false;
        // save to database
        return true;
    }

    private function is_valid() {
        Validator::validate_name($this, 'FirstName', 'FirstName');
        Validator::validate_name($this, 'LastName',  'LastName');
        Validator::validate_cnp($this, 'CNP', 'CNP');
        // Id not in inmates table
        $this->validate_id('Id');
        $this->validate_institution('InstId');
        Validator::validate_date($this, 'DOB', 'DOB');
        Validator::validate_date($this, 'IncarcerationDate', 'IncarcerationDate');
        Validator::validate_date($this, 'ReleaseDate', 'ReleaseDate');
        Validator::validate_exists($this, 'Crime', 'Crime');
        Validator::validate_sentence($this, 'Sentence', 'Sentence');
        if (!empty($this->LawyerFirstName) ||
            !empty($this->LawyerLastName)  ||
            !empty($this->LawyerCNP)) {
            Validator::validate_name($this, 'LawyerFirstName', 'LawyerFirstName');
            Validator::validate_name($this, 'LawyerLastName',  'LawyerLastName');
            Validator::validate_cnp($this, 'LawyerCNP', 'LawyerCNP');
            // LawyerId not in inmates table
            $this->validate_id('LawyerId');
        }

        return count($this->validation_errors) === 0;
    }
    
    private function validate_institution($label) {
        $sql = "SELECT Id FROM institutions WHERE id=:id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->bindValue(':id', $this->$label, PDO::PARAM_INT);
        $query->execute();
        $count = count($query->fetchAll());
        if ($count === 0) {
            // Institution not found
            $message = "Not a valid Institution id.";
            $this->validation_errors[$label] = $message;
        }
        else {
            unset($this->validation_errors[$label]);
        }
    }

    private function validate_id($label) {
        $sql = "SELECT 1 FROM inmates WHERE id=:id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->bindValue(':id', $this->$label, PDO::PARAM_STR);
        $query->execute();
        $count = count($query->fetchAll());
        if ($count === 0) {
            // id not found (unique)
            unset($this->validation_errors[$label]);
        }
        else {
            $message = "Credentials match an existing inmate.";
            $this->validation_errors[$label] = $message;
        }
    }
}



// Model helpers
function clean($arr, $key) {
    if (isset($arr[$key])) {
        return trim(strip_tags($arr[$key]));
    }
}
