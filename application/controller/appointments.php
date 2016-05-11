<?php

class Appointments extends Controller {

    public function index() {

        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }

        if (isset($_SESSION['user_id'])){
            $appointments = $this->model->getAllAppointmentsByVisitor($_SESSION['user_id']);
            require APP . 'view/_templates/header.php';
            require APP . 'view/visitors/appointments.php';
            require APP . 'view/_templates/footer.php';
        }
        else if(isset($_SESSION['admin_id']) &&
                $_SESSION['rank'] == 0) {
            $appointments = $this->model->getAllAppointments();
            require APP . 'view/_templates/header.php';
            require APP . 'view/appointments/index.php';
            require APP . 'view/_templates/footer.php';
        }
        else if(isset($_SESSION['admin_id']) &&
                $_SESSION['rank'] == 1) {
            $appointments = $this->model->getAllAppointmentsByInstitution($_SESSION['admin_id']);
            require APP . 'view/_templates/header.php';
            require APP . 'view/appointments/index.php';
            require APP . 'view/_templates/footer.php';
        }
        else if(isset($_SESSION['admin_id']) &&
                $_SESSION['rank'] == 2) {

            $ap_pending = $this->model->getPendingAppointments();
            $ap_for_review = $this->model->getApprovedAppointments();
            print_r($ap_for_review);
			require APP . 'view/_templates/header.php';
            require APP . 'view/admins/appointments-guard.php';
            require APP . 'view/_templates/footer.php';
        }
        else {
            header('location: ' . URL . 'visitors/index');
            die();
        }
    }

    public function add() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/appointments/add.php';
        require APP . 'view/_templates/footer.php';
    }

	public function approve($id)
	{	
		session_start();
		$GuardId=$_SESSION['admin_id'];
		$this->model->approve_appointment($id, $GuardId);
		header('location: ' . URL . 'appointments/index');
		die();
	}
    
	public function reject($id)
	{
		session_start();
		$GuardId=$_SESSION['admin_id'];
		$this->model->reject_appointment($id,$GuardId);
		header('location: ' . URL . 'appointments/index');
		die();
	}

    public function noshow($id) {
        $this->model->setState($id, 'noshow');
        header('location: ' . URL . 'appointments/index');
        die();
    }

	public function show($Id)
	{
		$appointment = $this->model->getAppointment($Id);
		$visitor = $this->model->getVisitor($appointment->VisitorId);
		$inmate=$this->model->getInmate($appointment->InmateId);
		$picture=$this->model->getPicture($appointment->VisitorId) ;
		require APP . 'view/_templates/header.php';
        require APP . 'view/appointments/show.php';
        require APP . 'view/_templates/footer.php';	
	}
	
	
	public function create() {
		if(!$_POST) {
			header('location: ' . URL . 'appointments/add');
			return;
		}

        require APP . 'view/_templates/header.php';

		$appointment = $this->model;
		$appointment->initialize(
		$_SESSION['user_id'],
        $_POST['DateOfAppointment'],
        $_POST['TimeOfAppointment'],
        $_POST['Visitor2FirstName'],
        $_POST['Visitor2LastName'],
        $_POST['Visitor2CNP'],
        $_POST['Visitor3FirstName'],
        $_POST['Visitor3LastName'],
        $_POST['Visitor3CNP']);
		       
		$success = $appointment->save();
		

        if ($success) {
			
			header('location: '.URL. 'appointments/index');
        }
		
		
        else {
            // redisplay filled form and validation hints
            $validation_errors = $this->model->validation_errors;
            require APP . 'view/appointments/add.php';
        }

        require APP . 'view/_templates/footer.php';
    
	}
}
