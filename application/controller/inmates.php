<?php

class Inmates extends Controller {

    public function index() {
        $inmates = $this->model->getAllInmates();
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function add() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/add.php';
        require APP . 'view/_templates/footer.php';
    }

    public function create() {
        if(!$_POST || !isset($_POST['Create'])) {
            header('location: ' . URL . 'inmates/add');
            return;
        }

        require APP . 'view/_templates/header.php';
        $inmate = $this->model;
        $inmate->initialize(
            $_POST['FirstName'],
            $_POST['LastName'],
            $_POST['CNP'],
            $_POST['DOB'],
            $_POST['InstId'],
            $_POST['Crime'],
            $_POST['Sentence'],
            $_POST['IncarcerationDate'],
            $_POST['ReleaseDate'],
            $_POST['LawyerFirstName'],
            $_POST['LawyerLastName'],
            $_POST['LawyerCNP'] );

        $success = $inmate->save();

        if ($success) {
            require APP . 'view/inmates/create.php';
        }
        else {
            // model_validation_error_index => view_label
            $dict = [
                'firstName'         => 'FirstName',
                'lastName'          => 'LastName',
                'CNP'               => 'CNP',
                'id'                => 'Id',
                'DOB'               => 'DOB',
                'instId'            => 'InstId',
                'crime'             => 'Crime',
                'sentence'          => 'Sentence',
                'incarcerationDate' => 'IncarcerationDate',
                'releaseDate'       => 'ReleaseDate',
                'lawyerFirstName'   => 'LawyerFirstName',
                'lawyerLastName'    => 'LawyerLastName',
                'lawyerCNP'         => 'LawyerCNP',
                'lawyerId'          => 'LawyerId' ];

            // redisplay filled form and validation hints
            $validation_errors = map_model_validation_errors_to_view($inmate, $dict);
            require APP . 'view/inmates/add.php';
        }

        require APP . 'view/_templates/footer.php';
    }
}


function map_model_validation_errors_to_view($model, $dict) {
    foreach ($dict as $m_key => $v_key) {
        if(isset($model->validation_errors[$m_key])) {
            $errors[$v_key] = $model->validation_errors[$m_key];
        }
    }
    return $errors;
}
