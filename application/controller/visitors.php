<?php

class Visitors extends Controller {

    public function login() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/visitors/login.php';
        require APP . 'view/_templates/footer.php';
    }

    public function index() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/visitors/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function register() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/visitors/register.php';
        require APP . 'view/_templates/footer.php';
    }

    public function appointments() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/visitors/appointments.php';
        require APP . 'view/_templates/footer.php';
    }

	
	public function edit() {
		session_start();
		 
        $visitor_db = $this->model->find_by_id($_SESSION['user_id']);
        $cache = (array) $visitor_db;
        require APP . 'view/_templates/header.php';
        require APP . 'view/visitors/edit.php';
        require APP . 'view/_templates/footer.php';
    }
	
    public function update() {	
		session_start();
		 
		if (!$_POST || !isset($_POST['Update'])) {
			header('location: ' . URL . 'visitors/edit');
			die();
		}
		
		$visitor = $this->model;
		$visitor->initialize(
			$_SESSION['user_id'],
			$_POST['UserName'],
			$_POST['FirstName'],
			$_POST['LastName'],
			$_POST["Email"],
			$_POST['CNP'],
            $_POST['OldPassword'],
			$_POST['Password'],
			$_POST['RepeatPassword'],
			$_FILES['uploadImage']['name'] ?? NULL );

		$success = $visitor->update();
		
		if ($success) {
			header('location: ' . URL . 'visitors/edit');
			die();
		}
		else { 
			$validation_errors = $visitor->validation_errors;
            require APP . 'view/_templates/header.php';
            require APP . 'view/visitors/edit.php';
            require APP . 'view/_templates/footer.php';
		}
    }

    public function logout() {
        session_start();
        session_destroy();
        header('location: ' . URL . 'visitors/index');
        die();
    }

}
