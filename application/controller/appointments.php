<?php

class Appointments extends Controller {

    public function index() {
        $appointments = $this->model->getAllAppointments();
        require APP . 'view/_templates/header.php';
        require APP . 'view/appointments/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function add() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/appointments/add.php';
        require APP . 'view/_templates/footer.php';
    }

    public function create() {
        if(!$_POST || !isset($_POST['Create'])) {
            header('location: ' . URL . 'appointments/add');
            return;
        }

        require APP . 'view/_templates/header.php';

        $success = true;

        if ($success) {
            require APP . 'view/appointments/create.php';
        }
        else {
            // redisplay filled form and validation hints
            $validation_errors = $this->model->validation_errors;
            require APP . 'view/appointments/add.php';
        }

        require APP . 'view/_templates/footer.php';
    }
}