<?php

class Inmates extends Controller {

  public function index() {

    $inmates = $this->model->getAllInmates();
    require APP . 'view/_templates/header.php';
    require APP . 'view/inmates/index.php';
    require APP . 'view/_templates/footer.php';
  }


  public function new_inmate() {

    require APP . 'view/_templates/header.php';
    require APP . 'view/inmates/new.php';
    require APP . 'view/_templates/footer.php';
  }

  public function create() {
    // whitelist params
    // send to model for validation
    require APP . 'view/_templates/header.php';

    if (isset($_POST['Create'])) {
      $this->model->initialize($_POST);

      if ($this->model->is_valid()) {
        echo 'Everything is OK';
        // model->save();
        // redirect
        require APP . 'view/inmates/create.php';
      }
      else {
        echo 'Not Ok';
        // redisplay filled form and validation hints
        $validation_errors = $this->model->validation_errors;
        require APP . 'view/inmates/new.php';
      }
    }
    else {
      // not a POST request ...
      require APP . 'view/inmates/new.php';
    }
    
    require APP . 'view/_templates/footer.php';
  }

}
