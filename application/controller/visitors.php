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

    public function editaccount() 
	{	
		if(!$_POST) 
		{
			header('location: ' . URL . 'visitors/editaccount');
			return;
		}
	
		$edit=$this->model;
		$edit->initialize(
		$_SESSION['user_id'],
		$_POST['UserName'],
		$_POST['FirstName'],
		$_POST['LastName'],
		$_POST["Email"],
		$_POST['CNP'],
		$_POST['Password'],
		$_POST['RepeatPassword'],
		$_FILES['uploadImage']);
	
		$success = $edit->save();
		
		if($success)
		{
		//old page
        require APP . 'view/_templates/header.php';
        require APP . 'view/visitors/editaccount.php';
        require APP . 'view/_templates/footer.php';
		}
		
		else
		{
			
		}
		
		
		
		
    }

    public function logout() {
        session_start();
        session_destroy();
        header('location: ' . URL . 'visitors/index');
        die();
    }

}
