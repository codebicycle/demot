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

        $inmate = $this->model;
        $inmate->initialize(
            null,
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
            $_POST['LawyerCNP'],
            null );

        $success = $inmate->save();

        if ($success) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        else {
            // redisplay filled form and validation hints
            $validation_errors = $inmate->validation_errors;
            require APP . 'view/_templates/header.php';
            require APP . 'view/inmates/add.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function delete($id) {
        $success = $this->model->destroy($id);
        if ($success) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        else {
            // TODO: add flash message
            header('location: ' . URL . 'errorz/index');
            die();
        }
    }

    public function edit($id) {
        // find id in database
        // show form and populate fields
        $inmate_db = $this->model->find_by_id($id);
        $cache = (array) $inmate_db;
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/edit.php';
        require APP . 'view/_templates/footer.php';
    }

    public function update($id) {
        if(!$_POST || !isset($_POST['Update'])) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        $inmate = $this->model;
        $inmate->initialize(
            $id,
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
            $_POST['LawyerCNP'],
            $_POST['LawyerId'] );

        $success = $inmate->update($inmate->Id);
        
        if ($success) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        else {
            // redisplay filled form and validation hints
            $validation_errors = $inmate->validation_errors;
            require APP . 'view/_templates/header.php';
            require APP . 'view/inmates/edit.php';
        }
        require APP . 'view/_templates/footer.php';
    }
}
