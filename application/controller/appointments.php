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
	public function approve($id)
	{
		$this->model->approve_appointment($id);
		header('location: ' . URL . 'admins'); 
		die();
	}
	public function reject($id)
	{
		$this->model->reject_appointment($id);
		header('location: ' . URL . 'admins'); 
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
}
