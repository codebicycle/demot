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
        $inmate->initialize($_POST);
        $success = $inmate->save();

        if ($success) {
            require APP . 'view/inmates/create.php';
        }
        else {
            // redisplay filled form and validation hints
            $validation_errors = $inmate->validation_errors;
            require APP . 'view/inmates/add.php';
        }

        require APP . 'view/_templates/footer.php';
    }
}
