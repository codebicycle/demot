<?php

class Visitors extends Controller {
    public function index() {
        
        header('location: ' . URL . 'inmates/find');
		die();
        
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
			trim($_POST['UserName']),
			$_POST['FirstName'],
			$_POST['LastName'],
			$_POST["Email"],
			$_POST['CNP'],
            $_POST['OldPassword'],
			$_POST['Password'],
			$_POST['RepeatPassword'],
			$_FILES['uploadImage']);
			
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
	
	public function register() {
		
		if (!$_POST || !isset($_POST['Register'])) {
			require APP . 'view/_templates/header.php';
			require APP . 'view/visitors/register_form.php';
			die();
		}
		
		$visitor=$this->model;
		$visitor->initialize_register(
			trim($_POST['register_UserName']),
			$_POST['register_FirstName'],
			$_POST['register_LastName'],
			$_POST['register_Email'],
			$_POST['register_CNP'],
			$_POST['register_Password'],
			$_POST['register_RepeatPassword'],
			$_FILES['register_uploadImage']??NULL);
		$success = $visitor->register();
		
		if ($success) 
		{	
			header('location: ' . URL . 'visitors/index');
			die();
		}
		else 
		{ 
			$validation_errors = $visitor->validation_errors;
			require APP . 'view/_templates/header.php';
			require APP . 'view/visitors/register_form.php';
			require APP . 'view/_templates/footer.php';
			
		 }
    }

	
	public function login() {
		if (!$_POST || !isset($_POST['Login'])) {
			require APP . 'view/_templates/header.php';
			require APP . 'view/visitors/login_form.php';
			die();
		}
		
		$visitor = $this->model;
		$visitor->initialize_login(trim($_POST['login_UserName']) ,$_POST['login_Password']);
			
		$success = $visitor->login();
		
		if ($success) {
			header('location: ' . URL . 'visitors/index');
			die();
		}
		else 
		{ 
			$validation_errors = $visitor->validation_errors;
			require APP . 'view/_templates/header.php';
			require APP . 'view/visitors/login_form.php';
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
