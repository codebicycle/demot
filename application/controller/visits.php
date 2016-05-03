<?php

class Visits extends Controller {

  public function create() {
    if(!$_POST) {
        header('location: ' . URL . 'admins/index');
        return;
    }
    // if(!isset($_POST['Review'])) {
      
    // }
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
        $_POST['SecondVisitor'] ?? null,
        $_POST['ThirdVisitor'] ?? null );

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
