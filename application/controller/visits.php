<?php

class Visits extends Controller {

    public function index() {
		
		if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
		if (isset($_SESSION['user_id']))
		{
           $visits=$this->model->getAllVisitsByVisitor($_SESSION['user_id']);
		   
        }
		
        else if(isset($_SESSION['admin_id']) &&
                $_SESSION['rank'] == 0) {
             $visits = $this->model->getAllVisits();
			 
        }
		else if(isset($_SESSION['admin_id']) &&
                $_SESSION['rank'] == 1) {
             $visits = $this->model->getAllVisitsByInstitution($_SESSION['admin_id']);
			
        }
		
		else {
            header('location: ' . URL . 'visitors/index');
            die();
        }
		
		require APP . 'view/_templates/header.php';
		require APP . 'view/visits/index.php';
		require APP . 'view/_templates/footer.php';
    }

    public function create() {
    if(!$_POST) {
        header('location: ' . URL . 'admins/index');
        return;
    }

    $visit = $this->model;
    $visit->initialize(
        $_POST['AppointmentId'],
        $_POST['GivenObjects'],
        $_POST['ReceivedObjects'],
        $_POST['Duration'],
        $_POST['Motive'],
        $_POST['Comments'],
        $_POST['InmatePhisicalState'],
        $_POST['InmateEmotionalState'],
        $_POST['Relationship'],
		$_POST['SecondVisitor']??null,
        $_POST['ThirdVisitor']??null,
		$_POST['GuardId']);

    $success = $visit->save();

    if ($success) {
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/create.php';
        require APP . 'view/_templates/footer.php';
        // header('location: ' . URL . 'admins/index');
        // die();
    }
    else {
        // redisplay filled form and validation hints
        $validation_errors = $visit->validation_errors;
        require APP . 'view/_templates/header.php';
        require APP . 'view/appointments/show' . $visit->AppointmentId .'.php';
        require APP . 'view/_templates/footer.php';
    }    
  }
}
